<script setup>
// assets/vue/controllers/admin/Shoporders/orders.vue

import _ from "lodash";
import moment from "moment";
import { reactive, onBeforeMount } from "vue";
import { useRouter } from "vue-router";
import http from "@/helpers/http";
import Hero from "@/components/Hero.vue";

const router = useRouter();
const state = reactive({
  orders: [],
});

onBeforeMount(async () => {
  const { data, status } = await http.get("/api/shop/orders", {
    withCredentials: true,
  });

  if (status === 200) {
    state.orders = _.concat(data.orders);
  }
});
</script>

<template>
  <Hero
    title="Commandes enregistrées"
    description="Retrouvez toutes les commandes effectuées par vos clients."
  />

  <div class="flex flex-row flex-wrap gap-4 justify-center w-full px-4 py-8">
    <div
      v-for="order in state.orders"
      class="flex flex-col gap-0 md:w-96 sm:w-full shadow-md rounded-xl bg-zinc-100 border border-zinc-300 py-8 px-6 mb-4"
    >
      <div class="flex flex-row gap-0 w-full">
        <p
          class="w-1/3 pr-3 py-4 font-bold text-right border-r-4 border-rose-600"
        >
          Référence
        </p>

        <p class="w-2/3 pl-3 py-4">
          {{ order.reference }}
        </p>
      </div>

      <div class="flex flex-row gap-0 w-full">
        <p
          class="w-1/3 pr-3 py-4 font-bold text-right border-r-4 border-rose-600"
        >
          Email
        </p>
        <p class="w-2/3 pl-3 py-4">
          {{ order.emailAddress }}
        </p>
      </div>

      <div class="flex flex-row gap-0 w-full">
        <p
          class="w-1/3 pr-3 py-4 font-bold text-right border-r-4 border-rose-600"
        >
          Statut
        </p>
        <p class="w-2/3 pl-3 py-4">
          {{ order.status }}
        </p>
      </div>

      <div class="flex flex-row gap-0 w-full">
        <p
          class="w-1/3 pr-3 py-4 font-bold text-right border-r-4 border-rose-600"
        >
          Créée-le
        </p>
        <p class="w-2/3 pl-3 py-4">
          {{ moment(order.createdAt).format("LLLL") }}
        </p>
      </div>

      <FormKit
        type="button"
        @click="
          () =>
            router.push({
              name: 'shop-order-read',
              params: { orderId: order.orderId },
            })
        "
        label="Afficher les articles"
        prefix-icon="eye"
        :actions="false"
        wrapper-class="w-full justify-center mt-8"
      />
    </div>
  </div>
</template>
