<template>
  <PrimaryLayout>
    <main class="add-client">
      <Head title="Add client" />
      <ClientForm
        @update="handleChange"
        :handleSubmit="handleSubmit"
        :isLoading="isLoading"
        title="Add Client"
        btnText="Add"
        :v$="v$"
      />
    </main>
  </PrimaryLayout>
</template>

<script setup>
import ClientForm from "@/components/ClientForm.vue";
import { router, useForm } from "@inertiajs/vue3";
import { Head } from "@inertiajs/vue3";
import useVuelidate from "@vuelidate/core";
import { required, maxLength, between } from "@vuelidate/validators";
import PrimaryLayout from "@/layouts/PrimaryLayout.vue";
import { ref, watch } from "vue";

const { prevUrl } = defineProps({
  prevUrl: String,
});

let client = useForm({
  name: "",
  rate: "",
});

const isLoading = ref(false);

const rules = {
  name: { required, maxLength: maxLength(50) },
  rate: {
    between: between(0, 99999),
  },
};

const v$ = useVuelidate(rules, client);

const handleChange = (newClient) => {
  client.name = newClient.name;
  client.rate = newClient.rate;
};

const handleSubmit = async () => {
  const isValid = await v$.value.$validate();

  if (isValid) {
    isLoading.value = !client.processing;

    client.post("/clients");
  }
};

watch(
  () => client.processing,
  () => {
    if (!client.processing) {
      if (
        !prevUrl ||
        prevUrl.includes("/clients/create") ||
        prevUrl.endsWith("/projects")
      ) {
        router.visit("/clients");
      } else {
        router.visit(prevUrl);
      }
    }
  }
);
</script>

<style lang="scss" scoped>
.add-client {
  padding: 35px 0;
  width: 100%;
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
}
</style>
