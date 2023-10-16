<template>
  <main class="add-project">
    <Head title="Add project" />
    <ProjectForm
      @update="handleChange"
      :handleSubmit="handleSubmit"
      :isLoading="project.processing"
      title="Add project"
      btnText="Add"
    />
  </main>
</template>

<script setup>
import ProjectForm from "@/components/ProjectForm.vue";
import { useForm } from "@inertiajs/vue3";
import { Head } from "@inertiajs/vue3";

let project = useForm({
  name: "",
  rate: "",
});

let isValid = false;

const handleChange = (newProject, isValidProject) => {
  project.name = newProject.name;
  project.rate = newProject.rate;

  isValid = isValidProject;
};

const handleSubmit = () => {
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
