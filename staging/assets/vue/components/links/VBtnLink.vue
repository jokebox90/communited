<script setup>
// assets/vue/components/VBtnLink.vue

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
    class="transition-all hover:-translate-y-1 w-max inline-flex items-center justify-center rounded-xl border"
    :class="[
      color == 'blue'
        ? 'border-blue-500 bg-gradient-to-br from-blue-900 to-blue-500 hover:to-blue-400 text-white'
        : null,
      color == 'green'
        ? 'border-green-500 bg-gradient-to-br from-green-900 to-green-400 hover:to-green-300 text-white'
        : null,
      color == 'yellow'
        ? 'border-yellow-500 bg-gradient-to-br from-yellow-700 to-yellow-400 hover:to-yellow-300 text-white'
        : null,
      color == 'red'
        ? 'border-red-500 bg-gradient-to-br from-red-700 to-red-300 hover:to-red-200 text-white'
        : null,
      color == 'violet'
        ? 'border-violet-500 bg-gradient-to-br from-violet-900 to-violet-400 hover:to-violet-300 text-white'
        : null,
      color == 'slate'
        ? 'border-slate-500 bg-gradient-to-b from-slate-900 to-slate-500 hover:to-slate-400 text-white'
        : null,
    ]"
  >
    <span
      class="w-max h-10 py-2 px-2 rounded-bl-xl rounded-tl-xl border-r"
      :class="[
        color == 'blue' ? 'border-blue-500' : null,
        color == 'green' ? 'border-green-500' : null,
        color == 'yellow' ? 'border-yellow-500' : null,
        color == 'red' ? 'border-red-500' : null,
        color == 'violet' ? 'border-violet-500' : null,
        color == 'slate' ? 'border-slate-500' : null,
      ]"
    >
      <i class="w-full h-full" :data-feather="icon"></i>
    </span>
    <span class="px-4 rounded-br-xl rounded-tr-xl">{{ title }}</span>
  </router-link>
</template>
