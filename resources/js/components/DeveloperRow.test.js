import { render } from "@testing-library/vue";
import DeveloperRow from "./DeveloperRow.vue";

test("Renders developer information", async () => {
  const developer = {
    id: 1,
    firstName: "John",
    lastName: "Doe",
    rate: "100.0",
    ratePercent: 50,
    status: true,
  };

  const { getByText } = render(DeveloperRow, {
    props: {
      developer,
    },
  });

  const firstName = getByText("John");
  const lastName = getByText("Doe");

  const rateContainer = getByText("100.0");

  const ratePercent = getByText("50%");
  const status = getByText("Active");

  expect(firstName).toBeTruthy();
  expect(lastName).toBeTruthy();
  expect(rateContainer).toBeTruthy();
  expect(ratePercent).toBeTruthy();
  expect(status).toBeTruthy();
});
