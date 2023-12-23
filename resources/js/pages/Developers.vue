<template>
  <PrimaryLayout>
    <main class="developers">
      <Head title="Volunteers" />
      <div class="container">
        <div class="developers__top">
          <h1 class="developers__title">Volunteers</h1>
          <Link href="/volunteers/create" class="developers__add"
            ><AddBtn
          /></Link>
        </div>
        <PrimaryTable
          :headers="[
            'First Name',
            'Last Name',
            'Rate',
            'Rate Percent',
            'Status',
            'Actions',
          ]"
          v-if="developers.length"
        >
          <DeveloperRow
            v-for="developer in developers.slice().reverse()"
            :developer="developer"
            :key="developer.id"
          />
        </PrimaryTable>
        <p class="developers__not-found" v-else>Volunteers not found</p>
      </div>
    </main>
  </PrimaryLayout>
</template>

<script setup>
import PrimaryTable from "@/components/UI/PrimaryTable.vue";
import DeveloperRow from "@/components/DeveloperRow.vue";
import AddBtn from "@/components/AddBtn.vue";
import { Link, Head } from "@inertiajs/vue3";
import PrimaryLayout from "@/layouts/PrimaryLayout.vue";

const { developers } = defineProps({
  developers: {
    type: Array,
    required: true,
  },
});
</script>

<style lang="scss" scoped>
@import "../../scss/var";
.developers {
  padding: 50px 0;

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
