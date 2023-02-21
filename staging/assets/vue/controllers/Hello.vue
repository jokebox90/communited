<script setup>
// assets/vue/controllers/About.vue

import _ from "lodash";
import { computed, reactive } from 'vue';
import { useRoute } from 'vue-router';
import Title from "@/components/Title.vue";

const route = useRoute();

const firstNameParam = computed(() => route.params.firstName);
const lastNameParam = computed(() => route.params.lastName);

const state = reactive({
  firstName: _.capitalize(_.defaultTo(firstNameParam.value, "")),
  lastName: _.capitalize(_.defaultTo(lastNameParam.value, "world")),
});
</script>

<template>
  <div class="mx-auto w-max">
    <Title random-color>
      Hello, {{ state.firstName }} {{ state.lastName }}!
    </Title>
  </div>
</template>
