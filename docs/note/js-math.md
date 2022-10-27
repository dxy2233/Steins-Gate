# math 相关

## 区间随机数

```js
// (min,max)
const randomNone = (min, max) =>
  min + Math.ceil(Math.random() * (max - min - 1));
// [min,max)
const randomMin = (min, max) => min + Math.floor(Math.random() * (max - min));
// (min,max]
const randomMax = (min, max) => min + Math.ceil(Math.random() * (max - min));
// [min,max]
const randomAll = (min, max) =>
  min + Math.floor(Math.random() * (max - min + 1));
```

## 四舍五入

```js
const round = (n, decimals = 0) =>
  Number(`${Math.round(`${n}e${decimals}`)}e-${decimals}`);
```

## 数字补零

```js
const padding = (num, length) => {
  //这里用slice和substr均可
  return (Array(length).join("0") + num).slice(-length);
};
```

## 判断是否为数字

```js
Number.isFinite(value);
```

## 唯一 ID 生成

- 可以使用[nanoid](https://github.com/ai/nanoid#readme)

## matrix 分解

```js
const test = (mat) => {
  var a = mat[0];
  var b = mat[1];
  var c = mat[2];
  var d = mat[3];
  var e = mat[4];
  var f = mat[5];

  var delta = a * d - b * c;

  let result = {
    translation: [e, f],
    rotation: 0,
    scale: [0, 0],
    skew: [0, 0],
  };

  if (a != 0 || b != 0) {
    var r = Math.sqrt(a * a + b * b);
    result.rotation = b > 0 ? Math.acos(a / r) : -Math.acos(a / r);
    result.scale = [r, delta / r];
    result.skew = [Math.atan((a * c + b * d) / (r * r)), 0];
  } else if (c != 0 || d != 0) {
    var s = Math.sqrt(c * c + d * d);
    result.rotation =
      Math.PI / 2 - (d > 0 ? Math.acos(-c / s) : -Math.acos(c / s));
    result.scale = [delta / s, s];
    result.skew = [0, Math.atan((a * c + b * d) / (s * s))];
  } else {
    // a = b = c = d = 0
  }

  return result;
};
```
