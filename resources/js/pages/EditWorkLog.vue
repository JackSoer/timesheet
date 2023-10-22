<template>
  <PrimaryLayout>
    <main class="edit-work-log">
      <Head title="Edit Work Log" />
      <WorkLogForm
        title="Edit Work Log"
        @update="handleChange"
        :handleSubmit="handleSubmit"
        :isLoading="isLoading"
        :defaultWorkLog="workLog"
        btnText="Save"
        :projects="projects"
        :developers="developers"
        :v$="v$"
      />
    </main>
  </PrimaryLayout>
</template>

<script setup>
import WorkLogForm from "@/components/WorkLogForm.vue";
import { Head } from "@inertiajs/vue3";
import { useForm } from "@inertiajs/vue3";
import useVuelidate from "@vuelidate/core";
import { required, between } from "@vuelidate/validators";
import PrimaryLayout from "@/layouts/PrimaryLayout.vue";
import { ref } from "vue";

const { defaultWorkLog, developers, projects } = defineProps({
  defaultWorkLog: {
    type: Object,
    required: true,
  },
  developers: {
    type: Array,
    required: true,
  },
  projects: {
    type: Array,
    required: true,
  },
});

let formattedDefaultWorkLog = defaultWorkLog;

if (defaultWorkLog.rate === null) {
  formattedDefaultWorkLog = { ...defaultWorkLog, rate: "" };
}

if (defaultWorkLog.status === 100) {
  formattedDefaultWorkLog = { ...defaultWorkLog, status: false };
}

let workLog = useForm(formattedDefaultWorkLog);
const isLoading = ref(false);

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
    isLoading.value = !workLog.processing;

    workLog.put(`/work-logs/${workLog.id}`);
  }
};
</script>

<style lang="scss" scoped>
.edit-work-log {
  padding: 35px 0;
  width: 100%;
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
}
</style>
