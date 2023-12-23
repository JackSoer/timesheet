<template>
  <PrimaryLayout>
    <main class="edit-developer">
      <Head title="Edit Volunteer" />
      <DeveloperForm
        title="Edit Volunteer"
        @update="handleChange"
        :handleSubmit="handleSubmit"
        :isLoading="isLoading"
        :defaultDeveloper="developer"
        btnText="Save"
        :withStatus="true"
        :v$="v$"
      />
    </main>
  </PrimaryLayout>
</template>

<script setup>
import DeveloperForm from "@/components/DeveloperForm.vue";
import { Head } from "@inertiajs/vue3";
import { useForm } from "@inertiajs/vue3";
import useVuelidate from "@vuelidate/core";
import { required, maxLength, between } from "@vuelidate/validators";
import PrimaryLayout from "@/layouts/PrimaryLayout.vue";
import { ref } from "vue";

const { defaultDeveloper } = defineProps({
  defaultDeveloper: {
    type: Object,
    required: true,
  },
});

let formattedDefaultDeveloper = defaultDeveloper;

if (defaultDeveloper.rate === null) {
  formattedDefaultDeveloper = { ...formattedDefaultDeveloper, rate: "" };
}

if (defaultDeveloper.ratePercent === null) {
  formattedDefaultDeveloper = { ...formattedDefaultDeveloper, ratePercent: "" };
}

let developer = useForm(formattedDefaultDeveloper);
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

    developer.put(`/volunteers/${developer.id}`);
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
