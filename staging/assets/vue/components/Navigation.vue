<template>
  <nav class="w-full pl-6 flex flex-row justify-start bg-gradient-to-b from-cyan-600 to-cyan-900">
    <div class="bg-transparent border-r-4 my-6 mr-3 pr-3">
      <span class="text-2xl font-bold">Tableau de bord</span>
    </div>

    <div class="flex flex-row justify-center items-center gap-3 py-3">
      <div class="transition hover:-translate-y-1 ease-in-out delay-100 duration-300 bg-zinc-100 hover:bg-zinc-300 rounded-full">
        <router-link to="/" replace class="m-0 p-2 text-black inline-flex gap-3">
          <i data-feather="home"></i>
        </router-link>
      </div>

      <div class="transition hover:-translate-y-1 ease-in-out delay-100 duration-300 bg-zinc-100 hover:bg-zinc-300 rounded-lg">
        <router-link to="/about" replace class="m-0 px-4 py-2 text-black inline-flex gap-3">
          <i data-feather="info"></i>
          About
        </router-link>
      </div>

      <div class="transition hover:-translate-y-1 ease-in-out delay-100 duration-300 bg-zinc-100 hover:bg-zinc-300 rounded-lg">
        <router-link to="/about/else/world" replace class="m-0 px-4 py-2 text-black inline-flex gap-3">
          <i data-feather="globe"></i>
          Elseworld
        </router-link>
      </div>

      <div class="transition hover:-translate-y-1 ease-in-out delay-100 duration-300 bg-zinc-100 hover:bg-zinc-300 rounded-lg">
        <router-link to="/sign-up" replace class="m-0 px-4 py-2 text-black inline-flex gap-3">
          <i data-feather="user-check"></i>
          S'inscrire
        </router-link>
      </div>
    </div>
  </nav>
</template>
