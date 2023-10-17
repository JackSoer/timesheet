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
      :inputProps="{ placeholder: '99999.99', id: 'rate' }"
      :errors="v$.rate.$errors"
      :handleBlur="v$.rate.$touch"
    />
    <PrimaryInput
      label="Rate percent"
      v-model.trim="developer.ratePercent"
      :inputProps="{ placeholder: '100.00', id: 'ratePercent' }"
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
import { isNumberInRange } from "@/utils/numbersUtils";
import useVuelidate from "@vuelidate/core";
import { helpers, required, maxLength } from "@vuelidate/validators";
import PrimaryButton from "./UI/PrimaryButton.vue";
import { VueToggles } from "vue-toggles";

const {
  defaultDeveloper,
  handleSubmit,
  btnText,
  title,
  isLoading,
  withStatus,
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
});

const emit = defineEmits(["update"]);

const defaultDeveloperCopy = JSON.parse(JSON.stringify(defaultDeveloper));

const developer = reactive(defaultDeveloperCopy);

const validateRate = (value) => {
  if (value.trim() !== "") {
    return isNumberInRange(value, 99999.99, -99999.99);
  }

  return true;
};

const validateRatePercent = (value) => {
  if (value.trim() !== "") {
    return isNumberInRange(value, 100.0, 0.0);
  }

  return true;
};

const rules = {
  firstName: { required, maxLength: maxLength(50) },
  lastName: { required, maxLength: maxLength(50) },
  rate: {
    validateRate: helpers.withMessage(
      "Rate should be 99999.99 format",
      validateRate
    ),
  },
  ratePercent: {
    validateRatePercent: helpers.withMessage(
      "Rate percent should be from 0 to 100 format",
      validateRatePercent
    ),
  },
};

const v$ = useVuelidate(rules, developer);

watch(developer, async () => {
  const isValid = await v$.value.$validate();
  emit("update", developer, isValid);
});
</script>

<style lang="scss" scoped></style>
