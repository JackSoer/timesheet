import { render } from "@testing-library/vue";
import WorkLogsTable from "./WorkLogsTable.vue";

test("Renders the correct title", () => {
  const { getByText } = render(WorkLogsTable, {
    props: {
      workLogs: [],
      date: "2023-10-01",
      isLoading: false,
    },
  });

  const titleText = getByText("October 2023");
  expect(titleText).toBeTruthy();
});

test("Renders 'no work logs' message when filledLogs is empty", () => {
  const { getByText } = render(WorkLogsTable, {
    props: {
      workLogs: [],
      date: "2023-10-01",
      isLoading: false,
    },
  });

  const noWorkLogsMessage = getByText(
    "There are no work logs for this month yet."
  );
  expect(noWorkLogsMessage).toBeTruthy();
});
