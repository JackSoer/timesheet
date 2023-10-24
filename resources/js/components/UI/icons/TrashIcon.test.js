import { render } from "@testing-library/vue";
import TrashIcon from "./TrashIcon.vue";

test("Check component rendering", () => {
  const { container } = render(TrashIcon);
  expect(container).toBeDefined();
});
