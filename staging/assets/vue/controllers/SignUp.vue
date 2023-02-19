<script setup>
// assets/vue/controllers/SignUp.vue

import _ from "lodash";
import { onMounted, reactive } from 'vue';
import { toast } from 'vue3-toastify';
import "vue3-toastify/dist/index.css";
import http from "../services/http";
import Title from "../components/Title.vue";
import Description from "../components/Description.vue";
import Navigation from "../components/Navigation.vue";

const state = reactive({
  password: "",
  showPassword: false,
  registerStatus: "Idle",
})

async function notify(message) {
  toast(message);
}

async function success(message) {
  toast.success(message);
}

async function warning(message) {
  toast.warning(message);
}

async function registerUser(fields) {
  const { data, status } = await http.post("/sign-up", {
    username: fields.username,
    password: fields.password,
    email: fields.email,
    approvals: fields.approvals,
  });

  if (status === 201) {
    state.registerStatus = "Success";
    success("Vous êtes bien enregistré !");
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
</script>

<template>
  <div class="h-full flex flex-col justify-center items-center gap-12">
    <div class="w-full max-w-sm flex flex-col items-center justify-center gap-6">
      <div class="text-center">
        <Title random-color>
          Inscription
        </Title>

        <Description>
          Renseignez vos informations pour
          créer votre compte d'utilisateur.
        </Description>
      </div>

      <FormKit
        type="form"
        id="signUpForm"
        @submit="registerUser"
        :actions="false"
      >
        <div class="w-full max-w-sm flex flex-col gap-3">
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
