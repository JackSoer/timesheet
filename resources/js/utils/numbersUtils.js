export function isNumberInRange(input, max, min) {
  input = input.trim();

  const regex = /^-?\d+(\.\d{1,2})?$/;

  return (
    regex.test(input) && parseFloat(input) >= min && parseFloat(input) <= max
  );
}

export function intToDecimal(number) {
  if (!number) {
    return number;
  }

  const cleanValue = number.replace(/[^\d.]/g, "");

  const [dollars, cents] = cleanValue.split(".");

  const trimmedDollars = dollars.slice(0, 5);

  const trimmedCents = cents ? cents.slice(0, 2) : "";

  const paddedCents = trimmedCents.padEnd(2, "0");

  const formattedValue = `${trimmedDollars}${
    paddedCents ? `.${paddedCents}` : ""
  }`;

  return parseFloat(formattedValue).toFixed(2);
}

export function formatNumber(number) {
  if (number === "") {
    return number;
  }

  const parsedNumber = parseFloat(number);
  return parsedNumber % 1 === 0
    ? parsedNumber.toString()
    : parsedNumber.toFixed(2);
}
