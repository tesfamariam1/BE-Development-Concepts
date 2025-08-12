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