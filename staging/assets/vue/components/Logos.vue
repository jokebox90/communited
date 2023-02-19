<template>
  <div class="mb-12 flex flex-col items-center justify-center mx-auto w-max text-center">
    <p class="text-xl italic font-serif">Application développée avec</p>
    <p class="text-3xl">
      Symfony - VueJS - TailwindCSS
    </p>
  </div>

  <div class="mb-12 flex flex-row justify-center gap-12 w-min mx-auto">
    <div class="w-60 h-60">
      <img src="https://symfony.com/logos/symfony_black_03.svg" alt="Logo Symfony" class="w-full h-full">
    </div>
    <div class="w-60 h-60">
      <img src="https://upload.wikimedia.org/wikipedia/commons/9/95/Vue.js_Logo_2.svg" alt="Logo VueJS"
        class="w-full h-full">
    </div>
    <div class="w-60 h-60">
      <img src="https://tailwindcss.com/_next/static/media/tailwindcss-mark.79614a5f61617ba49a0891494521226b.svg" alt="Logo Bootstrap"
        class="w-full h-full">
    </div>
  </div>
</template>

<style scoped>
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