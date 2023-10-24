import { render, fireEvent } from "@testing-library/vue";
import PrimaryForm from "./PrimaryForm.vue";

test("Render component without title and without slot content", async () => {
  const { container } = render(PrimaryForm);
  expect(container).toBeDefined();
  expect(container.querySelector(".primary-form__title")).toBeNull();
  expect(container.querySelector(".primary-form__box")).toBeNull();
});

test("Render component with title", async () => {
  const title = "Test Title";
  const { getByText } = render(PrimaryForm, {
    props: { title },
  });

  const titleElement = getByText(title);
  expect(titleElement).toBeTruthy();
});

test("Render component with slot content", async () => {
  const { container } = render(PrimaryForm, {
    slots: {
      default: "Slot Content",
    },
  });

  expect(container.textContent).toContain("Slot Content");
});

test("Render component with title and with slot content", async () => {
  const title = "Test Title";
  const { getByText } = render(PrimaryForm, {
    props: { title },
    slots: {
      default: "Slot Content",
    },
  });

  const titleElement = getByText(title);

  expect(titleElement).toBeTruthy();
  expect(getByText("Slot Content")).toBeTruthy();
});

test("Check handleSubmit function is called on form submit", async () => {
  const handleSubmit = jest.fn();
  const { getByTestId } = render(PrimaryForm, {
    props: { handleSubmit },
  });

  const form = getByTestId("primary-form");
  await fireEvent.submit(form);
  expect(handleSubmit).toHaveBeenCalled();
});
