<template>
  <button class="pen-btn">
    <PenIcon class="pen-btn__icon" />
  </button>
</template>

<script setup>
import PenIcon from "../components/UI/icons/PenIcon.vue";
</script>

<style lang="scss">
@import "../../scss/var";
.pen-btn {
  border-radius: 50%;
  max-width: 35px;
  max-height: 35px;
  border: 2px solid $mainBorder;
  padding: 5px;
  transition: all 0.3s ease;

  &:hover {
    background-color: $mainBorder;

    .pen-btn__icon {
      stroke: white;
    }
  }

  &__icon {
    transition: 0.3s ease all;
    stroke: $mainTextColor;
  }
}
</style>
