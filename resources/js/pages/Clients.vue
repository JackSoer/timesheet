<template>
  <PrimaryLayout>
    <main class="clients">
      <Head title="Clients" />
      <div class="container">
        <div class="clients__top">
          <h1 class="clients__title">Clients</h1>
          <Link href="/clients/create" class="clients__add"><AddBtn /></Link>
        </div>
        <PrimaryTable
          :headers="['Name', 'Rate', 'Status', 'Actions']"
          v-if="clients.length"
        >
          <ClientRow
            v-for="client in clients.slice().reverse()"
            :client="client"
            :key="client.id"
          />
        </PrimaryTable>
        <p class="clients__not-found" v-else>Clients not found</p>
      </div>
    </main>
  </PrimaryLayout>
</template>

<script setup>
import PrimaryTable from "@/components/UI/PrimaryTable.vue";
import ClientRow from "@/components/ClientRow.vue";
import AddBtn from "@/components/AddBtn.vue";
import { Link, Head } from "@inertiajs/vue3";
import PrimaryLayout from "@/layouts/PrimaryLayout.vue";

const { clients } = defineProps({
  clients: {
    type: Array,
    required: true,
  },
});
</script>

<style lang="scss" scoped>
@import "../../scss/var";
.clients {
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
