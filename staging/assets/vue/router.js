// assets/vue/router.js

import { createRouter, createWebHistory } from "vue-router";
import Home from "./controllers/Home.vue";
import About from "./controllers/About.vue";
import SignUp from "./controllers/SignUp.vue";
import World from "./controllers/World.vue";

const routes = [
  { path: "/", component: Home },
  { path: "/about", component: About },
  { path: "/about/:firstName/:lastName", component: World },
  { path: "/sign-up", component: SignUp },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
