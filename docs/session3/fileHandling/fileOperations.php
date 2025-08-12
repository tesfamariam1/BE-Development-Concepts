<?php
echo "=== DEMO 5: File Operations ===\n";

$filename = "test_file.txt";

// Create a test file
file_put_contents($filename, "This is a test file for operations demo.");

// Check if file exists
if (file_exists($filename)) {
    echo "✅ File '{$filename}' exists!\n";
    
    // Get file size
    $size = filesize($filename);
    echo "📏 File size: {$size} bytes\n";
    
    // Get file modification time
    $modTime = filemtime($filename);
    echo "⏰ Last modified: " . date('Y-m-d H:i:s', $modTime) . "\n";
    
    // Check if readable
    if (is_readable($filename)) {
        echo "👁️ File is readable\n";
    }
    
    // Check if writable
    if (is_writable($filename)) {
        echo "✏️ File is writable\n";
    }
    
    echo "\n" . str_repeat("-", 30) . "\n";
    
    // Copy file
    $backupName = "backup_" . $filename;
    if (copy($filename, $backupName)) {
        echo "📋 File copied to '{$backupName}'\n";
    }
    
    // Rename file
    $newName = "renamed_" . $filename;
    if (rename($filename, $newName)) {
        echo "✏️ File renamed to '{$newName}'\n";
        $filename = $newName; // Update variable
    }
    
    // Delete backup file
    if (unlink($backupName)) {
        echo "🗑️ Backup file deleted\n";
    }
    
    // Finally delete the test file
    if (unlink($filename)) {
        echo "🗑️ Test file deleted\n";
    }
    
} else {
    echo "❌ File does not exist!\n";
}

echo "\n=== End Demo 5 ===\n\n";
?>