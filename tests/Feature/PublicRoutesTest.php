<?php

namespace Tests\Feature;

use Tests\TestCase;

/**
 * Baseline coverage for the whole public surface.
 *
 * This site has no controllers, no forms and no write routes — its entire
 * behaviour is three views, a redirect table and the Vite build. That last one
 * is the real risk: a dependency bump can produce a page that returns 200 with
 * missing styles or dead JavaScript, which no status-code check would catch.
 */
class PublicRoutesTest extends TestCase
{
    /**
     * @return list<array{string, string}>
     */
    public static function pageProvider(): array
    {
        return [
            'home' => ['/', 'Pixaproof'],
            'contact' => ['/contact', 'sales@innov8tif.com'],
            'privacy' => ['/privacy', 'Privacy'],
        ];
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('pageProvider')]
    public function test_page_renders(string $path, string $expected): void
    {
        $this->get($path)
            ->assertOk()
            ->assertSee($expected, false);
    }

    /**
     * A representative sample of the ~20-entry redirect table. They are all
     * Route::redirect, so if one resolves they all do.
     *
     * @return list<array{string, string}>
     */
    public static function redirectProvider(): array
    {
        return [
            ['/technology', '/#technology'],
            ['/about', '/#about'],
            ['/company/contact', '/contact'],
            ['/solutions/insurance-claims', '/#solutions'],
        ];
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('redirectProvider')]
    public function test_legacy_paths_redirect(string $from, string $to): void
    {
        $this->get($from)->assertRedirect($to);
    }

    public function test_vite_build_produces_the_app_entrypoints(): void
    {
        // Guards the most likely dependency-update failure: a build that emits
        // no CSS (e.g. Tailwind v4's @source scanning changing) still exits 0
        // and still serves a 200 — just unstyled.
        //
        // Asserted against the manifest rather than the rendered page because
        // tests/TestCase.php calls withoutVite(), so no asset tags are ever
        // rendered under test.
        $manifestPath = public_path('build/manifest.json');

        if (! file_exists($manifestPath)) {
            $this->markTestSkipped('No Vite build present; run `npm run build` to exercise this.');
        }

        $manifest = json_decode((string) file_get_contents($manifestPath), true);

        $this->assertIsArray($manifest, 'build/manifest.json should be valid JSON.');
        $this->assertArrayHasKey('resources/css/app.css', $manifest, 'The CSS entrypoint is missing from the build.');
        $this->assertArrayHasKey('resources/js/app.js', $manifest, 'The JS entrypoint is missing from the build.');

        foreach (['resources/css/app.css', 'resources/js/app.js'] as $entry) {
            $this->assertFileExists(
                public_path('build/'.$manifest[$entry]['file']),
                "Manifest references {$entry} but the emitted file is absent.",
            );
        }
    }

    public function test_health_endpoint_responds(): void
    {
        $this->get('/up')->assertOk();
    }
}
