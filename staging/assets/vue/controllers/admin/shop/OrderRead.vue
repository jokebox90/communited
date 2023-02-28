<script setup>
// assets/vue/controllers/admin/ShopOrders/OrderList.vue

import _ from "lodash";
import moment from "moment";
import { reactive, onBeforeMount } from "vue";
import http from "@/helpers/http";
import Hero from "@/components/Hero.vue";
import { useRoute } from "vue-router";

const route = useRoute();
const state = reactive({
  orderList: [],
  order: {},
});

onBeforeMount(async () => {
  const orderId = route.params.orderId;
  const { data, status } = await http.get(`/api/shop/orders/${orderId}`, {
    withCredentials: true,
  });

  if (status === 200) {
    state.order = data.order;
  }
});
</script>

<template>
  <Hero
    :title="state.order.title"
    description="Article de votre boutique en ligne."
  />

  <div class="w-full px-3 py-8">
    <div
      class="flex flex-col gap-0 w-full shadow-md rounded-xl bg-zinc-100 border border-zinc-300 py-8 px-6"
    >
      <div class="flex flex-row gap-0 w-full">
        <p
          class="w-1/3 pr-3 py-4 font-bold text-right border-r-4 border-rose-600"
        >
          Référence
        </p>

        <p class="w-2/3 pl-3 py-4">
          {{ state.order.reference }}
        </p>
      </div>

      <div class="flex flex-row gap-0 w-full">
        <p
          class="w-1/3 pr-3 py-4 font-bold text-right border-r-4 border-rose-600"
        >
          Email
        </p>
        <p class="w-2/3 pl-3 py-4">
          {{ state.order.emailAddress }}
        </p>
      </div>

      <div class="flex flex-row gap-0 w-full">
        <p
          class="w-1/3 pr-3 py-4 font-bold text-right border-r-4 border-rose-600"
        >
          Créée-le
        </p>
        <p class="w-2/3 pl-3 py-4">
          {{ moment(state.order.createdAt).format("LLLL") }}
        </p>
      </div>

      <div class="flex flex-row gap-0 w-full">
        <p
          class="w-1/3 pr-3 py-4 font-bold text-right border-r-4 border-rose-600"
        >
          Modifiée-le
        </p>
        <p class="w-2/3 pl-3 py-4">
          {{ moment(state.order.modifiedAt).format("LLLL") }}
        </p>
      </div>
    </div>

    <div class="flex flex-row flex-wrap gap-4 w-full px-4 py-8">
      <table
        v-for="item in state.order.items"
        class="border-separate border border-zinc-400 md:w-96 sm:w-full"
      >
        <tbody>
          <tr>
            <th
              class="border border-zinc-200 bg-zinc-500 text-end text-white px-4 py-2 w-2/5"
            >
              Titre
            </th>
            <td
              class="border border-zinc-200 bg-zinc-300 text-black px-4 py-2 w-3/5"
            >
              <p class="mr-auto">{{ item.item.title }}</p>
            </td>
          </tr>
          <tr>
            <th
              class="border border-zinc-200 bg-zinc-500 text-end text-white px-4 py-2 w-2/5"
            >
              Prix total
            </th>
            <td
              class="border border-zinc-200 bg-zinc-300 text-black px-4 py-2 w-3/5"
            >
              {{ item.price.amount }} €
            </td>
          </tr>
          <tr>
            <th
              class="border border-zinc-200 bg-zinc-500 text-end text-white px-4 py-2 w-2/5"
            >
              Fréquence de paiement
            </th>
            <td
              class="border border-zinc-200 bg-zinc-300 text-black px-4 py-2 w-3/5"
            >
              {{ item.price.frequency }}
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>
