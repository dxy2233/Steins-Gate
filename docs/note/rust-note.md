# 圣经记录

## 2.猜数字

### 变量

```rust
let apples = 5; (不可变)
let mut apples = 5; (可变)
```

### 变量引用

```rust
&mut apples
```

### 关联函数

```rust
let str = String::new();
```

associated function, 类似静态方法(static method)
针对类型实现的函数

### Resule,expect

Resule,拥有Ok或Err成员的枚举
expect,一个方法，会导致程序崩溃，并显示当做参数传递的信息

### trait

```rust
use rand::Rng;
```

Rng就是一个trait

### ordering

一个枚举，成员有Less, Greater, Equal
比较俩个值可能出现的三种结果

### cmp

一个方法，用来比较两个值并可以在任何可比较的值上调用

### match

match是rust中最强大的表达式
由分支(arms)构成，一个分支包含一个模式(pattern)和表达式开头的值与分支模式相匹配时应该执行的代码

### 直接创建新的guess变量

用一个新值来隐藏(shadowing)之前的值
常用再需要转换值类型的场景

## 3.常见编程概念

### 标量

- 整形
- 浮点
- 布尔
- 字符(双引号是字符串,单引号是字符)

### 复合类型

- 元组
- 数组
- vector(类数组的集合类型)

### 函数

- 关键字 fn
- snake case规范风格
- 返回值需要 -> 指定返回类型

### 语句、表达式

语句以;号结尾，没有返回值
表达式没有;且有返回值
函数调用是一个表达式，宏调用是一个表达式，大括号创建的新作用域也是表达式

### 注释

基本和js一样

### 控制流

- if判断不用写括号
- 循环有3种，loop、while、for
- loop可以指定名称，并用break指定终止具名loop
- for in循环数组

```rust
'test_name: loop {
  break 'test_name
}
```
