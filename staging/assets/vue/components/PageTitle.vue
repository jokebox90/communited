<template>
  <h1 :class="textColor">
    <slot></slot>
  </h1>
</template>

<script>
import _ from "lodash";

const textColors = [
  "text-primary",
  "text-secondary",
  "text-info",
  "text-warning",
  "text-success",
  "text-danger",
  "text-dark",
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
