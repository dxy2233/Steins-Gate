# rxjs相关

## 竞态问题
```js
const race = async ([text, time]) => {
    await sleep(time)
    return text
}
let runner
new Observable((subscriber) => (runner = subscriber))
    .pipe(switchMap((params) => race(params)))
    .subscribe((val) => {
        console.log(val)
    })

!(async () => {
    runner.next(['A', 800])
    // await sleep(1000)
    runner.next(['B', 1000])
})()
// 只返回B，A被取消了
```