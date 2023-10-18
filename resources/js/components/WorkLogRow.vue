<template>
  <tr class="work-log-row">
    <td class="work-log-row__item">
      <p class="work-log-row__text">{{ workLog.date }}</p>
    </td>
    <td class="work-log-row__item">
      <p class="work-log-row__text">
        {{ `${workLog.developer.firstName} ${workLog.developer.lastName}` }}
      </p>
    </td>
    <td class="work-log-row__item">
      <p class="work-log-row__text">
        {{ workLog.project.name }}
      </p>
    </td>
    <td class="work-log-row__item">
      <p class="work-log-row__text">{{ workLog.rate }}</p>
    </td>
    <td class="work-log-row__item">
      <p class="work-log-row__text">{{ workLog.hrs }}</p>
    </td>
    <td class="work-log-row__item">
      <p class="work-log-row__text">
        {{ workLog.total ? workLog.total : workLog.rate * workLog.hrs }}
      </p>
    </td>
    <td class="work-log-row__item">
      <p class="work-log-row__text">
        {{ workLog.status === 100 ? "Unpaid" : "Paid" }}
      </p>
    </td>
    <td class="work-log-row__item">
      <Link :href="`/work-logs/${workLog.id}/edit`"><EditBtn /></Link>
      <DeleteBtn
        @click="destroy(workLog.id)"
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

const { workLog } = defineProps({
  workLog: {
    type: Object,
    require: true,
  },
});

const destroy = async (id) => {
  deleteIsLoading.value = true;

  router.delete(`/work-logs/${id}`);
};
</script>

<style lang="scss" scoped>
.work-log-row {
  width: 100%;
  display: grid;
  grid-template-columns: 1fr 1fr 1fr 1fr 1fr 1fr 1fr 1fr;

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
