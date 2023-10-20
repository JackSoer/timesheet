<template>
  <tr
    class="developer-logs-row"
    :style="{
      gridTemplateColumns: `repeat(${headers.length + 1}, 1fr)`,
    }"
  >
    <td class="developer-logs-row__cell developer-logs-row__cell--first">
      {{ workLog.developer }}
    </td>
    <td v-for="log in workLog.logs" class="developer-logs-row__cell">
      {{ formatHrs(log.hrs) }}
    </td>
  </tr>
</template>

<script setup>
const { workLog, headers } = defineProps({
  workLog: {
    type: Object,
    required: true,
  },
  headers: {
    type: Array,
    required: true,
  },
});

const formatHrs = (hrs) => {
  if (hrs === "") {
    return hrs;
  }

  const parsedHrs = parseFloat(hrs);
  return parsedHrs % 1 === 0 ? parsedHrs.toString() : parsedHrs.toFixed(2);
};
</script>

<style lang="scss" scoped>
.developer-logs-row {
  width: 100%;
  display: grid;

  &__cell {
    padding: 10px 0;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    text-align: center;
    color: black;
    font-size: 11px;

    &--first {
      width: 120px;
      font-size: 14px;
      font-weight: 500;
    }
  }
}
</style>
