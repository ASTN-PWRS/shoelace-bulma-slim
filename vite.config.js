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
          src: "node_modules/@shoelace-style/shoelace/dist/assets",
          dest: "",
        },
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
        {
          src: "node_modules/mermaid/dist/mermaid.min.js",
          dest: "../mermaid",
        },
        {
          src: "node_modules/markdown-it/dist/markdown-it.min.js",
          dest: "../markdown-it",
        },
        {
          src: "node_modules/markdown-it-container/dist/markdown-it-container.min.js",
          dest: "../markdown-it",
        },
        {
          src: "node_modules/@panzoom/panzoom/dist/panzoom.min.js",
          dest: "../panzoom",
        },
      ],
    }),
  ],
});
