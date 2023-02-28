<script setup>
// assets/vue/App.vue

import { onBeforeMount, onBeforeUnmount, onMounted, onUpdated } from "vue";
import { useRouter } from "vue-router";
import { useBrowserStore, useUserStore } from "@/helpers/stores";
import http from "@/helpers/http";
import sleep from "@/helpers/sleep";
import { danger, notify } from "@/helpers/toasts";
import { featherReplace } from "@/helpers/feather";
import "~/assets/styles/app.css";
import "animate.css";

const { doWindowResize } = useBrowserStore();
const { doSignIn, doSignOut, userState } = useUserStore();
const router = useRouter();

async function doSignCheck() {
  await http
    .get("/api/sign-check", { withCredentials: true })
    .then(async ({ data }) => {
      if (!userState.isAuthenticated) {
        doSignIn(data.user);
        await notify("Reconnexion de votre compte utilisateur...");
        await sleep(5000);
        router.go();
      }
    })
    .catch(async ({ response }) => {
      if (!response) {
        await danger("Pas de réponse du serveur.");
      } else {
        if (response.status === 401) doSignOut();
        else await danger("Erreur inconnue.");
      }
    });
}

onBeforeMount(async () => {
  await doSignCheck();
  window.addEventListener("resize", doWindowResize);
  window.addEventListener("resize", featherReplace);
});

onBeforeUnmount(() => {
  window.removeEventListener("resize", doWindowResize);
  window.removeEventListener("resize", featherReplace);
});

onMounted(async () => {
  doWindowResize();
  featherReplace();
});
</script>

<template>
  <router-view />
</template>
