# 文件操作

## 递归文件夹
```js
const func = filePath => {
    fs.readdir(filePath, (err, list) => {
        list.forEach(item => {
            const itemPath = path.resolve(filePath, item)
            fs.stat(itemPath, (err, data) => {
                if (data.isFile()) console.log(itemPath)
                else uploadFile(itemPath)
            })
        })
    })
}
```