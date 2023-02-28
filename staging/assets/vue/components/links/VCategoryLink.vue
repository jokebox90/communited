<script setup>
const Props = defineProps({
  to: Array | Object,
  title: String,
  icon: String,
  color: String,
});
</script>

<template>
  <router-link
    :to="to"
    class="lg:w-48 lg:h-48 md:w-32 md:h-32 w-24 h-24 py-4 px-2 flex flex-col items-center justify-around shadow-md md:shadow-xl hover:shadow-sm rounded-2xl border border-zinc-300"
    :class="[
      color == 'blue'
        ? 'bg-gradient-to-br from-blue-900 to-blue-500 hover:to-blue-400 text-white'
        : null,
      color == 'green'
        ? 'bg-gradient-to-br from-green-900 to-green-400 hover:to-green-300 text-white'
        : null,
      color == 'yellow'
        ? 'bg-gradient-to-br from-yellow-700 to-yellow-400 hover:to-yellow-300 text-white'
        : null,
      color == 'red'
        ? 'bg-gradient-to-br from-red-700 to-red-300 hover:to-red-200 text-white'
        : null,
      color == 'violet'
        ? 'bg-gradient-to-br from-violet-900 to-violet-400 hover:to-violet-300 text-white'
        : null,
    ]"
  >
    <div class="w-full h-1/2 flex flex-col items-center justify-center">
      <div class="w-auto h-full">
        <i class="w-full h-full" :data-feather="icon"></i>
      </div>
    </div>
    <div class="w-full h-auto flex flex-col items-center justify-center">
      <p class="text-center md:text-3xl text-lg">
        {{ title }}
      </p>
    </div>
  </router-link>
</template>
