<template>
  <Logos />

  <Navigation />

  <div id="greeter">
    <PageTitle random-color>
      Hello, {{ _.capitalize(_.defaultTo(name, "world")) }}!
    </PageTitle>

    <h3>{{ message }}!</h3>
    <p>{{ path }}!</p>
  </div>
</template>

<script setup>
import _ from "lodash";
import Logos from "../components/Logos.vue";
import Navigation from "../components/Navigation.vue";
import PageTitle from "../components/PageTitle.vue";

defineProps({
  name: String,
  message: String,
  path: String,
});
</script>

<style lang="scss">
#about {
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
