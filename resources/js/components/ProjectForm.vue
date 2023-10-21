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
        :errors="v$.clientId.$errors"
        :handleBlur="v$.clientId.$touch"
      />
      <Link href="/clients/create" class="project-form-add-client__add"
        ><AddBtn
      /></Link>
    </div>
    <PrimaryInput
      label="Rate"
      v-model.trim="project.rate"
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
      v-model="project.status"
      checkedText="Active"
      uncheckedText="Inactive"
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
import PrimaryButton from "./UI/PrimaryButton.vue";
import { VueToggles } from "vue-toggles";
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
  v$,
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
  v$: Object,
});

const emit = defineEmits(["update"]);

const defaultProjectCopy = JSON.parse(JSON.stringify(defaultProject));

const project = reactive(defaultProjectCopy);

const options = computed(() =>
  clients.map((client) => {
    return { value: client.id, text: client.name };
  })
);

watch(project, () => {
  emit("update", project);
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
