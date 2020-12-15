# 目录结构推荐

## 目录结构
一定使用go mod创建项目
[参考](https://github.com/golang-standards/project-layout/blob/master/README_zh.md)

## Go目录
### /cmd
项目主干，每个应用程序的目录名应该与你想要的可执行文件的名称相匹配(例如，/cmd/myapp)。

通常有一个小的 main 函数，从 /internal 和 /pkg 目录导入和调用代码，除此之外没有别的东西。

### /internal
私有应用程序和库代码。这是你不希望其他人在其应用程序或库中导入代码。请注意，这个布局模式是由 Go 编译器本身执行的。有关更多细节，请参阅Go 1.4 release notes 。注意，你并不局限于顶级 internal 目录。在项目树的任何级别上都可以有多个内部目录。

### /pkg
外部应用程序可以使用的库代码(例如 /pkg/mypubliclib)。

### /vendor
应用程序依赖项(手动管理或使用你喜欢的依赖项管理工具，如新的内置 Go Modules 功能)。go mod vendor 命令将为你创建 /vendor 目录。请注意，如果未使用默认情况下处于启用状态的 Go 1.14，则可能需要在 go build 命令中添加 -mod=vendor 标志。

如果你正在构建一个库，那么不要提交你的应用程序依赖项。

## 服用应用程序目录
### /api
OpenAPI/Swagger 规范，JSON 模式文件，协议定义文件。

## web应用程序目录
### /web
特定于 Web 应用程序的组件:静态 Web 资产、服务器端模板和 SPAs。

## 通用应用目录
### /configs
配置文件模板或默认配置。

将你的 confd 或 consul-template 模板文件放在这里。

### /init
System init（systemd，upstart，sysv）和 process manager/supervisor（runit，supervisor）配置。

### /scripts
执行各种构建、安装、分析等操作的脚本。

### /build
打包和持续集成。

将你的云( AMI )、容器( Docker )、操作系统( deb、rpm、pkg )包配置和脚本放在 /build/package 目录下。

将你的 CI (travis、circle、drone)配置和脚本放在 /build/ci 目录中。请注意，有些 CI 工具(例如 Travis CI)对配置文件的位置非常挑剔。尝试将配置文件放在 /build/ci 目录中，将它们链接到 CI 工具期望它们的位置(如果可能的话)。

### /deployments
IaaS、PaaS、系统和容器编配部署配置和模板(docker-compose、kubernetes/helm、mesos、terraform、bosh)。注意，在一些存储库中(特别是使用 kubernetes 部署的应用程序)，这个目录被称为 /deploy。

### /test
额外的外部测试应用程序和测试数据。你可以随时根据需求构造 /test 目录。对于较大的项目，有一个数据子目录是有意义的。例如，你可以使用 /test/data 或 /test/testdata (如果你需要忽略目录中的内容)。请注意，Go 还会忽略以“.”或“_”开头的目录或文件，因此在如何命名测试数据目录方面有更大的灵活性。

## 其它目录
### /docs
设计和用户文档(除了 godoc 生成的文档之外)。

### /tools
这个项目的支持工具。注意，这些工具可以从 /pkg 和 /internal 目录导入代码。

### /examples
你的应用程序和/或公共库的示例。

### /third_party
外部辅助工具，分叉代码和其他第三方工具(例如 Swagger UI)。

### /assets
与存储库一起使用的其他资产(图像、徽标等)。

### /website
如果你不使用 Github 页面，则在这里放置项目的网站数据。