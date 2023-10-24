import { render, fireEvent } from "@testing-library/vue";
import PrimaryInput from "./PrimaryInput.vue";

test("Render input with label", async () => {
  const label = "Test Label";
  const { getByText } = render(PrimaryInput, {
    props: { label, inputProps: { id: "test-input" } },
  });

  const labelElement = getByText(label);
  expect(labelElement).toBeTruthy();

  const inputElement = document.getElementById("test-input");
  expect(inputElement).toBeDefined();
});

test("Render input without label", async () => {
  const { container } = render(PrimaryInput, {
    props: { inputProps: { id: "test-input" } },
  });

  const labelElement = container.querySelector(".primary-input__label");
  expect(labelElement).toBeNull();

  const inputElement = document.getElementById("test-input");
  expect(inputElement).toBeDefined();
});

test("Handle input event", async () => {
  const { getByRole } = render(PrimaryInput, {
    props: { inputProps: { id: "test-input" }, modelValue: "Initial Value" },
  });

  const inputElement = getByRole("textbox");
  expect(inputElement.value).toBe("Initial Value");

  await fireEvent.update(inputElement, "New Value");
  expect(inputElement.value).toBe("New Value");
});

test("Handle blur event", async () => {
  const handleBlur = jest.fn();
  const { getByRole } = render(PrimaryInput, {
    props: { inputProps: { id: "test-input" }, handleBlur },
  });

  const inputElement = getByRole("textbox");
  await fireEvent.blur(inputElement);

  expect(handleBlur).toHaveBeenCalled();
});

test("Render errors", async () => {
  const errors = ["Error 1", "Error 2"];
  const { getByText } = render(PrimaryInput, {
    props: { errors, inputProps: { id: "test-input" } },
  });

  errors.forEach((error) => {
    const errorElement = getByText(error);
    expect(errorElement).toBeTruthy();
  });
});

test("Render without errors", async () => {
  const { container } = render(PrimaryInput, {
    props: { inputProps: { id: "test-input" } },
  });

  const errorElements = container.querySelectorAll(".error");
  expect(errorElements).toHaveLength(0);
});
