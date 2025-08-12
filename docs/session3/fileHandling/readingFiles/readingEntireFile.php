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