import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/dashboard.css',
                'resources/css/adit.css',
                'resources/js/dashboard.js',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
});
