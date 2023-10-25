import { render } from "@testing-library/vue";
import RadioGroup from "./RadioGroup.vue";

test("Renders the toggle component with options", () => {
  const values = [
    { value: "option1", label: "Option 1", checked: true },
    { value: "option2", label: "Option 2", checked: false },
    { value: "option3", label: "Option 3", checked: false },
  ];
  const name = "toggleName";

  const { getByText } = render(RadioGroup, {
    props: { values, name },
  });

  const toggleTitle = getByText("toggleName");
  expect(toggleTitle).toBeTruthy();

  for (const value of values) {
    const optionLabel = getByText(value.label);
    expect(optionLabel).toBeTruthy();
  }
});
