<script setup>
import { onUpdated, onMounted } from "vue";
import { featherReplace } from "@/helpers/feather";

onMounted(async () => {
  featherReplace();
});

onUpdated(async () => {
  featherReplace();
});

defineProps({
  to: Array | Object,
  title: String,
  icon: String,
});
</script>

<template>
  <router-link
    :to="to"
    class="v-nav-link mt-1 px-4 py-2 inline-flex justify-between w-max gap-3 transition duration-200 delay-100 first:border-0 border-l border-r-white text-white hover:text-yellow-300 hover:-translate-y-1"
  >
    {{ title }}
    <i :data-feather="icon" class="w-5 h-5"></i>
  </router-link>
</template>
