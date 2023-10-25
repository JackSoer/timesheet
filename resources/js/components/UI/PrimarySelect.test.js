import { render, fireEvent } from "@testing-library/vue";
import PrimarySelect from "./PrimarySelect.vue";

test("Render select with label and options", async () => {
  const options = [
    { value: "option1", text: "Option 1" },
    { value: "option2", text: "Option 2" },
  ];

  const { getByText } = render(PrimarySelect, {
    props: {
      label: "Select Label",
      options,
      selectProps: { id: "test-select" },
      modelValue: "",
    },
  });

  const labelElement = getByText("Select Label");
  expect(labelElement).toBeTruthy();

  for (const option of options) {
    const optionElement = getByText(option.text);
    expect(optionElement).toBeTruthy();
  }
});

test("Check select change event", async () => {
  const options = [
    { value: "option1", text: "Option 1" },
    { value: "option2", text: "Option 2" },
  ];

  const { container } = render(PrimarySelect, {
    props: { options, modelValue: "", selectProps: { id: "test-select" } },
  });

  const selectElement = container.querySelector(".primary-select__item");

  expect(selectElement.value).toBe("");

  await fireEvent.change(selectElement, {
    target: { value: "option1" },
  });
  expect(selectElement.value).toBe("option1");

  await fireEvent.change(selectElement, {
    target: { value: "option2" },
  });
  expect(selectElement.value).toBe("option2");
});
