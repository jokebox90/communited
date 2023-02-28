// assets/vue/router.js

import _ from "lodash";
import { nextTick } from "vue";
import { createRouter, createWebHistory } from "vue-router";
import { useUserStore } from "@/helpers/stores";
import { warning } from "@/helpers/toasts";
import Public from "@/Public.vue";
import AppLayout from "@/AppLayout.vue";
import NotFound from "@/controllers/NotFound.vue";
import Home from "@/controllers/Home.vue";
import Hello from "@/controllers/Hello.vue";
import About from "@/controllers/About.vue";
import ShopHome from "@/controllers/admin/shop/Home.vue";
import SignIn from "@/controllers/SignIn.vue";
import SignOut from "@/controllers/SignOut.vue";
import SignUp from "@/controllers/SignUp.vue";
import MyAccount from "@/controllers/MyAccount.vue";
import UserList from "@/controllers/admin/users/UserList.vue";
import ItemList from "@/controllers/admin/shop/ItemList.vue";
import ItemRead from "@/controllers/admin/shop/ItemRead.vue";
import CustomerList from "@/controllers/admin/shop/CustomerList.vue";
import CustomerRead from "@/controllers/admin/shop/CustomerRead.vue";
import CustomerAddDetails from "@/controllers/customer/AddDetails.vue";
import OrderList from "@/controllers/admin/shop/OrderList.vue";
import OrderRead from "@/controllers/admin/shop/OrderRead.vue";
import { featherReplace } from "@/helpers/feather";

const routes = [
  {
    path: "/",
    component: AppLayout,
    children: [
      {
        path: "",
        component: Home,
        name: "home"
      },
      {
        path: "about",
        component: About,
        name: "about"
      },
      {
        path: "hello/:firstName/:lastName",
        component: Hello,
        name: "hello"
      },
      {
        path: "sign-in",
        component: SignIn,
        name: "sign-in",
      },
      {
        path: "sign-out",
        component: SignOut,
        name: "sign-out",
        meta: { requiresAuth: true, backTo: "home" },
      },
      {
        path: "sign-up",
        component: SignUp,
        name: "sign-up",
      },
      {
        path: "my-account",
        component: MyAccount,
        name: "my-account",
        meta: { requiresAuth: true, backTo: "home" },
      },
    ],
  },
  {
    path: "/details/add",
    component: CustomerAddDetails,
    name: "customer-add-details",
    meta: { requiresAuth: true, backTo: "sign-in" },
  },
  {
    path: "/admin",
    component: AppLayout,
    meta: { requiresAuth: true, backTo: "sign-in" },
    children: [
      {
        path: "users",
        component: UserList,
        name: "user-list",
      },
    ],
  },
  {
    path: "/admin/shop",
    component: AppLayout,
    meta: { requiresAuth: true, backTo: "sign-in" },
    children: [
      {
        path: "",
        component: ShopHome,
        name: "shop",
      },
      {
        path: "items",
        component: ItemList,
        name: "shop-item-list",
      },
      {
        path: "items/:itemId",
        component: ItemRead,
        name: "shop-item-read",
      },
      {
        path: "customers",
        component: CustomerList,
        name: "shop-customer-list",
      },
      {
        path: "customers/:customerId",
        component: CustomerRead,
        name: "shop-customer-read",
      },
      {
        path: "orders",
        component: OrderList,
        name: "shop-order-list",
      },
      {
        path: "orders/:orderId",
        component: OrderRead,
        name: "shop-order-read",
      },
    ],
  },
  {
    path: "/:pathMatch(.*)*",
    component: NotFound,
    name: "not-found",
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

async function canUserAccess(to, from) {
  const { userState, doSignOut } = useUserStore();

  if (to.matched.some(m => m.meta.requiresAuth)  && !userState.isAuthenticated) {
    await warning("Vous n'êtes pas connecté.");
    doSignOut();
    return false;
  }

  return true;
}

router.beforeEach(async (to, from, next) => {
  const canAccess = await canUserAccess(to, from);
  if (canAccess) next();
  else next({ name: _.get(to, "meta.backTo", "home") });
});

router.afterEach(async () => {
  await nextTick();
  featherReplace();
});

export default router;
