import { render } from "@testing-library/vue";
import SwitchMonthBtns from "./SwitchMonthButton.vue";

test("Renders the component with Previous and Next buttons", () => {
  const { getByText } = render(SwitchMonthBtns, {
    props: { currentDateProp: new Date("2023-10-01"), loading: false },
  });

  const prevButton = getByText("Prev");
  const nextButton = getByText("Next");

  expect(prevButton).toBeTruthy();
  expect(nextButton).toBeTruthy();
});
