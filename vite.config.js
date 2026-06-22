import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import fs from 'node:fs'

export default defineConfig({
  plugins: [
    laravel({
      input: [
        'resources/css/app.css',
        'resources/js/app.js',
        'resources/js/list-search.js',
        'resources/js/rutinas/create-rutina.js',
        'resources/js/cliente/historial.js',
		'resources/js/cliente/progreso-chart.js',
      ],
      refresh: true,
    }),
  ],

  server: {
    host: '0.0.0.0',
    port: 5173,

    https: {
      key: fs.readFileSync('./certs/91.98.229.28-key.pem'),
      cert: fs.readFileSync('./certs/91.98.229.28.pem'),
    },

    hmr: {
      host: '91.98.229.28',
      protocol: 'wss',
      port: 5173,
    },
  },
})
