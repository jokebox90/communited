// assets/app.js

import "./styles/app.css";

import { createApp } from "vue";
import { plugin, defaultConfig } from "@formkit/vue";
import Vue3Toastify from "vue3-toastify";
import config from "../formKit.config";
import App from "./vue/App.vue";
import router from "./vue/router";
import vue3ToastifyConfig from "./vue/vue3-toastify";
import feather from "feather-icons";

const app = createApp(App);

app.use(plugin, defaultConfig(config));
console.log("FormKit is running ...");

app.use(Vue3Toastify, vue3ToastifyConfig);
console.log("Vue3 Toastify is running ...");

app.use(router);
console.log("VueRouter is running ...");

app.mount("#root");
feather.replace();
