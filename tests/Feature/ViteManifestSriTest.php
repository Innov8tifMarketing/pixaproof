<?php

namespace Tests\Feature;

use Tests\TestCase;

class ViteManifestSriTest extends TestCase
{
    private const MANIFEST = 'public/build/manifest.json';

    /**
     * @return array<string, array{file: string, integrity?: string}>
     */
    private function manifest(): array
    {
        $path = base_path(self::MANIFEST);

        if (! file_exists($path)) {
            $this->markTestSkipped('No Vite build present; run `npm run build`.');
        }

        return json_decode((string) file_get_contents($path), true);
    }

    public function test_every_script_and_style_entry_carries_an_integrity_hash(): void
    {
        $missing = [];

        foreach ($this->manifest() as $key => $entry) {
            if (! preg_match('/\.(js|css)$/', $entry['file'])) {
                continue;
            }

            if (! isset($entry['integrity'])) {
                $missing[] = $key;

                continue;
            }

            $this->assertMatchesRegularExpression(
                '/^sha384-[A-Za-z0-9+\/]+=*$/',
                $entry['integrity'],
                "{$key} has a malformed integrity hash.",
            );
        }

        $this->assertSame(
            [],
            $missing,
            'vite-plugin-sri.js must hash every JS/CSS entry, or Laravel renders tags without integrity.',
        );
    }

    public function test_the_hashes_actually_match_the_built_files(): void
    {
        $checked = 0;

        foreach ($this->manifest() as $key => $entry) {
            if (! isset($entry['integrity'])) {
                continue;
            }

            $contents = (string) file_get_contents(base_path('public/build/'.$entry['file']));

            $this->assertSame(
                'sha384-'.base64_encode(hash('sha384', $contents, true)),
                $entry['integrity'],
                "{$key}: the manifest hash does not match the file on disk.",
            );

            $checked++;
        }

        $this->assertGreaterThan(0, $checked, 'Expected at least one hashed entry.');
    }
}
