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
    />
  </main>
</template>

<script setup>
import ProjectForm from "@/components/ProjectForm.vue";
import { Head } from "@inertiajs/vue3";
import { useForm } from "@inertiajs/vue3";

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

let isValid = true;

const handleChange = (newProject, isValidProject) => {
  project.name = newProject.name;
  project.rate = newProject.rate;
  project.status = newProject.status;
  project.clientId = newProject.clientId;

  isValid = isValidProject;
};

const handleSubmit = () => {
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
