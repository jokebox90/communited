<script setup>
// assets/vue/controllers/SignOut.vue

import { reactive, onBeforeMount } from 'vue';
import { useRouter } from "vue-router";
import { useUserStore } from "../helpers/stores";
import http from '../helpers/http';
import { success, warning } from "../helpers/toasts";
import Hero from '../components/Hero.vue';

const router = useRouter();
const userStore = useUserStore();

const state = reactive({
  userName: "",
  userEmail: "",
})

async function onSubmit() {
  const { data, status } = await http.post("/api/sign-out", null, {
    withCredentials: true,
  })

  if (status === 200) {
    await success("Vous êtes bien déconnecté !");
    userStore.doSignOut();
    router.push({ name: "home" });
  } else if (status === 401) {
    _.map(data.messages, async (m) => await warning(m));
  }
}

onBeforeMount(async () => {
  const { data, status } = await http.get("/api/my-account");

  if (status === 200) {
    state.userName = data.userName;
    state.userEmail = data.userEmail;
  } else if (status === 401) {
    await warning("Vous n'êtes pas connecté.");
    router.replace({ name: "sign-in" });
  }
});
</script>

<template>
  <Hero
    title="Déconnexion"
    description="Voulez-vous vous déconnecter ?"
  />

  <div class="w-full px-3 py-8">
    <div class="flex flex-col gap-0 w-full shadow-md rounded-xl bg-zinc-100 border border-zinc-300 py-8 px-6">
      <div class="flex flex-row gap-0 w-full">
        <p class="w-1/3 pr-3 py-4 font-bold text-right border-r-4 border-rose-600">
          Utilisateur
        </p>
        <p class="w-2/3 pl-3 py-4">
          {{ state.userName }}
        </p>
      </div>

      <div class="flex flex-row gap-0 w-full">
        <p class="w-1/3 pr-3 py-4 font-bold text-right border-r-4 border-rose-600">
          Email
        </p>
        <p class="w-2/3 pl-3 py-4">
          {{ state.userEmail }}
        </p>
      </div>
    </div>
  </div>

  <div class="w-full px-3 py-8">
    <div class="flex flex-col gap-0 w-full shadow-md rounded-xl bg-zinc-100 border border-zinc-300 py-8 px-6">
      <div class="flex flex-row gap-0 w-full">

        <FormKit
          type="form"
          id="signOutForm"
          @submit="() => onSubmit()"
          :actions="null"
        >
          <FormKit
            type="submit"
            label="Valider"
            prefix-icon="check"
            :actions="false"
            wrapper-class="w-full justify-center"
          />
        </FormKit>
      </div>
    </div>
  </div>
</template>