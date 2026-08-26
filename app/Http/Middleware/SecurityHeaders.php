<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    private const ENFORCED_CSP = [
        "frame-ancestors 'self'",
        "object-src 'none'",
        "base-uri 'self'",
    ];

    /**
     * @var list<string>
     */
    private const REPORT_ONLY_CSP = [
        "default-src 'self'",
        "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://www.googletagmanager.com https://www.google-analytics.com",
        "style-src 'self' 'unsafe-inline'",
        "img-src 'self' data: https://www.googletagmanager.com https://www.google-analytics.com",
        "font-src 'self' data:",
        "frame-src 'self' https://www.googletagmanager.com",
        "connect-src 'self' https://www.googletagmanager.com https://www.google-analytics.com https://*.google-analytics.com https://*.analytics.google.com",
        "form-action 'self'",
        "base-uri 'self'",
        "object-src 'none'",
        "frame-ancestors 'self'",
    ];

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
