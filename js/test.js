// (min,max)
function randomNone(min, max) {
  return min + Math.ceil(Math.random() * (max - min - 1))
}
// [min,max)
function randomMin(min, max) {
  return min + Math.floor(Math.random() * (max - min))
}
// (min,max]
function randomMax(min, max) {
  return min + Math.ceil(Math.random() * (max - min))
}
// [min,max]
function randomAll(min, max) {
  return min + Math.floor(Math.random() * (max - min + 1))
}

const round = (n, decimals = 0) =>
  Number(`${Math.round(`${n}e${decimals}`)}e-${decimals}`)

console.log(round(0.3555, 2))
