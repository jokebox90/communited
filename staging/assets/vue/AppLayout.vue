<script setup>
// assets/vue/AppLayout.vue

import Navigation from "@/components/Navigation.vue";
</script>

<template>
  <navigation />
  <div class="w-screen relative lg:px-40 px-8">
    <router-view />
  </div>
</template>
