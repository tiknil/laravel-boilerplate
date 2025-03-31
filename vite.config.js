import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import vue from '@vitejs/plugin-vue'

export default defineConfig({
  plugins: [
    laravel({
      input: [
        'resources/css/auth/main.scss',
        'resources/css/backend/main.scss',
        'resources/js/backend/main.ts',
        'resources/js/frontend/main.ts',
        'resources/css/frontend/main.scss',
      ],
      refresh: true,
    }),
    vue({
      template: {
        transformAssetUrls: {
          // The Vue plugin will re-write asset URLs, when referenced
          // in Single File Components, to point to the Laravel web
          // server. Setting this to `null` allows the Laravel plugin
          // to instead re-write asset URLs to point to the Vite
          // server instead.
          base: null,

          // The Vue plugin will parse absolute URLs and treat them
          // as absolute paths to files on disk. Setting this to
          // `false` will leave absolute URLs un-touched so they can
          // reference assets in the public directory as expected.
          includeAbsolute: false,
        },
      },
    }),
  ],
  resolve: {
    alias: {
      '@': '/resources/js',
    },
  },
  css: {
    preprocessorOptions: {
      scss: {
        // Warning di bootstrap, vedi: https://github.com/twbs/bootstrap/issues/40962
        silenceDeprecations: ['color-functions', 'mixed-decls', 'global-builtin'],
      },
    },
  },
})
