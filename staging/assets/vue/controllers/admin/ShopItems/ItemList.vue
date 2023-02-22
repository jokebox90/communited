<script setup>
// assets/vue/controllers/admin/ShopItems/ItemList.vue

import _ from "lodash";
import { reactive, onBeforeMount } from 'vue';
import { useRouter } from "vue-router";
import http from "@/helpers/http";
import Hero from "@/components/Hero.vue";

const router = useRouter();
const state = reactive({
  itemList: [],
})

onBeforeMount(async () => {
  const { data, status } = await http.get("/api/shop/items");
  if (status === 200) {
    _.map(data.shopItems, (item) => {
      state.itemList.push({
        itemId: item.itemId,
        title: item.title,
        available: item.available,
        tags: item.tags,
      });
    });
  }
});
</script>

<template>
  <Hero title="Articles de la boutique" description="Retrouvez tous les article de vote boutique en ligne." />

  <div class="w-full px-3 py-8">
    <div v-for="item in state.itemList"
      class="flex flex-col gap-0 w-full shadow-md rounded-xl bg-zinc-100 border border-zinc-300 py-8 px-6 mb-4">
      <div class="flex flex-row gap-0 w-full">
        <p class="w-1/3 pr-3 py-4 font-bold text-right border-r-4 border-rose-600">
          UniqueId
        </p>

        <p class="w-2/3 pl-3 py-4">
          {{ item.itemId }}
        </p>
      </div>

      <div class="flex flex-row gap-0 w-full">
        <p class="w-1/3 pr-3 py-4 font-bold text-right border-r-4 border-rose-600">
          Titre
        </p>

        <p class="w-2/3 pl-3 py-4">
          {{ item.title }}
        </p>
      </div>

      <div class="flex flex-row gap-0 w-full">
        <p class="w-1/3 pr-3 py-4 font-bold text-right border-r-4 border-rose-600">
          Tags
        </p>
        <p class="w-2/3 pl-3 py-4">
          {{ _.join(item.tags, ", ") }}
        </p>
      </div>

      <div class="flex flex-row gap-0 w-full">
        <p class="w-1/3 pr-3 py-4 font-bold text-right border-r-4 border-rose-600">
          Disponibilité
        </p>
        <p class="w-2/3 pl-3 py-4">
          {{ item.available }}
        </p>
      </div>


      <FormKit
        type="button"
        @click="() => router.push({ name: 'shop-item-read', params: { itemId: item.itemId } })"
        label="Afficher"
        prefix-icon="eye"
        :actions="false"
        wrapper-class="w-full justify-center mt-8"
      />
    </div>
  </div>
</template>