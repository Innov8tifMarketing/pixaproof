<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * Collects Content-Security-Policy violation reports.
 *
 * The site ships its full target policy Report-Only (see
 * App\Http\Middleware\SecurityHeaders), so violations are observations, not
 * blocks. This endpoint turns them into aggregatable data on the `csp` log
 * channel. Tuning knobs live in config/csp.php.
 *
 * Two wire formats arrive here and both must be handled:
 *   1. `report-uri`   — `application/csp-report`, one object under `csp-report`
 *                       (Firefox, Safari, and Chrome for backwards compat).
 *   2. Reporting API  — `application/reports+json`, a batched ARRAY of
 *                       envelopes with the payload under `body` (Chrome).
 *
 * Always answers 204, including for junk: a browser that gets an error status
 * may retry, and there is nothing useful to say to it anyway.
 */
class CspReportController extends Controller
{
    public function __invoke(Request $request): Response
    {
        if (! config('csp.reporting_enabled', true)) {
            return response()->noContent();
        }

        /*
         * Read the RAW body. `$request->json()` / `->all()` return EMPTY here:
         * Request::isJson() matches only content types containing `/json` or
         * `+json`, and the legacy format arrives as `application/csp-report`,
         * which matches neither. This is the single most common way a CSP
         * endpoint silently collects nothing.
         */
        $body = $request->getContent();
        $maxBytes = (int) config('csp.max_body_bytes', 16384);

        if ($body === '' || strlen($body) > $maxBytes) {
            return response()->noContent();
        }

        $decoded = json_decode($body, true);

        if (! is_array($decoded)) {
            return response()->noContent();
        }

        foreach ($this->normalise($decoded) as $report) {
            $this->record($report);
        }

        return response()->noContent();
    }

    /**
     * Flatten either wire format into a single shape.
     *
     * @param  array<mixed>  $decoded
     * @return list<array{directive: string, blocked_uri: string, document_uri: string, disposition: string, source_file: string, line: int|null}>
     */
    private function normalise(array $decoded): array
    {
        // Reporting API: a batched array of envelopes.
        if (array_is_list($decoded)) {
            $reports = [];

            foreach ($decoded as $envelope) {
                if (! is_array($envelope) || ($envelope['type'] ?? null) !== 'csp-violation') {
                    continue;
                }

                $reportBody = $envelope['body'] ?? null;

                if (! is_array($reportBody)) {
                    continue;
                }

                $reports[] = [
                    'directive' => (string) ($reportBody['effectiveDirective'] ?? ''),
                    'blocked_uri' => (string) ($reportBody['blockedURL'] ?? ''),
                    'document_uri' => (string) ($reportBody['documentURL'] ?? $envelope['url'] ?? ''),
                    'disposition' => (string) ($reportBody['disposition'] ?? 'report'),
                    'source_file' => (string) ($reportBody['sourceFile'] ?? ''),
                    'line' => isset($reportBody['lineNumber']) ? (int) $reportBody['lineNumber'] : null,
                ];
            }

            return $reports;
        }

        // Legacy report-uri: a single object under `csp-report`.
        $reportBody = $decoded['csp-report'] ?? null;

        if (! is_array($reportBody)) {
            return [];
        }

        return [[
            // `effective-directive` is the precise one; `violated-directive`
            // is the older, coarser field and is the only one Safari sends.
            'directive' => (string) ($reportBody['effective-directive'] ?? $reportBody['violated-directive'] ?? ''),
            'blocked_uri' => (string) ($reportBody['blocked-uri'] ?? ''),
            'document_uri' => (string) ($reportBody['document-uri'] ?? ''),
            'disposition' => (string) ($reportBody['disposition'] ?? 'report'),
            'source_file' => (string) ($reportBody['source-file'] ?? ''),
            'line' => isset($reportBody['line-number']) ? (int) $reportBody['line-number'] : null,
        ]];
    }

    /**
     * @param  array{directive: string, blocked_uri: string, document_uri: string, disposition: string, source_file: string, line: int|null}  $report
     */
    private function record(array $report): void
    {
        if ($report['directive'] === '') {
            return;
        }

        if ($this->isExtensionNoise($report['blocked_uri']) || $this->isExtensionNoise($report['source_file'])) {
            return;
        }

        // Only report on documents we actually serve.
        $documentScheme = strtolower((string) parse_url($report['document_uri'], PHP_URL_SCHEME));
        if (! in_array($documentScheme, ['http', 'https'], true)) {
            return;
        }

        $blockedOrigin = $this->originOf($report['blocked_uri']);
        $documentPath = (string) (parse_url($report['document_uri'], PHP_URL_PATH) ?: '/');
        /*
         * Collapse identical violations. Keyed on the blocked ORIGIN rather than
         * the full URL — cache-busted asset URLs would otherwise defeat this and
         * every page view would log afresh. Mirrors the exception-notification
         * throttle in bootstrap/app.php.
         */
        $fingerprint = hash('sha256', implode('|', [
            $report['directive'],
            $blockedOrigin,
            $documentPath,
        ]));

        $dedupeMinutes = max(1, (int) config('csp.dedupe_minutes', 10));

        try {
            if (! Cache::add("csp_report:{$fingerprint}", true, now()->addMinutes($dedupeMinutes))) {
                return;
            }
        } catch (\Throwable) {
            // A cache outage must not take the endpoint down; log through.
        }

        $context = [
            'directive' => $report['directive'],
            'blocked_origin' => $blockedOrigin,
            // Truncated: query strings on blocked URLs can be enormous, and the
            // origin above is what actually drives policy decisions.
            'blocked_uri' => Str::limit($report['blocked_uri'], 200),
            'document_path' => $documentPath,
            'disposition' => $report['disposition'],
            'source_file' => Str::limit($report['source_file'], 200),
            'line' => $report['line'],
            'fingerprint' => substr($fingerprint, 0, 12),
            'at' => now()->toIso8601String(),
        ];

        // `original-policy` is deliberately not logged — roughly 1KB per report,
        // and we already know what we sent.
        if ($report['disposition'] === 'enforce') {
            Log::channel('csp')->warning('CSP violation (enforced)', $context);

            return;
        }

        Log::channel('csp')->info('CSP violation (report-only)', $context);
    }

    /**
     * Browser-extension injections say nothing about the site's own policy.
     */
    private function isExtensionNoise(string $uri): bool
    {
        if ($uri === '') {
            return false;
        }

        $scheme = strtolower((string) parse_url($uri, PHP_URL_SCHEME));

        if ($scheme === '') {
            return false;
        }

        /** @var list<string> $ignored */
        $ignored = config('csp.ignored_schemes', []);

        return in_array($scheme, $ignored, true);
    }

    /**
     * Reduce a blocked URI to scheme+host, preserving CSP's own keywords
     * ("inline", "eval", "self", "data") which are not URLs at all.
     */
    private function originOf(string $uri): string
    {
        if ($uri === '') {
            return 'unknown';
        }

        $parts = parse_url($uri);

        if ($parts === false || ! isset($parts['host'])) {
            return $uri;
        }

        $scheme = $parts['scheme'] ?? 'https';

        return "{$scheme}://{$parts['host']}";
    }
}
