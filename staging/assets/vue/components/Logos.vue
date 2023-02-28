<script setup>
import Hero from "./Hero.vue";
import symfonyBlackTransparentPNG from "@/images/symfony_black_transparent.png";
import tailwindcssPNG from "@/images/tailwindcss.png";
</script>

<template>
  <Hero
    cite="Application développée avec"
    title="Symfony - VueJS - TailwindCSS"
    icon="code"
  />

  <div
    class="flex md:flex-row max-sm:flex-col justify-around items-center w-screen p-12"
  >
    <div
      class="w-80 h-80 px-8 bg-gradient-to-br from-white to-zinc-400 border border-white rounded-3xl flex items-center"
    >
      <img :src="symfonyBlackTransparentPNG" class="w-full h-auto" />
    </div>
    <div
      class="w-80 h-80 px-8 bg-gradient-to-br from-white to-zinc-400 border border-white rounded-3xl flex items-center"
    >
      <img
        src="https://upload.wikimedia.org/wikipedia/commons/9/95/Vue.js_Logo_2.svg"
        alt="Logo VueJS"
        class="w-full h-auto"
      />
    </div>
    <div
      class="w-80 h-80 px-8 bg-gradient-to-br from-white to-zinc-400 border border-white rounded-3xl flex items-center"
    >
      <img :src="tailwindcssPNG" alt="Logo Bootstrap" class="w-full h-auto" />
    </div>
  </div>
</template>
