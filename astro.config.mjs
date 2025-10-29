import { defineConfig } from 'astro/config';
import svelte from '@astrojs/svelte';
import path from 'path'

const __dirname = path.resolve(path.dirname(''))
const pathSrc = path.resolve(__dirname, 'src')

export default defineConfig({
  integrations: [svelte()],
  vite: {
    resolve: {
      alias: {
        '@': pathSrc,
      },
    },
  }
});
