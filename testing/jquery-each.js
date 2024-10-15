// ARRAYS
const arr = ['one', 'two', 'three', 'four', 'five'];

$.each(arr, function (index, value) {
  console.log(value);
  // Will stop running after "three"
  return value !== 'three';
});

// Outputs: one two three
