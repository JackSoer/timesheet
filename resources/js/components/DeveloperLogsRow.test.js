import { render, screen } from "@testing-library/vue";
import DeveloperLogsRow from "./DeveloperLogsRow.vue";
import { formatNumber } from "../utils/numbersUtils";

test("Renders developer name and log values", async () => {
  const workLog = {
    developer: "John Doe",
    logs: [{ hrs: 3 }, { hrs: 5 }, { hrs: 2 }],
  };

  const headers = ["Date 1", "Date 2", "Date 3"];

  render(DeveloperLogsRow, {
    props: {
      workLog,
      headers,
    },
  });

  const developerName = screen.getByText("John Doe");
  expect(developerName).toBeTruthy();

  for (const log of workLog.logs) {
    const logValue = screen.getByText(log.hrs.toString());
    expect(logValue).toBeTruthy();
  }
});
