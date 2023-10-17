<template>
  <PrimaryForm :title="title">
    <PrimaryInput
      label="Name"
      :inputProps="{
        autofocus: true,
        required: true,
        placeholder: 'Game shop site',
        id: 'name',
      }"
      v-model.trim="project.name"
      :errors="v$.name.$errors"
      :handleBlur="v$.name.$touch"
    />
    <div class="project-form-add-client">
      <PrimarySelect
        :options="options"
        label="Client"
        :selectProps="{ id: 'Client', required: true }"
        v-model="project.clientId"
      />
      <Link href="/clients/create" class="project-form-add-client__add"
        ><AddBtn
      /></Link>
    </div>
    <PrimaryInput
      label="Rate"
      v-model.trim="project.rate"
      :inputProps="{ placeholder: '99999.99', id: 'rate' }"
      :errors="v$.rate.$errors"
      :handleBlur="v$.rate.$touch"
    />
    <Toggle
      @change="handleChangeStatus"
      :values="values"
      name="Status"
      v-if="withStatus"
    />
    <PrimaryButton @click="handleSubmit" :btnProps="{ disabled: isLoading }">{{
      btnText
    }}</PrimaryButton>
  </PrimaryForm>
</template>

<script setup>
import { computed, reactive, watch } from "vue";
import PrimaryForm from "./UI/PrimaryForm.vue";
import PrimaryInput from "./UI/PrimaryInput.vue";
import { isNumberInRange } from "@/utils/numbersUtils";
import useVuelidate from "@vuelidate/core";
import { helpers, required, maxLength } from "@vuelidate/validators";
import PrimaryButton from "./UI/PrimaryButton.vue";
import Toggle from "./Toggle.vue";
import PrimarySelect from "./UI/PrimarySelect.vue";
import AddBtn from "./AddBtn.vue";
import { Link } from "@inertiajs/vue3";

const {
  clients,
  defaultProject,
  handleSubmit,
  btnText,
  title,
  isLoading,
  withStatus,
} = defineProps({
  defaultProject: {
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
  clients: {
    type: Array,
    required: true,
  },
});

const emit = defineEmits(["update"]);

const defaultProjectCopy = JSON.parse(JSON.stringify(defaultProject));

const project = reactive(defaultProjectCopy);

const values = [
  { value: 1, label: "Active", checked: project.status ? true : false },
  { value: 0, label: "Inactive", checked: !project.status ? true : false },
];

const options = computed(() =>
  clients.map((client) => {
    return { value: client.id, text: client.name };
  })
);

const validateRate = (value) => {
  if (value.trim() !== "") {
    return isNumberInRange(value, 99999.99, -99999.99);
  }

  return true;
};

const handleChangeStatus = (selectedValue) => {
  project.status = selectedValue;
};

const rules = {
  name: { required, maxLength: maxLength(50) },
  rate: {
    validateRate: helpers.withMessage(
      "Rate should be 99999.99 format",
      validateRate
    ),
  },
  clientId: { required },
};

const v$ = useVuelidate(rules, project);

watch(project, async () => {
  const isValid = await v$.value.$validate();

  project.clientId = project.clientId;

  emit("update", project, isValid);
});
</script>

<style lang="scss" scoped>
.project-form-add-client {
  display: flex;
  align-items: center;
  gap: 10px;
  width: 100%;

  &__add {
    margin-top: auto;
  }
}
</style>
