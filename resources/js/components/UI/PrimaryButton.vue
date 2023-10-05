<template>
  <button
    class="primary-button"
    :class="btnProps?.disabled ? 'primary-button__disabled' : null"
    v-bind="btnProps"
  >
    <slot />
  </button>
</template>

<script setup>
const { btnProps } = defineProps({
  btnProps: Object,
});
</script>

<style lang="scss" scoped>
@import "../../../scss/var";

.primary-button {
  border: 2px solid $mainTextColor;
  border-radius: 20px;
  padding: 10px;
  font-size: 20px;
  font-weight: 500;
  color: $mainTextColor;
  transition: all 0.3s ease;

  &:hover {
    background-color: $mainTextColor;
    color: white;
  }

  &__disabled {
    cursor: default;
    opacity: 0.5;

    &:hover {
      background-color: transparent;
      color: $mainTextColor;
    }
  }
}
</style>
