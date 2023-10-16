<template>
  <div class="toggle">
    <h6 class="toggle__title">{{ name }}</h6>
    <PrimaryRadio
      v-for="value in values"
      :value="value.value"
      :label="value.label"
      :checked="value.checked"
      :name="name"
      v-model="selectedValue"
    />
  </div>
</template>

<script setup>
import { ref, watch } from "vue";
import PrimaryRadio from "./UI/PrimaryRadio.vue";

const { values, name } = defineProps({
  values: {
    type: Array,
    required: true,
  },
  name: {
    type: String,
    required: true,
  },
});

const selectedValue = ref("");

const emit = defineEmits(["change"]);

watch(selectedValue, () => {
  emit("change", selectedValue);
});
</script>

<style lang="scss" scoped>
.toggle {
  display: flex;
  flex-direction: column;
  gap: 3px;

  &__title {
    margin-bottom: 5px;
    font-weight: 500;
  }
}
</style>
