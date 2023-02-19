<script setup>
// assets/vue/App.vue
import Navigation from "./components/Navigation.vue";
</script>

<template>
  <div id="app" class="bg-teal-700 text-white h-full">
    <Navigation />
    <router-view />
  </div>
</template>