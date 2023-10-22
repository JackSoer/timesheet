<template>
  <PrimaryLayout>
    <main class="edit-client">
      <Head title="Edit client" />
      <ClientForm
        title="Edit Client"
        @update="handleChange"
        :handleSubmit="handleSubmit"
        :isLoading="isLoading"
        :defaultClient="client"
        btnText="Save"
        :withStatus="true"
        :v$="v$"
      />
    </main>
  </PrimaryLayout>
</template>

<script setup>
import ClientForm from "@/components/ClientForm.vue";
import { Head } from "@inertiajs/vue3";
import { useForm } from "@inertiajs/vue3";
import useVuelidate from "@vuelidate/core";
import { required, maxLength, between } from "@vuelidate/validators";
import PrimaryLayout from "@/layouts/PrimaryLayout.vue";
import { ref } from "vue";

const { defaultClient } = defineProps({
  defaultClient: {
    type: Object,
    required: true,
  },
});

const formattedDefaultClient =
  defaultClient.rate === null ? { ...defaultClient, rate: "" } : defaultClient;

let client = useForm(formattedDefaultClient);
const isLoading = ref(false);

const rules = {
  name: { required, maxLength: maxLength(50) },
  rate: {
    between: between(0, 99999),
  },
};

const v$ = useVuelidate(rules, client);

const handleChange = (newClient) => {
  for (const key in newClient) {
    client[key] = newClient[key];
  }
};

const handleSubmit = async () => {
  const isValid = await v$.value.$validate();

  if (isValid) {
    isLoading.value = !client.processing;

    client.put(`/clients/${client.id}`);
  }
};
</script>

<style lang="scss" scoped>
.edit-client {
  padding: 35px 0;
  width: 100%;
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
}
</style>
