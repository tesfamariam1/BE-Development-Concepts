# PHP Fundamentals
## 1 Sessions × 1.5 Hours

---

# Session 1: Introduction to Programming & PHP Basics

## Part 1: Welcome & Backend Development

### Opening Introduction
> "Welcome everyone! Over the next 8 weeks, you're going to transform from complete beginners into capable backend developers. By the end, you'll build real applications that handle user data, authentication, and complex business logic."


**Course Overview:**
```
Week 1-3: PHP & Laravel Basics
Week 3-4: First Project - Blog System  
Week 5-6: Second Project - Task Manager with Authentication
Week 7-8: Final Project - E-commerce System
```

### What is Backend Development?

**Visual Analogy - Restaurant Example:**
```
Frontend (Customer Area):
- Menu (Website Interface)
- Tables (User Interface)
- What customers see and interact with

Backend (Kitchen):
- Chefs (Server Processing)
- Recipes (Business Logic)
- Storage (Database)
- What happens behind the scenes
```

**Real-World Examples:**
1. **Social Media Login:**
   - "When you log into Facebook, frontend sends your password"
   - "Backend checks if password matches database"
   - "Backend decides: allow access or show error"

2. **Online Shopping:**
   - "You click 'Add to Cart' (frontend)"
   - "Backend updates your cart in database"
   - "Backend calculates total with taxes"

3. **Search Function:**
   - "You type in search box (frontend)"
   - "Backend searches through millions of records"
   - "Backend returns relevant results"

**Why PHP & Laravel?**
- **PHP Statistics:** 78% of web servers use PHP
- **Popular Sites:** Wikipedia, WordPress, Slack, Etsy
- **Laravel Benefits:** Makes PHP simple to learn and powerful
- **Career Prospects:** High demand, good salaries

---

## Part 1: PHP Basics - Variables & Data Types

### Our First PHP Script

**Create: `first_script.php`**
```php
<!DOCTYPE html>
<html>
<head>
    <title>My First PHP Script</title>
</head>
<body>
    <h1>Welcome to PHP!</h1>
    
    <?php
    echo "<p>Hello from PHP!</p>";
    echo "<p>Today is: " . date("Y-m-d H:i:s") . "</p>";
    ?>
    
    <p>This is regular HTML</p>
</body>
</html>
```

**Key Teaching Points:**
- PHP code goes between `<?php` and `?>`
- Can mix PHP with HTML
- `echo` outputs content to browser
- Semicolons end statements

### Variables Deep Dive

**Create: `variables_demo.php`**
```php
<?php
echo "<h1>PHP Variables Masterclass</h1>";

// 1. STRING VARIABLES
$studentName = "Tesfamariam";
$courseName = "Laravel Backend Development";
$university = 'Jimma University'; // Single or double quotes

echo "<h2>Student Information</h2>";
echo "Student: " . $studentName . "<br>";
echo "Course: " . $courseName . "<br>";
echo "University: " . $university . "<br><br>";

// 2. NUMERIC VARIABLES
$age = 23;                    // Integer
$gpa = 3.85;                 // Float/Double
$courseCredits = 4;          // Integer
$tuitionFee = 15000.50;      // Float

echo "<h2>Academic Details</h2>";
echo "Age: " . $age . " years<br>";
echo "GPA: " . $gpa . "/4.0<br>";
echo "Course Credits: " . $courseCredits . "<br>";
echo "Tuition Fee: $" . $tuitionFee . "<br><br>";

// 3. BOOLEAN VARIABLES
$isEnrolled = true;
$hasScholarship = false;
$isGraduating = true;

echo "<h2>Status Check</h2>";
echo "Enrolled: " . ($isEnrolled ? "Yes" : "No") . "<br>";
echo "Has Scholarship: " . ($hasScholarship ? "Yes" : "No") . "<br>";
echo "Graduating: " . ($isGraduating ? "Yes" : "No") . "<br><br>";

// 4. ARRAY VARIABLES
$subjects = ["Mathematics", "Computer Science", "Physics", "English"];
$grades = [85, 92, 78, 88];

echo "<h2>Subjects & Grades</h2>";
echo "Subject 1: " . $subjects[0] . " - Grade: " . $grades[0] . "%<br>";
echo "Subject 2: " . $subjects[1] . " - Grade: " . $grades[1] . "%<br>";
echo "Subject 3: " . $subjects[2] . " - Grade: " . $grades[2] . "%<br>";
echo "Subject 4: " . $subjects[3] . " - Grade: " . $grades[3] . "%<br>";
?>
```


### Data Types & Operators

**Create: `operators_demo.php`**
```php
<?php
echo "<h1>PHP Operators in Action</h1>";

// ARITHMETIC OPERATORS
$price = 100;
$discount = 15;
$tax = 8.5;

echo "<h2>Shopping Cart Calculator</h2>";
echo "Original Price: $" . $price . "<br>";
echo "Discount: " . $discount . "%<br>";

$discountAmount = $price * ($discount / 100);
$priceAfterDiscount = $price - $discountAmount;
$taxAmount = $priceAfterDiscount * ($tax / 100);
$finalPrice = $priceAfterDiscount + $taxAmount;

echo "Discount Amount: $" . $discountAmount . "<br>";
echo "Price After Discount: $" . $priceAfterDiscount . "<br>";
echo "Tax Amount: $" . $taxAmount . "<br>";
echo "<strong>Final Price: $" . round($finalPrice, 2) . "</strong><br><br>";

// COMPARISON OPERATORS
$student1Grade = 85;
$student2Grade = 92;
$passingGrade = 70;

echo "<h2>🎯 Grade Comparison</h2>";
echo "Student 1: " . $student1Grade . " points<br>";
echo "Student 2: " . $student2Grade . " points<br>";
echo "Passing Grade: " . $passingGrade . " points<br><br>";

echo "Student 1 passed: " . ($student1Grade >= $passingGrade ? "✅ Yes" : "❌ No") . "<br>";
echo "Student 2 passed: " . ($student2Grade >= $passingGrade ? "✅ Yes" : "❌ No") . "<br>";
echo "Student 2 scored higher: " . ($student2Grade > $student1Grade ? "✅ Yes" : "❌ No") . "<br>";

// STRING OPERATORS
$firstName = "John";
$lastName = "Doe";
$fullName = $firstName . " " . $lastName;

echo "<h2>String Operations</h2>";
echo "First Name: " . $firstName . "<br>";
echo "Last Name: " . $lastName . "<br>";
echo "Full Name: " . $fullName . "<br>";
echo "Name Length: " . strlen($fullName) . " characters<br>";
echo "Uppercase: " . strtoupper($fullName) . "<br>";
?>
```

---

## Part 4: Hands-On Practice

### Individual Exercise
**Task:** Create `my_profile.php` with:
```php
<?php
$name = "Your Name";
$age = 25;
$city = "Your City";
$hobbies = ["hobby1", "hobby2", "hobby3"];
$isStudent = true;
$favoriteNumber = 7;

// Then display everything with nice formatting
// Calculate and display birth year
$birthYear = date("Y") - $age;
?>
```

---

# Session 2: PHP Fundamentals I (Control Structures, Functions, Arrays)


## Part 1: Control Structures

### If/Else Statements

**Create: `control_structures.php`**
```php
<?php
echo "<h1>Decision Making with PHP</h1>";

// SIMPLE IF STATEMENT
$temperature = 75;
echo "<h2>Weather Advisory</h2>";
echo "Current Temperature: " . $temperature . "°F<br>";

if ($temperature > 80) {
    echo "<p style='color: red;'>It's hot outside! Stay hydrated.</p>";
}

// IF-ELSE STATEMENT
$userAge = 20;
echo "<h2>Movie Ticket Checker</h2>";
echo "Your Age: " . $userAge . "<br>";

if ($userAge >= 18) {
    echo "<p style='color: green;'>You can watch R-rated movies!</p>";
} else {
    echo "<p style='color: orange;'>You can only watch PG-13 movies.</p>";
}

// IF-ELSEIF-ELSE STATEMENT
$score = 85;
echo "<h2>Grade Calculator</h2>";
echo "Your Score: " . $score . "%<br>";

if ($score >= 90) {
    $grade = "A";
    $message = "🎉 Excellent work!";
    $color = "green";
} elseif ($score >= 80) {
    $grade = "B";
    $message = "👍 Good job!";
    $color = "blue";
} elseif ($score >= 70) {
    $grade = "C";
    $message = "📚 Keep studying!";
    $color = "orange";
} elseif ($score >= 60) {
    $grade = "D";
    $message = "⚠️ Needs improvement!";
    $color = "red";
} else {
    $grade = "F";
    $message = "❌ Study harder!";
    $color = "darkred";
}

echo "<p style='color: $color;'>Grade: <strong>$grade</strong><br>$message</p>";

// NESTED IF STATEMENTS
$isLoggedIn = true;
$userRole = "admin";

echo "<h2>Access Control System</h2>";

if ($isLoggedIn) {
    echo "<p>User is logged in</p>";
    
    if ($userRole == "admin") {
        echo "<p style='color: purple;'>Admin access granted - Full control</p>";
    } elseif ($userRole == "editor") {
        echo "<p style='color: blue;'>Editor access - Can edit content</p>";
    } else {
        echo "<p style='color: green;'>Viewer access - Read only</p>";
    }
} else {
    echo "<p style='color: red;'>Please log in to access the system</p>";
}
?>
```

**Key Points:**
- Comparison operators: `==`, `!=`, `>`, `<`, `>=`, `<=`
- The difference between `=` (assignment) and `==` (comparison)

### Loops

**Create: `loops_demo.php`**
```php
<?php
echo "<h1>Mastering PHP Loops</h1>";

// FOR LOOP - Counting
echo "<h2>Countdown Timer</h2>";
for ($i = 10; $i >= 1; $i--) {
    echo "$i seconds remaining...<br>";
}
echo "Blast off!<br><br>";

// FOR LOOP - Multiplication Table
echo "<h2>Multiplication Table (5x)</h2>";
for ($i = 1; $i <= 10; $i++) {
    $result = 5 * $i;
    echo "5 × $i = <strong>$result</strong><br>";
}
echo "<br>";

// WHILE LOOP - User Authentication Attempts
echo "<h2>Login Attempt Simulator</h2>";
$attempts = 1;
$maxAttempts = 3;
$correctPassword = "secret123";
$userPassword = "wrongpass";

while ($attempts <= $maxAttempts) {
    echo "Attempt $attempts: ";
    
    if ($userPassword == $correctPassword) {
        echo "Login successful!<br>";
        break;
    } else {
        echo "Wrong password<br>";
        $attempts++;
    }
}

if ($attempts > $maxAttempts) {
    echo "Account locked after $maxAttempts failed attempts<br>";
}
echo "<br>";

// FOREACH LOOP - Processing Arrays
echo "<h2>Shopping Cart Items</h2>";
$cartItems = ["Laptop", "Mouse", "Keyboard", "Monitor", "Speakers"];
$itemPrices = [999.99, 25.50, 75.00, 299.99, 149.99];

$totalPrice = 0;
$itemNumber = 1;

foreach ($cartItems as $index => $item) {
    $price = $itemPrices[$index];
    echo "$itemNumber. $item - $" . number_format($price, 2) . "<br>";
    $totalPrice += $price;
    $itemNumber++;
}

echo "<hr>";
echo "<strong>Total: $" . number_format($totalPrice, 2) . "</strong><br><br>";

// DO-WHILE LOOP - Random Number Guessing
echo "<h2>Random Number Generator</h2>";
$attempts = 0;
$targetNumber = 7;

do {
    $generatedNumber = rand(1, 10);
    $attempts++;
    echo "Attempt $attempts: Generated $generatedNumber";
    
    if ($generatedNumber == $targetNumber) {
        echo " - Bingo! Found $targetNumber<br>";
    } else {
        echo " - Keep trying...<br>";
    }
} while ($generatedNumber != $targetNumber && $attempts < 10);

if ($attempts >= 10) {
    echo "Max attempts reached!<br>";
}
?>
```

---

## Part 2: Functions and Scope

### Basic Functions

**Create: `functions_demo.php`**
```php
<?php
echo "<h1>PHP Functions Workshop</h1>";

// SIMPLE FUNCTION
function welcomeMessage() {
    return "Welcome to our Laravel course!";
}

echo "<h2>Welcome Function</h2>";
echo welcomeMessage() . "<br><br>";

// FUNCTION WITH PARAMETERS
function greetUser($name, $course) {
    return "Hello <strong>$name</strong>! Welcome to $course.";
}

echo "<h2>Personalized Greeting</h2>";
echo greetUser("Alice", "Backend Development") . "<br>";
echo greetUser("Bob", "PHP Fundamentals") . "<br><br>";

// FUNCTION WITH DEFAULT PARAMETERS
function calculateGrade($score, $maxScore = 100) {
    $percentage = ($score / $maxScore) * 100;
    
    if ($percentage >= 90) return "A";
    elseif ($percentage >= 80) return "B";
    elseif ($percentage >= 70) return "C";
    elseif ($percentage >= 60) return "D";
    else return "F";
}

echo "<h2>Grade Calculator Function</h2>";
echo "Score 95/100: Grade " . calculateGrade(95) . "<br>";
echo "Score 42/50: Grade " . calculateGrade(42, 50) . "<br>";
echo "Score 65/100: Grade " . calculateGrade(65) . "<br><br>";

// FUNCTION RETURNING MULTIPLE VALUES
function calculateOrderTotal($items, $taxRate = 0.08) {
    $subtotal = array_sum($items);
    $tax = $subtotal * $taxRate;
    $total = $subtotal + $tax;
    
    return [
        'subtotal' => $subtotal,
        'tax' => $tax,
        'total' => $total
    ];
}

echo "<h2>Order Calculator</h2>";
$orderItems = [29.99, 15.50, 8.75, 42.00];
$orderSummary = calculateOrderTotal($orderItems);

echo "Subtotal: $" . number_format($orderSummary['subtotal'], 2) . "<br>";
echo "Tax: $" . number_format($orderSummary['tax'], 2) . "<br>";
echo "Total: $" . number_format($orderSummary['total'], 2) . "<br><br>";

// RECURSIVE FUNCTION
function factorial($n) {
    if ($n <= 1) {
        return 1;
    }
    return $n * factorial($n - 1);
}

echo "<h2>Factorial Calculator</h2>";
for ($i = 1; $i <= 5; $i++) {
    echo "Factorial of $i = " . factorial($i) . "<br>";
}
?>
```

### Variable Scope (10 minutes)

**Create: `scope_demo.php`**
```php
<?php
echo "<h1>Variable Scope Explained</h1>";

// GLOBAL SCOPE
$globalMessage = "I am a global variable";
$globalCounter = 0;

function demonstrateScope() {
    // LOCAL SCOPE
    $localMessage = "I am a local variable";
    
    // Accessing global variable inside function
    global $globalMessage, $globalCounter;
    $globalCounter++;
    
    echo "<h3>Inside Function:</h3>";
    echo "Local: $localMessage<br>";
    echo "Global: $globalMessage<br>";
    echo "Counter: $globalCounter<br><br>";
}

echo "<h2>Global Scope Test</h2>";
echo "Before function call - Counter: $globalCounter<br>";

demonstrateScope();
demonstrateScope();

echo "After function calls - Counter: $globalCounter<br><br>";

// STATIC VARIABLES
function countCalls() {
    static $callCount = 0;
    $regularVar = 0;
    
    $callCount++;
    $regularVar++;
    
    echo "📞 Function called $callCount times<br>";
    echo "Regular variable: $regularVar<br><br>";
}

echo "<h2>Static Variables</h2>";
countCalls();
countCalls();
countCalls();
?>
```

---

## Part 3: Arrays Deep Dive

### Indexed Arrays

**Create: `arrays_demo.php`**
```php
<?php
echo "<h1>PHP Arrays Mastery</h1>";

// INDEXED ARRAYS
echo "<h2>Indexed Arrays</h2>";

// Creating arrays
$fruits = ["apple", "banana", "orange", "grape", "mango"];
$numbers = [10, 25, 30, 45, 50];

echo "<h3>Fruits Collection:</h3>";
echo "First fruit: " . $fruits[0] . "<br>";
echo "Last fruit: " . $fruits[4] . "<br>";
echo "Total fruits: " . count($fruits) . "<br><br>";

// Adding elements
$fruits[] = "pineapple";  // Add to end
$fruits[10] = "kiwi";     // Add at specific index

echo "<h3>➕ After adding fruits:</h3>";
for ($i = 0; $i < count($fruits); $i++) {
    if (isset($fruits[$i])) {
        echo "Index $i: " . $fruits[$i] . "<br>";
    }
}
echo "<br>";

// Array functions
echo "<h3>🔧 Array Functions:</h3>";
echo "Array sum: " . array_sum($numbers) . "<br>";
echo "Maximum: " . max($numbers) . "<br>";
echo "Minimum: " . min($numbers) . "<br>";
echo "Average: " . (array_sum($numbers) / count($numbers)) . "<br><br>";

// Searching in arrays
$searchFruit = "orange";
if (in_array($searchFruit, $fruits)) {
    $position = array_search($searchFruit, $fruits);
    echo "🔍 Found '$searchFruit' at position $position<br><br>";
}
?>
```

### Associative Arrays

**Continue in same file:**
```php
<?php
// ASSOCIATIVE ARRAYS
echo "<h2>🗝️ Associative Arrays</h2>";

// Student information
$student = [
    "name" => "John Doe",
    "age" => 22,
    "email" => "john@university.edu",
    "gpa" => 3.75,
    "major" => "Computer Science",
    "isActive" => true
];

echo "<h3>Student Profile:</h3>";
echo "Name: " . $student["name"] . "<br>";
echo "Age: " . $student["age"] . "<br>";
echo "Email: " . $student["email"] . "<br>";
echo "GPA: " . $student["gpa"] . "<br>";
echo "Major: " . $student["major"] . "<br>";
echo "Status: " . ($student["isActive"] ? "Active" : "Inactive") . "<br><br>";

// Course grades
$grades = [
    "Mathematics" => 85,
    "Physics" => 92,
    "Chemistry" => 78,
    "Computer Science" => 96,
    "English" => 88
];

echo "<h3>Course Grades:</h3>";
$totalGrades = 0;
$courseCount = 0;

foreach ($grades as $course => $grade) {
    echo "$course: $grade%<br>";
    $totalGrades += $grade;
    $courseCount++;
}

$average = $totalGrades / $courseCount;
echo "<hr>";
echo "<strong>Average Grade: " . round($average, 2) . "%</strong><br><br>";

// Multidimensional arrays
$classroom = [
    "student1" => [
        "name" => "Alice Johnson",
        "grades" => [85, 90, 78, 92],
        "email" => "alice@school.com"
    ],
    "student2" => [
        "name" => "Bob Smith",
        "grades" => [76, 88, 85, 79],
        "email" => "bob@school.com"
    ],
    "student3" => [
        "name" => "Carol Davis",
        "grades" => [94, 87, 91, 96],
        "email" => "carol@school.com"
    ]
];

echo "<h3>Classroom Report:</h3>";
foreach ($classroom as $studentId => $studentData) {
    $name = $studentData["name"];
    $average = array_sum($studentData["grades"]) / count($studentData["grades"]);
    
    echo "<strong>$name</strong><br>";
    echo "Email: " . $studentData["email"] . "<br>";
    echo "Grades: " . implode(", ", $studentData["grades"]) . "<br>";
    echo "Average: " . round($average, 2) . "%<br><br>";
}

// Array manipulation
echo "<h2>Array Manipulation</h2>";

$originalArray = [1, 2, 3, 4, 5];
echo "Original: " . implode(", ", $originalArray) . "<br>";

// Add elements
array_push($originalArray, 6, 7);
echo "After push: " . implode(", ", $originalArray) . "<br>";

// Remove elements
$removed = array_pop($originalArray);
echo "Removed: $removed<br>";
echo "After pop: " . implode(", ", $originalArray) . "<br>";

// Sort array
sort($originalArray);
echo "Sorted: " . implode(", ", $originalArray) . "<br>";

// Reverse array
$reversed = array_reverse($originalArray);
echo "Reversed: " . implode(", ", $reversed) . "<br>";
?>
```

---

## Part 4: Practice Exercise

**Individual Task:** Create `student_manager.php`
```php
<?php
// Create a student management system with:
// 1. Student array with name, age, grades
// 2. Function to calculate average grade
// 3. Function to determine if student passes (average >= 70)
// 4. Display all students with their status
?>
```

---

# Session 3: PHP Fundamentals II (OOP, File Handling, Database Intro)

---

## Part 1: Object-Oriented Programming Basics

### Classes and Objects Introduction

**Create: `oop_basics.php`**
```php
<?php
echo "<h1>Object-Oriented Programming in PHP</h1>";

// BASIC CLASS DEFINITION
class Student {
    // Properties (attributes)
    public $name;
    public $age;
    public $email;
    public $grades;
    
    // Constructor method
    public function __construct($name, $age, $email) {
        $this->name = $name;
        $this->age = $age;
        $this->email = $email;
        $this->grades = [];
        
        echo "New student created: $name<br>";
    }
    
    // Methods (functions inside a class)
    public function addGrade($subject, $grade) {
        $this->grades[$subject] = $grade;
        echo "Added grade: $subject = $grade for {$this->name}<br>";
    }
    
    public function getAverageGrade() {
        if (empty($this->grades)) {
            return 0;
        }
        
        return array_sum($this->grades) / count($this->grades);
    }
    
    public function getStudentInfo() {
        $html = "<div style='border: 1px solid #ccc; padding: 10px; margin: 10px;'>";
        $html .= "<h3>{$this->name}</h3>";
        $html .= "<p><strong>Age:</strong> {$this->age}</p>";
        $html .= "<p><strong>Email:</strong> {$this->email}</p>";
        
        if (!empty($this->grades)) {
            $html .= "<p><strong>Grades:</strong></p><ul>";
            foreach ($this->grades as $subject => $grade) {
                $html .= "<li>$subject: $grade%</li>";
            }
            $html .= "</ul>";
            $html .= "<p><strong>Average:</strong> " . round($this->getAverageGrade(), 2) . "%</p>";
        }
        
        $html .= "</div>";
        return $html;
    }
    
    public function isPassingStudent() {
        return $this->getAverageGrade() >= 70;
    }
}

// CREATING OBJECTS (INSTANCES)
echo "<h2>🎓 Creating Students</h2>";

$student1 = new Student("Alice Johnson", 20, "alice@university.edu");
$student2 = new Student("Bob Smith", 19, "bob@university.edu");
$student3 = new Student("Carol Davis", 21, "carol@university.edu");

echo "<br>";

// USING OBJECT METHODS
echo "<h2>📚 Adding Grades</h2>";

$student1->addGrade("Mathematics", 85);
$student1->addGrade("Physics", 92);
$student1->addGrade("Chemistry", 78);

$student2->addGrade("Mathematics", 76);
$student2->addGrade("Physics", 68);
$student2->addGrade("Chemistry", 82);

$student3->addGrade("Mathematics", 94);
$student3->addGrade("Physics", 89);
$student3->addGrade("Chemistry", 96);

echo "<br>";

// DISPLAYING STUDENT INFORMATION
echo "<h2>📊 Student Reports</h2>";

$students = [$student1, $student2, $student3];

foreach ($students as $student) {
    echo $student->getStudentInfo();
    
    if ($student->isPassingStudent()) {
        echo "<p style='color: green;'>✅ Status: PASSING</p>";
    } else {
        echo "<p style='color: red;'>❌ Status: NEEDS IMPROVEMENT</p>";
    }
}
?>
```

### Advanced OOP Concepts

**Create: `advanced_oop.php`**
```php
<?php
echo "<h1>🚀 Advanced OOP Concepts</h1>";

// INHERITANCE
class Person {
    protected $name;
    protected $age;
    protected $email;
    
    public function __construct($name, $age, $email) {
        $this->name = $name;
        $this->age = $age;
        $this->email = $email;
    }