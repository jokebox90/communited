<script setup>
import _ from "lodash";
import { defineProps } from 'vue';

const Props = defineProps({
  cite: String,
  title: String,
  description: String,
});
</script>

<template>
  <div class="text-center pt-24 bg-rose-600 bg-gradient-to-b from-rose-700 via-rose-500 to-transparent w-full border-b-2 border-zinc-700">
    <p v-if="cite" class="text-xl text-zinc-300 italic font-serif mb-3">
      {{ cite }}
    </p>
    <p v-if="title" class="text-3xl text-yellow-300 mb-6">
      {{ title }}
    </p>
    <p v-if="description" class="text-lg text-white mb-6">
      {{ description }}
    </p>
  </div>
</template>
