# 圣经记录

## 结构体struct

### 基础定义

```rust
// 定义结构体
struct User {
    active: bool,
    username: String,
    email: String,
    sign_in_count: u64,
}

// 元组结构体
struct Color(i32, i32, i32);

// 类单元结构体
struct AlwaysEqual;

fn main() {
  // 实例化
  let user1 = User {
    active: true,
    username: String::from("someusername123"),
    email: String::from("someone@example.com"),
    sign_in_count: 1,
  };

  // 和js类似的叠加语法
  // 此赋值和`=`赋值一样，会移动数据，所以该例中，user1不再有效，但如果所有移动元素都实现了`Copy trait`,移动后同样有效
  let user2 = User {
    email: String::from("another@example.com"),
    ..user1
  };

  let black = Color(0, 0, 0);

  let subject = AlwaysEqual;
}

// 和js一样简写
fn build_user(email: String, username: String) -> User {
    User {
        active: true,
        username,
        email,
        sign_in_count: 1,
    }
}
```

赋予数据更多意义

```rust
// 打印调试结构体，必须显式选择这个功能
// 派生trait Debug
#[derive(Debug)]

struct Rectangle {
  width: u32,
  height: u32,
}
fn main() {
  let rect1 = Rectangle {
    width: 30,
    height: 50,
  };
  println!(
    "The area of the rectangle is {area(&rect1)} square pixels."
  );
  println!("{rect1:?}");
  println!("{rect1:#?}");

  // dbg会打印到标准输出控制台流stdout，dbg!宏可以接收一个表达式的所有权，println!只能接收引用
  dbg!(&rect1);
}
fn area(rectangle: &Rectangle) -> u32 {
  rectangle.width * rectangle.height
}
```

### 方法method

与普通函数类似，但它是在结构体的上下文中被定义，低一个参数总是self

```rust
#[derive(Debug)]
struct Rectangle {
    width: u32,
    height: u32,
}

// impl是implementation的缩写
impl Rectangle {
    fn area(&self) -> u32 {
        self.width * self.height
    }
}

fn main() {
    let rect1 = Rectangle {
        width: 30,
        height: 50,
    };

    println!(
        "The area of the rectangle is {} square pixels.",
        rect1.area()
    );
}
```

### 关联函数

- 所有在`impl`块中的函数都是关联函数
- 不以`self`为第一参数的关联函数不是方法，常被用作返回一个结构体新实例的构造函数
- 每个结构体都可以有多个`impl`块，和写在一个块中是等效的

```rust
let mut guess = String::new();
```

:: 语法表明 new 是 String 类型的一个 关联函数

## 枚举 enum

### 定义枚举

```rust
enum IpAddrKind {
  V4,
  V6,
}
enum IpAddr{
  V4(String),
  V6(String),
}
impl IpAddr {
  fn call(&self) {
    // 和结构体一样可以定义方法
  }
}

fn main() {
  // 最简单定义
  let four = IpAddrKind::V4;
  let six = IpAddrKind::V6;

  // 初始化数据
  let hoem = IpAddr::V4(String::from("127.0.0.1"));
  let loopback = IpAddr::V6(String::from("::1"));
}
```

### Option

- `Option`是标准库定义的一个枚举，不需要引入就可以使用
- 它表示一个值要么有值要么没值
- Rust中并没有`null`

```rust
enum Option<T> {
  None,
  Some(T),
}

let some_number = Some(5);
let some_char = Some('e');
let absent_number: Option<i32> = None; // 没有具体值时需要指定类型
```

### match

```rust
enum Coin {
    Penny,
    Nickel,
    Dime,
    Quarter,
}

fn value_in_cents(coin: Coin) -> u8 {
    match coin {
        Coin::Penny => 1,
        Coin::Nickel => 5,
        Coin::Dime => 10,
        Coin::Quarter => 25,
    }
}

// match匹配必须是穷尽的
let dice_roll = 9;
match dice_roll {
    3 => add_fancy_hat(),
    7 => remove_fancy_hat(),
    other => move_player(other),
    _ => reroll(), // 不使用other的情况
}
```

### if let

- 比math简洁的控制流

```rust
let config_max = Some(3u8);
if let Some(max) = config_max {
  println!("The maximum is configured to be {max}");
}
```

## 集合

### Vector

- 单独的数据结构中存储多于一个的值
- 在内存中彼此相邻地排列所有值
- 只能存储相同类型的值

```rust
// 空值的时候需要指定类型
let v: Vec<i32> = Vec::new();

let v = vec![1, 2, 3];

// 更新
let mut v = Vec::new();
v.push(5);

// 读取
let v = vec![1, 2, 3, 4, 5];
let third: &i32 = &v[2];
let third: Option<&i32> = v.get(2);

// 遍历
let mut v = vec![100, 32, 57];
for i in &mut v {
  *i += 50;
}

// 变相存储不同类型数据
enum SpreadsheetCell {
    Int(i32),
    Float(f64),
    Text(String),
}

let row = vec![
    SpreadsheetCell::Int(3),
    SpreadsheetCell::Text(String::from("blue")),
    SpreadsheetCell::Float(10.12),
];

```

### String

- `String`是一个`Vec<u8>`的封装
- Unicode的标量值可能不止一个字节，所以不能使用索引取值

操作字符串最好的方法是明确表示需要字符还是字节

```rust
for c in "Зд".chars() {
    println!("{c}");
}
for b in "Зд".bytes() {
    println!("{b}");
}
```

### HashMap

```rust
// 需要主动引入
use std::collections::HashMap;

let mut scores = HashMap::new();

scores.insert(String::from("Blue"), 10);
scores.insert(String::from("Yellow"), 50);

let score = scores.get("Blue").copied().unwrap_or(0);

```

## trait

- 定义共同行为

### 基础概念

```rust
// Rng 是一个trait
use rand::Rng;
```

```rust
// 定义一个Summary的trait
pub trait Summary {
    fn summarize(&self) -> String;
}

// 为NewsArticle和Tweet实现Summary特性
pub struct NewsArticle {
    pub headline: String,
    pub location: String,
    pub author: String,
    pub content: String,
}

impl Summary for NewsArticle {
    fn summarize(&self) -> String {
        format!("{}, by {} ({})", self.headline, self.author, self.location)
    }
}

pub struct Tweet {
    pub username: String,
    pub content: String,
    pub reply: bool,
    pub retweet: bool,
}

impl Summary for Tweet {
    fn summarize(&self) -> String {
        format!("{}: {}", self.username, self.content)
    }
}

// 默认实现
impl Summary for NewsArticle {}

// 默认实现可以和具体定义组合调用
pub trait Summary {
    fn summarize_author(&self) -> String;

    fn summarize(&self) -> String {
        format!("(Read more from {}...)", self.summarize_author())
    }
}
impl Summary for Tweet {
    fn summarize_author(&self) -> String {
        format!("@{}", self.username)
    }
}

```

### 作为参数

- notift函数体中，可以调用任何来自summary的trait的方法
- `impl Trait`实际上是`trait bound`的语法糖

```rust
pub fn notify(item: &impl Summary) {
    println!("Breaking news! {}", item.summarize());
}

```

### trait bound和where

```rust
pub fn notify<T: Summary>(item: &T) {
    println!("Breaking news! {}", item.summarize());
}

fn some_function<T, U>(t: &T, u: &U) -> i32
where
    T: Display + Clone,
    U: Clone + Debug,
{

```

### 返回实现了trait的类型

```rust
fn returns_summarizable() -> impl Summary {
    Tweet {
        username: String::from("horse_ebooks"),
        content: String::from(
            "of course, as you probably already know, people",
        ),
        reply: false,
        retweet: false,
    }
}
```

### 使用`trait bound`有条件的实现方法

```rust
use std::fmt::Display;

struct Pair<T> {
    x: T,
    y: T,
}

impl<T> Pair<T> {
    fn new(x: T, y: T) -> Self {
        Self { x, y }
    }
}

impl<T: Display + PartialOrd> Pair<T> {
    fn cmp_display(&self) {
        if self.x >= self.y {
            println!("The largest member is x = {}", self.x);
        } else {
            println!("The largest member is y = {}", self.y);
        }
    }
}

```

## 错误处理

- Rust将错误分为两大类：可恢复的(recoverable)和不可恢复的(unrecoverable)

### `panic!`

- 用`panic!`处理不可恢复的错误

错误时由展开切换为终止，二进制文件也会小一点

```toml
[profile.release]
panic = 'abort'
```

### Result

- 用`Result`处理可恢复错误
- `Result`是一种枚举类型，包含Ok和Err；实例拥有`expect`方法，Err会导致程序崩溃并显示传递的参数
- `unwarap`，出错时调用`panic!`
- `expect`，出错时调用`pacic!`但可以自己定义文本
- `?`，如果`Result`是`Ok`，则返回`Ok`中的值继续执行；如果是`Err`，`Err`将作为整个函数的返回值；所以只能在返回值为`Result`或`Option`的函数中使用

```rust
enum Result<T, E> {
  Ok(T),
  Err(E),
}

use std::{fs::File, io::ErrorKind};

fn main() {
    let gretting_file_result = File::open("hello.txt");

    let greeting_file = match gretting_file_result {
        Ok(file) => file,
        Err(error) => match error.kind() {
            ErrorKind::NotFound => match File::create("hello.txt") {
                Ok(fc) => fc,
                Err(e) => panic!("{e:?}"),
            },
            other_error => {
                panic!("{other_error:?}");
            }
        },
    };
}

// ?
fn read_username_from_file() -> Result<String, io::Error> {
    let mut username = String::new();
    let mut username_file = File::open("hello.txt")?.read_to_string(&mut username)?;
    Ok(username)
}
```

## 泛型

基础使用

```rust
fn main() {
    let number_list = vec![34, 50, 25, 100, 65];
    let res = largest(&number_list);
    println!("The largest number is {res}");

    let char_list = vec!['y', 'm', 'a', 'q'];
    let res_char = largest(&char_list);
    println!("The largest number is {res_char}");
}

fn largest<T: PartialOrd>(list: &[T]) -> &T {
    let mut largest = &list[0];

    for number in list {
        if number > largest {
            largest = number;
        }
    }

    largest
}
```

结构体定义不同类型

```rust
struct Point<T, U> {
  x: T,
  y: U,
}
```

区分不同的参数

```rust
struct Point<X1, Y1> {
    x: X1,
    y: Y1,
}

impl<X1, Y1> Point<X1, Y1> {
    fn mixup<X2, Y2>(self, other: Point<X2, Y2>) -> Point<X1, Y2> {
        Point {
            x: self.x,
            y: other.y,
        }
    }
}

fn main() {
    let p1 = Point { x: 5, y: 10.4 };
    let p2 = Point { x: "Hello", y: 'c' };

    let p3 = p1.mixup(p2);

    println!("p3.x = {}, p3.y = {}", p3.x, p3.y);
}
```

## 生命周期

- 生命周期确保结构体引用的数据有效性跟结构体本身保持一致

## 所有权

### 所有权规则

- 每一个值都有一个所有者(owner)
- 值在任一时刻有且只有一个所有者
- 当所有者(变量)离开作用域，这个值将被丢弃

将值传递给函数，也同样适用该规则

```rust
  let s1 = String::from("hello");
  let s2 = s1;
  println!("{s1}, world!");
  // js中是浅拷贝，s1、s2同时有效
  // rust中则是所有权移动(move)到了s2，s1则不再有效
```

```rust
  let s1 = String::from("hello");
  let s2 = s1.clone();
  println!("s1 = {s1}, s2 = {s2}");
  // 深拷贝可以使用通用函数clone
```

### 引用

不可变引用

```rust
fn main() {
    let s1 = String::from("hello");
    let len = calculate_length(&s1);
    println!("The length of '{s1}' is {len}.");
}
fn calculate_length(s: &String) -> usize {
    s.len()
}
```

可变引用

- 同作用域，有一个可变引用就不能有其它引用

```rust
fn main() {
    let mut s = String::from("hello");
    change(&mut s);
}
fn change(some_string: &mut String) {
    some_string.push_str(", world");
}
```

### slice

`slice`允许你引用集合中一段连续的元素序列，而不用引用整个集合。slice 是一种引用，所以它没有所有权

字符串slice

```rust
  let s = String::from("hello world");
  let hello = &s[0..5];
  let world = &s[6..11];
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

## 项目组织

### Crate

- Crate有两种形式：二进制项(src/main.rs)和库(src/lib.rs)

### 模块

- `mod` 声明模块
- `pub` 公有；结构体公有，不代表属性公有；枚举公有则完全公有
- `use` 引用
- `super` 类似..的语法，引用到父模块
- `as` 类似js提供新的命名空间
- `pub use` 重导出，允许别人导出这个引用
- 模块树和文件树结构基本一致

```rust
// src/main.rs
use crate::garden::vegetables::Asparagus;

pub mod garden;

fn main() {
    let plant = Asparagus {};
    println!("I'm growing {plant:?}!");
}

// src/garden.rs
pub mod vegetables;
```

```rust
// 模块公私有
mod front_of_house {
    pub mod hosting {
        pub fn add_to_waitlist() {}
    }
}

pub fn eat_at_restaurant() {
    // 绝对路径
    crate::front_of_house::hosting::add_to_waitlist();

    // 相对路径
    front_of_house::hosting::add_to_waitlist();
}
```

```rust
// use的嵌套路径
use std::cmp::Ordering;
use std::io;

use std::{cmp::Ordering, io};

use std::io;
use std::io:Write;

use std::{self, Write};

// global
use std::collections::*;
```
