<template>
  <main class="edit-developer">
    <Head title="Edit Developer" />
    <DeveloperForm
      title="Edit developer"
      @update="handleChange"
      :handleSubmit="handleSubmit"
      :isLoading="developer.processing"
      :defaultDeveloper="developer"
      btnText="Edit"
      :withStatus="true"
    />
  </main>
</template>

<script setup>
import DeveloperForm from "@/components/DeveloperForm.vue";
import { Head } from "@inertiajs/vue3";
import { useForm } from "@inertiajs/vue3";

const { defaultDeveloper } = defineProps({
  defaultDeveloper: {
    type: Object,
    required: true,
  },
});

const formattedDefaultDeveloper =
  defaultDeveloper.rate === null
    ? { ...defaultDeveloper, rate: "" }
    : defaultDeveloper;

let developer = useForm(formattedDefaultDeveloper);

let isValid = true;

const handleChange = (newDeveloper, isValidDeveloper) => {
  developer.firstName = newDeveloper.firstName;
  developer.lastName = newDeveloper.lastName;
  developer.rate = newDeveloper.rate;
  developer.ratePercent = newDeveloper.ratePercent;
  developer.status = newDeveloper.status;

  isValid = isValidDeveloper;
};

const handleSubmit = () => {
  if (isValid) {
    developer.put(`/developers/${developer.id}`);
  }
};
</script>

<style lang="scss" scoped>
.edit-developer {
  padding: 35px 0;
  width: 100%;
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
}
</style>
