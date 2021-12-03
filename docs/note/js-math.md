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

## 数字补零
```js
const padding = (num, length) => {
  //这里用slice和substr均可
  return (Array(length).join('0') + num).slice(-length)
}
```

## 判断是否为数字
```js
Number.isFinite(value)
```

## 唯一ID生成
* 可以使用[nanoid](https://github.com/ai/nanoid#readme)