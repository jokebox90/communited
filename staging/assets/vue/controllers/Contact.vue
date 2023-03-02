<template>
  <div class="flex flex-col justify-start items-center gap-12">
    <div class="w-full flex flex-col items-center justify-center gap-6">
      <FormKit type="form" id="contactForm" @submit="contact" :actions="false">
        <div class="w-full max-w-sm pt-6 px-3 flex flex-col gap-3">
          <FormKit
            type="text"
            name="contactName "
            label="Nom du contact"
            placeholder="Dupont"
            validation="required|length:6,60"
            validation-visibility="live"
            :validation-messages="{
              required: `Veulliez saisir le nom du contact.`,
              length: `Veulliez saisir entre 6 et 60 caractères.`,
            }"
          />
          <FormKit
            type="email"
            name="emailAddress"
            label="Addresse email"
            prefix-icon="email"
            placeholder="dupont@gmail.com"
            validation="required|length:6,60|email"
            validation-visibility="live"
            :validation-messages="{
              required: `Veulliez saisir une adresse email.`,
              length: `Veulliez saisir entre 6 et 60 caractères.`,
              email: `Veulliez saisir une adresse email correcte.`,
            }"
          />
          <FormKit
            type="tel"
            name="phoneNumber"
            label="Numéro de téléphone"
            placeholder="0123456789"
            validation="required|matches:/^[0-5][0-9]{9}$/"
            :validation-messages="{
              matches:
                'Votre numéro doit commencer par un chiffre de 0 à 5 et être suivi de 9 chiffres.',
              required: `Veulliez saisir votre numéro de téléphone.`,
            }"
            validation-visibility="dirty"
          />

          <FormKit
            type="text"
            name="street"
            label="Adresse"
            placeholder="12 Californie"
            validation="required|length:10,120"
            validation-visibility="live"
            :validation-messages="{
              required: `Veulliez saisir votre adresse.`,
              length: `Veulliez saisir entre 10 et 120 caractères.`,
            }"
          />
          <FormKit
            type="number"
            label="Code postal"
            name="postalCode"
            placeholder="12345"
            validation="required|length:5,10|"
            :validation-messages="{
              required: `Veulliez saisir votre code postal.`,
              length: `Veulliez saisir entre 5 et 10 chiffres.`,
            }"
          />
          <FormKit
            type="text"
            name="locality"
            label="Ville"
            placeholder="Californie"
            validation="required|length:10,60"
            validation-visibility="live"
            :validation-messages="{
              required: `Veulliez saisir votre ville.`,
              length: `Veulliez saisir entre 10 et 60 caractères.`,
            }"
          />
          <FormKit
            type="text"
            name="country"
            label="Pays"
            placeholder="Etats-Unis"
            validation="required|length:10,60"
            validation-visibility="live"
            :validation-messages="{
              required: `Veulliez saisir votre pays.`,
              length: `Veulliez saisir entre 10 et 60 caractères.`,
            }"
          />
          <FormKit
            type="number"
            name="siret"
            label="Numéro siret"
            placeholder="12345678901234"
            validation="required|matches:/^[0-9]{14}$/"
            :validation-messages="{
              required: 'Veuillez saisir votre numéro de siret',
              matches: 'Votre numéro de siret doit comporter 14 chiffres',
            }"
            validation-visibility="dirty"
          />
          <FormKit
            type="text"
            name="vat"
            label="Numéro TVA"
            validation="required|length:12,20"
            validation-visibility="live"
            :validation-messages="{
              required: `Veulliez saisir votre numéro de TVA.`,
              length: `Veulliez saisir entre 12 et 20 caractères.`,
            }"
          />
          <FormKit
            type="textarea"
            name="additionalNotes"
            label="Informations complémentaire"
            validation="length:6,500"
            rows="10"
            validation-visibility="live"
            :validation-messages="{
              length: `Veulliez saisir entre 6 et 500 caractères.`,
            }"
          />
        </div>
      </FormKit>
    </div>
  </div>
</template>

<script setup>
import _ from "lodash";
import { reactive } from "vue";
import http from "@/helpers/http";
import { success, warning } from "@/helpers/toasts";

const state = reactive({
  registerStatus: "Idle",
});

async function contact(fields) {
  const { data, status } = await http.post("/api/merchant", {
    contactName: fields.contactName,
    emailAddress: fields.emailAddress,
    phoneNumber: fields.phoneNumber,
    street: fields.street,
    postalCode: fields.postalCode,
    locality: fields.locality,
    country: fields.country,
    siret: fields.siret,
    vat: fields.vat,
    additionalNotes: fields.additionalNotes,
  });

  if (status === 201) {
    state.registerStatus = "Success";
    await success("Vous êtes bien enregistré !");
  } else if (status === 400) {
    state.registerStatus = "Error";
    _.map(data.messages, async (m) => await warning(m));
  }
}
</script>
