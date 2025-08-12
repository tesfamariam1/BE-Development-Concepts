<?php
$conn = new mysqli("localhost", "root", "", "my_database");

$name = "Charlie";
$email = "charlie@email.com";
$age = 28;

$sql = "INSERT INTO users (name, email, age) VALUES ('$name', '$email', $age)";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>