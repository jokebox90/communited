<script setup>
// assets/vue/controllers/SignUp.vue

import _ from "lodash";
import moment from "moment";
import { onBeforeMount, reactive } from "vue";
import { useRouter } from "vue-router";
import { useUserStore } from "@/helpers/stores";
import http from "@/helpers/http";
import { success, warning } from "@/helpers/toasts";
import Hero from "@/components/Hero.vue";
import sleep from "@/helpers/sleep";

const router = useRouter();
const { userState } = useUserStore();
const { isAuthenticated } = userState;
const state = reactive({
  password: "",
  showPassword: false,
  registerStatus: "Idle",
});

const date = moment().subtract(30, "years").format("YYYY-01-31");

async function addDetailsHandler(fields) {
  await sleep(2000);
  alert(JSON.stringify(fields));
  // const { data, status } = await http.post("/api/sign-up", {
  //   username: fields.username,
  //   password: fields.password,
  //   email: fields.email,
  //   approvals: fields.approvals,
  // });

  // if (status === 201) {
  //   state.registerStatus = "Success";
  //   await success("Vous êtes bien enregistré !");
  // } else if (status === 400) {
  //   state.registerStatus = "Error";
  //   _.map(data.messages, async (m) => await warning(m));
  // }
}

onBeforeMount(() => {
  if (!isAuthenticated) router.push({ name: "my-account" });
});
</script>

<template>
  <Hero
    cite="Adresse de contact"
    title="Nouveau contact"
    description="Ajoutez une nouvelle adresse de contact."
    icon="phone-incoming"
  />
  <div class="w-full flex flex-col justify-center px-8 gap-6">
    <FormKit
      type="form"
      id="addDetailsForm"
      @submit="addDetailsHandler"
      :actions="false"
    >
      <div class="w-96 pt-6 px-3 flex flex-col gap-3">
        <FormKit
          type="text"
          name="firstName"
          label="Prénom"
          label-class="text-end"
          placeholder="Prénom"
          prefix-icon="tag"
          validation="required|length:2,60|alphanumeric"
          :validation-messages="{
            required: `Veulliez saisir votre prénom.`,
            length: `Veulliez saisir entre 6 et 60 caractères.`,
            alphanumeric: `Veulliez saisir des lettres et des chiffres sans espaces.`,
          }"
        />

        <FormKit
          type="text"
          name="lastName"
          label="Nom"
          label-class="text-end"
          placeholder="Nom"
          prefix-icon="tag"
          validation="required|length:2,60|alphanumeric"
          :validation-messages="{
            required: `Veulliez saisir votre nom.`,
            length: `Veulliez saisir entre 6 et 60 caractères.`,
            alphanumeric: `Veulliez saisir des lettres et des chiffres sans espaces.`,
          }"
        />

        <FormKit
          name="birthDate"
          type="date"
          label="Date de naissance"
          label-class="text-end"
          prefix-icon="star"
          validation="required"
          :value="date"
        />

        <FormKit
          type="email"
          name="email"
          label="Email"
          label-class="text-end"
          prefix-icon="email"
          placeholder="Email"
          validation="required|length:6,120|email"
          :validation-messages="{
            required: `Veulliez saisir une adresse email.`,
            length: `Veulliez saisir entre 6 et 60 caractères.`,
            email: `Veulliez saisir une adresse email correcte.`,
          }"
        />

        <FormKit
          name="phoneNumber"
          type="text"
          label="Téléphone"
          label-class="text-end"
          placeholder="Numéro de téléphone"
          prefix-icon="telephone"
          validation="required|length:10,20"
          :validation-messages="{
            required: `Veulliez saisir votre numéro de téléphone.`,
            length: `Veulliez saisir un numéro à 10 chiffres.`,
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
</template>
