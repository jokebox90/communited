<script setup>
// assets/vue/components/VBtnLink.vue

const Props = defineProps({
  color: String,
});
</script>

<template>
  <div class="mb-2 px-4 text-zinc-800" :class="color">
    <slot></slot>
  </div>
</template>
