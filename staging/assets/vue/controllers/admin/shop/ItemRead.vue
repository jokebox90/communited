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
    icon="shopping-bag"
  />

  <v-btn-link
    :to="{ name: 'shop-item-list' }"
    title="Retour"
    icon="chevrons-left"
    color="blue"
  />

  <div class="w-96 mt-8">
    <div>
      <p class="mb-2 text-zinc-900">
        <span class="font-bold">Titre</span>
      </p>

      <p class="mb-2 ml-4 text-zinc-900">
        {{ state.item.title }}
      </p>

      <p class="mb-2 text-zinc-900">
        <span class="font-bold">Tags</span>
      </p>

      <p class="mb-2 ml-4 text-zinc-900">
        #{{ _.join(state.item.tags, " #") }}
      </p>

      <p class="mb-2 text-zinc-900">
        <span class="font-bold">Disponibilité</span>
      </p>

      <p class="mb-2 ml-4 text-zinc-900">
        {{ state.item.available }}
      </p>

      <p class="mb-2 text-zinc-900">
        <span class="font-bold">Description</span>
      </p>

      <p class="mb-2 ml-4 text-zinc-900">
        {{ state.item.description }}
      </p>
    </div>
  </div>
</template>
