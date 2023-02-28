<script setup>
const Props = defineProps({
  to: Array | Object,
  title: String,
  icon: String,
  linkClass: String | Array,
  color: String,
  bg: String,
  iconBg: String,
  iconColor: String,
});
</script>

<template>
  <router-link
    :to="to"
    :class="[bg || 'bg-transparent', color || 'text-black']"
    class="inline-flex items-center justify-end gap-6 w-full px-4 py-2 text-2xl"
  >
    <slot></slot>
    <div
      class="rounded-full p-4 w-16 h-16"
      :class="[iconBg || 'bg-zinc-50', iconColor || 'text-black']"
    >
      <i class="w-full h-full" :data-feather="icon"></i>
    </div>
  </router-link>
</template>
