<template>
  <div class="app">
    <Navbar />
    <slot />
  </div>
</template>

<script setup>
import Navbar from "../components/Navbar.vue";
</script>

<style lang="scss" scoped></style>
