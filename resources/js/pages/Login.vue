<template>
  <div class="login">
    <Head title="Login" />
    <PrimaryForm
      :title="'Login'"
      :handleSubmit="() => credentials.post('/login')"
    >
      <PrimaryInput
        :inputProps="{ id: 'login', required: true, autofocus: true }"
        :label="'Login'"
        v-model="credentials.name"
      />
      <p class="error" v-if="errors.name">{{ errors.name }}</p>
      <PrimaryInput
        :inputProps="{ id: 'password', type: 'password', required: true }"
        :label="'Password'"
        v-model="credentials.password"
      />
      <p class="error" v-if="errors.password">{{ errors.password }}</p>
      <PrimaryButton
        :class="'login__btn'"
        :btnProps="{ disabled: credentials.processing }"
        >Log In</PrimaryButton
      >
      <p class="error error-center" v-if="errors.login">{{ errors.login }}</p>
      <p class="error error-center" v-if="errors.email">{{ errors.email }}</p>
    </PrimaryForm>
  </div>
</template>

<script setup>
import PrimaryForm from "../components/UI/PrimaryForm.vue";
import PrimaryInput from "../components/UI/PrimaryInput.vue";
import PrimaryButton from "../components/UI/PrimaryButton.vue";
import { useForm, Head } from "@inertiajs/vue3";

const credentials = useForm({
  name: "",
  password: "",
});

const { errors } = defineProps({
  errors: Object,
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
