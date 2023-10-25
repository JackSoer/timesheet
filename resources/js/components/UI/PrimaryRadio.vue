<template>
  <div class="primary-radio">
    <input
      type="radio"
      class="primary-radio__item"
      :value="value"
      :id="value"
      @change="handleChange"
      :name="name"
      :checked="checked"
    />
    <label :for="value" class="primary-radio__label" v-if="label">{{
      label
    }}</label>
  </div>
</template>

<script setup>
const { value, modelValue, name, label, checked } = defineProps({
  value: {
    required: true,
  },
  name: {
    type: String,
  },
  modelValue: {
    type: String,
  },
  label: {
    type: String,
  },
  checked: {
    type: Boolean,
  },
});

const emit = defineEmits(["update:modelValue"]);

const handleChange = (e) => {
  let value = e.target.value;

  emit("update:modelValue", value);
};
</script>

<style lang="scss" scoped>
.primary-radio {
  display: flex;
  gap: 7px;
}
</style>
