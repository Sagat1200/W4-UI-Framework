import { defineConfig } from 'vite';
import { resolve } from 'node:path';

export default defineConfig({
  build: {
    outDir: 'resources/dist',
    emptyOutDir: false,
    manifest: true,
    cssCodeSplit: true,
    rollupOptions: {
      input: {
        'w4-native': resolve(__dirname, 'resources/assets/css/build/w4-native.css'),
      },
      output: {
        assetFileNames: 'css/[name][extname]',
      },
    },
  },
});
