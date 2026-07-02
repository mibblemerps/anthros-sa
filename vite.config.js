import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { bunny } from 'laravel-vite-plugin/fonts';
import tailwindcss from '@tailwindcss/vite';
import * as fs from 'fs';
import * as path from 'path';

const scssFiles = fs.readdirSync('resources/css')
    .filter(file => file.endsWith('.scss'))
    .map(file => path.join('resources/css', file).replace(/\\/g, '/'));

const imgFiles = fs.readdirSync('resources/img')
    .filter(file => file.endsWith('.png') || file.endsWith('.jpg'))
    .map(file => path.join('resources/img', file).replace(/\\/g, '/'));

export default defineConfig({
    plugins: [
        laravel({
            input: [...scssFiles, ...imgFiles, 'resources/js/app.js', 'resources/js/home.js', 'resources/js/upload.js'],
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
