<template>
  <div class="row mb-5">
    <div class="col-12 text-center">
      <p class="fs-4">Application développée avec</p>
      <p class="fs-2 text-info">
        Symfony - VueJS - Bootstrap
      </p>
    </div>
  </div>

  <div class="row mb-5">
    <div class="col-4">
      <img src="https://symfony.com/logos/symfony_black_03.svg" alt="Logo Symfony" class="logo-sf">
    </div>
    <div class="col-4">
      <img src="https://upload.wikimedia.org/wikipedia/commons/9/95/Vue.js_Logo_2.svg" alt="Logo VueJS"
        class="logo-vue">
    </div>
    <div class="col-4">
      <img src="https://upload.wikimedia.org/wikipedia/commons/b/b2/Bootstrap_logo.svg" alt="Logo Bootstrap"
        class="logo-bs">
    </div>
  </div>
</template>

<style lang="scss" scoped>
.col-4 {
  display: flex;
  align-items: center;
  justify-content: center;
}

.logo-sf {
  height: 256px;
  width: 256px;
}

.logo-vue {
  height: 224px;
  width: 224px;
}

.logo-bs {
  height: 192px;
  width: 192px;
}
</style>