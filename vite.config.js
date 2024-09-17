import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import vue from '@vitejs/plugin-vue'
import tailwindcss from 'tailwindcss'

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        vue(),
    ],
    css: {
        postcss: {
            plugins: [tailwindcss],
        },
    },
    resolve: {
        alias: {
            '@': '/resources/js',
        },
    },
    build: {
        target: 'esnext',
        chunkSizeWarningLimit: 5000,
    },
})
