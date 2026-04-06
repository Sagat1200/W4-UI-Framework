import { defineConfig } from 'vite';
import { resolve } from 'node:path';

export default defineConfig({
  build: {
    outDir: 'resources/dist',
    emptyOutDir: false,
    cssCodeSplit: true,
    rollupOptions: {
      input: {
        'w4-daisyui': resolve(__dirname, 'resources/assets/css/build/w4-daisyui.css'),
        'w4-tailwind': resolve(__dirname, 'resources/assets/css/build/w4-tailwind.css'),
      },
      output: {
        assetFileNames: 'css/[name][extname]',
      },
    },
  },
});
