import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import vue from '@vitejs/plugin-vue'
import VueI18nPlugin from '@intlify/unplugin-vue-i18n/vite'
import { resolve, dirname } from 'node:path'
import { fileURLToPath } from 'url'

export default defineConfig({
    plugins: [
        vue(),
        VueI18nPlugin({
            include: resolve(dirname(fileURLToPath(import.meta.url)), './resources/js/locales/**'),
        }),
        laravel({
            input: ['resources/js/app.js', 'resources/scss/app.scss'],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            '@': '/resources/js',
        },
    },
    build: {
        target: 'esnext',
        chunkSizeWarningLimit: 1000,
        rollupOptions: {
            // https://rollupjs.org/guide/en/#big-list-of-options
        },
    },
})
