<template>
  <main class="login">
    <Head title="Login" />
    <PrimaryForm
      :title="'Login'"
      :handleSubmit="() => credentials.post('/login')"
    >
      <PrimaryInput
        :inputProps="{ id: 'login', required: true, autofocus: true }"
        :label="'Login'"
        v-model="credentials.name"
        :error="errors?.name"
      />
      <PrimaryInput
        :inputProps="{ id: 'password', type: 'password', required: true }"
        :label="'Password'"
        v-model="credentials.password"
        :error="errors?.password"
      />
      <PrimaryButton
        :class="'login__btn'"
        :btnProps="{ disabled: credentials.processing }"
        >Log In</PrimaryButton
      >
      <p class="error error-center" v-if="errors?.login">{{ errors.login }}</p>
      <p class="error error-center" v-if="errors?.email">{{ errors.email }}</p>
    </PrimaryForm>
  </main>
</template>

<script setup>
import PrimaryForm from "../components/UI/PrimaryForm.vue";
import PrimaryInput from "../components/UI/PrimaryInput.vue";
import PrimaryButton from "../components/UI/PrimaryButton.vue";
import { useForm, Head, usePage } from "@inertiajs/vue3";
import { onMounted } from "vue";
const page = usePage();

const credentials = useForm({
  name: "",
  password: "",
});

let { errors } = defineProps({
  errors: {
    type: Object,
    default: null,
  },
});

onMounted(() => {
  page.props.errors = null;
});
</script>

<style lang="scss" scoped>
.login {
  min-height: 100vh;
  width: 100%;

  display: flex;
  align-items: center;
  justify-content: center;

  &__btn {
    margin-top: 5px;
  }
}

.error-center {
  text-align: center;
}
</style>
