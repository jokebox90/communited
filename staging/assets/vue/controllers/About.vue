<script setup>
import _ from "lodash";
import { computed } from 'vue';
import { useRoute } from 'vue-router';
import Logos from "@/components/Logos.vue";
import Title from "@/components/Title.vue";

const route = useRoute();
const path = computed(() => route.path);
</script>

<template>
  <div class="flex flex-col items-center justify-start">
    <Logos />

    <div class="flex flex-col items-center w-max">
      <Title class="text-rose-600">
        Vous êtes ici: {{ path }}
      </Title>

      <p>Editez: assets/vue/controllers/About.vue</p>
    </div>
  </div>
</template>

