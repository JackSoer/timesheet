import { render } from "@testing-library/vue";
import ClientRow from "./ClientRow.vue";

test("Renders client information correctly", () => {
  const client = {
    name: "Jack",
    rate: "1.00",
    status: true,
    id: 1,
  };

  const { getByText } = render(ClientRow, {
    props: {
      client,
    },
  });

  const nameElement = getByText("Jack");
  const rateElement = getByText("1.00");
  const statusElement = getByText("Active");

  expect(nameElement).toBeTruthy();
  expect(rateElement).toBeTruthy();
  expect(statusElement).toBeTruthy();
});
