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
      @blur="handleBlur"
    />
    <div class="errors">
      <p class="error" v-if="errors.length" v-for="error in errors">
        {{ error.$message }}
      </p>
    </div>
  </div>
</template>

<script setup>
const { label, inputProps, errors, handleBlur } = defineProps({
  label: String,
  inputProps: Object,
  modelValue: String,
  errors: Array,
  handleBlur: Function,
});
const emit = defineEmits(["update:modelValue"]);

const handleInput = (e) => {
  let value = e.target.value;

  emit("update:modelValue", value);
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
    outline: 1px solid lightgray;

    &:focus {
      outline: 1px solid $mainBorder;
    }
  }

  &__label {
    font-size: 12px;
  }
}

.errors {
  display: flex;
  flex-direction: column;
  gap: 2px;
}
</style>
