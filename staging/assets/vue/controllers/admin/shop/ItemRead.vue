<script setup>
// assets/vue/controllers/admin/ShopItems/ItemList.vue

import _ from "lodash";
import { reactive, onBeforeMount } from "vue";
import http from "@/helpers/http";
import Hero from "@/components/Hero.vue";
import { useRoute } from "vue-router";
import VBtnLink from "@/components/links/VBtnLink.vue";

const route = useRoute();
const state = reactive({
  item: {},
});

onBeforeMount(async () => {
  const itemId = route.params.itemId;
  const { data, status } = await http.get(`/api/shop/items/${itemId}`, {
    withCredentials: true,
  });

  if (status === 200) {
    _.assign(state.item, {
      itemId: data.item.itemId,
      title: data.item.title,
      description: data.item.description,
      available: data.item.available,
      tags: data.item.tags,
    });
  }
});
</script>

<template>
  <Hero
    title="Articles de la boutique"
    description="Retrouvez tous les article de votre boutique en ligne."
  />

  <div class="flex flex-wrap flex-row gap-4 justify-center w-full px-4 py-8">
    <div
      class="w-96 flex flex-col justify-between shadow-md rounded-xl border border-zinc-300 bg-gradient-to-br from-blue-900 to-blue-500 p-4"
    >
      <div>
        <p class="mb-2 text-white">
          <span class="font-bold">Titre</span>
        </p>

        <p class="mb-2 ml-4 text-white">
          {{ state.item.title }}
        </p>

        <p class="mb-2 text-white">
          <span class="font-bold">Tags</span>
        </p>

        <p class="mb-2 ml-4 text-white">#{{ _.join(state.item.tags, " #") }}</p>

        <p class="mb-2 text-white">
          <span class="font-bold">Disponibilité</span>
        </p>

        <p class="mb-2 ml-4 text-white">
          {{ state.item.available }}
        </p>

        <p class="mb-2 text-white">
          <span class="font-bold">Description</span>
        </p>

        <p class="mb-2 ml-4 text-white">
          {{ state.item.description }}
        </p>
      </div>

      <v-btn-link
        :to="{ name: 'shop-item-list' }"
        title="Retour"
        icon="chevrons-left"
        color="blue"
      />
    </div>
  </div>
</template>
