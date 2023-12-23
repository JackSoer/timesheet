<template>
  <div class="work-logs-table">
    <h1 class="work-logs-table__title">{{ `${monthName} ${year}` }}</h1>
    <SwitchMonthButton
      @update="handleMonth"
      :currentDateProp="currentDate"
      :loading="loading"
    />
    <PrimaryTable
      :headers="headers"
      :doubleCell="{
        firstText: 'Day',
        secondText: 'Volunteer',
      }"
      :class="{
        loading: loading,
      }"
    >
      <DeveloperLogsRow
        v-for="workLog in filledLogs"
        :workLog="workLog"
        :headers="headers"
      />
      <tr class="not-found" v-if="filledLogs.length < 1">
        <td class="not-found__cell">
          There are no work logs for this month yet.
        </td>
      </tr>
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

const { workLogs, date, isLoading } = defineProps({
  workLogs: {
    type: Array,
    required: true,
  },
  date: String,
  isLoading: {
    type: Boolean,
    default: false,
  },
});
const loading = ref(isLoading);

let currentDate = ref(date ? new Date(date) : new Date());

const arrayDates = computed(() => getArrayOfAllDatesInMonth(currentDate.value));

const filledLogs = workLogs.map((log) => {
  const filledLogs = arrayDates.value.map((date) => {
    const matchingLog = log.logs.find((logEntry) => logEntry.date === date);

    if (matchingLog) {
      return matchingLog;
    } else {
      return { date, hrs: "" };
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

watch(monthName, () => {
  loading.value = true;

  router.get(`/work-logs/${year.value}/${monthName.value}`);
});
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

.not-found {
  &__cell {
    font-size: 25px;
    font-weight: 500;

    text-align: center;
    color: black;
    padding: 10px;
  }
}
</style>
