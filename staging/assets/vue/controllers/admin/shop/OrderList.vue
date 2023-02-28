<script setup>
// assets/vue/controllers/admin/Shoporders/orders.vue

import _ from "lodash";
import moment from "moment";
import { reactive, onBeforeMount } from "vue";
import { useRouter } from "vue-router";
import http from "@/helpers/http";
import Hero from "@/components/Hero.vue";
import VBtnLink from "@/components/links/VBtnLink.vue";
import VCard from "@/components/card/VCard.vue";
import VCardContent from "@/components/card/VCardContent.vue";
import VCardTitle from "@/components/card/VCardTitle.vue";

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
    <v-card v-for="order in state.orders" color="yellow">
      <v-card-title class="border-zinc-200 text-zinc-200">
        {{ order.reference }} ({{ order.status }})
      </v-card-title>

      <v-card-content color="text-zinc-200">
        {{ order.emailAddress }}
      </v-card-content>

      <v-card-content class="text-sm font-semibold" color="text-zinc-200">
        Créée-le: {{ moment(order.createdAt).format("LLLL") }}
      </v-card-content>

      <v-card-content>
        <v-btn-link
          :to="{
            name: 'shop-order-read',
            params: { orderId: order.orderId },
          }"
          title="Afficher"
          icon="eye"
          color="red"
        />
      </v-card-content>
    </v-card>
  </div>
</template>
