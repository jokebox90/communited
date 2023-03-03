<script setup>
// assets/vue/controllers/MyAccount.vue

import { reactive, onBeforeMount, onMounted } from "vue";
import { useRoute, useRouter } from "vue-router";
import http from "@/helpers/http";
import { warning } from "@/helpers/toasts";
import Hero from "@/components/Hero.vue";
import { success } from "../helpers/toasts";

const route = useRoute();
const router = useRouter();

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

onMounted(() => {
  if (route.query.login) success("Vous êtes bien connecté !");
});
</script>

<template>
  <Hero
    title="Mon compte"
    description="Retrouvez toutes les informations de votre compte utilisateur."
    icon="user"
  />

  <div class="w-full">
    <div class="mb-3">
      <p class="font-bold">Utilisateur</p>
      <p>{{ state.userName }}</p>
    </div>
    <div class="mb-3">
      <p class="font-bold">Adresse email</p>
      <p>{{ state.userEmail }}</p>
    </div>
  </div>
</template>
