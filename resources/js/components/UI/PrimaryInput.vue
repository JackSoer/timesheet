<template>
  <div class="primary-input">
    <label :for="inputProps?.id" class="primary-input__label">{{
      label
    }}</label>
    <input
      type="text"
      class="primary-input__item"
      v-bind="inputProps"
      :value="modelValue"
      @input="handleInput"
    />
  </div>
</template>

<script setup>
const { label, inputProps } = defineProps({
  label: String,
  inputProps: Object,
  modelValue: String,
});
const emit = defineEmits(["update:modelValue"]);

const handleInput = (e) => {
  emit("update:modelValue", e.target.value);
};
</script>

<style lang="scss" scoped>
@import "../../../scss/var";
.primary-input {
  display: flex;
  flex-direction: column;
  justify-content: center;
  gap: 4px;

  &__item {
    width: 100%;
    font-size: 16px;
    padding: 6px;

    &:focus {
      outline: 1px solid $mainBorder;
    }
  }

  &__label {
    font-size: 12px;
  }
}
</style>
