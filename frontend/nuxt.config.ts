import tailwindcss from "@tailwindcss/vite";

export default defineNuxtConfig({
  modules: [
    "@pinia/nuxt",
    "@nuxt/test-utils/module",
    "@nuxt/eslint",
    "@nuxt/image",
  ],
  devtools: { enabled: true },
  css: ["~/assets/css/main.css"],
  app: {
    head: {
      titleTemplate: "%s | Recipe Search 3000",
      htmlAttrs: {
        lang: "en",
      },
      link: [
        { rel: "icon", type: "image/x-icon", href: "/favicon.ico" },
      ],
      meta: [
        {
          name: "viewport",
          content: "width=device-width, initial-scale=1",
        },
        { charset: "utf-8" },
        {
          name: "description",
          content:
            "Search and discover delicious recipes from around the world.",
        },
      ],
    },
  },
  image: {
    presets: {
      recipeCard: {
        modifiers: {
          format: "webp",
          quality: 85,
          fit: "cover",
        },
      },
    },
  },

  compatibilityDate: "2025-03-30",
  vite: {
    plugins: [tailwindcss()],
  },
  eslint: {
    config: {
      stylistic: {
        quotes: "single",
        indent: 4,
      },
    },
  },
});
