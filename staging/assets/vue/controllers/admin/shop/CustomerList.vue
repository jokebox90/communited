<script setup>
// assets/vue/controllers/admin/customers/customerList.vue

import _ from "lodash";
import { reactive, onBeforeMount } from "vue";
import { useRouter } from "vue-router";
import http from "@/helpers/http";
import Hero from "@/components/Hero.vue";

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
  />

  <div
    class="flex justify-center flex-wrap md:flex-row sm:flex-col gap-4 w-screen px-4 py-8"
  >
    <div v-for="customer in state.customers" class="md:w-96 sm:w-full">
      <div
        class="flex flex-col gap-0 shadow-md rounded-xl bg-zinc-100 border border-zinc-300 pt-8 px-6"
      >
        <div class="flex flex-row gap-0 w-full">
          <p
            class="w-1/3 pr-3 py-4 font-bold text-right border-r-4 border-rose-600"
          >
            Nom
          </p>

          <p class="w-2/3 pl-3 py-4">
            {{ customer.firstName }} {{ _.upperCase(customer.lastName) }}
          </p>
        </div>

        <div class="flex flex-row gap-0 w-full">
          <p
            class="w-1/3 pr-3 py-4 font-bold text-right border-r-4 border-rose-600"
          >
            Grade
          </p>
          <p class="w-2/3 pl-3 py-4">
            {{ customer.grade }}
          </p>
        </div>

        <div class="flex flex-row gap-0 w-full">
          <p
            class="w-1/3 pr-3 py-4 font-bold text-right border-r-4 border-rose-600"
          >
            Téléphone
          </p>
          <p class="w-2/3 pl-3 py-4">
            {{ customer.phoneNumber }}
          </p>
        </div>

        <div class="flex flex-row gap-0 w-full">
          <p
            class="w-1/3 pr-3 py-4 font-bold text-right border-r-4 border-rose-600"
          >
            Email
          </p>
          <p class="w-2/3 pl-3 py-4">
            {{ customer.emailAddress }}
          </p>
        </div>

        <div class="w-full inline-flex justify-center mt-8">
          <FormKit
            type="button"
            @click="
              () =>
                router.push({
                  name: 'shop-customer-read',
                  params: { customerId: customer.uniqueId },
                })
            "
            class="bg-blue-500"
          >
            Afficher
          </FormKit>
        </div>
      </div>
    </div>
  </div>
</template>
