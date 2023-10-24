import { render } from "@testing-library/vue";
import AddButton from "./AddBtn.vue";

test("Render enabled button", async () => {
  const { container } = render(AddButton, {
    props: { btnProps: { disabled: false } },
  });

  const buttonElement = container.querySelector(".add-btn");
  expect(buttonElement).toBeTruthy();

  const iconElement = container.querySelector(".add-btn__icon");
  expect(iconElement).toBeTruthy();

  expect(buttonElement.classList).not.toContain("add-btn__disabled");
});

test("Render disabled button", async () => {
  const { container } = render(AddButton, {
    props: { btnProps: { disabled: true } },
  });

  const buttonElement = container.querySelector(".add-btn");
  expect(buttonElement).toBeTruthy();

  const iconElement = container.querySelector(".add-btn__icon");
  expect(iconElement).toBeTruthy();

  expect(buttonElement.classList).toContain("add-btn__disabled");
});
