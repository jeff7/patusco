import { defineConfig } from "vite";
import vue from "@vitejs/plugin-vue";
import path from "path";
import vuetify from "vite-plugin-vuetify";


export default defineConfig({
    plugins: [vue(), vuetify({ autoImport: true })],
    server: {
        proxy: {
            "/app": "http://localhost:8000",
        },
    },
    resolve: {
        alias: {
            vue: path.resolve(
                __dirname,
                "node_modules/vue/dist/vue.esm-bundler.js"
            ),
        },
    },
});
