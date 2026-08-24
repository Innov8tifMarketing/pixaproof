<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Content hashes for public assets, memoised per request.
     *
     * @var array<string, string>
     */
    protected static array $assetHashes = [];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::directive(
            'fingerprintedAsset',
            fn (string $expression): string => "<?php echo e(\\App\\Providers\\AppServiceProvider::fingerprintedAsset({$expression})); ?>"
        );
    }

    /**
     * Resolve a public asset URL carrying a content-derived query string.
     *
     * Favicons and manifests live in public/ rather than the Vite build, so they
     * keep a stable URL across deploys and both Cloudflare and browsers happily
     * serve a stale copy until TTL expiry. Appending a content hash makes each
     * revision a distinct cache key, so a changed icon is picked up immediately
     * while an unchanged one stays cached.
     */
    public static function fingerprintedAsset(string $path): string
    {
        if (! array_key_exists($path, static::$assetHashes)) {
            $absolute = public_path($path);

            static::$assetHashes[$path] = is_file($absolute)
                ? substr((string) md5_file($absolute), 0, 8)
                : '';
        }

        $hash = static::$assetHashes[$path];

        return $hash === '' ? asset($path) : asset($path).'?v='.$hash;
    }
}
