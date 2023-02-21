<script setup>
// assets/vue/controllers/SignUp.vue

import _ from "lodash";
import { onBeforeMount, reactive } from 'vue';
import { useRouter } from "vue-router";
import { useUserStore } from "../helpers/stores";
import http from "../helpers/http";
import { success, warning } from "../helpers/toasts";
import Hero from "../components/Hero.vue";

const router = useRouter();
const userStore = useUserStore();
const state = reactive({
  password: "",
  showPassword: false,
  registerStatus: "Idle",
});

async function signUp(fields) {
  const { data, status } = await http.post("/api/sign-up", {
    username: fields.username,
    password: fields.password,
    email: fields.email,
    approvals: fields.approvals,
  });

  if (status === 201) {
    state.registerStatus = "Success";
    await success("Vous êtes bien enregistré !");
  } else if (status === 400) {
    state.registerStatus = "Error";
    _.map(data.messages, async (m) => await warning(m));
  }
}

function showPassword() {
  state.showPassword = !state.showPassword;
}

function generatePassword() {
  const chars = [
    String.fromCharCode(_.random(33, 47)),
    String.fromCharCode(_.random(58, 64)),
    String.fromCharCode(_.random(91, 96)),
    String.fromCharCode(_.random(123, 126)),
    _.random(1000, 9999),
  ];

  for (let index = 0; index < 4; index++) {
    chars.push(String.fromCharCode(_.random(65, 90)));
    chars.push(String.fromCharCode(_.random(97, 122)));
  }

  state.password = _.join(_.shuffle(chars), "");
  state.showPassword = true;
}

onBeforeMount(() => {
  if (userStore.isAuthenticated) router.push("my-account");
});
</script>

<template>
  <div class="flex flex-col justify-start items-center gap-12">
    <div class="w-full flex flex-col items-center justify-center gap-6">

      <Hero
        cite="Gestion des comptes"
        title="Inscription"
        description="Renseigner vos informations utilisateur et créez votre compte."
      />

      <FormKit
        type="form"
        id="signUpForm"
        @submit="signUp"
        :actions="false"
      >
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
            type="email"
            name="email"
            prefix-icon="email"
            placeholder="Email"
            validation="required|length:6,120|email"
            validation-visibility="live"
            :validation-messages="{
              required: `Veulliez saisir une adresse email.`,
              length: `Veulliez saisir entre 6 et 60 caractères.`,
              email: `Veulliez saisir une adresse email correcte.`,
            }"
          />

          <FormKit
            name="password"
            :type='state.showPassword ? "text" : "password"'
            :prefix-icon='state.showPassword ? "eyeClosed" : "password"'
            @prefix-icon-click="showPassword"
            @suffix-icon-click="generatePassword"
            v-model="state.password"
            suffix-icon="refresh"
            placeholder="Mot de passe"
            validation="required|length:6,120"
            validation-visibility="live"
            :validation-messages="{
              required: `Veulliez saisir un mot de passe.`,
              length: `Veulliez saisir entre 6 et 120 caractères.`,
            }"
            help="Vous pouvez générer un mot de passe sécurisé automatiquement."
          />

          <FormKit
            type="checkbox"
            name="approvals"
            label="Conditions d'utilisations"
            help="En cochant cette case, je reconnais avoir lu et j'accepte les conditions d'utilisation du service."
            validation="accepted"
            validation-visibility="live"
            :validation-messages="{ accepted: `Votre approbation est nécessaire pour continuer.`, }"
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
  </div>
</template>
