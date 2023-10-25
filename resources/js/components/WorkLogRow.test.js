import { render } from "@testing-library/vue";
import WorkLogRow from "./WorkLogRow.vue";

test("Renders the WorkLogRow component with the provided work log data", () => {
  const workLog = {
    id: 1,
    date: "2023-10-24",
    developer: { firstName: "John", lastName: "Doe" },
    project: { name: "Project A" },
    rate: 50,
    hrs: 8,
    total: 400,
    status: 100,
  };

  const { getByText } = render(WorkLogRow, {
    props: {
      workLog,
    },
  });

  const dateText = getByText("2023-10-24");
  const developerText = getByText("John Doe");
  const projectText = getByText("Project A");
  const rateText = getByText("50");
  const hrsText = getByText("8");
  const totalText = getByText("400");
  const statusText = getByText("Unpaid");

  expect(dateText).toBeTruthy();
  expect(developerText).toBeTruthy();
  expect(projectText).toBeTruthy();
  expect(rateText).toBeTruthy();
  expect(hrsText).toBeTruthy();
  expect(totalText).toBeTruthy();
  expect(statusText).toBeTruthy();
});
