<template>
  <div class="primary-select">
    <label class="primary-select__label" :for="selectProps.id">{{
      label
    }}</label>
    <select
      class="primary-select__item"
      @change="handleSelectChange"
      :value="modelValue"
      v-bind="selectProps"
      @blur="handleBlur"
    >
      <option
        class="primary-select__option"
        value=""
        disabled
        selected
      ></option>
      <option
        class="primary-select__option"
        v-for="option in options"
        :value="option.value"
      >
        {{ option.text }}
      </option>
    </select>
    <div class="errors" v-if="errors?.length">
      <p class="error" v-for="error in errors">
        {{ error?.$message || error }}
      </p>
    </div>
  </div>
</template>

<script setup>
const { options, modelValue, selectProps, label, errors, handleBlur } =
  defineProps({
    options: {
      type: Array,
      required: true,
    },
    modelValue: {
      required: true,
      default: "",
    },
    selectProps: {
      type: Object,
    },
    label: {
      type: String,
    },
    errors: Array,
    handleBlur: Function,
  });

const emit = defineEmits(["update:modelValue"]);

const handleSelectChange = (e) => {
  let value = e.target.value;

  emit("update:modelValue", value);
};
</script>

<style lang="scss" scoped>
@import "../../../scss/var";

.primary-select {
  display: flex;
  flex-direction: column;
  gap: 4px;
  width: 100%;

  &__item {
    width: 100%;
    font-size: 16px;
    padding: 6px 2px;
    border: 1px solid lightgray;

    &:focus {
      border: 1px solid $mainBorder;
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
