<template>
  <PrimaryLayout>
    <main class="add-developer">
      <Head title="Add Volunteer" />
      <DeveloperForm
        @update="handleChange"
        :handleSubmit="handleSubmit"
        :isLoading="isLoading"
        title="Add Volunteer"
        btnText="Add"
        :v$="v$"
      />
    </main>
  </PrimaryLayout>
</template>

<script setup>
import DeveloperForm from "@/components/DeveloperForm.vue";
import { router, useForm } from "@inertiajs/vue3";
import { Head } from "@inertiajs/vue3";
import useVuelidate from "@vuelidate/core";
import { required, maxLength, between } from "@vuelidate/validators";
import PrimaryLayout from "@/layouts/PrimaryLayout.vue";
import { ref, watch } from "vue";

const { prevUrl } = defineProps({
  prevUrl: String,
});

let developer = useForm({
  firstName: "",
  lastName: "",
  rate: "",
  ratePercent: "",
});

const isLoading = ref(false);

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
    isLoading.value = !developer.processing;

    developer.post("/volunteers");
  }
};

watch(
  () => developer.processing,
  () => {
    if (!developer.processing) {
      if (
        !prevUrl ||
        prevUrl.includes("/clients/create") ||
        prevUrl.endsWith("/projects")
      ) {
        router.visit("/volunteers");
      } else {
        router.visit(prevUrl);
      }
    }
  }
);
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
