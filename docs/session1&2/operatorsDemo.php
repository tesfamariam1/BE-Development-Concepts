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