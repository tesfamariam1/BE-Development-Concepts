# Session 3: PHP Fundamentals II (OOP, File Handling, Database Intro)
**Duration:** 90 minutes  
**Target:** Beginner PHP Students

---

## 🎯 Session Overview
Today we'll explore three fundamental PHP concepts that will elevate your programming skills:
1. **Object-Oriented Programming (OOP)** - Writing cleaner, more organized code
2. **File Handling** - Reading from and writing to files
3. **Database Introduction** - Connecting PHP to databases

---

## 📋 Session Structure

### **Part 1: Object-Oriented Programming (OOP)**
### **Part 2: File Handling**
### **Part 3: Database Introduction**
### **Part 4: Hands-on Exercise**

---

# 🏗️ Part 1: Object-Oriented Programming (OOP)

## What is OOP?
OOP is a programming approach that organizes code into **classes** and **objects**. Think of it like blueprints and houses:
- **Class** = Blueprint (defines what a house should have)
- **Object** = Actual house (built from the blueprint)
- **Properties** = House features (color, size, rooms)
- **Methods** = Things you can do with the house (open door, turn on lights)

## Key OOP Concepts

### 1. Classes and Objects
```php
<?php
// Class definition (blueprint)
class Car {
    // Properties (characteristics)
    public $brand;
    public $color;
    public $speed = 0;
    
    // Methods (actions)
    public function accelerate($amount) {
        $this->speed += $amount;
        echo "Speed increased to {$this->speed} km/h\n";
    }
    
    public function brake() {
        $this->speed = 0;
        echo "Car stopped!\n";
    }
}

// Creating objects (actual cars)
$myCar = new Car();
$myCar->brand = "Toyota";
$myCar->color = "Red";
$myCar->accelerate(50);
?>
```

### 2. Constructor Method
You don't call it manually, it runs when you create an object
```php
<?php
class Student {
    public $name;
    public $age;
    public $grade;
    
    // CONSTRUCTOR - runs automatically when creating a new Student
    public function __construct($name, $age, $grade) {
        $this->name = $name;
        $this->age = $age;
        $this->grade = $grade;
        echo "New student {$name} enrolled!\n";
    }
    
    public function study($subject) {
        echo "{$this->name} is studying {$subject}\n";
    }
    
    public function getInfo() {
        return "Name: {$this->name}, Age: {$this->age}, Grade: {$this->grade}";
    }
}

// When you create a new pizza, constructor runs automatically
$student1 = new Student("Alice", 20, "A");
$student2 = new Student("Bob", 19, "B");

echo $student1->getInfo();
?>
```
### 3. The Four Pillars of OOP

#### **Encapsulation (Private/Protected)**: Bundling data and methods together, hiding internal details, **Keep Your Stuff Private**


**Real-World Analogy**
Think of your **smartphone:**
- You can use it (make calls, send texts)
- But you can't mess with the internal circuits
- The phone protects its internal parts from you

```php
class BankAccount {
    private $balance = 1000;        // PRIVATE - hidden from outside
    private $accountNumber = "123"; // PRIVATE - hidden from outside
    public $ownerName = "John";     // PUBLIC - anyone can see
    
    // PUBLIC method - safe way to access private data
    public function checkBalance() {
        return "Your balance is: $" . $this->balance;
    }
    
    // PUBLIC method - safe way to change private data
    public function deposit($amount) {
        if ($amount > 0) {  // Safety check!
            $this->balance += $amount;
            echo "Deposited $" . $amount;
        } else {
            echo "Invalid amount!";
        }
    }
}

$myAccount = new BankAccount();

// ✅ This works - using public methods
echo $myAccount->checkBalance();  // "Your balance is: $1000"
$myAccount->deposit(100);

// This would cause an ERROR - trying to access private data
// echo $myAccount->balance;  // Can't do this!
```
**Why Encapsulation?**

- **Safety:** Prevents accidental mistakes
- **Control:** You decide how data can be changed
- **Security:** Sensitive information stays protected

#### **Inheritance (Learning from Your Parents):** Creating new classes based on existing ones
**Real-World Analogy**
Just like you inherit traits from your parents:

- You have your mom's eyes
- You have your dad's height
- But you also have your own unique personality

```php
// PARENT CLASS - the "mom/dad"
class Animal {
    public $name;
    public $age;
    
    public function __construct($name, $age) {
        $this->name = $name;
        $this->age = $age;
    }
    
    // All animals can do this
    public function eat() {
        echo $this->name . " is eating.";
    }
    
    public function sleep() {
        echo $this->name . " is sleeping.";
    }
}

// CHILD CLASS - inherits from Animal
class Dog extends Animal {
    // Dogs get all Animal abilities PLUS their own
    public function bark() {
        echo $this->name . " says: Woof! Woof!";
    }
    
    public function wagTail() {
        echo $this->name . " is wagging tail happily!";
    }
}

// ANOTHER CHILD CLASS
class Cat extends Animal {
    // Cats get all Animal abilities PLUS their own
    public function meow() {
        echo $this->name . " says: Meow!";
    }
    
    public function purr() {
        echo $this->name . " is purring contentedly.";
    }
}

// Using inheritance
$myDog = new Dog("Buddy", 3);
$myCat = new Cat("Whiskers", 2);

// Dogs can do everything Animals can do:
$myDog->eat();    // Inherited from Animal
$myDog->sleep();  // Inherited from Animal

// PLUS their own special abilities:
$myDog->bark();     // Dog's own method
$myDog->wagTail();  // Dog's own method

// Same with cats:
$myCat->eat();   // Inherited from Animal  
$myCat->meow();  // Cat's own method

```
**Why Inheritance?**

- Reuse Code: Don't write the same thing twice
- Organization: Group similar things together
- Easy Updates: Change parent, all children get the update

#### **Polymorphism(Same Name, Different Actions):** Same method name, different implementations
**Real-World Analogy**
Think of the word "PLAY":

- Musicians play instruments 🎸
- Athletes play sports ⚽
- Kids play with toys 🧸
- Same word, different actions!

```php
// Different classes, same method name
class Dog {
    public function makeSound() {
        echo "Woof! Woof!";
    }
}

class Cat {
    public function makeSound() {
        echo "Meow!";
    }
}

class Cow {
    public function makeSound() {
        echo "Moo!";
    }
}

class Duck {
    public function makeSound() {
        echo "Quack!";
    }
}

// Same method name, different results!
$animals = [
    new Dog(),
    new Cat(), 
    new Cow(),
    new Duck()
];

// Call the same method on different objects
foreach ($animals as $animal) {
    $animal->makeSound();  // Each animal makes its own sound!
}
// Output: 
// "Woof! Woof!"
// "Meow!" 
// "Moo!"
// "Quack!"
```
**Why Polymorphism?**

- **Consistency:** Same method names across different classes
- **Flexibility:** Easy to add new types without changing existing code
- **Simplicity:** One interface, many implementations

#### **Abstraction(Hide the Complicated Stuff):** Hiding complex implementation details, showing only essential features
**Real-World Analogy**

When you drive a car:
- You use simple controls: steering wheel, pedals, gear shift
- You don't need to understand: engine mechanics, fuel injection, transmission
- The complexity is hidden from you!
```php
// Abstract class - like a template
abstract class Vehicle {
    protected $fuel;
    protected $speed = 0;
    
    // Concrete method - all vehicles have this
    public function addFuel($amount) {
        $this->fuel += $amount;
        echo "Added {$amount} units of fuel.";
    }
    
    // Abstract method - each vehicle must implement this differently
    abstract public function start();
    abstract public function accelerate();
}

// Car implements the abstract vehicle
class Car extends Vehicle {
    // Must implement abstract methods
    public function start() {
        echo "Turning key... Car engine started! 🚗";
    }
    
    public function accelerate() {
        $this->speed += 10;
        echo "Car accelerating... Speed: {$this->speed} mph";
    }
}

// Motorcycle implements the abstract vehicle
class Motorcycle extends Vehicle {
    // Must implement abstract methods
    public function start() {
        echo "Pressing button... Motorcycle started! 🏍️";
    }
    
    public function accelerate() {
        $this->speed += 15;  // Motorcycles accelerate faster!
        echo "Motorcycle accelerating... Speed: {$this->speed} mph";
    }
}

// Using abstraction
$myCar = new Car();
$myBike = new Motorcycle();

// Simple interface, complex implementation hidden
$myCar->start();        // Different starting process
$myCar->accelerate();   // Different acceleration

$myBike->start();       // Different starting process  
$myBike->accelerate();  // Different acceleration
```
**Why Abstraction?**
- **Simplicity:** Easy to use without knowing how it works
- **Focus:** You focus on WHAT to do, not HOW it's done
- **Maintainability:** Internal changes don't affect how you use it

# Benefits of OOP

- Organized Code - Everything related is grouped together
- Reusable - Write once, use many times
- Maintainable - Easier to update and fix
- Real-world Modeling - Code mirrors how we think about objects

# Why Use OOP?
Instead of writing scattered functions, OOP lets you model real-world entities (users, products, orders) as objects with their own properties and behaviors, making your code more intuitive and manageable.

## 🎯 **Mini Exercise:**
Create a `Book` class with properties: title, author, pages. Add methods to display book info and mark as read.

---

# 📁 Part 2: File Handling

## Why File Handling?
- Store data permanently
- Read configuration files
- Process uploaded files
- Create logs and reports

## Creating Sample File
```php
<?php
// Create a sample data file for demonstrations
$sampleData = "Welcome to PHP File Handling!
This is line 2.
This is line 3.
End of sample data.";

file_put_contents("sample.txt", $sampleData);
echo "Sample file created successfully!\n";
?>
```

## Reading Files

### 1. Reading Entire File
```php
<?php
echo "=== DEMO 1: Reading Entire File ===\n";

// Method 1: file_get_contents()
echo "Using file_get_contents():\n";
$content = file_get_contents("sample.txt");
echo $content . "\n";

echo "\n" . str_repeat("-", 40) . "\n";

// Method 2: file() - into array
echo "Using file() - each line as array element:\n";
$lines = file("sample.txt");
foreach ($lines as $lineNumber => $line) {
    echo "Line " . ($lineNumber + 1) . ": " . trim($line) . "\n";
}

echo "\n=== End Demo 1 ===\n\n";
?>
```

### 2. Reading Line by Line
```php
<?php
echo "=== DEMO 2: Reading Line by Line ===\n";

$filename = "sample.txt";

// Check if file exists first
if (file_exists($filename)) {
    echo "File exists! Opening...\n";
    
    $file = fopen($filename, "r");
    
    if ($file) {
        $lineCount = 1;
        while (($line = fgets($file)) !== false) {
            echo "Processing Line {$lineCount}: " . trim($line) . "\n";
            $lineCount++;
        }
        fclose($file);
        echo "File closed successfully.\n";
    } else {
        echo "Error: Could not open file!\n";
    }
} else {
    echo "Error: File does not exist!\n";
}

echo "\n=== End Demo 2 ===\n\n";
?>
```

## Writing Files

### 1. Writing to File
```php
<?php
echo "=== DEMO 3: Writing to Files ===\n";

// Method 1: file_put_contents() - overwrites
echo "Creating new file 'output.txt'...\n";
$newContent = "This is my first line.\nThis is my second line.\nCreated on: " . date('Y-m-d H:i:s');
$result = file_put_contents("output.txt", $newContent);

if ($result !== false) {
    echo "Successfully wrote {$result} bytes to file!\n";
    echo "File content:\n";
    echo file_get_contents("output.txt") . "\n";
} else {
    echo "Error writing to file!\n";
}

echo "\n" . str_repeat("-", 40) . "\n";

// Method 2: Appending to file
echo "Appending to existing file...\n";
$appendContent = "\nThis line was appended.\nAppended on: " . date('Y-m-d H:i:s');
$result = file_put_contents("output.txt", $appendContent, FILE_APPEND);

if ($result !== false) {
    echo "Successfully appended {$result} bytes!\n";
    echo "Updated file content:\n";
    echo file_get_contents("output.txt") . "\n";
}

echo "\n=== End Demo 3 ===\n\n";
?>
```

### 2. Using fopen() for Writing
```php
<?php
echo "=== DEMO 4: Using fopen() for Writing ===\n";

// Writing mode
echo "Creating log file...\n";
$logFile = fopen("activity_log.txt", "w");

if ($logFile) {
    fwrite($logFile, "=== ACTIVITY LOG ===\n");
    fwrite($logFile, "Started: " . date('Y-m-d H:i:s') . "\n");
    fwrite($logFile, "User: Demo User\n");
    fwrite($logFile, "Action: File handling demo\n");
    fclose($logFile);
    
    echo "Log file created! Content:\n";
    echo file_get_contents("activity_log.txt") . "\n";
} else {
    echo "Error creating log file!\n";
}

echo "\n" . str_repeat("-", 40) . "\n";

// Append mode
echo "Appending to log file...\n";
$logFile = fopen("activity_log.txt", "a");

if ($logFile) {
    fwrite($logFile, "Updated: " . date('Y-m-d H:i:s') . "\n");
    fwrite($logFile, "Status: Demo completed\n");
    fclose($logFile);
    
    echo "Log updated! Final content:\n";
    echo file_get_contents("activity_log.txt") . "\n";
}

echo "\n=== End Demo 4 ===\n\n";
?>
```

## File Operations
```php
<?php
echo "=== DEMO 5: File Operations ===\n";

$filename = "test_file.txt";

// Create a test file
file_put_contents($filename, "This is a test file for operations demo.");

// Check if file exists
if (file_exists($filename)) {
    echo "✅ File '{$filename}' exists!\n";
    
    // Get file size
    $size = filesize($filename);
    echo "📏 File size: {$size} bytes\n";
    
    // Get file modification time
    $modTime = filemtime($filename);
    echo "⏰ Last modified: " . date('Y-m-d H:i:s', $modTime) . "\n";
    
    // Check if readable
    if (is_readable($filename)) {
        echo "👁️ File is readable\n";
    }
    
    // Check if writable
    if (is_writable($filename)) {
        echo "✏️ File is writable\n";
    }
    
    echo "\n" . str_repeat("-", 30) . "\n";
    
    // Copy file
    $backupName = "backup_" . $filename;
    if (copy($filename, $backupName)) {
        echo "📋 File copied to '{$backupName}'\n";
    }
    
    // Rename file
    $newName = "renamed_" . $filename;
    if (rename($filename, $newName)) {
        echo "✏️ File renamed to '{$newName}'\n";
        $filename = $newName; // Update variable
    }
    
    // Delete backup file
    if (unlink($backupName)) {
        echo "🗑️ Backup file deleted\n";
    }
    
    // Finally delete the test file
    if (unlink($filename)) {
        echo "🗑️ Test file deleted\n";
    }
    
} else {
    echo "❌ File does not exist!\n";
}

echo "\n=== End Demo 5 ===\n\n";
?>
```

## 🎯 **Mini Exercise:**
Write a PHP script that creates a "visitors.txt" file and logs each page visit with timestamp.

---

# 🗄️ Part 3: Database Introduction

## What is a Database?
A database is an organized collection of data that can be easily accessed, managed, and updated.

**Common Database Types:**
- **MySQL** - Most popular with PHP
- **PostgreSQL** - Advanced features
- **SQLite** - File-based, simple

## Database Concepts

### 1. Basic Structure
- **Database** - Container for all data
- **Table** - Like a spreadsheet with rows and columns
- **Row** - Individual record
- **Column** - Data field (name, email, age, etc.)

### 2. SQL Basics
```sql
-- Create table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100),
    age INT
);

-- Insert data
INSERT INTO users (name, email, age) VALUES 
('Alice', 'alice@email.com', 25),
('Bob', 'bob@email.com', 30);

-- Select data
SELECT * FROM users;
SELECT name, email FROM users WHERE age > 25;

-- Update data
UPDATE users SET age = 31 WHERE name = 'Bob';

-- Delete data
DELETE FROM users WHERE id = 1;
```

## Connecting PHP to MySQL

### 1. MySQLi Connection
```php
<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "my_database";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully!";

// Close connection
$conn->close();
?>
```

### 2. Inserting Data
```php
<?php
$conn = new mysqli("localhost", "root", "", "my_database");

$name = "Charlie";
$email = "charlie@email.com";
$age = 28;

$sql = "INSERT INTO users (name, email, age) VALUES ('$name', '$email', $age)";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
```

### 3. Retrieving Data
```php
<?php
$conn = new mysqli("localhost", "root", "", "my_database");

$sql = "SELECT id, name, email, age FROM users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Name</th><th>Email</th><th>Age</th></tr>";
    
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["id"] . "</td>";
        echo "<td>" . $row["name"] . "</td>";
        echo "<td>" . $row["email"] . "</td>";
        echo "<td>" . $row["age"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}

$conn->close();
?>
```

### 4. Prepared Statements (Secure)
```php
<?php
$conn = new mysqli("localhost", "root", "", "my_database");

// Prepare statement
$stmt = $conn->prepare("INSERT INTO users (name, email, age) VALUES (?, ?, ?)");
$stmt->bind_param("ssi", $name, $email, $age);  // s=string, i=integer

// Set parameters and execute
$name = "Diana";
$email = "diana@email.com";
$age = 22;
$stmt->execute();

echo "New record created successfully";

$stmt->close();
$conn->close();
?>
```

---

# 🏋️ Part 4: Hands-on Exercise

## **Complete Exercise: Student Management System**

Create a simple system that combines all three concepts:

### Task:
1. Create a `Student` class with OOP principles
2. Save student data to a text file
3. Later: Discuss how this could be improved with a database

### Requirements:
```php
<?php
class Student {
    // Properties
    private $name;
    private $email;
    private $grade;
    
    // Constructor
    public function __construct($name, $email, $grade) {
        // Set properties
    }
    
    // Method to save student to file
    public function saveToFile() {
        // Append student data to "students.txt"
    }
    
    // Method to display student info
    public function displayInfo() {
        // Show student details
    }
    
    // Static method to read all students from file
    public static function getAllStudents() {
        // Read and display all students from file
    }
}

// Test the class
$student1 = new Student("Alice", "alice@email.com", "A");
$student2 = new Student("Bob", "bob@email.com", "B");

$student1->saveToFile();
$student2->saveToFile();

Student::getAllStudents();
?>
```

---

## 📚 Session Summary

### What We Learned:
1. **OOP Basics:** Classes, objects, constructors, encapsulation
2. **File Handling:** Reading, writing, and managing files
3. **Database Intro:** SQL basics and PHP-MySQL connection

### Key Takeaways:
- OOP makes code more organized and reusable
- File handling enables data persistence
- Databases provide structured, efficient data storage
- Always use prepared statements for database security

### Next Steps:
- Practice creating more complex classes
- Explore advanced file operations
- Learn more SQL and database design
- Build complete web applications combining all concepts

---

## 🎯 **Quick Quiz (Optional)**
1. What's the difference between public, private, and protected?
2. Which function reads an entire file into a string?
3. What does SQL stand for?
4. Why use prepared statements?

**Great job completing Session 3! You're now ready for more advanced PHP development!**