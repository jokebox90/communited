<script setup>
import Hero from "./Hero.vue";
import symfonyBlackTransparentPNG from "../../images/symfony_black_transparent.png";
</script>

<template>
  <Hero
    cite="Application développée avec"
    title="Symfony - VueJS - TailwindCSS"
  />

  <div class="mb-12 flex flex-row justify-center gap-12 w-min mx-auto pt-12">
    <div class="w-60 h-60 px-8 bg-gradient-to-br from-white to-zinc-400 border border-white rounded-3xl flex items-center">
      <img :src="symfonyBlackTransparentPNG" class="w-full h-auto">
    </div>
    <div class="w-60 h-60 px-8 bg-gradient-to-br from-white to-zinc-400 border border-white rounded-3xl flex items-center">
      <img src="https://upload.wikimedia.org/wikipedia/commons/9/95/Vue.js_Logo_2.svg" alt="Logo VueJS"
        class="w-full h-auto">
    </div>
    <div class="w-60 h-60 px-8 bg-gradient-to-br from-white to-zinc-400 border border-white rounded-3xl flex items-center">
      <img src="https://tailwindcss.com/_next/static/media/tailwindcss-mark.79614a5f61617ba49a0891494521226b.svg" alt="Logo Bootstrap"
        class="w-full h-auto">
    </div>
  </div>
</template>
