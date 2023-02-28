<script setup>
// assets/vue/components/VBtnLink.vue

const Props = defineProps({
  color: String,
});
</script>

<template>
  <div
    class="card lg:w-96 md:w-5/12 w-full flex flex-col justify-between shadow rounded-xl border"
    :class="[
      color == 'blue'
        ? 'border-blue-500 bg-gradient-to-br from-blue-900 to-blue-500 hover:to-blue-400 text-white'
        : null,
      color == 'green'
        ? 'border-green-500 bg-gradient-to-br from-green-900 to-green-400 hover:to-green-300 text-white'
        : null,
      color == 'yellow'
        ? 'border-yellow-500 bg-gradient-to-br from-yellow-600 to-yellow-400 hover:to-yellow-300 text-white'
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
    <slot></slot>
  </div>
</template>
