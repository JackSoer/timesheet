import { render, screen } from "@testing-library/vue";
import ProjectRow from "./ProjectRow.vue";

test("Displays project details", () => {
  const project = {
    id: 1,
    name: "Test Project",
    client: { id: 1, name: "Client 1" },
    rate: "1.00",
    status: true,
  };

  render(ProjectRow, {
    props: { project },
  });

  expect(screen.getByText("Test Project")).toBeTruthy();
  expect(screen.getByText("Client 1")).toBeTruthy();
  expect(screen.getByText("1.00")).toBeTruthy();
  expect(screen.getByText("Active")).toBeTruthy();
});
