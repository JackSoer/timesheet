import { render } from "@testing-library/vue";
import DashboardCard from "./DashboardCard.vue";

test("Renders the card with title and text", () => {
  const title = "Title";
  const text = "Some text";
  const { getByText } = render(DashboardCard, {
    props: {
      title,
      text,
    },
  });

  const titleElement = getByText(title);
  const textElement = getByText(text);

  expect(titleElement).toBeTruthy();
  expect(textElement).toBeTruthy();
});

test("Card appears after mounting", async () => {
  const title = "Title";
  const text = "Some text";
  const { container } = render(DashboardCard, {
    props: {
      title,
      text,
    },
  });

  const card = container.querySelector(".dashboard-card");

  expect(card.classList.contains("appear")).toBeFalsy();

  await new Promise((resolve) => setTimeout(resolve, 100));

  expect(card.classList.contains("appear")).toBeTruthy();
});
