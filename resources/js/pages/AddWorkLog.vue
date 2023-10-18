<template>
  <main class="add-work-log">
    <Head title="Add Work Log" />
    <WorkLogForm
      @update="handleChange"
      :handleSubmit="handleSubmit"
      :isLoading="workLog.processing"
      :developers="developers"
      :projects="projects"
      title="Add work log"
      btnText="Add"
      :defaultWorkLog="workLog"
      :v$="v$"
    />
  </main>
</template>

<script setup>
import WorkLogForm from "@/components/WorkLogForm.vue";
import { useForm } from "@inertiajs/vue3";
import { Head } from "@inertiajs/vue3";
import { format } from "date-fns";
import useVuelidate from "@vuelidate/core";
import { required, between } from "@vuelidate/validators";

const { developers, projects } = defineProps({
  developers: {
    type: Array,
    required: true,
  },
  projects: {
    type: Array,
    required: true,
  },
});

let workLog = useForm({
  date: format(new Date(), "yyyy-MM-dd"),
  developerId: null,
  projectId: null,
  rate: "",
  hrs: "",
  total: "",
  status: null,
});

const rules = {
  date: { required },
  developerId: { required },
  projectId: { required },
  hrs: { required, between: between(1, 24) },
  rate: {
    between: between(0, 99999),
  },
  total: {
    between: between(0, 1000000000),
  },
};

const v$ = useVuelidate(rules, workLog);

const handleChange = (newWorkLog) => {
  for (const key in newWorkLog) {
    workLog[key] = newWorkLog[key];
  }

  workLog.status = newWorkLog.status ? 200 : 100;
};

const handleSubmit = async () => {
  const isValid = await v$.value.$validate();

  if (isValid) {
    workLog.post("/work-logs");
  }
};
</script>

<style lang="scss" scoped>
.add-work-log {
  padding: 35px 0;
  width: 100%;
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
}
</style>
