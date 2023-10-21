export function isNumberInRange(input, max, min) {
  input = input.trim();

  const regex = /^-?\d+(\.\d{1,2})?$/;

  return (
    regex.test(input) && parseFloat(input) >= min && parseFloat(input) <= max
  );
}

export function intToDecimal(number) {
  const numericValue = parseFloat(number).toFixed(2);

  if (!isNaN(numericValue)) {
    return numericValue;
  } else {
    return number;
  }
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
