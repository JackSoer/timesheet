<template>
  <tr class="client-row">
    <td class="client-row__item">
      <p class="client-row__text">{{ client.name }}</p>
    </td>
    <td class="client-row__item">
      <p class="client-row__text">{{ client.rate }}</p>
    </td>
    <td class="client-row__item">
      <p class="client-row__text">
        {{ client.status ? "Active" : "Inactive" }}
      </p>
    </td>
    <td class="client-row__item">
      <Link :href="`/clients/${client.id}/edit`"><EditBtn /></Link>
      <DeleteBtn
        @click="destroy(client.id)"
        :btnProps="{ disabled: deleteIsLoading }"
      />
    </td>
  </tr>
</template>

<script setup>
import DeleteBtn from "./DeleteBtn.vue";
import EditBtn from "./EditBtn.vue";
import { router, Link } from "@inertiajs/vue3";
import { ref } from "vue";

const deleteIsLoading = ref(false);

const { client } = defineProps({
  client: {
    type: Object,
    require: true,
  },
});

const destroy = async (id) => {
  deleteIsLoading.value = true;

  router.delete(`/clients/${id}`);
};
</script>

<style lang="scss" scoped>
.client-row {
  width: 100%;
  display: grid;
  grid-template-columns: 1fr 1fr 1fr 1fr;

  &__item {
    padding: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
  }

  &__text {
    font-size: 16px;
    font-weight: 500;
    text-align: center;
    color: black;
  }
}
</style>
