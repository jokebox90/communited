<template>
  <h1 :class="`text-4xl mb-3 ${textColor}`">
    <slot></slot>
  </h1>
</template>

<script>
import _ from "lodash";

const textColors = [
  "text-blue-400",
  "text-zinc-400",
  "text-indigo-400",
  "text-yellow-600",
  "text-green-600",
  "text-red-600",
  "text-emerald-600",
];

export default {
  props: {
    randomColor: Boolean
  },

  data() {
    return {
      textColor: this.randomColor ? _.sample(textColors) : "text-primary",
    };
  },
};
</script >
