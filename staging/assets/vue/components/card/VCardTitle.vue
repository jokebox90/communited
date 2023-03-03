<script setup>
// assets/vue/components/VBtnLink.vue

const Props = defineProps({
  class: String,
});
</script>

<template>
  <div class="mb-2 px-4 pt-4 pb-2 border-b text-2xl" :class="class">
    <p>
      <slot></slot>
    </p>
  </div>
</template>
