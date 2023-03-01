<template>
    <div class="flex flex-col justify-start items-center gap-12">
        <div class="w-full flex flex-col items-center justify-center gap-6">
            <FormKit type="form" id="itemForm" @submit="item" :actions="false">
                <div class="w-full max-w-sm pt-6 px-3 flex flex-col gap-3">
                    <FormKit type="text" name="title" label="titre" placeholder="" validation="required|length:6,255"
                        validation-visibility="live" :validation-messages="{
                            required: `Veulliez saisir le titre de l'article.`,
                            length: `Veulliez saisir entre 6 et 225 caractères.`,
                        }" />

                    <FormKit type="textarea" name="description" label="description" validation="required|length:6,500"
                        rows="10" validation-visibility="live" :validation-messages="{
                            required: `Veulliez saisir votre activité.`,
                            length: `Veulliez saisir entre 6 et 500 caractères.`,
                        }" />
                    <FormKit type="taglist" name="tags" label="Tags" :options="tags" :allow-new-values="true" />
                </div>
            </FormKit>
        </div>
    </div>
</template>



<script setup>
import _ from "lodash";
import { reactive, ref } from "vue";
import http from "@/helpers/http";
import { success, warning } from "@/helpers/toasts";

const state = reactive({
    registerStatus: "Idle",
});

const tags = ref([])

async function item(fields) {
    const { data, status } = await http.post("/api/item", {
        title: fields.title,
        description: fields.description,
        tags: fields.tags,
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