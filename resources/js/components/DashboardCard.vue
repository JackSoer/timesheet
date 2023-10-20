<template>
  <div class="dashboard-card" :class="{ appear: mounted }">
    <h6 class="dashboard-card__count">{{ title }}</h6>
    <p class="dashboard-card__text">{{ text }}</p>
  </div>
</template>

<script setup>
import { onMounted, ref } from "vue";

const { title, text } = defineProps({
  title: {
    type: String,
  },
  text: {
    type: String,
  },
});

const mounted = ref(false);

onMounted(() => {
  setTimeout(() => {
    mounted.value = true;
  }, 100);
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
  opacity: 0;
  transform: translateY(30px);
  transition: transform 0.5s, opacity 0.5s, background-color 0.3s,
    box-shadow 0.3s;

  &__count {
    font-size: 40px;
    font-weight: 700;
  }

  &__text {
    font-size: 25px;
    font-weight: 500;
    text-align: center;
  }

  &:hover {
    background-color: lighten(
      $mainBorder,
      10%
    ); // Измените цвет фона при наведении
    box-shadow: 0 0 10px 3px $mainTextColor; // Увеличьте размер и интенсивность тени
  }
}

.appear {
  transform: translateY(0);
  opacity: 1;
}
</style>
