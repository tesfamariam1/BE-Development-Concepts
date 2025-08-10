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

// if($attempts <= $maxAttempts) {
//     if ($userPassword == $correctPassword) {
//         echo "Login successful!<br>";
//         break;
//     } else {
//         echo "Wrong password<br>";
//         $attempts++;
//     }
// }

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
echo "<strong>🧾 Total: $" . number_format($totalPrice, 2) . "</strong><br><br>";

// DO-WHILE LOOP - Random Number Guessing
echo "<h2>🎲 Random Number Generator</h2>";
$attempts = 0;
$targetNumber = 7;

do {
    $generatedNumber = rand(1, 10);
    $attempts++;
    echo "Attempt $attempts: Generated $generatedNumber";
    
    if ($generatedNumber == $targetNumber) {
        echo " - 🎯 Bingo! Found $targetNumber<br>";
    } else {
        echo " - ⚡ Keep trying...<br>";
    }
} while ($generatedNumber != $targetNumber && $attempts < 10);

if ($attempts >= 10) {
    echo "⏰ Max attempts reached!<br>";
}
?>