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
