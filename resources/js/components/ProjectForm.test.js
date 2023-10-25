import { render, screen, fireEvent } from "@testing-library/vue";
import YourComponent from "./YourComponent.vue";

test("Check form rendering", () => {
  const { container } = render(YourComponent, {
    props: {
      title: "Test Title",
      btnText: "Submit",
      clients: [{ id: 1, name: "Client 1" }],
      withStatus: false,
      v$: {},
      defaultProject: {},
      handleSubmit: () => {},
      isLoading: false,
    },
  });

  expect(container).toMatchSnapshot();

  expect(screen.getByText("Test Title")).toBeTruthy();
  expect(screen.getByText("Name")).toBeTruthy();
  expect(screen.getByLabelText("Name")).toBeTruthy();
  expect(screen.getByText("Client")).toBeTruthy();
  expect(screen.getByLabelText("Client")).toBeTruthy();
  expect(screen.getByText("Rate")).toBeTruthy();
  expect(screen.getByLabelText("Rate")).toBeTruthy();
  expect(screen.getByText("Submit")).toBeTruthy();
});

test("Check entering a value in the Name field", async () => {
  render(YourComponent, {
    props: {
      title: "Test Title",
      btnText: "Submit",
      clients: [{ id: 1, name: "Client 1" }],
      withStatus: false,
      v$: {},
      defaultProject: {},
      handleSubmit: () => {},
      isLoading: false,
    },
  });

  const nameInput = screen.getByLabelText("Name");

  await fireEvent.update(nameInput, "Test Project");

  expect(nameInput.value).toBe("Test Project");
});
