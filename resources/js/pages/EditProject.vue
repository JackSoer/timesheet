<template>
  <main class="edit-project">
    <Head title="Edit project" />
    <ProjectForm
      title="Edit Project"
      @update="handleChange"
      :handleSubmit="handleSubmit"
      :isLoading="project.processing"
      :defaultproject="project"
      btnText="Edit"
      :withStatus="true"
      :clients="clients"
      :defaultProject="project"
      :v$="v$"
    />
  </main>
</template>

<script setup>
import ProjectForm from "@/components/ProjectForm.vue";
import { Head } from "@inertiajs/vue3";
import { useForm } from "@inertiajs/vue3";
import useVuelidate from "@vuelidate/core";
import { required, maxLength, between } from "@vuelidate/validators";

const { defaultProject, clients } = defineProps({
  defaultProject: {
    type: Object,
    required: true,
  },
  clients: {
    type: Array,
    required: true,
  },
});

const formattedDefaultProject =
  defaultProject.rate === null
    ? { ...defaultProject, rate: "" }
    : defaultProject;

let project = useForm(formattedDefaultProject);

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
    project.put(`/projects/${project.id}`);
  }
};
</script>

<style lang="scss" scoped>
.edit-project {
  padding: 35px 0;
  width: 100%;
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
}
</style>
