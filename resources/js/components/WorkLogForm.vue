<template>
  <PrimaryForm :title="title">
    <PrimaryInput
      label="Date"
      :inputProps="{
        type: 'date',
        autofocus: true,
        required: true,
        id: 'date',
      }"
      v-model.trim="workLog.date"
      :errors="v$.date.$errors"
      :handleBlur="v$.date.$touch"
    />
    <div class="work-log-form-add-developer">
      <PrimarySelect
        :options="optionsDevelopers"
        label="Developer"
        :selectProps="{ id: 'Developer', required: true }"
        v-model="workLog.developerId"
        :errors="v$.developerId.$errors"
        :handleBlur="v$.developerId.$touch"
      />
      <Link href="/developers/create" class="work-log-form-add-developer__add"
        ><AddBtn
      /></Link>
    </div>
    <div class="work-log-form-add-project">
      <PrimarySelect
        :options="optionsProjects"
        label="Projects"
        :selectProps="{ id: 'Project', required: true }"
        v-model="workLog.projectId"
        :errors="v$.projectId.$errors"
        :handleBlur="v$.projectId.$touch"
      />
      <Link href="/projects/create" class="work-log-form-add-project__add"
        ><AddBtn
      /></Link>
    </div>
    <div class="rate-box">
      <PrimaryInput
        @input="handleFormatRate"
        @handleChange="rateDescription = ''"
        label="Rate"
        v-model.trim="workLog.rate"
        :inputProps="{
          placeholder: '1.00',
          id: 'rate',
          type: 'number',
          step: 0.01,
        }"
        :errors="v$.rate.$errors"
        :handleBlur="v$.rate.$touch"
      />
      <p class="rate-box__desc" v-if="rateDescription">
        {{ rateDescription }} rate
      </p>
    </div>
    <PrimaryInput
      label="Hours"
      v-model.trim="workLog.hrs"
      :inputProps="{
        placeholder: '24',
        id: 'hrs',
        required: true,
        type: 'number',
      }"
      :errors="v$.hrs.$errors"
      :handleBlur="v$.hrs.$touch"
    />
    <PrimaryInput
      label="Total"
      v-model.trim="workLog.total"
      :inputProps="{ placeholder: '1000000000', id: 'total', type: 'number' }"
      :errors="v$.total.$errors"
      :handleBlur="v$.total.$touch"
    />
    <VueToggles
      v-model="workLog.status"
      checkedText="Paid"
      uncheckedText="Unpaid"
    />
    <PrimaryButton @click="handleSubmit" :btnProps="{ disabled: isLoading }">{{
      btnText
    }}</PrimaryButton>
  </PrimaryForm>
</template>

<script setup>
import { computed, reactive, ref, watch } from "vue";
import PrimaryForm from "./UI/PrimaryForm.vue";
import PrimaryInput from "./UI/PrimaryInput.vue";
import PrimaryButton from "./UI/PrimaryButton.vue";
import { VueToggles } from "vue-toggles";
import PrimarySelect from "./UI/PrimarySelect.vue";
import AddBtn from "./AddBtn.vue";
import { Link } from "@inertiajs/vue3";
import { intToDecimal } from "@/utils/numbersUtils";

const {
  developers,
  projects,
  defaultWorkLog,
  handleSubmit,
  btnText,
  title,
  isLoading,
  v$,
} = defineProps({
  defaultWorkLog: {
    type: Object,
    default: {
      date: "",
      developerId: "",
      projectId: "",
      rate: "",
      hrs: "",
      total: "",
    },
  },
  handleSubmit: {
    type: Function,
    required: true,
  },
  isLoading: Boolean,
  title: String,
  btnText: String,
  developers: {
    type: Array,
    required: true,
  },
  projects: {
    type: Array,
    required: true,
  },
  v$: Object,
});

const emit = defineEmits(["update"]);

const defaultWorkLogCopy = JSON.parse(JSON.stringify(defaultWorkLog));

const workLog = reactive(defaultWorkLogCopy);
const rateDescription = ref("");

const optionsDevelopers = computed(() =>
  developers.map((developer) => {
    return {
      value: developer.id,
      text: `${developer.firstName} ${developer.lastName}`,
    };
  })
);

const optionsProjects = computed(() =>
  projects.map((project) => {
    return { value: project.id, text: project.name };
  })
);

const rate = computed(() => {
  const developer = developers.find(
    (developer) => developer.id === Number(workLog.developerId)
  );

  if (developer?.rate && parseFloat(developer?.rate) !== 0) {
    rateDescription.value = "Developer";

    return developer?.rate;
  }

  const project = projects.find(
    (project) => project.id === Number(workLog.projectId)
  );

  if (project?.rate && parseFloat(project?.rate) !== 0) {
    rateDescription.value = "Project";

    return project?.rate;
  }

  if (project?.client?.rate && parseFloat(project?.client?.rate) !== 0) {
    rateDescription.value = "Client";

    return project?.client?.rate;
  }
});

const handleFormatRate = () => {
  workLog.rate = intToDecimal(workLog.rate);
};

const total = computed(() => {
  let total = "";

  if (workLog.hrs && workLog.rate) {
    total = (workLog.hrs * workLog.rate).toFixed(2);
  }

  return total;
});

watch(total, () => {
  workLog.total = total.value;
});

watch(rate, () => {
  workLog.rate = rate.value;
});

watch(workLog, () => {
  if (!workLog.rate) {
    rateDescription.value = "";
  }

  emit("update", workLog);
});
</script>

<style lang="scss" scoped>
.work-log-form-add-project,
.work-log-form-add-developer {
  display: flex;
  align-items: center;
  gap: 10px;
  width: 100%;

  &__add {
    margin-top: auto;
  }
}

.rate-box {
  &__desc {
    margin-top: 4px;
    font-size: 10px;
    color: gray;
  }
}
</style>
