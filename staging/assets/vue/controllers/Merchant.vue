<template>
    <div class="flex flex-col justify-start items-center gap-12">
        <div class="w-full flex flex-col items-center justify-center gap-6">
            <FormKit type="form" id="merchantForm" @submit="merchant" :actions="false">
                <div class="w-full max-w-sm pt-6 px-3 flex flex-col gap-3">
                    <FormKit type="text" name="companyName" label="Nom de l'entreprise" placeholder="Apple"
                        validation="required|length:6,60" validation-visibility="live" :validation-messages="{
                            required: `Veulliez saisir le nom de votre entreprise.`,
                            length: `Veulliez saisir entre 6 et 60 caractères.`,
                        }" />

                    <FormKit type="text" name="activity" label="activité" placeholder="technologie"
                        validation="required|length:6,30" validation-visibility="live" :validation-messages="{
                            required: `Veulliez saisir votre activité.`,
                            length: `Veulliez saisir entre 6 et 30 caractères.`,
                        }" />

                    <FormKit type="email" name="emailAddress" label="Addresse email" prefix-icon="email"
                        placeholder="apple@gmail.com" validation="required|length:6,60|email" validation-visibility="live"
                        :validation-messages="{
                            required: `Veulliez saisir une adresse email.`,
                            length: `Veulliez saisir entre 6 et 60 caractères.`,
                            email: `Veulliez saisir une adresse email correcte.`,
                        }" />

                    <FormKit type="tel" name="phoneNumber" label="Numéro de téléphone" placeholder="0123456789"
                        validation="required|matches:/^[0-5][0-9]{9}$/" :validation-messages="{
                            matches: 'Votre numéro doit commencer par un chiffre de 0 à 5 et être suivi de 9 chiffres.',
                            required: `Veulliez saisir votre numéro de téléphone.`,
                        }" validation-visibility="dirty" />

                    <FormKit type="text" name="street" label="Adresse" placeholder="12 Californie"
                        validation="required|length:10,120" validation-visibility="live" :validation-messages="{
                            required: `Veulliez saisir votre adresse.`,
                            length: `Veulliez saisir entre 10 et 120 caractères.`,
                        }" />

                    <FormKit type="number" label="Code postal" name="postalCode" placeholder="12345"
                        validation="required|length:5,10|" :validation-messages="{
                            required: `Veulliez saisir votre code postal.`,
                            length: `Veulliez saisir entre 5 et 10 chiffres.`,
                        }" />

                    <FormKit type="text" name="locality" label="Ville" placeholder="Californie"
                        validation="required|length:10,60" validation-visibility="live" :validation-messages="{
                            required: `Veulliez saisir votre ville.`,
                            length: `Veulliez saisir entre 10 et 60 caractères.`,
                        }" />

                    <FormKit type="text" name="country" label="Pays" placeholder="Etats-Unis"
                        validation="required|length:10,60" validation-visibility="live" :validation-messages="{
                            required: `Veulliez saisir votre pays.`,
                            length: `Veulliez saisir entre 10 et 60 caractères.`,
                        }" />
                    <FormKit type="text" name="website" label="Site web" placeholder="www.apple.fr"
                        validation="length:10,60" validation-visibility="live" :validation-messages="{
                            length: `Veulliez saisir entre 10 et 60 caractères.`,
                        }" />
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

async function merchant(fields) {
    const { data, status } = await http.post("/api/merchant", {
        companyName: fields.companyName,
        activity: fields.activity,
        emailAddress: fields.emailAddress,
        phoneNumber: fields.phoneNumber,
        street: fields.street,
        postalCode: fields.postalCode,
        locality: fields.locality,
        country: fields.country,
        website: fields.website

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