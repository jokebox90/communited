<template>
  <div class="d-flex flex-column align-items-center pt-5 col-sm-6 mx-auto">
    <Logos />

    <div id="greeter">
      <Title random-color>
        Vous êtes ici: {{ name }}!
      </Title>

      <h4>{{ message }}!</h4>
      <p>{{ path }}!</p>
      <p>{{ hit }}!</p>
    </div>
  </div>
</template>

<script setup>
import _ from "lodash";
import Navigation from "../components/Navigation.vue";
import Logos from "../components/Logos.vue";
import Title from "../components/Title.vue";

defineProps({
  name: String,
  message: String,
  path: String,
  hit: Number,
});
</script>

<style scoped>
#home {
  min-height: 100vh;
  height: auto;
  width: 100%;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
}

#greeter {
  text-align: center;
}
</style>