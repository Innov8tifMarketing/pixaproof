<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class SecurityHeadersTest extends TestCase
{
    /**
     * Every page this site serves. There are only three — the rest of
     * routes/web.php is a redirect table.
     *
     * @return list<array{string}>
     */
    public static function pageProvider(): array
    {
        return [
            'home' => ['/'],
            'contact' => ['/contact'],
            'privacy' => ['/privacy'],
        ];
    }

    /**
     * @return array<string, string>
     */
    private function expectedHeaders(): array
    {
        return [
            'X-Frame-Options' => 'SAMEORIGIN',
            'X-Content-Type-Options' => 'nosniff',
            'Referrer-Policy' => 'strict-origin-when-cross-origin',
            'Permissions-Policy' => 'geolocation=(), microphone=(), camera=()',
            'Cross-Origin-Opener-Policy' => 'same-origin',
            'Cross-Origin-Resource-Policy' => 'same-origin',
        ];
    }

    #[DataProvider('pageProvider')]
    public function test_every_page_carries_security_headers(string $path): void
    {
        $response = $this->get($path);

        $response->assertOk();

        foreach ($this->expectedHeaders() as $name => $value) {
            $response->assertHeader($name, $value);
        }
    }

    public function test_enforced_policy_keeps_its_nonce_free_directives(): void
    {
        $policy = (string) $this->get('/')->headers->get('Content-Security-Policy');

        $this->assertStringContainsString("frame-ancestors 'self'", $policy);
        $this->assertStringContainsString("object-src 'none'", $policy);
        $this->assertStringContainsString("base-uri 'self'", $policy);

        // Anything needing a nonce must stay report-only until proven clean.
        $this->assertStringNotContainsString('script-src', $policy);
    }

    public function test_report_only_policy_allows_the_one_external_origin(): void
    {
        $policy = (string) $this->get('/')->headers->get('Content-Security-Policy-Report-Only');

        $this->assertStringContainsString("default-src 'self'", $policy);
        // GTM is the only third party in the served HTML. Cloudflare's own
        // injections come from /cdn-cgi/ on this origin, so 'self' covers them.
        $this->assertStringContainsString('googletagmanager.com', $policy);
    }

    public function test_both_policies_advertise_the_report_endpoint(): void
    {
        $response = $this->get('/');

        foreach (['Content-Security-Policy', 'Content-Security-Policy-Report-Only'] as $header) {
            $policy = (string) $response->headers->get($header);
            $this->assertStringContainsString('report-uri', $policy, $header);
            $this->assertStringContainsString('report-to csp-endpoint', $policy, $header);
        }

        // The group name must match report-to exactly or Chrome silently drops
        // every report.
        $this->assertStringContainsString(
            'csp-endpoint=',
            (string) $response->headers->get('Reporting-Endpoints'),
        );
    }

    public function test_powered_by_banner_is_stripped(): void
    {
        $this->assertFalse($this->get('/')->headers->has('X-Powered-By'));
    }

    public function test_hsts_is_absent_over_plain_http(): void
    {
        $this->assertFalse(
            $this->get('/')->headers->has('Strict-Transport-Security'),
            'HSTS must only be emitted over secure production connections.',
        );
    }
}
