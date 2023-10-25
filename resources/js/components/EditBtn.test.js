import { render } from "@testing-library/vue";
import EditBtn from "./EditBtn.vue";

test("Render enabled button", async () => {
  const { container } = render(EditBtn);

  const buttonElement = container.querySelector(".pen-btn");
  expect(buttonElement).toBeTruthy();

  const iconElement = container.querySelector(".pen-btn__icon");
  expect(iconElement).toBeTruthy();
});
