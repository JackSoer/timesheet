<template>
  <PrimaryLayout>
    <main class="edit-project">
      <Head title="Edit project" />
      <ProjectForm
        title="Edit Project"
        @update="handleChange"
        :handleSubmit="handleSubmit"
        :isLoading="isLoading"
        btnText="Save"
        :withStatus="true"
        :clients="clients"
        :defaultProject="project"
        :v$="v$"
      />
      <PrimaryModal v-model:isOpen="warningOpen">
        <div class="edit-project__modal">
          <p class="edit-project__warning">
            Project with this name already exists. Are you sure you want to save
            it?
          </p>
          <PrimaryButton
            class="edit-project__save"
            @click="
              () => {
                handleSubmit(e, true);
              }
            "
            >Save</PrimaryButton
          >
        </div>
      </PrimaryModal>
    </main>
  </PrimaryLayout>
</template>

<script setup>
import ProjectForm from "@/components/ProjectForm.vue";
import { Head } from "@inertiajs/vue3";
import { useForm } from "@inertiajs/vue3";
import useVuelidate from "@vuelidate/core";
import { required, maxLength, between } from "@vuelidate/validators";
import PrimaryLayout from "@/layouts/PrimaryLayout.vue";
import PrimaryModal from "@/components/UI/PrimaryModal.vue";
import PrimaryButton from "@/components/UI/PrimaryButton.vue";
import { ref } from "vue";

const { defaultProject, clients, projects } = defineProps({
  defaultProject: {
    type: Object,
    required: true,
  },
  clients: {
    type: Array,
    required: true,
  },
  projects: {
    type: Array,
    required: true,
  },
});

const formattedDefaultProject =
  defaultProject.rate === null
    ? { ...defaultProject, rate: "" }
    : defaultProject;

let project = useForm(formattedDefaultProject);

const warningOpen = ref(false);
const isLoading = ref(false);

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

const isExistingProject = () => {
  let isExistingProject = false;

  projects.forEach((existingProject) => {
    if (
      existingProject.name === project.name &&
      project.name !== formattedDefaultProject.name
    ) {
      isExistingProject = true;
    }
  });

  return isExistingProject;
};

const handleSubmit = async (e, confirmed) => {
  const isValid = await v$.value.$validate();

  if (isExistingProject() && !confirmed && isValid) {
    warningOpen.value = true;

    return;
  }

  if (isValid) {
    warningOpen.value = false;

    isLoading.value = !project.processing;

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

  &__warning {
    text-align: center;
    font-size: 16px;
    color: black;
  }

  &__modal {
    display: flex;
    flex-direction: column;
    gap: 20px;
    justify-content: center;
    align-items: center;
  }

  &__save {
    padding: 5px 50px;
  }
}
</style>
