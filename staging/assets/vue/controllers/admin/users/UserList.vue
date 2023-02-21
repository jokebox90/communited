<script setup>
// assets/vue/controllers/MyAccount.vue

import { reactive, onBeforeMount } from 'vue';
import { useRouter } from "vue-router";
import { useUserStore } from "@/helpers/stores";
import http from "@/helpers/http";
import { warning } from "@/helpers/toasts";
import Hero from "@/components/Hero.vue";

const router = useRouter();
const userStore = useUserStore();

const state = reactive({
  userList: [],
})

onBeforeMount(async () => {
  const { data, status } = await http.get("/api/users");
  if (status === 200) {
    _.map(data.users, (user) => {
      state.userList.push({
        userId: user.userId,
        userName: user.userName,
        userEmail: user.userEmail,
      });
    });
  }
});
</script>

<template>
  <Hero
    title="Mon compte"
    description="Retrouvez toutes les informations de votre compte utilisateur."
  />

  <div class="w-full px-3 py-8">
    <div v-for="user in state.userList" class="flex flex-col gap-0 w-full shadow-md rounded-xl bg-zinc-100 border border-zinc-300 py-8 px-6">
      <div class="flex flex-row gap-0 w-full">
        <p class="w-1/3 pr-3 py-4 font-bold text-right border-r-4 border-rose-600">
          UniqueId
        </p>

        <p class="w-2/3 pl-3 py-4">
          {{ user.userId }}
        </p>
      </div>

      <div class="flex flex-row gap-0 w-full">
        <p class="w-1/3 pr-3 py-4 font-bold text-right border-r-4 border-rose-600">
          Utilisateur
        </p>

        <p class="w-2/3 pl-3 py-4">
          {{ user.userName }}
        </p>
      </div>

      <div class="flex flex-row gap-0 w-full">
        <p class="w-1/3 pr-3 py-4 font-bold text-right border-r-4 border-rose-600">
          Email
        </p>
        <p class="w-2/3 pl-3 py-4">
          {{ user.userEmail }}
        </p>
      </div>
    </div>
  </div>
</template>