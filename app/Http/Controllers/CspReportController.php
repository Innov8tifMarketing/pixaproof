<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CspReportController extends Controller
{
    public function __invoke(Request $request): Response
    {
        if (! config('csp.reporting_enabled', true)) {
            return response()->noContent();
        }

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
     * @param  array<mixed>  $decoded
     * @return list<array{directive: string, blocked_uri: string, document_uri: string, disposition: string, source_file: string, line: int|null}>
     */
    private function normalise(array $decoded): array
    {
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

        $reportBody = $decoded['csp-report'] ?? null;

        if (! is_array($reportBody)) {
            return [];
        }

        return [[
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

        $documentScheme = strtolower((string) parse_url($report['document_uri'], PHP_URL_SCHEME));
        if (! in_array($documentScheme, ['http', 'https'], true)) {
            return;
        }

        $blockedOrigin = $this->originOf($report['blocked_uri']);
        $documentPath = (string) (parse_url($report['document_uri'], PHP_URL_PATH) ?: '/');
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
        }

        $context = [
            'directive' => $report['directive'],
            'blocked_origin' => $blockedOrigin,
            'blocked_uri' => Str::limit($report['blocked_uri'], 200),
            'document_path' => $documentPath,
            'disposition' => $report['disposition'],
            'source_file' => Str::limit($report['source_file'], 200),
            'line' => $report['line'],
            'fingerprint' => substr($fingerprint, 0, 12),
            'at' => now()->toIso8601String(),
        ];

        if ($report['disposition'] === 'enforce') {
            Log::channel('csp')->warning('CSP violation (enforced)', $context);

            return;
        }

        Log::channel('csp')->info('CSP violation (report-only)', $context);
    }

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
