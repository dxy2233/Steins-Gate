# 圣经记录

## 关联函数

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

## 所有权

### 所有权规则

- 每一个值都有一个所有者(owner)
- 值在任一时刻有且只有一个所有者
- 当所有者(变量)离开作用域，这个值将被丢弃

```rust
  let s1 = String::from("hello");
  let s2 = s1;
  println!("{s1}, world!");
```

## 常见概念

### 常量

```rust
const THREE_HOURS_IN_SECONED: u32 = 60 * 60 *3;
```

常量用const声明，且永远不可变，命名全大写

### 隐藏

rust允许用一个新值来隐藏之前一个同名的值，这个功能常用在需要转换值类型之类的场景

### 标量

整型、浮点、布尔、字符

整型

| 长度    | 有符号 | 无符号 |
| ------- | ------ | ------ |
| 8-bit   | i8     | u8     |
| 16-bit  | i16    | u16    |
| 32-bit  | i32    | u32    |
| 64-bit  | i64    | u64    |
| 128-bit | i128   | u128   |
| arch    | isize  | usize  |

浮点
f32和f64，默认f64

布尔
ture false

字符

```rust
fn main() {
    let c = 'z';
    let z: char = 'ℤ'; // with explicit type annotation
    let heart_eyed_cat = '😻';
}
```

单引号声明，四个字节，代表一个Unicode标量值

### 复合类型

元组、数组

### 函数

```rust
fn main() {
  println!("Hello, world!");

  another_function();
}

fn another_function(x: i32) {
  println!("Another function. {x}");
}

fn rrreturn_one_num() -> i32 {
  5
}
```

- main函数，很多程序的入口点
- 函数和变量名风格使用snake case规范
- 必须声明参数的类型
- 返回值跟在->后面，需要声明类型

### 表达式

```rust
fn main() {
    let y = {
        let x = 3;
        x + 1
    };

    println!("The value of y is: {y}");
}
```

- 语句是执行一些操作但不返回值的指令
- 表达式计算并产生一个值

### 控制流

if

```rust
fn main() {
    let number = 3;
    if number < 5 {
        println!("condition was true");
    } else if number < 3 {
        println!("else if");
    } else {
        println!("condition was false");
    }
}
```

loop

```rust
fn main() {
  loop {
    println!("again!");
  }
}

// break停止循环
fn main() {
  let mut counter = 0;
  let result = loop {
    counter += 1;
    if couinter == 10 {
      break counter * 2;
    }
  };
  println!("The result is {result}");
}

fn main() {
  let mut count = 0;
  'counting_up: loop {
    println!("count = {count}");
    let mut remaining = 10;

    loop {
      println!("remaining = {remaining}");
      if remaining == 9 {
        break;
      }
      if count == 2 {
        break 'counting_up;
      }
      remaining -= 1;
    }

    count += 1;
  }
  println!("End count = {count}");
}
```

while

```rust
fn main() {
    let mut number = 3;

    while number != 0 {
        println!("{number}!");

        number -= 1;
    }

    println!("LIFTOFF!!!");
}
```

for

```rust
fn main() {
    let a = [10, 20, 30, 40, 50];

    for element in a {
        println!("the value is: {element}");
    }
}

fn main() {
    for number in (1..4).rev() {
        println!("{number}!");
    }
    println!("LIFTOFF!!!");
}
```
