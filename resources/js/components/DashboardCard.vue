<template>
  <div class="dashboard-card">
    <h6 class="dashboard-card__count">{{ title }}</h6>
    <p class="dashboard-card__text">{{ text }}</p>
  </div>
</template>

<script setup>
const { title, text } = defineProps({
  title: {
    type: String,
  },
  text: {
    type: String,
  },
});
</script>

<style lang="scss" scoped>
@import "../../scss/var";
.dashboard-card {
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  gap: 10px;
  padding: 20px;
  width: 250px;
  height: 150px;
  background-color: $mainBorder;
  color: white;
  border-radius: 20px;
  box-shadow: 0 0 5px 2px $mainTextColor;

  &__count {
    font-size: 40px;
    font-weight: 700;
  }

  &__text {
    font-size: 25px;
    font-weight: 500;
    text-align: center;
  }
}
</style>
