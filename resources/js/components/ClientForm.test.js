import { render, fireEvent } from "@testing-library/vue";
import ClientForm from "./ClientForm.vue";
import { VueToggles } from "vue-toggles";

test("Renders the form with initial values", async () => {
  const { getByText, getByPlaceholderText } = render(ClientForm, {
    props: {
      defaultClient: {
        name: "Jack",
        rate: "1.00",
      },
      title: "Your Title",
      btnText: "Submit",
      isLoading: false,
      withStatus: true,
    },
  });

  const nameLabel = getByText("Name");
  const rateLabel = getByText("Rate");
  const nameInput = getByPlaceholderText("Jack");
  const rateInput = getByPlaceholderText("1.00");

  expect(nameLabel).toBeTruthy();
  expect(rateLabel).toBeTruthy();
  expect(nameInput.value).toBe("Jack");
  expect(rateInput.value).toBe("1.00");
});

test("Calls handleSubmit when form is submitted", async () => {
  const handleSubmit = jest.fn();
  const { getByText } = render(ClientForm, {
    props: {
      handleSubmit,
      defaultClient: {
        name: "Jack",
        rate: "1.00",
      },
    },
  });

  const submitButton = getByText("Submit");
  await fireEvent.click(submitButton);

  expect(handleSubmit).toHaveBeenCalled();
});
