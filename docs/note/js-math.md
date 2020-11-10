# math相关

## 区间随机数
```js
// (min,max)
const randomNone = (min, max) =>
  min + Math.ceil(Math.random() * (max - min - 1))
// [min,max)
const randomMin = (min, max) =>
  min + Math.floor(Math.random() * (max - min))
// (min,max]
const randomMax = (min, max) =>
  min + Math.ceil(Math.random() * (max - min))
// [min,max]
const randomAll = (min, max) =>
  min + Math.floor(Math.random() * (max - min + 1))
```

## 四舍五入
```js
const round = (n, decimals = 0) =>
  Number(`${Math.round(`${n}e${decimals}`)}e-${decimals}`)
```
