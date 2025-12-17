import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import react from "@vitejs/plugin-react-swc";
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        react(),
        tailwindcss(), // 👈 THIS IS MANDATORY FOR TAILWIND v4
        laravel({
            input: ["resources/css/app.css", "resources/js/index.jsx"],
            refresh: true,
        }),
    ],
    optimizeDeps: {
        force: true, // 👈 avoids this issue next time
    },
});
