<template>
  <PrimaryForm
    class="change-pswrd"
    :handleSubmit="() => credentials.post('/change-password')"
  >
    <PrimaryInput
      v-model="credentials.currentPassword"
      :inputProps="{
        placeholder: 'Current Password',
        type: 'password',
        id: 'current-password',
        required: true,
      }"
      :errors="[errors?.currentPassword]"
    />
    <PrimaryInput
      v-model="credentials.newPassword"
      :inputProps="{
        placeholder: 'New Password',
        type: 'password',
        id: 'new-password',
        required: true,
      }"
      :errors="[errors?.newPassword]"
    />
    <div class="change-pswrd__btns">
      <PrimaryButton
        class="change-pswrd__edit-btn"
        :btnProps="{ type: 'submit' }"
        >Edit</PrimaryButton
      >
      <PrimaryButton class="change-pswrd__edit-btn" @click="emit('cancel')"
        >Cancel</PrimaryButton
      >
    </div>
  </PrimaryForm>
</template>

<script setup>
import PrimaryInput from "./UI/PrimaryInput.vue";
import PrimaryButton from "./UI/PrimaryButton.vue";
import PrimaryForm from "./UI/PrimaryForm.vue";
import { useForm } from "@inertiajs/vue3";
import { computed } from "vue";

const emit = defineEmits(["cancel"]);

const credentials = useForm({
  currentPassword: "",
  newPassword: "",
});

const errors = computed(() => credentials.errors);
</script>

<style lang="scss" scoped>
@import "../../scss/var";
.change-pswrd {
  width: 150px;

  &__btns {
    display: flex;
    align-items: center;
    gap: 8px;
  }

  &__edit-btn {
    border: 2px solid white;
    color: white;
    width: 100%;
    font-size: 16px;
    padding: 5px 8px;
    font-weight: 700;

    &:hover {
      border: 2px solid $mainBorder;
      color: $mainTextColor;
      background-color: white;
    }

    &__disabled {
      &:hover {
        border: 2px solid white;
        color: white;
        background-color: transparent;
      }
    }
  }
}
</style>
