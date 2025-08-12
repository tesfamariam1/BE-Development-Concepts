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