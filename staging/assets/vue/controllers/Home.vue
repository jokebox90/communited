<template>
  <Logos />

  <Navigation />

  <div id="greeter">
    <PageTitle random-color>
      Vous êtes ici: {{ name }}!
    </PageTitle>

    <h4>{{ message }}!</h4>
    <p>{{ path }}!</p>
  </div>
</template>

<script setup>
import _ from "lodash";
import Navigation from "../components/Navigation.vue";
import Logos from "../components/Logos.vue";
import PageTitle from "../components/PageTitle.vue";
defineProps({
  name: String,
  message: String,
  path: String,
});
</script>

<style lang="scss">
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