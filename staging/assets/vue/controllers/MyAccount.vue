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
  />

  <div class="w-screen flex flex-row justify-center px-4 py-8">
    <table class="border-collapse border border-rose-700 md:w-1/3 sm:w-80">
      <tr>
        <th
          class="border border-yellow-300 bg-yellow-50 text-zinc-400 px-4 py-2"
        >
          Utilisateur
        </th>
        <td
          class="border border-zinc-300 bg-yellow-300 text-zinc-700 px-4 py-2"
        >
          {{ state.userName }}
        </td>
      </tr>
      <tr>
        <th
          class="border border-yellow-300 bg-yellow-50 text-zinc-400 px-4 py-2"
        >
          Adresse email
        </th>
        <td
          class="border border-zinc-300 bg-yellow-300 text-zinc-700 px-4 py-2"
        >
          {{ state.userEmail }}
        </td>
      </tr>
    </table>
  </div>
</template>
