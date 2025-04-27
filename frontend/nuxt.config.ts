// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  devtools: { enabled: true },
  ssr: true,
  app: {
    head: {
      meta: [
        { charset: "utf-8" },
        { name: "viewport", content: "width=device-width, initial-scale=1.0" },
      ],
      link: [
        { rel: "icon", type: "image/png", href: "/icons/favicon.png" },
        {
          rel: "stylesheet",
          href: "https://fonts.googleapis.com/css?family=Poppins:400,400i,500,500i,600,600i,700,700i,800,800i",
        },
        {
          rel: "stylesheet",
          href: "https://fonts.googleapis.com/css?family=Roboto:400,400i,500,500i,700,700i&display=swap",
        },
        {
          rel: "stylesheet",
          href: "https://fonts.googleapis.com/css?family=Rubik:400,400i,500,500i,700,700i",
        },
      ],
    },
  },

  modules: [
    "@nuxtjs/tailwindcss",
    "@pinia/nuxt",
    "@primevue/nuxt-module",
    "nuxt-icon",
    "@pinia/nuxt",
    "@primevue/nuxt-module",
  ],

  css: [
    "@mdi/font/css/materialdesignicons.css",
    "@/assets/css/bootstrap.css",
    "@/assets/css/styles.css",
  ],

  plugins: [
    {
      src: "@/plugins/plugins.ts",
      mode: "client",
    },
    {
      src: "@/plugins/vue-query.ts",
    },
  ],

  build: {
    transpile: ["vuetify", "bootstrap"],
  },

  runtimeConfig: {
    public: {
      API_BASE_URL: process.env.API_BASE_URL || "http://localhost",
    },
  },

  primevue: {
    importTheme: { from: "@/themes/theme.js" },
  },

  compatibilityDate: "2024-09-23",
});
