<script setup>
// assets/vue/components/Navigation.vue

import _ from "lodash";
import {
  computed,
  onBeforeMount,
  onBeforeUnmount,
  reactive,
} from 'vue';
import { useRouter, useRoute } from "vue-router";

const router = useRouter();
const route = useRoute();

const state = reactive({
  width: window.innerHeight,
  height: window.innerWidth,
  isMobile: window.innerWidth < 420,
  open: false,
  transition: "animate__animated animate__fadeInDown",
  transitionWrapper: "max-h-min",
});

function resizeHadndler() {
  state.height = window.innerHeight;
  state.width = window.innerWidth;
  state.isMobile = window.innerWidth < 420;

}

function toggle() {
  if (state.open) {
    state.transition = "animate__animated animate__fadeOutUp";
    setTimeout(() => state.open = !state.open, 600);
  } else {
    state.transition = "animate__animated animate__fadeInDown animate__faster";
    state.open = !state.open;
  }
}
function navigateTo(name, options) {
  console.log("GoTo:", name);
  state.open = false;

  const { params, query } = {
    params: _.get(options, "params", {}),
    query: _.get(options, "query", {}),
  }

  router.push({
    name,
    params: {
      ...params,
    },
    query: {
      ...route.query,
      ...query,
    },
  });
}

onBeforeMount(() => {
  window.addEventListener("resize", resizeHadndler);
});

onBeforeUnmount(() => {
  window.removeEventListener("resize", resizeHadndler);
});

const defaultClass = "w-full flex flex-col items-end py-3 pr-3 bg-slate-900 px-3 pb-3 absolute";
</script>

<template>
  <nav class="w-full flex flex-lg-row flex-col justify-start relative">
    <div class="z-50 bg-transparent py-6 text-yellow-400 w-full inline-flex justify-between bg-gradient-to-b from-slate-600 to-slate-900">
      <span class="text-2xl font-bold border-r-4 border-yellow-400 mr-3 px-3">
        Tableau de bord
      </span>

      <button v-show="state.isMobile" type="button" v-on:click="toggle" class="p-2 mr-3 bg-rose-600 rounded-full">
        <span v-show="!state.open" class="text-2xl">
          <i data-feather="more-vertical"></i>
        </span>

        <span v-show="state.open" class="text-2xl">
          <i data-feather="more-horizontal"></i>
        </span>
      </button>
    </div>

    <div v-show="state.isMobile && state.open" class="z-40 static">
      <div :class="[defaultClass, state.transition]">
        <div class="animate__animated animate__fadeInRight animate__faster animate__delay-2s relative">
          <div
            class="bg-yellow-400 hover:bg-yellow-300 rounded-full w-full mb-3">
            <button v-on:click="() =>navigateTo('home')" type="button" class="m-0 px-4 py-2 text-black flex justify-end gap-3">
              Home
              <i data-feather="home"></i>
            </button>
          </div>
        </div>

        <div class="animate__animated animate__fadeInRight animate__faster animate__delay-2s w-full">
          <div
            class="bg-zinc-100 rounded-full w-full mb-3">
            <button v-on:click="() =>navigateTo('about')" class="m-0 px-4 py-2 text-black flex justify-end gap-3">
              About
              <i data-feather="info"></i>
            </button>
          </div>

          <div class="animate__animated animate__fadeInRight animate__faster animate__delay-2s w-full">
            <div
              class="bg-zinc-100 rounded-full w-full mb-3">
              <button
                v-on:click="() =>navigateTo('hello', { params: {firstName: 'Else', lastName: 'World'} })"
                class="m-0 px-4 py-2 text-black flex justify-end gap-3"
              >
                Elseworld
                <i data-feather="globe"></i>
              </button>
            </div>
          </div>

          <div class="animate__animated animate__fadeInRight animate__faster animate__delay-2s w-full">
            <div
              class="bg-zinc-100 rounded-full w-full mb-3">
              <button v-on:click="() =>navigateTo('my-account')" class="m-0 px-4 py-2 text-black flex justify-end gap-3">
                Compte
                <i data-feather="globe"></i>
              </button>
            </div>
          </div>

          <div class="animate__animated animate__fadeInRight animate__faster animate__delay-2s w-full">
            <div
              class="bg-zinc-100 rounded-full w-full mb-3">
              <button v-on:click="() =>navigateTo('sign-in')" class="m-0 px-4 py-2 text-black flex justify-end gap-3">
                Se connecter
                <i data-feather="user-check"></i>
              </button>
            </div>
          </div>

          <div class="animate__animated animate__fadeInRight animate__faster animate__delay-2s w-full">
            <div
              class="bg-zinc-100 rounded-full w-full mb-3">
              <button v-on:click="() =>navigateTo('sign-out')" class="m-0 px-4 py-2 text-black flex justify-end gap-3">
                Se déconnecter
                <i data-feather="user-check"></i>
              </button>
            </div>
          </div>

          <div class="animate__animated animate__fadeInRight animate__faster animate__delay-2s w-full">
            <div
              class="bg-zinc-100 rounded-full w-full mb-3">
              <button v-on:click="() =>navigateTo('sign-up')" class="m-0 px-4 py-2 text-black flex justify-end gap-3">
                S'inscrire
                <i data-feather="user-check"></i>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
</nav></template>
