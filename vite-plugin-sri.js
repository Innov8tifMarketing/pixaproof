import { createHash } from 'node:crypto';
import { readFile, writeFile } from 'node:fs/promises';
import path from 'node:path';

export default function manifestSri() {
    let manifestPath;

    return {
        name: 'manifest-sri',
        apply: 'build',

        configResolved(config) {
            const name = config.build.manifest === true
                ? '.vite/manifest.json'
                : config.build.manifest;

            manifestPath = name
                ? path.resolve(config.root, config.build.outDir, name)
                : null;
        },

        async writeBundle() {
            if (!manifestPath) {
                return;
            }

            let manifest;

            try {
                manifest = JSON.parse(await readFile(manifestPath, 'utf8'));
            } catch (error) {
                throw new Error(
                    `[manifest-sri] Could not read the Vite manifest at ${manifestPath}. `
                    + 'Laravel would then render script/style tags without an integrity '
                    + `attribute. Original error: ${error.message}`
                );
            }

            const outDir = path.dirname(manifestPath);

            for (const entry of Object.values(manifest)) {
                if (!/\.(js|css)$/.test(entry.file)) {
                    continue;
                }

                const bytes = await readFile(path.join(outDir, entry.file));

                entry.integrity = `sha384-${createHash('sha384').update(bytes).digest('base64')}`;
            }

            await writeFile(manifestPath, JSON.stringify(manifest, null, 2));
        },
    };
}
