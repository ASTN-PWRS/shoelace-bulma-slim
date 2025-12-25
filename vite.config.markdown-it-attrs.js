import { defineConfig } from "vite";
import path from "path";

export default defineConfig({
  publicDir: "dummy",
  build: {
    lib: {
      entry: path.resolve(__dirname, "resources/markdown-it-attrs-entry.js"),
      name: "markdownitAttrs", // 👈 ここがグローバル変数名になる
      formats: ["umd"],
      fileName: () => "markdown-it-attrs.umd.js",
    },
    outDir: "public/markdown-it",
    emptyOutDir: false,
    rollupOptions: {
      external: ["markdown-it"],
      output: {
        globals: {
          "markdown-it": "markdownit",
        },
      },
    },
  },
});
