<script setup>
// assets/vue/components/VFeather.vue

import { onUpdated, onMounted } from "vue";
import { featherReplace } from "@/helpers/feather";

onMounted(async () => {
  featherReplace();
});

onUpdated(async () => {
  featherReplace();
});

const Props = defineProps({
  class: String,
  icon: String,
});
</script>

<template>
  <i class="w-full h-full" :class="class" :data-feather="icon"></i>
</template>
