<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * @var array<string, string>
     */
    protected static array $assetHashes = [];

    public function register(): void {}

    public function boot(): void
    {
        Blade::directive(
            'fingerprintedAsset',
            fn (string $expression): string => "<?php echo e(\\App\\Providers\\AppServiceProvider::fingerprintedAsset({$expression})); ?>"
        );
    }

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
