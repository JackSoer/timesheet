<template>
  <div class="switch-month-btns">
    <PrimaryButton
      class="switch-month-btns__btn"
      @click="prevMonth"
      :btnProps="{ disabled: loading }"
      >Prev</PrimaryButton
    ><PrimaryButton
      class="switch-month-btns__btn"
      @click="nextMonth"
      :btnProps="{ disabled: loading }"
      >Next</PrimaryButton
    >
  </div>
</template>

<script setup>
import {
  format,
  getDaysInMonth,
  getYear,
  addMonths,
  subMonths,
} from "date-fns";
import { ref, watch } from "vue";
import PrimaryButton from "./UI/PrimaryButton.vue";

const emit = defineEmits(["update"]);
const { currentDateProp, loading } = defineProps({
  currentDateProp: {
    type: Object,
  },
  loading: {
    type: Boolean,
    default: false,
  },
});

let currentDate = currentDateProp ? currentDateProp : new Date();

const year = ref(getYear(currentDate));
const daysInMonth = ref(getDaysInMonth(currentDate));
const monthName = ref(format(currentDate, "MMMM"));

const nextMonth = () => {
  currentDate = addMonths(currentDate, 1);

  daysInMonth.value = getDaysInMonth(currentDate);
  monthName.value = format(currentDate, "MMMM");
  year.value = getYear(currentDate);
};

const prevMonth = () => {
  currentDate = subMonths(currentDate, 1);

  daysInMonth.value = getDaysInMonth(currentDate);
  monthName.value = format(currentDate, "MMMM");
  year.value = getYear(currentDate);
};

watch([daysInMonth, monthName, year], () => {
  emit("update", monthName, daysInMonth, year, currentDate);
});
</script>

<style lang="scss" scoped>
.switch-month-btns {
  display: flex;
  align-items: center;
  gap: 10px;
  justify-content: flex-end;
}
</style>
