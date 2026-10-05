/* START: ViteConfig — bundler and Tailwind configuration */
import { defineConfig } from 'vite';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig(({ command }) => ({
  plugins: [tailwindcss()],
  publicDir: false,
  base: command === 'build' ? '/dist/' : '/',
  build: {
    outDir: 'dist',
    emptyOutDir: true,
    manifest: true,
    rollupOptions: {
      input: 'frontend/src/js/main.js',
    },
  },
  server: {
    host: 'localhost',
    port: 5173,
    strictPort: true,
    cors: true,
    origin: 'http://localhost:5173',
  },
}));
/* END: ViteConfig */
