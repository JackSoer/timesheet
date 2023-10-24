import { render } from "@testing-library/vue";
import PlusIcon from "./PlusIcon.vue";

test("Check component rendering", () => {
  const { container } = render(PlusIcon);
  expect(container).toBeDefined();
});
