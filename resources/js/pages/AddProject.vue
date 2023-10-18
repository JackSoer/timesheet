<template>
  <main class="add-project">
    <Head title="Add project" />
    <ProjectForm
      @update="handleChange"
      :handleSubmit="handleSubmit"
      :isLoading="project.processing"
      :clients="clients"
      title="Add project"
      btnText="Add"
      :v$="v$"
    />
  </main>
</template>

<script setup>
import ProjectForm from "@/components/ProjectForm.vue";
import { useForm } from "@inertiajs/vue3";
import { Head } from "@inertiajs/vue3";
import useVuelidate from "@vuelidate/core";
import { required, maxLength, between } from "@vuelidate/validators";

const { clients } = defineProps({
  clients: {
    type: Array,
    required: true,
  },
});

let project = useForm({
  name: "",
  rate: "",
  clientId: null,
});

const rules = {
  name: { required, maxLength: maxLength(50) },
  rate: {
    between: between(0, 99999),
  },
  clientId: { required },
};

const v$ = useVuelidate(rules, project);

const handleChange = (newProject) => {
  for (const key in newProject) {
    project[key] = newProject[key];
  }
};

const handleSubmit = async () => {
  const isValid = await v$.value.$validate();

  if (isValid) {
    project.post("/projects");
  }
};
</script>

<style lang="scss" scoped>
.add-project {
  padding: 35px 0;
  width: 100%;
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
}
</style>
