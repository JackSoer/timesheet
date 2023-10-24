import { render, fireEvent } from "@testing-library/vue";
import PrimaryModal from "./PrimaryModal.vue";

test("Render modal when isOpen is true", async () => {
  const { queryByTestId, getByText } = render(PrimaryModal, {
    props: { isOpen: true },
    slots: { default: "Modal Content" },
  });

  const modal = queryByTestId("modal");
  expect(modal).toBeTruthy();

  const modalContent = getByText("Modal Content");
  expect(modalContent).toBeTruthy();
});

test("Do not render modal when isOpen is false", async () => {
  const { queryByTestId } = render(PrimaryModal, {
    props: { isOpen: false },
    slots: { default: "Modal Content" },
  });

  const modal = queryByTestId("modal");
  expect(modal).toBeNull();
});

test("Close modal when close button is clicked", async () => {
  const { getByText, emitted } = render(PrimaryModal, {
    props: { isOpen: true },
    slots: { default: "Modal Content" },
  });

  const closeButton = getByText("x");
  await fireEvent.click(closeButton);

  expect(emitted("update:isOpen")).toBeTruthy();
  expect(emitted("update:isOpen")[0][0]).toBe(false);
});
