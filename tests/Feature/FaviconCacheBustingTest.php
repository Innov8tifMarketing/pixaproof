<?php

namespace Tests\Feature;

use App\Providers\AppServiceProvider;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class FaviconCacheBustingTest extends TestCase
{
    /**
     * Every icon referenced from the layout head must carry a cache-busting
     * query string, otherwise a changed icon stays stale behind Cloudflare.
     *
     * @return array<int, array{0: string}>
     */
    public static function iconAssetProvider(): array
    {
        return [
            ['favicon-96x96.png'],
            ['favicon.svg'],
            ['favicon.ico'],
            ['apple-touch-icon.png'],
            ['site.webmanifest'],
        ];
    }

    #[DataProvider('iconAssetProvider')]
    public function test_homepage_head_fingerprints_each_icon(string $path): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee(AppServiceProvider::fingerprintedAsset($path), false);
        $response->assertDontSee('href="'.asset($path).'"', false);
    }

    public function test_fingerprint_is_derived_from_file_contents(): void
    {
        $url = AppServiceProvider::fingerprintedAsset('favicon.svg');

        $this->assertStringStartsWith(asset('favicon.svg').'?v=', $url);
        $this->assertSame(
            substr((string) md5_file(public_path('favicon.svg')), 0, 8),
            parse_url($url, PHP_URL_QUERY) ? substr((string) parse_url($url, PHP_URL_QUERY), 2) : ''
        );
    }

    public function test_missing_asset_falls_back_to_plain_url(): void
    {
        $this->assertSame(
            asset('does-not-exist.png'),
            AppServiceProvider::fingerprintedAsset('does-not-exist.png')
        );
    }

    public function test_manifest_carries_the_application_name(): void
    {
        $manifest = json_decode((string) file_get_contents(public_path('site.webmanifest')), true);

        $this->assertIsArray($manifest);
        $this->assertSame('Pixaproof', $manifest['name']);
        $this->assertSame('Pixaproof', $manifest['short_name']);
    }

    public function test_manifest_icons_all_exist_in_public(): void
    {
        $manifest = json_decode((string) file_get_contents(public_path('site.webmanifest')), true);

        $this->assertNotEmpty($manifest['icons']);

        foreach ($manifest['icons'] as $icon) {
            $this->assertFileExists(public_path(ltrim((string) $icon['src'], '/')));
        }
    }

    public function test_distinct_assets_get_distinct_fingerprints(): void
    {
        $this->assertNotSame(
            AppServiceProvider::fingerprintedAsset('favicon.svg'),
            AppServiceProvider::fingerprintedAsset('apple-touch-icon.png')
        );
    }
}
