<script setup>
// assets/vue/controllers/admin/ShopItems/ItemList.vue

import _ from "lodash";
import { onBeforeMount, onUpdated, reactive } from "vue";
import { useRouter } from "vue-router";
import http from "@/helpers/http";
import Hero from "@/components/Hero.vue";
import VBtnLink from "@/components/links/VBtnLink.vue";
import { featherReplace } from "@/helpers/feather";
import VCard from "@/components/card/VCard.vue";
import VCardContent from "@/components/card/VCardContent.vue";
import VCardTitle from "@/components/card/VCardTitle.vue";

const router = useRouter();
const state = reactive({
  items: [],
});

onBeforeMount(async () => {
  const { data, status } = await http.get("/api/shop/items", {
    withCredentials: true,
  });

  if (status === 200) {
    state.items = _.concat(data.items);
  }
});

onUpdated(async () => {
  featherReplace();
});
</script>

<template>
  <Hero
    title="Articles de la boutique"
    description="Retrouvez tous les article de votre boutique en ligne."
    icon="shopping-cart"
  />

  <div class="flex flex-wrap flex-row gap-4 justify-center w-full pb-8 px-4">
    <v-card v-for="item in state.items" color="yellow">
      <v-card-title class="border-zinc-200 text-zinc-200">
        {{ item.title }} ({{ item.available }})
      </v-card-title>

      <v-card-content color="text-zinc-200">
        {{ item.description }}
      </v-card-content>

      <v-card-content class="text-sm font-semibold" color="text-zinc-200">
        #{{ _.join(item.tags, " #") }}
      </v-card-content>

      <v-card-content>
        <v-btn-link
          :to="{
            name: 'shop-item-read',
            params: { itemId: item.uniqueId },
          }"
          title="Afficher"
          icon="eye"
          color="red"
        />
      </v-card-content>
    </v-card>
  </div>
</template>
