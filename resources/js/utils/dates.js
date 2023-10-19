import { addDays, endOfMonth, format, startOfMonth } from "date-fns";

export const getArrayOfAllDatesInMonth = (month) => {
  const firstDayOfMonth = startOfMonth(month);
  const lastDayOfMonth = endOfMonth(month);

  const allDatesInMonth = [];

  let date = firstDayOfMonth;

  while (date <= lastDayOfMonth) {
    allDatesInMonth.push(format(date, "yyyy-MM-dd"));
    date = addDays(date, 1);
  }

  return allDatesInMonth;
};
