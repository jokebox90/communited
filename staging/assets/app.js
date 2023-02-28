// assets/app.js

// import "~/assets/styles/app.css";
// import "animate.css";

import { createApp } from "vue";
import { createPinia } from "pinia";
import { plugin, defaultConfig } from "@formkit/vue";
import Vue3Toastify from "vue3-toastify";
import config from "~/formKit.config";
import App from "@/App.vue";
import router from "@/router";
import vue3ToastifyConfig from "@/vue3-toastify";

const app = createApp(App);

const pinia = createPinia();
app.use(pinia);

app.use(plugin, defaultConfig(config));
console.log("FormKit is running ...");

app.use(Vue3Toastify, vue3ToastifyConfig);
console.log("Vue3 Toastify is running ...");

app.use(router);
console.log("VueRouter is running ...");

app.mount("#root");
