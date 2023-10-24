import { render } from "@testing-library/vue";
import PrimaryTable from "./PrimaryTable.vue";

test("Render table without title and headers", async () => {
  const { container } = render(PrimaryTable, {
    props: { headers: [] },
  });

  const tableElement = container.querySelector(".primary-table");
  expect(tableElement).toBeTruthy();

  const titleElement = container.querySelector(".primary-table__title");
  expect(titleElement).toBeNull();

  const headerElements = container.querySelectorAll(
    ".primary-table__column-title"
  );
  expect(headerElements.length).toBe(0);
});

test("Render table with title and headers", async () => {
  const title = "Table Title";
  const headers = ["Header 1", "Header 2", "Header 3"];

  const { container, getByText } = render(PrimaryTable, {
    props: { title, headers },
  });

  const tableElement = container.querySelector(".primary-table");
  expect(tableElement).toBeTruthy();

  const titleElement = getByText(title);
  expect(titleElement).toBeTruthy();

  const headerElements = container.querySelectorAll(
    ".primary-table__column-title"
  );
  expect(headerElements.length).toBe(3);

  headers.forEach((headerText, index) => {
    const headerElement = getByText(headerText);
    expect(headerElement).toBeTruthy();
  });
});

test("Render table with double cell title", async () => {
  const headers = ["Header 1", "Header 2", "Header 3"];
  const doubleCell = { firstText: "First Text", secondText: "Second Text" };

  const { container, getByText } = render(PrimaryTable, {
    props: { headers, doubleCell },
  });

  const tableElement = container.querySelector(".primary-table");
  expect(tableElement).toBeTruthy();

  const headerElements = container.querySelectorAll(
    ".primary-table__column-title"
  );
  expect(headerElements.length).toBe(4);

  const firstTextElement = getByText(doubleCell.firstText);
  expect(firstTextElement).toBeTruthy();

  const secondTextElement = getByText(doubleCell.secondText);
  expect(secondTextElement).toBeTruthy();
});
