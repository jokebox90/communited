<script setup>
// assets/vue/Admin.vue

import Hero from "@/components/Hero.vue";
import VCategoryLink from "@/components/links/VCategoryLink.vue";
</script>

<template>
  <hero
    title="e-Boutique"
    description="Votre boutique en ligne."
    icon="shopping-cart"
  />
  <div class="flex flex-wrap flex-row md:gap-4 gap-2 py-8">
    <v-category-link
      :to="{ name: 'shop-item-list' }"
      title="Articles"
      icon="shopping-bag"
      color="blue"
    />
    <v-category-link
      :to="{ name: 'shop-customer-list' }"
      title="Clients"
      icon="users"
      color="green"
    />
    <v-category-link
      :to="{ name: 'shop-order-list' }"
      title="Commandes"
      icon="file-plus"
      color="yellow"
    />
    <v-category-link
      :to="{ name: 'shop-order-list' }"
      title="Paiements"
      icon="dollar-sign"
      color="red"
    />
    <v-category-link
      :to="{ name: 'shop-order-list' }"
      title="Vendeurs"
      icon="activity"
      color="violet"
    />
  </div>
</template>
