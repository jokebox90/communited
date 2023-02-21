// assets/vue/router.js

import { createRouter, createWebHistory } from "vue-router";
import { useUserStore } from "./helpers/stores";
import Home from "@/controllers/Home.vue";
import Hello from "@/controllers/Hello.vue";
import About from "@/controllers/About.vue";
import SignIn from "@/controllers/SignIn.vue";
import SignOut from "@/controllers/SignOut.vue";
import SignUp from "@/controllers/SignUp.vue";
import MyAccount from "@/controllers/MyAccount.vue";
import UserList from "@/controllers/admin/users/UserList.vue";
import _ from "lodash";
import { warning } from "./helpers/toasts";

const routes = [
  { path: "/", component: Home, name: "home" },
  { path: "/site/about", component: About, name: "about" },
  { path: "/site/hello/:firstName/:lastName", component: Hello, name: "hello" },
  {
    path: "/site/sign-in",
    component: SignIn,
    name: "sign-in",
    meta: { publicZone: true, backTo: "my-account" },
  },
  {
    path: "/site/sign-out",
    component: SignOut,
    name: "sign-out",
    meta: { requiresAuth: true, backTo: "sign-in" },
  },
  {
    path: "/site/sign-up",
    component: SignUp,
    name: "sign-up",
    meta: { publicZone: true, backTo: "my-account" },
  },
  {
    path: "/site/my-account",
    component: MyAccount,
    name: "my-account",
    meta: { requiresAuth: true, backTo: "sign-in" },
  },
  {
    path: "/admin/users",
    component: UserList,
    name: "user-list",
    meta: { requiresAuth: true, backTo: "sign-in" },
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

async function canUserAccess(to) {
  const userStore = useUserStore();

  if (to.meta.publicZone && userStore.isAuthenticated) {
    await warning("Vous n'êtes pas connecté.");
    return false;
  }

  if (to.meta.requiresAuth && !userStore.isAuthenticated) {
    await warning("Vous n'êtes pas connecté.");
    return false;
  }

  return true;
}

router.beforeEach(async (to, from, next) => {
  const canAccess = await canUserAccess(to);
  if (canAccess) next();
  else next({ name: _.get(to, "meta.backTo", "home") });
});

export default router;
