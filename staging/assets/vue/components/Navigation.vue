<script setup>
// assets/vue/components/Navigation.vue

import _ from "lodash";
import { reactive } from "vue";
import { useBrowserStore, useUserStore } from "@/helpers/stores";
import VNavLink from "@/components/links/VNavLink.vue";
import VMenuLink from "./links/VMenuLink.vue";

const { browserState } = useBrowserStore();
const { userState } = useUserStore();
const { isAuthenticated, isAdmin } = userState;

const state = reactive({
  open: false,
  transition: "animate__animated animate__fadeInDown",
  transitionWrapper: "max-h-min",
});

function toggle() {
  if (!state.open) {
    state.transition = "animate__animated animate__fadeInRight animate__faster";
    setTimeout(() => (state.open = !state.open), 150);
  } else {
    state.transition =
      "animate__animated animate__fadeOutRight animate__faster";
    setTimeout(() => (state.open = !state.open), 150);
  }
}
</script>

<template>
  <nav
    class="flex flex-col items-start justify-between md:flex md:flex-row md:items-stretch w-screen bg-zinc-50"
  >
    <div
      class="z-50 relative bg-transparent py-6 w-full inline-flex justify-between"
    >
      <span
        class="mr-3 px-3 border-r border-yellow-500 text-2xl text-yellow-500"
      >
        Tableau de bord
      </span>

      <button
        type="button"
        v-on:click="toggle"
        class="lg:hidden p-2 mr-4 w-10 h-10 bg-zinc-200 text-rose-600 rounded-full transition-all delay-200 duration-300"
        :class="state.open && `-rotate-90`"
      >
        <i class="w-full h-full" data-feather="more-vertical"></i>
      </button>
    </div>

    <div :class="state.open ? null : `hidden`" class="static overflow-hidden">
      <div
        class="z-40 md:w-1/2 w-screen overflow-hidden flex flex-col items-end py-3 pr-3 bg-zinc-200 text-zinc-900 px-3 pb-3 absolute right-0 top-20"
        :class="state.transition"
      >
        <v-menu-link
          :to="{ name: 'home' }"
          icon="home"
          iconBg="bg-yellow-500"
          @click.native="() => (state.open = false)"
        >
          Home
        </v-menu-link>

        <v-menu-link
          :to="{ name: 'about' }"
          icon="info"
          @click.native="() => (state.open = false)"
        >
          About
        </v-menu-link>

        <v-menu-link
          :to="{
            name: 'hello',
            params: { firstName: 'Else', lastName: 'World' },
          }"
          icon="info"
          @click.native="() => (state.open = false)"
        >
          Elseworld
        </v-menu-link>

        <v-menu-link
          :to="{ name: 'user-list' }"
          icon="info"
          @click.native="() => (state.open = false)"
          v-if="!isAdmin"
        >
          Utilisateurs
        </v-menu-link>

        <v-menu-link
          :to="{ name: 'shop' }"
          icon="shopping-bag"
          @click.native="() => (state.open = false)"
          v-if="isAdmin"
        >
          Boutique
        </v-menu-link>

        <v-menu-link
          :to="{ name: 'my-account' }"
          icon="user"
          @click.native="() => (state.open = false)"
          v-if="isAuthenticated"
        >
          Compte
        </v-menu-link>

        <v-menu-link
          :to="{ name: 'sign-up' }"
          icon="user-check"
          @click.native="() => (state.open = false)"
          v-if="!isAuthenticated"
        >
          S'inscrire
        </v-menu-link>

        <v-menu-link
          :to="{ name: 'sign-in' }"
          icon="log-in"
          @click.native="() => (state.open = false)"
          v-if="!isAuthenticated"
        >
          Se connecter
        </v-menu-link>

        <v-menu-link
          :to="{ name: 'sign-out' }"
          icon="log-out"
          iconBg="bg-rose-600"
          iconColor="text-white"
          @click.native="() => (state.open = false)"
          v-if="isAuthenticated"
        >
          Se déconnecter
        </v-menu-link>
      </div>
    </div>

    <div class="hidden lg:inline-flex gap-2 items-center pr-4">
      <v-nav-link :to="{ name: 'home' }" icon="home" title="&nbsp;" />

      <v-nav-link
        title="Boutique"
        :to="{ name: 'shop' }"
        icon="shopping-cart"
        v-if="isAuthenticated && isAdmin"
      />

      <v-nav-link
        title="Utilisateurs"
        :to="{ name: 'user-list' }"
        icon="users"
        v-if="isAuthenticated && isAdmin"
      />

      <v-nav-link
        title="S'inscrire"
        :to="{ name: 'sign-up' }"
        icon="user-check"
        v-if="!isAuthenticated"
      />

      <v-nav-link
        title="Mon compte"
        :to="{ name: 'my-account' }"
        icon="user"
        v-if="isAuthenticated"
      />

      <v-nav-link
        title="Se connecter"
        :to="{ name: 'sign-in' }"
        icon="log-in"
        v-if="!isAuthenticated"
      />

      <v-nav-link
        title="Se déconnecter"
        :to="{ name: 'sign-out' }"
        icon="log-out"
        v-if="isAuthenticated"
      />
    </div>
  </nav>
</template>
