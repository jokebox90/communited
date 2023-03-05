<script setup>
// assets/vue/AppLayout.vue

import Navigation from "@/components/Navigation.vue";
</script>

<template>
  <navigation />
  <div
    class="w-screen min-h-screen relative grid grid-cols-12 gap-y-8 px-40 bg-orange-300 text-zinc-900"
  >
    <router-view />
  </div>

  <div class="w-screen px-8 py-16 grid grid-cols-12 bg-rose-900 text-white">
    <div class="col-span-4">
      <h2>[Titre du site]</h2>

      <p class="mb-3">
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla libero
        nibh, congue venenatis porta eget, accumsan eu est. Pellentesque
        scelerisque ligula nulla, eu porta lectus laoreet ac. Morbi id lorem
        bibendum, mollis quam id, egestas velit. Aenean et vestibulum est,
        finibus elementum lectus.
      </p>

      <div class="mb-4">
        <p class="mb-3">[Propriétaire]</p>
        <p class="mb-3">&copy; Tous droits réservés</p>
      </div>
    </div>

    <div class="col-span-4 col-start-8">
      <h2>Restez en contact</h2>
    </div>
  </div>
</template>
