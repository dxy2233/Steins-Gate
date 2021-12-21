# Rust 入门笔记

## 安装

以 windows 为例，参考该[网页](https://www.rust-lang.org/zh-CN/learn/get-started)下载安装器，如果缺少 c++生成工具需要先安装

- `cargo --version` 检查是否安装成功
- `rustup update` 升级版本

## cargo

Rust 的构建工具和包管理器

- `cargo new <name>` 生成一个叫[name]的新目录初始化项目
- `cargo build` 构建项目
- `cargo run` 运行项目
- `cargo test` 测试项目
- `cargo doc` 构建文档
- `cargo publish` 将库发布到 crates.io
