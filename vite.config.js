import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/auth/main.scss',
                'resources/css/backend/main.scss',
                'resources/js/backend/main.ts',
            ],
            refresh: true,
        }),
    ],
})
