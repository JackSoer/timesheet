<template>
  <PrimaryLayout>
    <main class="work-logs">
      <Head title="Work Logs" />
      <div class="container">
        <div class="work-logs__top">
          <h1 class="work-logs__title">Work Logs</h1>
          <Link href="/work-logs/create" class="work-logs__add"
            ><AddBtn
          /></Link>
        </div>
        <PrimaryTable
          :headers="[
            'Date',
            'Developer',
            'Project',
            'Rate',
            'Hrs',
            'Total',
            'Status',
            'Actions',
          ]"
          v-if="workLogs.length"
        >
          <WorkLogRow
            v-for="workLog in workLogs.slice().reverse()"
            :workLog="workLog"
            :key="workLog.id"
          />
        </PrimaryTable>
        <p class="work-logs__not-found" v-else>Work logs not found</p>
      </div>
    </main>
  </PrimaryLayout>
</template>

<script setup>
import PrimaryTable from "@/components/UI/PrimaryTable.vue";
import WorkLogRow from "@/components/WorkLogRow.vue";
import AddBtn from "@/components/AddBtn.vue";
import { Link, Head } from "@inertiajs/vue3";
import PrimaryLayout from "@/layouts/PrimaryLayout.vue";

const { workLogs } = defineProps({
  workLogs: {
    type: Array,
    required: true,
  },
});
</script>

<style lang="scss" scoped>
@import "../../scss/var";
.work-logs {
  padding: 35px 0;

  &__title {
    font-size: 40px;
    font-weight: 700;
    text-align: center;
  }

  &__top {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 15px;
    position: relative;
  }

  &__not-found {
    text-align: center;
    font-size: 30px;
    font-weight: 500;
    color: black;
  }

  &__add {
    position: absolute;
    right: 0;
    bottom: 0;
  }
}
</style>
