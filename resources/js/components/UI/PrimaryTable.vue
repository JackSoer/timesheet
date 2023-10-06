<template>
  <table class="primary-table">
    <caption class="primary-table__title" v-if="title">
      {{
        title
      }}
    </caption>
    <thead class="primary-table__head">
      <tr
        class="primary-table__row"
        :style="{ gridTemplateColumns: columnsTemplateClass }"
      >
        <th class="primary-table__column-title" v-for="header in headers">
          {{ header }}
        </th>
      </tr>
    </thead>
    <tbody class="primary-table__body">
      <slot />
    </tbody>
  </table>
</template>

<script setup>
import { computed } from "vue";

const { title, headers } = defineProps({
  title: String,
  headers: {
    type: Array,
    required: true,
  },
});

const columnsTemplateClass = computed(() => {
  let templateClass = "";

  headers.forEach(() => (templateClass += " 1fr"));

  return templateClass;
});
</script>

<style lang="scss" scoped>
.primary-table {
  width: 100%;

  &__title {
    font-size: 40px;
    font-weight: 700;
    margin-bottom: 15px;
  }

  &__head,
  &__body {
    width: 100%;
  }

  &__row {
    display: grid;
  }

  &__column-title {
    font-size: 18px;
    font-weight: 700;
    padding: 10px 0;
  }
}
</style>
