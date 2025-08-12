<?php
// Create a sample data file for demonstrations
$sampleData = "Welcome to PHP File Handling!
This is line 2.
This is line 3.
End of sample data.";

file_put_contents("sample.txt", $sampleData);
echo "Sample file created successfully!\n";
?>