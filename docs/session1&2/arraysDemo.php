<?php
echo "<h1>📚 PHP Arrays Mastery</h1>";

// INDEXED ARRAYS
echo "<h2>🔢 Indexed Arrays</h2>";

// Creating arrays
$fruits = ["apple", "banana", "orange", "grape", "mango"];
$numbers = [10, 25, 30, 45, 50];

echo "<h3>🍎 Fruits Collection:</h3>";
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