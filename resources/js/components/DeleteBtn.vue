<template>
  <button
    class="trash-btn"
    :class="btnProps?.disabled ? 'trash-btn__disabled' : null"
    v-bind="btnProps"
  >
    <TrashIcon class="trash-btn__icon" />
  </button>
</template>

<script setup>
import TrashIcon from "../components/UI/icons/TrashIcon.vue";

const { btnProps } = defineProps({
  btnProps: Object,
});
</script>

<style lang="scss">
@import "../../scss/var";
.trash-btn {
  border-radius: 50%;
  max-width: 35px;
  max-height: 35px;
  border: 2px solid $mainBorder;
  padding: 5px;
  transition: all 0.3s ease;

  &:hover {
    background-color: $mainBorder;

    .trash-btn__icon {
      fill: white;
    }
  }

  &__icon {
    transition: 0.3s ease all;
    fill: $mainTextColor;
  }

  &__disabled {
    cursor: default;
    opacity: 0.5;

    &:hover {
      background-color: transparent;

      .trash-btn__icon {
        fill: $mainTextColor;
      }
    }
  }
}
</style>
