<script setup>
// assets/vue/controllers/admin/ShopItems/ItemList.vue

import _ from "lodash";
import { reactive, onBeforeMount } from 'vue';
import http from "@/helpers/http";
import Hero from "@/components/Hero.vue";
import { useRoute } from "vue-router";

const route = useRoute();
const state = reactive({
  itemList: [],
})

onBeforeMount(async () => {
  const itemId = route.params.itemId;
  const { data, status } = await http.get(`/api/shop/items/${itemId}`, {
    withCredentials: true
  });

  if (status === 200) {
    state.item = {
      itemId: data.shopItem.itemId,
      title: data.shopItem.title,
      description: data.shopItem.description,
      available: data.shopItem.available,
      tags: data.shopItem.tags,
    }
  }
});
</script>

<template>
  <Hero :title="state.item.title" description="Article de votre boutique en ligne." />

  <div class="w-full px-3 py-8">
    <div class="flex flex-col gap-0 w-full shadow-md rounded-xl bg-zinc-100 border border-zinc-300 py-8 px-6">
      <div class="flex flex-row gap-0 w-full">
        <p class="w-1/3 pr-3 py-4 font-bold text-right border-r-4 border-rose-600">
          UniqueId
        </p>

        <p class="w-2/3 pl-3 py-4">
          {{ state.item.itemId }}
        </p>
      </div>

      <div class="flex flex-row gap-0 w-full">
        <p class="w-1/3 pr-3 py-4 font-bold text-right border-r-4 border-rose-600">
          Titre
        </p>

        <p class="w-2/3 pl-3 py-4">
          {{ state.item.title }}
        </p>
      </div>

      <div class="flex flex-row gap-0 w-full">
        <p class="w-1/3 pr-3 py-4 font-bold text-right border-r-4 border-rose-600">
          Tags
        </p>
        <p class="w-2/3 pl-3 py-4">
          {{ _.join(state.item.tags, ", ") }}
        </p>
      </div>

      <div class="flex flex-row gap-0 w-full">
        <p class="w-1/3 pr-3 py-4 font-bold text-right border-r-4 border-rose-600">
          Disponibilité
        </p>
        <p class="w-2/3 pl-3 py-4">
          {{ state.item.available }}
        </p>
      </div>
    </div>

    <div class="py-8 text-center font-bold text-lg">
      <p>{{ state.item.description }}</p>
    </div>
  </div>
</template>