// (min,max)
const randomNone = (min, max) => {
  return min + Math.ceil(Math.random() * (max - min - 1))
}
// [min,max)
const randomMin = (min, max) => {
  return min + Math.floor(Math.random() * (max - min))
}
// (min,max]
const randomMax = (min, max) => {
  return min + Math.ceil(Math.random() * (max - min))
}
// [min,max]
const randomAll = (min, max) => {
  return min + Math.floor(Math.random() * (max - min + 1))
}

// 四舍五入
const round = (n, decimals = 0) =>
  Number(`${Math.round(`${n}e${decimals}`)}e-${decimals}`)
