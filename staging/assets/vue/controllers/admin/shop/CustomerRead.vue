<script setup>
// assets/vue/controllers/admin/ShopCustomers/CustomerList.vue

import _ from "lodash";
import moment from "moment";
import { reactive, onBeforeMount } from "vue";
import { useRoute } from "vue-router";
import http from "@/helpers/http";
import Hero from "@/components/Hero.vue";

const route = useRoute();
const customer = reactive({});

onBeforeMount(async () => {
  const customerId = route.params.customerId;
  const { data, status } = await http.get(`/api/shop/customers/${customerId}`, {
    withCredentials: true,
  });

  if (status === 200) {
    _.assign(customer, data.customer);
  }
});
</script>

<template>
  <Hero
    :title="`${_.upperFirst(customer.firstName)} ${_.upperCase(
      customer.lastName,
    )}`"
    description="Client de votre boutique en ligne."
    icon="user"
  />

  <div class="w-96">
    <div class="flex flex-row gap-0 w-full">
      <p
        class="w-1/3 pr-3 py-4 font-bold text-right border-r-2 border-rose-600"
      >
        Email
      </p>
      <p class="w-2/3 pl-3 py-4">
        {{ customer.emailAddress }}
      </p>
    </div>

    <div class="flex flex-row gap-0 w-full">
      <p
        class="w-1/3 pr-3 py-4 font-bold text-right border-r-2 border-rose-600"
      >
        Téléphone
      </p>
      <p class="w-2/3 pl-3 py-4">
        {{ customer.phoneNumber }}
      </p>
    </div>

    <div class="flex flex-row gap-0 w-full">
      <p
        class="w-1/3 pr-3 py-4 font-bold text-right border-r-2 border-rose-600"
      >
        Grade
      </p>
      <p class="w-2/3 pl-3 py-4">
        {{ customer.grade }}
      </p>
    </div>

    <div class="flex flex-row gap-0 w-full">
      <p
        class="w-1/3 pr-3 py-4 font-bold text-right border-r-2 border-rose-600"
      >
        Anniversaire
      </p>

      <p class="w-2/3 pl-3 py-4">
        {{ moment(customer.birthDate).format("LL") }}
      </p>
    </div>
  </div>
</template>
