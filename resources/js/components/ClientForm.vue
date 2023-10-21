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
      :inputProps="{
        placeholder: '99999.00',
        id: 'rate',
        type: 'number',
        step: 0.01,
      }"
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
import PrimaryButton from "./UI/PrimaryButton.vue";
import { VueToggles } from "vue-toggles";

const {
  defaultClient,
  handleSubmit,
  btnText,
  title,
  isLoading,
  withStatus,
  v$,
} = defineProps({
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
  v$: Object,
});

const emit = defineEmits(["update"]);

const defaultClientCopy = JSON.parse(JSON.stringify(defaultClient));

const client = reactive(defaultClientCopy);

watch(client, () => {
  emit("update", client);
});
</script>

<style lang="scss" scoped></style>
