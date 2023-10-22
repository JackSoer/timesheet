<template>
  <PrimaryLayout>
    <main class="add-project">
      <Head title="Add project" />
      <ProjectForm
        @update="handleChange"
        :handleSubmit="handleSubmit"
        :isLoading="isLoading"
        :clients="clients"
        title="Add project"
        btnText="Add"
        :v$="v$"
      />
      <PrimaryModal v-model:isOpen="warningOpen">
        <div class="add-project__modal">
          <p class="add-project__warning">
            Project with this name already exists. Are you sure you want to save
            it?
          </p>
          <PrimaryButton
            class="add-project__save"
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
import { router, useForm } from "@inertiajs/vue3";
import { Head } from "@inertiajs/vue3";
import useVuelidate from "@vuelidate/core";
import { required, maxLength, between } from "@vuelidate/validators";
import PrimaryLayout from "@/layouts/PrimaryLayout.vue";
import { ref } from "vue";
import PrimaryButton from "@/components/UI/PrimaryButton.vue";
import PrimaryModal from "@/components/UI/PrimaryModal.vue";

const { clients, prevUrl, projects } = defineProps({
  clients: {
    type: Array,
    required: true,
  },
  prevUrl: String,
  projects: {
    type: Array,
    required: true,
  },
});

const isLoading = ref(false);

let project = useForm({
  name: "",
  rate: "",
  clientId: null,
});

const warningOpen = ref(false);

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
    if (existingProject.name === project.name) {
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

    project.post("/projects");

    if (
      !prevUrl ||
      prevUrl.includes("/clients/create") ||
      prevUrl.includes("/projects/create")
    ) {
      router.visit("/projects");
    } else {
      router.visit(prevUrl);
    }
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
