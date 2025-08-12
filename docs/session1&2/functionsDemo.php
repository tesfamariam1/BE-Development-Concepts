<?php
echo "<h1>🔧 PHP Functions Workshop</h1>";

// SIMPLE FUNCTION
function welcomeMessage() {
    return "🎉 Welcome to our Laravel course!";
}

echo "<h2>📢 Welcome Function</h2>";
echo welcomeMessage() . "<br><br>";

// FUNCTION WITH PARAMETERS
function greetUser($name, $course) {
    return "Hello <strong>$name</strong>! Welcome to $course.";
}
echo "<h2>👋 Personalized Greeting</h2>";
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

echo "<h2>📊 Grade Calculator Function</h2>";
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

echo "<h2>🧾 Order Calculator</h2>";
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

echo "<h2>🔢 Factorial Calculator</h2>";
for ($i = 1; $i <= 5; $i++) {
    echo "Factorial of $i = " . factorial($i) . "<br>";
}
?>