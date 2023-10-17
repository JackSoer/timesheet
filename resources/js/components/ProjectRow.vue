<template>
  <tr class="project-row">
    <td class="project-row__item">
      <p class="project-row__text">{{ project.name }}</p>
    </td>
    <td class="project-row__item">
      <p class="project-row__text">{{ project.client.name }}</p>
    </td>
    <td class="project-row__item">
      <p class="project-row__text">{{ project.rate }}</p>
    </td>
    <td class="project-row__item">
      <p class="project-row__text">
        {{ project.status ? "Active" : "Inactive" }}
      </p>
    </td>
    <td class="project-row__item">
      <Link :href="`/projects/${project.id}/edit`"><EditBtn /></Link>
      <DeleteBtn
        @click="destroy(project.id)"
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

const { project } = defineProps({
  project: {
    type: Object,
    require: true,
  },
});

const destroy = async (id) => {
  deleteIsLoading.value = true;

  router.delete(`/projects/${id}`);
};
</script>

<style lang="scss" scoped>
.project-row {
  width: 100%;
  display: grid;
  grid-template-columns: 1fr 1fr 1fr 1fr 1fr;

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
