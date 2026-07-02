import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { bunny } from 'laravel-vite-plugin/fonts';
import tailwindcss from '@tailwindcss/vite';
import * as fs from 'fs';
import * as path from 'path';

// Read all scss files from the target directory
const scssDir = 'resources/css';
const scssFiles = fs.readdirSync(scssDir)
    .filter(file => file.endsWith('.scss'))
    .map(file => path.join(scssDir, file).replace(/\\/g, '/'));

export default defineConfig({
    plugins: [
        laravel({
            input: [...scssFiles, 'resources/js/app.js', 'resources/js/home.js', 'resources/js/upload.js'],
            refresh: true,
            fonts: [
                bunny('Instrument Sans', {
                    weights: [400, 500, 600],
                }),
            ],
        }),
        tailwindcss(),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
