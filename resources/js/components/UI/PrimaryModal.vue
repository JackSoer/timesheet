<template>
  <div
    class="overlay"
    v-if="isOpen"
    :class="{ 'enter-active': isOpen }"
    data-testid="modal"
  >
    <div class="modal">
      <PrimaryButton class="modal__close" @click="handleClose">x</PrimaryButton>
      <slot />
    </div>
  </div>
</template>

<script setup>
import PrimaryButton from "./PrimaryButton.vue";

const { isOpen } = defineProps({
  isOpen: {
    type: Boolean,
    required: true,
    default: false,
  },
});

const emit = defineEmits(["update:isOpen"]);

const handleClose = () => {
  emit("update:isOpen", false);
};
</script>

<style lang="scss" scoped>
@import "../../../scss/var";

.overlay {
  background-color: rgba($mainBackground, 0.8);
  display: flex;
  align-items: center;
  justify-content: center;
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  z-index: 9999;
  opacity: 0;
  transition: opacity 0.3s;

  &.enter-active {
    opacity: 1;
  }

  .modal {
    background-color: white;
    border-radius: 5px;
    box-shadow: 0 0 10px $mainBoxShadow;
    padding: 20px;
    position: relative;
    max-width: 80%;
    max-height: 80%;
    overflow: auto;
    padding-top: 60px;

    &__close {
      position: absolute;
      top: 10px;
      right: 10px;
      padding: 0;
      width: 30px;
      height: 30px;
    }
  }
}
</style>
