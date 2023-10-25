import { render, fireEvent } from "@testing-library/vue";
import DeveloperForm from "./DeveloperForm.vue";

test("Renders the form with initial values", async () => {
  const { getByText, getByPlaceholderText } = render(DeveloperForm, {
    props: {
      defaultDeveloper: {
        firstName: "Jack",
        lastName: "Snow",
        rate: "1.00",
        ratePercent: "100",
      },
      title: "Your Title",
      btnText: "Submit",
      isLoading: false,
      withStatus: true,
    },
  });

  const firstNameLabel = getByText("First name");
  const lastNameLabel = getByText("Last name");
  const rateLabel = getByText("Rate");
  const ratePercentLabel = getByText("Rate percent");
  const firstNameInput = getByPlaceholderText("Jack");
  const lastNameInput = getByPlaceholderText("Snow");
  const rateInput = getByPlaceholderText("1.00");
  const ratePercentInput = getByPlaceholderText("100");

  expect(firstNameLabel).toBeTruthy();
  expect(lastNameLabel).toBeTruthy();
  expect(rateLabel).toBeTruthy();
  expect(ratePercentLabel).toBeTruthy();
  expect(firstNameInput.value).toBe("Jack");
  expect(lastNameInput.value).toBe("Snow");
  expect(rateInput.value).toBe("1.00");
  expect(ratePercentInput.value).toBe("100");
});

test("Calls handleSubmit when form is submitted", async () => {
  const handleSubmit = jest.fn();
  const { getByText } = render(DeveloperForm, {
    props: {
      handleSubmit,
      defaultDeveloper: {
        firstName: "Jack",
        lastName: "Snow",
        rate: "1.00",
        ratePercent: "100",
      },
    },
  });

  const submitButton = getByText("Submit");
  await fireEvent.click(submitButton);

  expect(handleSubmit).toHaveBeenCalled();
});
