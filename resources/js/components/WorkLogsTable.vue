<template>
  <div class="work-logs-table">
    <h1 class="work-logs-table__title">{{ `${monthName} ${year}` }}</h1>
    <SwitchMonthButton @update="handleMonth" />
    <PrimaryTable
      :headers="headers"
      :doubleCell="{
        firstText: 'Day',
        secondText: 'Developer',
      }"
    >
      <DeveloperLogsRow
        v-for="workLog in filledLogs"
        :workLog="workLog"
        :headers="headers"
      />
    </PrimaryTable>
  </div>
</template>

<script setup>
import PrimaryTable from "./UI/PrimaryTable.vue";
import SwitchMonthButton from "./SwitchMonthButton.vue";
import { computed, reactive, ref, watch } from "vue";
import { format, getDaysInMonth, getYear } from "date-fns";
import { router } from "@inertiajs/vue3";
import DeveloperLogsRow from "./DeveloperLogsRow.vue";
import { getArrayOfAllDatesInMonth } from "../utils/dates";

const { workLogs } = defineProps({
  workLogs: {
    type: Array,
    required: true,
  },
});

let currentDate = ref(new Date());

const arrayDates = computed(() => getArrayOfAllDatesInMonth(currentDate.value));

const filledLogs = workLogs.map((log) => {
  const filledLogs = arrayDates.value.map((date) => {
    const matchingLog = log.logs.find((logEntry) => logEntry.date === date);

    if (matchingLog) {
      return matchingLog;
    } else {
      return { date, hrs: "0" };
    }
  });

  return { ...log, logs: filledLogs };
});

const monthName = ref(format(currentDate.value, "MMMM"));
const daysInMonth = ref(getDaysInMonth(currentDate.value));
const year = ref(getYear(currentDate.value));

const getMonthDaysArray = (amountOfDays) => {
  const monthDaysArray = [];

  for (let i = 1; i <= amountOfDays; i++) {
    monthDaysArray.push(i);
  }

  return monthDaysArray;
};

let headers = reactive(getMonthDaysArray(daysInMonth.value));

const handleMonth = (newMonthName, newDaysInMonth, newYear, newCurrentDate) => {
  monthName.value = newMonthName.value;
  year.value = newYear.value;
  currentDate.value = newCurrentDate;

  headers = getMonthDaysArray(newDaysInMonth.value);
};

// watch(monthName, () => {
//   router.get(`/work-logs/${year.value}/${monthName.value}`);
// });
</script>

<style lang="scss" scoped>
.work-logs-table {
  display: flex;
  justify-content: center;
  flex-direction: column;
  gap: 10px;

  &__title {
    text-align: center;
    font-size: 30px;
    font-weight: 700;
  }
}
</style>
