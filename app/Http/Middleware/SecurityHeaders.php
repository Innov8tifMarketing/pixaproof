<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Applies baseline HTTP security headers to every response.
 *
 * Ported from the innov8tif marketing site, which shares this server. The
 * policy here is far smaller because the site is far smaller: three static
 * pages plus a redirect table, no forms, no uploads, no authentication. The
 * only external origin in the served HTML is Google Tag Manager. Cloudflare's
 * own injections (email obfuscation, the challenge platform) are served from
 * /cdn-cgi/ on this origin and so are already covered by 'self'.
 *
 * Two Content-Security-Policies are sent:
 *   1. An ENFORCED policy limited to directives that need no nonce and cannot
 *      break inline scripts/styles.
 *   2. A REPORT-ONLY policy carrying the full target. Because this site's
 *      surface is small and fully enumerated, this one can realistically be
 *      promoted to enforced — unlike the marketing site, which is gated on GTM.
 *
 * `frame-ancestors 'self'` is safe here: this is the marketing site for
 * Pixaproof, not the proofing product itself, so nothing embeds it.
 *
 * Violations are posted to `route('csp.report')` and land on the `csp` log
 * channel. HSTS deliberately starts at ten minutes and carries no
 * includeSubDomains — step both up only once HTTPS is confirmed everywhere,
 * including on any *.pixaproof.com host serving the product.
 */
class SecurityHeaders
{
    private const ENFORCED_CSP = [
        "frame-ancestors 'self'",
        "object-src 'none'",
        "base-uri 'self'",
    ];

    /**
     * `'unsafe-inline'`/`'unsafe-eval'` remain because Livewire and Alpine rely
     * on them — Alpine evaluates its `x-` expression strings at runtime, which
     * structurally requires `'unsafe-eval'`.
     *
     * @var list<string>
     */
    private const REPORT_ONLY_CSP = [
        "default-src 'self'",
        "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://www.googletagmanager.com https://www.google-analytics.com",
        "style-src 'self' 'unsafe-inline'",
        "img-src 'self' data: blob: https://www.googletagmanager.com https://www.google-analytics.com",
        "font-src 'self' data:",
        "media-src 'self'",
        "worker-src 'self' blob:",
        "child-src 'self' blob:",
        "frame-src 'self' https://www.googletagmanager.com",
        "connect-src 'self' https://www.googletagmanager.com https://www.google-analytics.com https://*.google-analytics.com https://*.analytics.google.com",
        "form-action 'self'",
        "base-uri 'self'",
        "object-src 'none'",
        "frame-ancestors 'self'",
    ];

    /**
     * Must match the `report-to` group name character-for-character, or Chrome
     * discards every report without surfacing an error.
     */
    private const REPORT_GROUP = 'csp-endpoint';

    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $reporting = [
            'report-uri '.route('csp.report'),
            'report-to '.self::REPORT_GROUP,
        ];

        $headers = [
            'X-Frame-Options' => 'SAMEORIGIN',
            'X-Content-Type-Options' => 'nosniff',
            'Referrer-Policy' => 'strict-origin-when-cross-origin',
            'Permissions-Policy' => 'geolocation=(), microphone=(), camera=()',
            'Content-Security-Policy' => implode('; ', [...self::ENFORCED_CSP, ...$reporting]),
            'Content-Security-Policy-Report-Only' => implode('; ', [...self::REPORT_ONLY_CSP, ...$reporting]),
            'Reporting-Endpoints' => self::REPORT_GROUP.'="'.route('csp.report').'"',
            'Cross-Origin-Opener-Policy' => 'same-origin',
            'Cross-Origin-Resource-Policy' => 'same-origin',
        ];

        if ($request->secure() && app()->isProduction()) {
            $headers['Strict-Transport-Security'] = 'max-age=600';
        }

        foreach ($headers as $name => $value) {
            if (! $response->headers->has($name)) {
                $response->headers->set($name, $value);
            }
        }

        $response->headers->remove('X-Powered-By');

        return $response;
    }
}
