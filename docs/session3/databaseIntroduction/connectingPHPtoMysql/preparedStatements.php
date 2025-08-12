<?php
$conn = new mysqli("localhost", "root", "", "my_database");

// Prepare statement
$stmt = $conn->prepare("INSERT INTO users (name, email, age) VALUES (?, ?, ?)");
$stmt->bind_param("ssi", $name, $email, $age);  // s=string, i=integer

// Set parameters and execute
$name = "Diana";
$email = "diana@email.com";
$age = 22;
$stmt->execute();

echo "New record created successfully";

$stmt->close();
$conn->close();
?>