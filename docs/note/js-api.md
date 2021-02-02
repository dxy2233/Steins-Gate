# API参考

## 随机值(符合密码学要求的安全的)
window.crypto.getRandomValues()

``` js
var array = new Uint32Array(10);
window.crypto.getRandomValues(array);
console.log("Your lucky numbers:");
for (var i = 0; i < array.length; i++) {
    console.log(array[i]);
}
```