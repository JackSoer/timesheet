import { render } from "@testing-library/vue";
import PenIcon from "./PenIcon.vue";

test("Check component rendering", () => {
  const { container } = render(PenIcon);
  expect(container).toBeDefined();
});
