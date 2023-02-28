<script setup>
// assets/vue/controllers/SignIn.vue

import _ from "lodash";
import { reactive } from "vue";
import { useRouter } from "vue-router";
import { useUserStore } from "@/helpers/stores";
import http from "@/helpers/http";
import Hero from "@/components/Hero.vue";

const router = useRouter();
const { doSignIn } = useUserStore();
const state = reactive({
  password: "",
  showPassword: false,
});

function showPassword() {
  state.showPassword = !state.showPassword;
}

async function onSubmit({ username, password, _remember_me }) {
  http
    .post(
      "/api/sign-in",
      { username, password, _remember_me },
      { withCredentials: true },
    )
    .then(({ data }) => {
      doSignIn({ username: data.username, roles: data.roles });
      window.location.href = "/my-account";
    })
    .catch(async ({ response }) => {
      if (response) {
        if (response.status === 401)
          await warning("Utilisateur ou mot de passe invalide.");
        else await danger("Erreur inconnue.");
      } else {
        await danger("Pas de réponse du serveur.");
      }
    });
}
</script>

<template>
  <Hero title="Connexion" description="Accédez à votre compte." icon="log-in" />
  <div class="w-full px-8">
    <FormKit type="form" id="signUpForm" @submit="onSubmit" :actions="false">
      <div class="w-full max-w-sm pt-6 px-3 flex flex-col gap-3">
        <FormKit
          type="text"
          name="username"
          prefix-icon="people"
          placeholder="Identifiant"
          validation="required|length:6,60|alphanumeric"
          validation-visibility="live"
          :validation-messages="{
            required: `Veulliez saisir un identifiant.`,
            length: `Veulliez saisir entre 6 et 60 caractères.`,
            alphanumeric: `Veulliez saisir des lettres et des chiffres sans espaces.`,
          }"
        />

        <FormKit
          name="password"
          :type="state.showPassword ? 'text' : 'password'"
          :prefix-icon="state.showPassword ? 'eyeClosed' : 'password'"
          @prefix-icon-click="showPassword"
          v-model="state.password"
          placeholder="Mot de passe"
          validation="required|length:6,120"
          validation-visibility="live"
          :validation-messages="{
            required: `Veulliez saisir un mot de passe.`,
            length: `Veulliez saisir entre 6 et 120 caractères.`,
          }"
        />

        <FormKit
          type="checkbox"
          name="_remember_me"
          label="Rester connecté"
          help="Vérifiez que vous utilisez bien un appareil personnel."
        />

        <FormKit
          type="submit"
          label="Valider"
          prefix-icon="check"
          :actions="false"
          wrapper-class="w-full justify-center"
        />
      </div>
    </FormKit>
  </div>
</template>
