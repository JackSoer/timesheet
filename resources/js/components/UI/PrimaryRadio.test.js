import { render, fireEvent } from "@testing-library/vue";
import PrimaryRadio from "./PrimaryRadio.vue";

test("Render radio without label", async () => {
  const { container } = render(PrimaryRadio, {
    props: {
      value: "option1",
    },
  });

  const radioElement = container.querySelector(".primary-radio__item");
  expect(radioElement).toBeTruthy();
});

test("Render radio with label", async () => {
  const { getByText } = render(PrimaryRadio, {
    props: {
      label: "Option 1",
      value: "option1",
    },
  });

  const radioElement = getByText("Option 1");
  expect(radioElement).toBeTruthy();
});

test("Check radio change event", async () => {
  const { container } = render(PrimaryRadio, {
    props: {
      value: "option1",
      modelValue: "option1",
    },
  });

  const radioElement = container.querySelector(".primary-radio__item");

  expect(radioElement.checked).toBe(false);
  await fireEvent.click(radioElement);
  expect(radioElement.checked).toBe(true);
});
