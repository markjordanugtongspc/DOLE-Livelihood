/* START: ViteConfig — bundler, Tailwind configuration, and PHP hot reload */
import { defineConfig } from 'vite';
import tailwindcss from '@tailwindcss/vite';

// Custom lightweight plugin to trigger full browser reload on PHP file changes
function liveReloadPhp() {
  return {
    name: 'live-reload-php',
    handleHotUpdate({ file, server }) {
      if (file.endsWith('.php')) {
        server.ws.send({
          type: 'full-reload',
          path: '*',
        });
      }
    },
  };
}

export default defineConfig(({ command }) => ({
  plugins: [
    tailwindcss(),
    liveReloadPhp(),
  ],
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
    watch: {
      // Ensure Vite watches all PHP files in frontend and backend
      ignored: ['**/vendor/**', '**/storage/**', '**/database/**'],
    },
  },
}));
/* END: ViteConfig */
