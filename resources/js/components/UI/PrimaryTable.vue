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
        :style="{
          gridTemplateColumns: doubleCell
            ? `repeat(${headers.length + 1}, 1fr)`
            : `repeat(${headers.length}, 1fr)`,
        }"
      >
        <th
          v-if="doubleCell"
          class="primary-table__column-title primary-table__column-title--double"
        >
          <p class="primary-table__column-title-item">
            {{ doubleCell.firstText }}
          </p>
          <p class="primary-table__column-title-item">
            {{ doubleCell.secondText }}
          </p>
        </th>
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
const { title, headers, doubleCell } = defineProps({
  title: String,
  headers: {
    type: Array,
    required: true,
  },
  doubleCell: Object,
});
</script>

<style lang="scss" scoped>
@import "../../../scss/var";
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
    display: flex;
    align-items: center;
    justify-content: center;

    &--double {
      display: flex;
      flex-direction: column;
      padding: 3px;
      position: relative;
      width: 120px;
      height: 55px;

      &::after {
        content: "";
        display: block;
        background-color: rgb(19, 15, 255);
        position: absolute;
        height: 1px;
        width: 130px;
        transform: rotate(24deg);
      }
    }

    &-item {
      font-size: 11px;
      font-weight: 700;
      position: absolute;

      &:first-child {
        align-self: flex-end;
        top: 10px;
        right: 10px;
      }

      &:last-child {
        align-self: flex-end;
        bottom: 10px;
        left: 10px;
      }
    }
  }
}
</style>
