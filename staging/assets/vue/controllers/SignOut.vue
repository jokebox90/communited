<script setup>
// assets/vue/controllers/SignOut.vue

import { reactive, onBeforeMount } from "vue";
import { useRouter } from "vue-router";
import { useUserStore } from "@/helpers/stores";
import http from "@/helpers/http";
import { success, warning, danger } from "@/helpers/toasts";
import Hero from "@/components/Hero.vue";

const router = useRouter();
const { doSignOut } = useUserStore();

const state = reactive({
  userName: "",
  userEmail: "",
});

onBeforeMount(() => {
  http
    .get("/api/my-account", {
      withCredentials: true,
    })
    .then(({ data }) => {
      state.userName = data.userName;
      state.userEmail = data.userEmail;
    })
    .catch(async ({ response }) => {
      if (response) {
        if (response.status === 401) {
          router.replace({ name: "home" });
          await warning("Vous n'êtes pas connecté.");
        } else {
          await danger("Erreur inconnue.");
        }
      } else {
        await danger("Pas de réponse du serveur.");
      }
    });
});

async function onSubmit() {
  http
    .get("/api/sign-out", { withCredentials: true })
    .then(async ({ data }) => {
      doSignOut();
      window.location.href = data.nextUrl;
    })
    .catch(async ({ response }) => {
      if (response) {
        if (response.status === 401) {
          await warning("Vous n'êtes pas connecté.");
          router.replace({ name: "sign-in" });
        } else {
          await danger("Erreur inconnue.");
        }
      } else {
        await danger("Pas de réponse du serveur.");
      }
    });
}
</script>

<template>
  <Hero
    title="Page de déconnexion"
    description="Voulez-vous vous déconnecter ?"
    icon="log-out"
  />

  <div class="w-full px-8 py-8">
    <div
      class="flex flex-col gap-0 md:w-96 w-full shadow-md rounded-xl bg-zinc-100 border border-zinc-300 py-8 px-6"
    >
      <div class="flex flex-row gap-0 w-full">
        <p
          class="w-1/3 pr-3 py-4 font-bold text-right border-r-4 border-rose-600"
        >
          Utilisateur
        </p>
        <p class="w-2/3 pl-3 py-4">
          {{ state.userName }}
        </p>
      </div>

      <div class="flex flex-row gap-0 w-full">
        <p
          class="w-1/3 pr-3 py-4 font-bold text-right border-r-4 border-rose-600"
        >
          Email
        </p>
        <p class="w-2/3 pl-3 py-4">
          {{ state.userEmail }}
        </p>
      </div>

      <FormKit
        type="submit"
        label="Valider"
        @click="onSubmit"
        :actions="false"
        prefix-icon="check"
        wrapper-class="w-full justify-center mt-8"
      />
    </div>
  </div>
</template>
