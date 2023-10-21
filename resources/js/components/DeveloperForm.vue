<template>
  <PrimaryForm :title="title">
    <PrimaryInput
      label="First name"
      :inputProps="{
        autofocus: true,
        required: true,
        placeholder: 'Jack',
        id: 'firstName',
      }"
      v-model.trim="developer.firstName"
      :errors="v$.firstName.$errors"
      :handleBlur="v$.firstName.$touch"
    />
    <PrimaryInput
      label="Last name"
      :inputProps="{
        required: true,
        placeholder: 'Snow',
        id: 'lastName',
      }"
      v-model.trim="developer.lastName"
      :errors="v$.lastName.$errors"
      :handleBlur="v$.lastName.$touch"
    />
    <PrimaryInput
      label="Rate"
      v-model.trim="developer.rate"
      :inputProps="{
        placeholder: '99999.00',
        id: 'rate',
        type: 'number',
        step: 0.01,
      }"
      :errors="v$.rate.$errors"
      :handleBlur="v$.rate.$touch"
    />
    <PrimaryInput
      label="Rate percent"
      v-model.trim="developer.ratePercent"
      :inputProps="{ placeholder: '100', id: 'ratePercent' }"
      :errors="v$.ratePercent.$errors"
      :handleBlur="v$.ratePercent.$touch"
    />
    <VueToggles
      v-if="withStatus"
      v-model="developer.status"
      checkedText="Active"
      uncheckedText="Inactive"
    />
    <PrimaryButton @click="handleSubmit" :btnProps="{ disabled: isLoading }">{{
      btnText
    }}</PrimaryButton>
  </PrimaryForm>
</template>

<script setup>
import { reactive, watch } from "vue";
import PrimaryForm from "./UI/PrimaryForm.vue";
import PrimaryInput from "./UI/PrimaryInput.vue";
import PrimaryButton from "./UI/PrimaryButton.vue";
import { VueToggles } from "vue-toggles";
import { intToDecimal } from "@/utils/numbersUtils";

const {
  defaultDeveloper,
  handleSubmit,
  btnText,
  title,
  isLoading,
  withStatus,
  v$,
} = defineProps({
  defaultDeveloper: {
    type: Object,
    default: {
      firstName: "",
      lastName: "",
      rate: "",
      ratePercent: "",
    },
  },
  handleSubmit: {
    type: Function,
    required: true,
  },
  isLoading: Boolean,
  title: String,
  btnText: String,
  withStatus: Boolean,
  v$: Object,
});

const emit = defineEmits(["update"]);

const defaultDeveloperCopy = JSON.parse(JSON.stringify(defaultDeveloper));

const developer = reactive(defaultDeveloperCopy);

watch(developer, () => {
  emit("update", developer);
});

watch(
  () => developer.rate,
  () => {
    developer.rate = intToDecimal(developer.rate);
  }
);
</script>

<style lang="scss" scoped></style>
