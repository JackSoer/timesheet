<template>
  <PrimaryLayout>
    <Head title="Dashboard" />
    <main class="dashboard">
      <div class="container">
        <div class="dashboard__cards">
          <DashboardCard
            :title="`${paidThisMonth.toFixed(2)}$`"
            :text="`Paid in ${monthName}`"
          />
          <DashboardCard :title="`${unpaid.toFixed(2)}$`" text="Total unpaid" />
        </div>
        <WorkLogsTable :workLogs="workLogsByDevelopers" :date="date" />
      </div>
    </main>
  </PrimaryLayout>
</template>

<script setup>
import DashboardCard from "@/components/DashboardCard.vue";
import PrimaryLayout from "../layouts/PrimaryLayout.vue";
import { Head } from "@inertiajs/vue3";
import WorkLogsTable from "@/components/WorkLogsTable.vue";
import { format } from "date-fns";

const { paidThisMonth, unpaid, workLogsByDevelopers, date } = defineProps({
  paidThisMonth: {
    type: Number,
    required: true,
  },
  unpaid: {
    type: Number,
    required: true,
  },
  workLogsByDevelopers: {
    type: Array,
    required: true,
  },
  date: String,
});

let currentDate = new Date();
const monthName = format(currentDate, "MMMM");
</script>

<style lang="scss" scoped>
.dashboard {
  padding: 35px 0;

  &__cards {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 30px;
    margin-bottom: 40px;
  }
}
</style>
