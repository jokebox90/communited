<script setup>
import _ from "lodash";
import { computed, onMounted } from "vue";
import { useRoute } from "vue-router";
import Logos from "@/components/Logos.vue";
import Title from "@/components/Title.vue";
import { success } from "@/helpers/toasts";
import VBtnLink from "@/components/links/VBtnLink.vue";
import tokyoJPG from "@/images/tokyo.jpg";
import comingsoonJPG from "@/images/comingsoon.jpg";

const route = useRoute();
const path = computed(() => route.path);

onMounted(() => {
  if (route.query.logout) success("Vous êtes bien déconnecté !");
});
</script>

<template>
  <div class="w-full h-96 absolute">
    <img :src="tokyoJPG" alt="Les rues de Tokyo" class="w-full h-full" />
  </div>

  <div class="col-span-6 col-start-7 relative z-10 mt-8">
    <div class="w-full bg-white bg-opacity-80 px-8 py-4 rounded-xl">
      <h1 class="text-6xl text-rose-900 mb-6 font-['Amatic_SC']">
        [Titre du site]
      </h1>
      <h2 class="text-3xl text-yellow-500 mb-3 font-['Droid_Serif']">
        [Sous-titre du site]
      </h2>
      <p class="text-lg mb-3">[Message de promotion]</p>
      <p class="text-lg italic mb-3">[CTA]</p>
    </div>
  </div>

  <div class="col-span-12">
    <div
      class="flex flex-row gap-8 p-8 rounded-xl relative z-20 bg-white bg-opacity-80"
    >
      <div class="w-3/12 h-min">
        <img
          :src="comingsoonJPG"
          alt="Coming soon..."
          class="w-full h-full rounded-full"
        />
      </div>

      <div class="text-gray-900 w-9/12">
        <h3 class="text-3xl text-green-700 mb-2">[Un titre]</h3>
        <h4 class="text-xl text-yellow-500 mb-4">[Un sous-titre]</h4>
        <p class="mb-4">
          Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla libero
          nibh, congue venenatis porta eget, accumsan eu est. Pellentesque
          scelerisque ligula nulla, eu porta lectus laoreet ac. Morbi id lorem
          bibendum, mollis quam id, egestas velit. Aenean et vestibulum est,
          finibus elementum lectus. Aenean consectetur odio et blandit sodales.
          Suspendisse vestibulum mattis erat, at venenatis nisl. Morbi eu purus
          orci. Suspendisse id dictum nulla, in congue velit. Duis venenatis
          laoreet aliquet. Vivamus vitae purus eget massa ultricies molestie sed
          vitae quam. Cras pulvinar ligula eu efficitur vehicula.
        </p>
      </div>
    </div>
  </div>

  <div class="col-span-12">
    <div class="grid grid-cols-12 gap-4">
      <div
        class="col-span-4 flex flex-col gap-4 z-10"
        v-for="index in _.range(3)"
      >
        <div class="bg-rose-900 rounded-xl">
          <div class="flex flex-row justify-between items-end">
            <div
              class="w-24 h-24 m-4 -mb-12 z-50 border-4 border-rose-900 rounded-full"
            >
              <img
                :src="comingsoonJPG"
                alt="Coming soon..."
                class="w-full h-full rounded-full"
              />
            </div>

            <div class="m-4">
              <router-link
                :to="{
                  name: 'home',
                }"
                class="inline-flex gap-2 text-white p-2 rounded-xl border border-gray-50 transition-all delay-200 duration-300 hover:-translate-y-1"
              >
                En savoir plus
                <i data-feather="navigation"></i>
              </router-link>
            </div>
          </div>

          <div class="p-4 pt-16 text-gray-900 bg-white">
            <h2 class="font-bold text-rose-700 mb-3 leading-none">
              [Un titre] #{{ index + 1 }}
            </h2>
            <h4 class="text-lg mb-4 text-yellow-500">[Un sous-titre]</h4>
            <p class="text-sm mb-4">
              Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla
              libero nibh, congue venenatis porta eget, accumsan eu est.
              Pellentesque scelerisque ligula nulla, eu porta lectus laoreet ac.
              Morbi id lorem bibendum, mollis quam id, egestas velit. Aenean et
              vestibulum est, finibus elementum lectus.
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-span-12 mb-8">
    <div class="grid grid-cols-12 gap-y-36 mt-36 gap-4">
      <div class="col-span-4 bg-white rounded-xl" v-for="index in _.range(3)">
        <div class="flex flex-col gap-4 bg-green-900 rounded-t-xl">
          <div class="w-full flex flex-row flex-wrap justify-between mb-4">
            <div class="w-64 -mt-32 h-min mx-auto">
              <img
                :src="comingsoonJPG"
                alt="Coming soon..."
                class="w-full h-full rounded-full border-8 border-green-900"
              />
            </div>
          </div>
        </div>

        <div class="px-4 pt-4">
          <h3 class="mb-4 leading-none text-green-700">
            [Un titre] #{{ index + 1 }}
          </h3>
          <h4 class="mb-4 text-yellow-600">[Un sous-titre]</h4>
          <p class="text-sm text-gray-900 mb-4">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla
            libero nibh, congue venenatis porta eget, accumsan eu est.
            Pellentesque scelerisque ligula nulla, eu porta lectus laoreet ac.
            Morbi id lorem bibendum, mollis quam id, egestas velit. Aenean et
            vestibulum est, finibus elementum lectus. Aenean consectetur odio et
            blandit sodales. Suspendisse vestibulum mattis erat, at venenatis
            nisl. Morbi eu purus orci. Suspendisse id dictum nulla, in congue
            velit. Duis venenatis laoreet aliquet. Vivamus vitae purus eget
            massa ultricies molestie sed vitae quam. Cras pulvinar ligula eu
            efficitur vehicula.
          </p>
        </div>

        <div class="px-4 mb-4">
          <router-link
            :to="{
              name: 'home',
            }"
            class="inline-flex gap-2 p-2 rounded-xl border border-green-700 text-green-700 trnsiation-all delay-200 duration-300 hover:-translate-y-1"
          >
            En savoir plus
            <i data-feather="navigation"></i>
          </router-link>
        </div>
      </div>
    </div>
  </div>

  <div class="col-span-12 mb-8 flex flex-col gap-8">
    <div
      v-for="index in _.range(3)"
      class="flex bg-white rounded-xl"
      :class="
        index % 2 <= 0 ? 'flex-row-reverse mr-32' : 'flex-row-reverse mr-32'
      "
    >
      <div class="flex flex-col gap-4">
        <div class="w-full flex flex-col">
          <div
            class="w-64 my-8 h-min"
            :class="index % 2 <= 0 ? '-mr-32' : '-mr-32'"
          >
            <img
              :src="comingsoonJPG"
              alt="Coming soon..."
              class="w-full h-full rounded-full border-8 border-gray-200"
            />
          </div>
        </div>
      </div>

      <div
        class="flex items-center"
        :class="index % 2 <= 0 ? 'flex-row' : 'flex-row'"
      >
        <div
          class="flex flex-col justify-between h-full p-4 w-2/5"
          :class="
            index % 2 <= 0
              ? 'bg-green-900 rounded-l-xl'
              : 'bg-rose-900 rounded-l-xl'
          "
        >
          <div class="mb-4">
            <h3 class="mb-2 text-gray-300">[Un titre] #{{ index + 1 }}</h3>
            <h4 class="text-lg mb-4 text-yellow-500">[Un sous-titre]</h4>
          </div>
          <div class="my-4">
            <router-link
              :to="{
                name: 'home',
              }"
              class="inline-flex gap-2 p-2 rounded-xl border border-white text-white trnsiation-all delay-200 duration-300 hover:-translate-y-1"
            >
              En savoir plus
              <i data-feather="navigation"></i>
            </router-link>
          </div>
        </div>

        <div class="p-4 w-3/5">
          <p class="text-sm mb-4">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla
            libero nibh, congue venenatis porta eget, accumsan eu est.
            Pellentesque scelerisque ligula nulla, eu porta lectus laoreet ac.
            Morbi id lorem bibendum, mollis quam id, egestas velit. Aenean et
            vestibulum est, finibus elementum lectus. Aenean consectetur odio et
            blandit sodales. Suspendisse vestibulum mattis erat, at venenatis
            nisl. Morbi eu purus orci. Suspendisse id dictum nulla, in congue
            velit. Duis venenatis laoreet aliquet. Vivamus vitae purus eget
            massa ultricies molestie sed vitae quam. Cras pulvinar ligula eu
            efficitur vehicula.
          </p>
        </div>
      </div>
    </div>
  </div>
</template>
