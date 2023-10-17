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
    />
  </main>
</template>

<script setup>
import ClientForm from "@/components/ClientForm.vue";
import { Head } from "@inertiajs/vue3";
import { useForm } from "@inertiajs/vue3";

const { defaultClient } = defineProps({
  defaultClient: {
    type: Object,
    required: true,
  },
});

const formattedDefaultClient =
  defaultClient.rate === null ? { ...defaultClient, rate: "" } : defaultClient;

let client = useForm(formattedDefaultClient);

let isValid = true;

const handleChange = (newClient, isValidClient) => {
  client.name = newClient.name;
  client.rate = newClient.rate;
  client.status = newClient.status;

  isValid = isValidClient;
};

const handleSubmit = () => {
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
