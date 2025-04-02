import { fileURLToPath } from "node:url";
import { defineVitestConfig } from "@nuxt/test-utils/config";

export default defineVitestConfig({
    test: {
        environmentMatchGlobs: [
            ["**/*.nuxt.spec.js", "nuxt"],
        ],
        environment: "happy-dom",
        environmentOptions: {
            nuxt: {
                rootDir: fileURLToPath(new URL(".", import.meta.url)),
            },
        },
    },
});
