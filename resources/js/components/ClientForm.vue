<template>
  <PrimaryForm :title="title">
    <PrimaryInput
      label="Name"
      :inputProps="{
        autofocus: true,
        required: true,
        placeholder: 'Jack',
        id: 'name',
      }"
      v-model.trim="client.name"
      :errors="v$.name.$errors"
      :handleBlur="v$.name.$touch"
    />
    <PrimaryInput
      label="Rate"
      v-model.trim="client.rate"
      :inputProps="{ placeholder: '99999.99', id: 'rate' }"
      :errors="v$.rate.$errors"
      :handleBlur="v$.rate.$touch"
    />
    <VueToggles
      v-if="withStatus"
      v-model="client.status"
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

const { defaultClient, handleSubmit, btnText, title, isLoading, withStatus } =
  defineProps({
    defaultClient: {
      type: Object,
      default: {
        name: "",
        rate: "",
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

const defaultClientCopy = JSON.parse(JSON.stringify(defaultClient));

const client = reactive(defaultClientCopy);

const validateRate = (value) => {
  if (value.trim() !== "") {
    return isNumberInRange(value, 99999.99, -99999.99);
  }

  return true;
};

const rules = {
  name: { required, maxLength: maxLength(50) },
  rate: {
    validateRate: helpers.withMessage(
      "Rate should be 99999.99 format",
      validateRate
    ),
  },
};

const v$ = useVuelidate(rules, client);

watch(client, async () => {
  const isValid = await v$.value.$validate();
  emit("update", client, isValid);
});
</script>

<style lang="scss" scoped></style>
