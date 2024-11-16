import { defineConfig } from "vite";

export default defineConfig({
  root: "./src",
  base: "/public/",
  build: {
    outDir: "../public",
    emptyOutDir: true,
  },
});
