<template>
  <main class="add-developer">
    <Head title="Add Developer" />
    <DeveloperForm
      @update="handleChange"
      :handleSubmit="handleSubmit"
      :isLoading="developer.processing"
      title="Add Developer"
      btnText="Add"
      :v$="v$"
    />
  </main>
</template>

<script setup>
import DeveloperForm from "@/components/DeveloperForm.vue";
import { useForm } from "@inertiajs/vue3";
import { Head } from "@inertiajs/vue3";
import useVuelidate from "@vuelidate/core";
import { required, maxLength, between } from "@vuelidate/validators";

let developer = useForm({
  firstName: "",
  lastName: "",
  rate: "",
  ratePercent: "",
});

const rules = {
  firstName: { required, maxLength: maxLength(50) },
  lastName: { required, maxLength: maxLength(50) },
  rate: {
    between: between(0, 99999),
  },
  ratePercent: {
    between: between(0, 100),
  },
};

const v$ = useVuelidate(rules, developer);

const handleChange = (newDeveloper) => {
  for (const key in newDeveloper) {
    developer[key] = newDeveloper[key];
  }
};

const handleSubmit = async () => {
  const isValid = await v$.value.$validate();

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
