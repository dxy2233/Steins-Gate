# wasm

## build
将go文件编译成wasm文件可以使用两种方式
* 原生编译
```bash
// bash
GOOS=js GOARCH=wasm go build -o main.wasm

// windows cmd
set GOOS=js
set GOARCH=wasm
go build -o main.wasm

// windows powershell
$env:GOOS="js"
$env:GOARCH="wasm"
go build -o main.wasm
```

* tinygo编译(文件会比较小)
```bash
tinygo build -o main-tinygo.wasm
```

## 在浏览器中运行
运行build的文件之前需要先引入js胶水代码，不同的编译流程需用对应的胶水代码，不同的胶水代码会有差异
```bash
// 原生编译
cp "$(go env GOROOT)/misc/wasm/wasm_exec.js"

// tinygo编译
cp "$(tinygo env TINYGOROOT)/targets/wasm_exec.js" ./wasm_exec_tiny.js
```

html加载示例
```html
<!DOCTYPE html>
<html lang="en">
<head>
  <script src="./wasm_exec_tiny.js"></script> // 加载胶水代码
</head>
<body>
  <script>
    const go = new Go() // wasm_exec.js 中的定义
    WebAssembly.instantiateStreaming(fetch('./main-tiny.wasm'), go.importObject)
      .then(res => {
        go.run(res.instance) // 执行 go main 方法
      })
  </script>
</body>
</html>
```

## go中定义函数
函数必须满足固定的格式
```go
// this是js中的this
// args是在js中调用该函数的参数列表
// 返回值需用js.Valueof映射成js的值
func test (this js.Value, args []js.Value) interface{} {
  fmt.Println("test")
  return nil
}

func main () {
  done := make(chan int, 1) // 需创建信道阻塞主携程

	js.Global().Set("test", js.FuncOf(test)) // 定义函数

	<-done
}
```