<template>
  <button
    class="add-btn"
    :class="btnProps?.disabled ? 'add-btn__disabled' : null"
    v-bind="btnProps"
  >
    <PlusIcon class="add-btn__icon" />
  </button>
</template>

<script setup>
import PlusIcon from "../components/UI/icons/PlusIcon.vue";

const { btnProps } = defineProps({
  btnProps: Object,
});
</script>

<style lang="scss" scoped>
@import "../../scss/var";
.add-btn {
  border-radius: 50%;
  max-width: 35px;
  max-height: 35px;
  border: 2px solid $mainBorder;
  padding: 5px;
  transition: all 0.3s ease;

  &:hover {
    background-color: $mainBorder;

    .add-btn__icon {
      fill: white;
    }
  }

  &__disabled {
    cursor: default;
    opacity: 0.5;

    &:hover {
      background-color: transparent;
      color: $mainTextColor;
    }
  }

  &__icon {
    transition: 0.3s ease all;
    fill: $mainTextColor;
  }
}
</style>
