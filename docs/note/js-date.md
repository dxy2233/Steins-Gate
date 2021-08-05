# js日期相关

## utc日期转换
```js
// utc时间转换为xxxx年yy月mm日 aa：bb:cc
const utc = (utc) =>
    new Date(utc).toLocaleString('chinese', { hour12: false })
```