<script setup>
import _ from "lodash";
import { defineProps } from "vue";
import VFeather from "@/components/VFeather.vue";

const Props = defineProps({
  cite: String,
  title: String,
  description: String,
  icon: String,
});
</script>

<template>
  <div class="md:hidden w-full flex flex-col items-end justify-end">
    <div
      v-if="icon"
      class="w-48 h-48 p-8 mt-8 bg-zinc-200 rounded-full text-zinc-100"
    >
      <v-feather class="w-full h-full" :icon="icon"></v-feather>
    </div>
    <div class="w-full -mt-24">
      <p
        v-if="cite"
        class="md:text-xl text-lg text-zinc-600 italic font-serif mb-3"
      >
        {{ cite }}
      </p>
      <p v-if="title" class="md:text-6xl text-5xl text-rose-500 mb-6">
        {{ title }}
      </p>
      <p v-if="description" class="md:text-3xl text-xl text-zinc-900 mb-6">
        {{ description }}
      </p>
    </div>
  </div>

  <div class="hidden -z-20 md:flex relative w-full md:-mb-16">
    <div
      v-if="icon"
      class="absolute block -z-10 right-0 mr-8 lg:w-2/5 md:w-2/3 h-auto p-16 bg-zinc-200 rounded-full text-zinc-50"
    >
      <i class="w-full h-full" :data-feather="icon"></i>
    </div>
    <div class="text-center md:text-start pt-32 md:mb-32">
      <p
        v-if="cite"
        class="md:text-xl text-lg text-zinc-600 italic font-serif mb-3"
      >
        {{ cite }}
      </p>
      <p v-if="title" class="text-6xl text-rose-500 mb-6">
        {{ title }}
      </p>
      <p v-if="description" class="md:text-3xl text-xl text-zinc-900 mb-6">
        {{ description }}
      </p>
    </div>
  </div>
</template>
