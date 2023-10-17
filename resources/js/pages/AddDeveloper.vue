<template>
  <main class="add-developer">
    <Head title="Add Developer" />
    <DeveloperForm
      @update="handleChange"
      :handleSubmit="handleSubmit"
      :isLoading="developer.processing"
      title="Add developer"
      btnText="Add"
    />
  </main>
</template>

<script setup>
import DeveloperForm from "@/components/DeveloperForm.vue";
import { useForm } from "@inertiajs/vue3";
import { Head } from "@inertiajs/vue3";

let developer = useForm({
  firstName: "",
  lastName: "",
  rate: "",
  ratePercent: "",
});

let isValid = false;

const handleChange = (newDeveloper, isValidDeveloper) => {
  developer.firstName = newDeveloper.firstName;
  developer.lastName = newDeveloper.lastName;
  developer.rate = newDeveloper.rate;
  developer.ratePercent = newDeveloper.ratePercent;

  isValid = isValidDeveloper;
};

const handleSubmit = () => {
  if (isValid) {
    developer.post("/developers");
  }
};
</script>

<style lang="scss" scoped>
.add-developer {
  padding: 35px 0;
  width: 100%;
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
}
</style>
