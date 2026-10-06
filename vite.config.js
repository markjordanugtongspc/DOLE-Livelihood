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
  base: command === 'build' ? './' : '/',
  build: {
    outDir: 'dist',
    emptyOutDir: true,
    manifest: true,
    rollupOptions: {
      input: 'frontend/src/js/main.js',
    },
  },
  server: {
    host: '0.0.0.0',
    port: 5173,
    strictPort: true,
    cors: true,
    origin: 'http://localhost:5173',
    hmr: {
      host: 'localhost',
      port: 5173,
    },
    watch: {
      // Use polling if Windows file system events are missed
      usePolling: true,
      interval: 100,
      ignored: ['**/vendor/**', '**/storage/**', '**/database/**', '**/.git/**'],
    },
  },
}));
/* END: ViteConfig */
