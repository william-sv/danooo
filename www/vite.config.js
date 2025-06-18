import { fileURLToPath, URL } from 'node:url'
import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import AutoImport from 'unplugin-auto-import/vite'
import Components from 'unplugin-vue-components/vite'
import { ElementPlusResolver } from 'unplugin-vue-components/resolvers'

// https://vite.dev/config/
export default defineConfig({
  plugins: [
    vue(),
    AutoImport({
      imports: ['vue', 'vue-router', 'pinia'],
      resolvers: [ElementPlusResolver()]
    }),
    Components({
      resolvers: [ElementPlusResolver()],
    })
  ],
  resolve: {
    alias: {
      '@': fileURLToPath(new URL('./src', import.meta.url)),
      '@v': fileURLToPath(new URL('./src/views', import.meta.url)),
      '@c': fileURLToPath(new URL('./src/components', import.meta.url)),
      '@u': fileURLToPath(new URL('./src/utils', import.meta.url)),
      '@s': fileURLToPath(new URL('./src/stores', import.meta.url)),
    }
  },
  build: {
    rollupOptions: {
      output: {
        manualChunks(id){
          if (id.includes('node_modules')){
            if (id.includes('lodash')) {
              return 'lodash';
            }
            if (id.includes('vue')) {
              return 'vue-vendor';
            }
            if (id.includes('element-plus')) {
              return 'element-plus';
            }
            if (id.includes('axios')) {
              return 'axios';
            }
            if (id.includes('dayjs')) {
              return 'dayjs';
            }
            if (id.includes('pinia')) {
              return 'pinia';
            }
            if (id.includes('vue-router')) {
              return 'vue-router';
            }
            return 'vendor'
          }
        }
      },
      plugins: [
        // uglify()
      ]
    }
  },
  server: {
    proxy: {
      '/dev': {
        target: 'https://api.songji.top',
        changeOrigin: true,
        secure: true,
        rewrite: (path) => path.replace(/^\/dev/, ''),
      }
    }
  }
})
