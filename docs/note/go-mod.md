# go包管理

## 代理
参考文档 [goproxy.io](https://goproxy.io/zh/)

## go mod命令
| 命令 | 说明 |
| ---- | ---- |
| download | download modules to local cache(下载依赖包) |
| edit | edit go.mod from tools or scripts（编辑go.mod) |
| graph | print module requirement graph (打印模块依赖图)  |
| init | initialize new module in current directory（在当前目录初始化mod） |
| tidy | add missing and remove unused modules(拉取缺少的模块，移除不用的模块) |
| vendor | make vendored copy of dependencies(将依赖复制到vendor下) |
| verify | verify dependencies have expected content (验证依赖是否正确） |
| why | explain why packages or modules are needed(解释为什么需要依赖) |

## go get升级
- 运行 go get -u 将会升级到最新的次要版本或者修订版本(x.y.z, z是修订版本号， y是次要版本号)
- 运行 go get -u=patch 将会升级到最新的修订版本
- 运行 go get package@version 将会升级到指定的版本号version
- 运行go get如果有版本的更改，那么go.mod文件也会更改