<script setup>
// assets/vue/controllers/admin/customers/customerList.vue

import _ from "lodash";
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
  customers: null,
});

onBeforeMount(async () => {
  const { data, status } = await http.get("/api/shop/customers", {
    withCredentials: true,
  });

  if (status === 200) {
    state.customers = data.customers;
  }
});
</script>

<template>
  <Hero
    title="Clients de la boutique"
    description="Retrouvez tous les clients de votre boutique en ligne."
    icon="users"
  />

  <div class="flex flex-wrap md:flex-row sm:flex-col gap-4 w-full pb-8">
    <v-card v-for="customer in state.customers" color="green">
      <v-card-title class="border-zinc-200 text-zinc-50">
        {{ customer.firstName }} {{ _.upperCase(customer.lastName) }}
        <small>({{ customer.grade }})</small>
      </v-card-title>

      <v-card-content color=" text-zinc-50">
        {{ customer.phoneNumber }}
      </v-card-content>

      <v-card-content color="text-zinc-50">
        {{ customer.emailAddress }}
      </v-card-content>

      <v-card-content>
        <v-btn-link
          :to="{
            name: 'shop-customer-read',
            params: { customerId: customer.uniqueId },
          }"
          title="Afficher"
          color="green"
          icon="eye"
        >
          Afficher
        </v-btn-link>
      </v-card-content>
    </v-card>
  </div>
</template>
