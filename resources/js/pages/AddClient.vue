<template>
  <div class="add-client">
    <ClientForm
      @update="handleChange"
      :handleSubmit="handleSubmit"
      :isLoading="client.processing"
    />
  </div>
</template>

<script setup>
import ClientForm from "@/components/ClientForm.vue";
import { useForm } from "@inertiajs/vue3";

let client = useForm({
  name: "",
  rate: "",
});

let isValid = false;

const handleChange = (newClient, isValidClient) => {
  client.name = newClient.name;
  client.rate = newClient.rate;

  isValid = isValidClient;
};

const handleSubmit = () => {
  if (isValid) {
    client.post("/clients");
  }
};
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
