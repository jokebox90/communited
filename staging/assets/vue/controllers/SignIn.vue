<script setup>
// assets/vue/controllers/SignIn.vue

import _ from "lodash";
import { reactive } from 'vue';
import { useRouter } from "vue-router";
import { useUserStore } from "@/helpers/stores";
import Hero from "@/components/Hero.vue";

const router = useRouter();
const userStore = useUserStore();
const state = reactive({
  password: "",
  showPassword: false,
});

function showPassword() {
  state.showPassword = !state.showPassword;
}

async function doSignInHandler(fields) {
  const { status } = await userStore.doSignIn(fields);
  if (status === 200) router.push("my-account");
}
</script>

<template>
  <div class="flex flex-col justify-start items-center gap-12">
    <div class="w-full flex flex-col items-center justify-center gap-6">

      <Hero
        title="Connexion"
        description="Accédez à votre compte."
      />

      <FormKit
        type="form"
        id="signUpForm"
        @submit="async (fields) => await doSignInHandler(fields)"
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
            name="password"
            :type='state.showPassword ? "text" : "password"'
            :prefix-icon='state.showPassword ? "eyeClosed" : "password"'
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
