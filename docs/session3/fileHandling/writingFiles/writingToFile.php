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