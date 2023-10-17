<template>
  <tr class="developer-row">
    <td class="developer-row__item">
      <p class="developer-row__text">{{ developer.firstName }}</p>
    </td>
    <td class="developer-row__item">
      <p class="developer-row__text">{{ developer.lastName }}</p>
    </td>
    <td class="developer-row__item">
      <p class="developer-row__text">{{ developer.rate }}</p>
    </td>
    <td class="developer-row__item">
      <p class="developer-row__text">
        {{ developer.ratePercent ? developer.ratePercent + "%" : "" }}
      </p>
    </td>
    <td class="developer-row__item">
      <p class="developer-row__text">
        {{ developer.status ? "Active" : "Inactive" }}
      </p>
    </td>
    <td class="developer-row__item">
      <Link :href="`/developers/${developer.id}/edit`"><EditBtn /></Link>
      <DeleteBtn
        @click="destroy(developer.id)"
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

const { developer } = defineProps({
  developer: {
    type: Object,
    require: true,
  },
});

const destroy = async (id) => {
  deleteIsLoading.value = true;

  router.delete(`/developers/${id}`);
};
</script>

<style lang="scss" scoped>
.developer-row {
  width: 100%;
  display: grid;
  grid-template-columns: 1fr 1fr 1fr 1fr 1fr 1fr;

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
