<template>
  <PrimaryLayout>
    <main class="projects">
      <Head title="Projects" />
      <div class="container">
        <div class="projects__top">
          <h1 class="projects__title">Projects</h1>
          <Link href="/projects/create" class="projects__add"><AddBtn /></Link>
        </div>
        <PrimaryTable
          :headers="['Name', 'Client', 'Rate', 'Status', 'Actions']"
          v-if="projects.length"
        >
          <ProjectRow
            v-for="project in projects.slice().reverse()"
            :project="project"
            :key="project.id"
          />
        </PrimaryTable>
        <p class="projects__not-found" v-else>Projects not found</p>
      </div>
    </main>
  </PrimaryLayout>
</template>

<script setup>
import PrimaryTable from "@/components/UI/PrimaryTable.vue";
import ProjectRow from "@/components/ProjectRow.vue";
import AddBtn from "@/components/AddBtn.vue";
import { Link, Head } from "@inertiajs/vue3";
import PrimaryLayout from "@/layouts/PrimaryLayout.vue";

const { projects } = defineProps({
  projects: {
    type: Array,
    required: true,
  },
});
</script>

<style lang="scss" scoped>
@import "../../scss/var";
.projects {
  padding: 35px 0;

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
