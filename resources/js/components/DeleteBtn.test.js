import { render } from "@testing-library/vue";
import DeleteBtn from "./DeleteBtn.vue";

test("Render enabled button", async () => {
  const { container } = render(DeleteBtn, {
    props: { btnProps: { disabled: false } },
  });

  const buttonElement = container.querySelector(".trash-btn");
  expect(buttonElement).toBeTruthy();

  const iconElement = container.querySelector(".trash-btn__icon");
  expect(iconElement).toBeTruthy();

  expect(buttonElement.classList).not.toContain("trash-btn__disabled");
});

test("Render disabled button", async () => {
  const { container } = render(DeleteBtn, {
    props: { btnProps: { disabled: true } },
  });

  const buttonElement = container.querySelector(".trash-btn");
  expect(buttonElement).toBeTruthy();

  const iconElement = container.querySelector(".trash-btn__icon");
  expect(iconElement).toBeTruthy();

  expect(buttonElement.classList).toContain("trash-btn__disabled");
});
