# 圣经记录

## 关联函数

1.

```rust
let mut guess = String::new();
```

:: 语法表明 new 是 String 类型的一个 关联函数

## trait

```rust
use rand::Rng;
```

Rng 是一个trait

## 错误处理

1. Result 是一种枚举类型，包含Ok和Err
   Result的实例拥有expect方法，Err会导致程序崩溃并显示传递的参数

## 隐藏

rust允许用一个新值来隐藏之前一个同名的值，这个功能常用在需要转换值类型之类的场景

## 常见概念

# 常量

```rust
const THREE_HOURS_IN_SECONED: u32 = 60 * 60 *3;
```

常量用const声明，且永远不可变，命名全大写
