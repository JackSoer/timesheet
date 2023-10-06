<template>
  <tr class="client-row">
    <td class="client-row__item">
      <p class="client-row__text">{{ client.name }}</p>
    </td>
    <td class="client-row__item">
      <p class="client-row__text">{{ client.rate }}</p>
    </td>
    <td class="client-row__item">
      <p class="client-row__text">{{ client.status }}</p>
    </td>
    <td class="client-row__item">
      <EditBtn />
      <Link
        as="button"
        :href="`/clients/${client.id}`"
        method="delete"
        :disabled="pageIsLoading"
      >
        <DeleteBtn :btnProps="{ disabled: pageIsLoading }" />
      </Link>
    </td>
  </tr>
</template>

<script setup>
import DeleteBtn from "./DeleteBtn.vue";
import EditBtn from "./EditBtn.vue";
import { Link, router } from "@inertiajs/vue3";
import { ref, onMounted } from "vue";

const { client } = defineProps({
  client: {
    type: Object,
    require: true,
  },
});

const pageIsLoading = ref(false);

onMounted(() => {
  router.on("start", () => (pageIsLoading.value = true));
  router.on("finish", () => (pageIsLoading.value = false));
});
</script>

<style lang="scss" scoped>
.client-row {
  width: 100%;
  display: grid;
  grid-template-columns: 1fr 1fr 1fr 1fr;

  &__item {
    padding: 10px 0;
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
