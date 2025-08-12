
# Introduction to PHP Basics

## 🟢 What is PHP?

- **PHP** stands for **Hypertext Preprocessor**
- It is a popular **server-side scripting language** used to create **dynamic web pages**
- PHP code is executed on the server and the result is sent to the browser as plain HTML

### Example:
```php
<?php
  echo "Hello, World!";
?>
```

---

## 🟡 1. Variables in PHP

### What is a Variable?

- A **variable** is a container used to store information
- In PHP, variables **start with a `$` sign**

### Rules for PHP Variables:

- Must start with **`$`** followed by the variable name
- Variable names must start with a **letter or underscore (`_`)**
- Variable names are **case-sensitive**

### Example:
```php
<?php
  $name = "Alice";
  $age = 25;
  echo "Name: $name, Age: $age";
?>
```

---

## 🟠 2. Data Types in PHP

PHP is a **loosely typed language** – you don’t need to declare the data type explicitly.

### Main Data Types:

| Type        | Example                        |
|-------------|--------------------------------|
| **String**  | `"Hello, World!"`              |
| **Integer** | `123`, `-100`                  |
| **Float**   | `3.14`, `-2.5`                 |
| **Boolean** | `true`, `false`                |
| **Array**   | `[1, 2, 3]`, `["a", "b", "c"]` |
| **Object**  | An instance of a class         |
| **NULL**    | A variable with no value       |

### Examples:
```php
<?php
  $text = "PHP is fun";       // String
  $number = 2025;             // Integer
  $price = 99.99;             // Float
  $isActive = true;           // Boolean
  $colors = ["red", "blue"];  // Array
  $nothing = NULL;            // Null
?>
```

---

## 🔵 3. Operators in PHP

### Arithmetic Operators

Used for mathematical operations.

| Operator | Name           | Example (`$a = 5`, `$b = 2`) | Result |
|----------|----------------|------------------------------|--------|
| `+`      | Addition        | `$a + $b`                    | `7`    |
| `-`      | Subtraction     | `$a - $b`                    | `3`    |
| `*`      | Multiplication  | `$a * $b`                    | `10`   |
| `/`      | Division        | `$a / $b`                    | `2.5`  |
| `%`      | Modulus         | `$a % $b`                    | `1`    |

### Assignment Operators

Used to assign values to variables.

| Operator | Example     | Same As         |
|----------|-------------|-----------------|
| `=`      | `$x = 10`   | Assign 10       |
| `+=`     | `$x += 5`   | `$x = $x + 5`   |
| `-=`     | `$x -= 5`   | `$x = $x - 5`   |

### Comparison Operators

Used to compare values.

| Operator | Description               | Example (`$a = 5`, `$b = "5"`) | Result |
|----------|---------------------------|-------------------------------|--------|
| `==`     | Equal (value only)        | `$a == $b`                    | `true` |
| `===`    | Identical (value + type)  | `$a === $b`                   | `false`|
| `!=`     | Not equal                 | `$a != $b`                    | `false`|
| `>`      | Greater than              | `$a > 3`                      | `true` |
| `<`      | Less than                 | `$a < 10`                     | `true` |

### Logical Operators

Used for combining conditions.

| Operator | Name     | Example                   |
|----------|----------|---------------------------|
| `&&`     | AND      | `($a > 0 && $a < 10)`     |
| `||`     | OR       | `($a > 10 || $b < 5)`     |
| `!`      | NOT      | `!($a == 5)`              |

---

## 🟣 Quick Practice

```php
<?php
  $a = 10;
  $b = 3;

  echo $a + $b;        // 13
  echo $a % $b;        // 1
  echo $a == "10";     // true
  echo $a === "10";    // false
?>
```

---

## ✅ Summary

- Use `$` to declare variables
- PHP supports multiple data types
- Operators help perform calculations and logic
- Use `echo` or `print` to display output
