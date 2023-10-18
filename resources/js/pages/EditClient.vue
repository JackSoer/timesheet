<template>
  <main class="edit-client">
    <Head title="Edit client" />
    <ClientForm
      title="Edit Client"
      @update="handleChange"
      :handleSubmit="handleSubmit"
      :isLoading="client.processing"
      :defaultClient="client"
      btnText="Edit"
      :withStatus="true"
      :v$="v$"
    />
  </main>
</template>

<script setup>
import ClientForm from "@/components/ClientForm.vue";
import { Head } from "@inertiajs/vue3";
import { useForm } from "@inertiajs/vue3";
import useVuelidate from "@vuelidate/core";
import { required, maxLength, between } from "@vuelidate/validators";

const { defaultClient } = defineProps({
  defaultClient: {
    type: Object,
    required: true,
  },
});

const formattedDefaultClient =
  defaultClient.rate === null ? { ...defaultClient, rate: "" } : defaultClient;

let client = useForm(formattedDefaultClient);

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
