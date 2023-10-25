import { render, fireEvent } from "@testing-library/vue";
import ChangePasswordForm from "./ChangePasswordForm.vue";
import { config } from "@vue/test-utils";

config.global.mocks = {
  $t: () => "",
};

jest.mock("@inertiajs/vue3", () => ({
  __esModule: true,
  ...jest.requireActual("@inertiajs/vue3"),
  useForm: () => ({
    currentPassword: "",
    newPassword: "",
  }),
}));

test("Renders the form", async () => {
  const { getByPlaceholderText } = render(ChangePasswordForm);

  const currentPasswordInput = getByPlaceholderText("Current Password");
  const newPasswordInput = getByPlaceholderText("New Password");

  expect(currentPasswordInput).toBeTruthy();
  expect(newPasswordInput).toBeTruthy();
});

test("Emits 'cancel' event when Cancel button is clicked", async () => {
  const { getByText, emitted } = render(ChangePasswordForm);

  const cancelButton = getByText("Cancel");

  await fireEvent.click(cancelButton);

  expect(emitted()).toHaveProperty("cancel");
});
