import { defineConfig } from "vite";
import { viteStaticCopy } from "vite-plugin-static-copy";

export default defineConfig({
  publicDir: "dummy",
  build: {
    outDir: "public/shoelace",
    emptyOutDir: false,
    rollupOptions: {
      input: "./resources/main.js",
      output: {
        entryFileNames: "shoelace.js",
        assetFileNames: "shoelace[extname]",
      },
    },
  },
  plugins: [
    viteStaticCopy({
      targets: [
        {
          src: "node_modules/katex/dist/*.{js,css}",
          dest: "../katex",
        },
        {
          src: "node_modules/katex/dist/fonts",
          dest: "../katex",
        },
        {
          src: "node_modules/katex/dist/contrib",
          dest: "../katex",
        },
      ],
    }),
  ],
});
