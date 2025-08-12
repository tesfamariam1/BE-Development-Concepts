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