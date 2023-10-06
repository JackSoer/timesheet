<template>
  <div class="clients">
    <Head title="Clients" />
    <div class="container">
      <div class="clients__top">
        <h1 class="clients__title">Clients</h1>
        <Link href="/add-client" class="clients__add">
          <AddBtn />
        </Link>
      </div>
      <PrimaryTable
        :headers="['Name', 'Rate', 'Status', 'Actions']"
        v-if="clients.length"
      >
        <ClientRow v-for="client in clients" :client="client" />
      </PrimaryTable>
      <p class="clients__not-found" v-else>0 clients</p>
    </div>
  </div>
</template>

<script setup>
import PrimaryTable from "@/components/UI/PrimaryTable.vue";
import ClientRow from "@/components/ClientRow.vue";
import AddBtn from "@/components/AddBtn.vue";
import { Link, Head } from "@inertiajs/vue3";

const { clients } = defineProps({
  clients: Array,
});
</script>

<style lang="scss" scoped>
.clients {
  padding: 15px 0;

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
  }

  &__add {
    position: absolute;
    right: 0;
    bottom: -8px;
  }
}
</style>
