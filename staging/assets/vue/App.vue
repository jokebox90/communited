<script setup>
// assets/vue/App.vue
import Navigation from "@/components/Navigation.vue";
</script>

<template>
  <div id="app" class="bg-gradient-to-br from-slate-300 to-slate-100 text-zinc-900 min-h-full">
    <Navigation />
    <router-view />
  </div>
</template>