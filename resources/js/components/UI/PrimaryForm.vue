<template>
  <form class="primary-form" @submit.prevent="handleSubmit">
    <h1 class="primary-form__title" v-if="title">{{ title }}</h1>
    <div class="primary-form__box">
      <slot />
    </div>
  </form>
</template>

<script setup>
const { title, handleSubmit } = defineProps({
  title: String,
  handleSubmit: Function,
});
</script>

<style lang="scss" scoped>
.primary-form {
  max-width: 330px;
  width: 100%;

  &__box {
    width: 100%;
    height: 100%;

    display: flex;
    flex-direction: column;
    justify-content: center;
    gap: 12px;
  }

  &__title {
    text-align: center;
    margin-bottom: 25px;
    font-size: 40px;
    font-weight: 700;
  }
}
</style>
