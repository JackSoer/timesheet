import { render } from "@testing-library/vue";
import PrimaryButton from "./PrimaryButton.vue";

test("Render button with content", async () => {
  const { getByText } = render(PrimaryButton, {
    slots: { default: "Button Content" },
    props: { btnProps: { disabled: false } },
  });

  const button = getByText("Button Content");
  expect(button).toBeTruthy();

  const classAttribute = button.getAttribute("class");
  expect(classAttribute).not.toContain("primary-button__disabled");
});

test("Render disabled button with content", async () => {
  const { getByText } = render(PrimaryButton, {
    slots: { default: "Button Content" },
    props: { btnProps: { disabled: true } },
  });

  const button = getByText("Button Content");
  expect(button).toBeTruthy();

  const classAttribute = button.getAttribute("class");
  expect(classAttribute).toContain("primary-button__disabled");
});
