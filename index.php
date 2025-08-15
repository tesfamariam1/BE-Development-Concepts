<!DOCTYPE html>
<html>
<head>
    <title>My First PHP Script</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans h-screen flex justify-center items-center">
    <div class="flex flex-col">
        <h1>Welcome to PHP!</h1>
    
        <!-- GET, POST, PUT, DELETE -->
   <?php
       // Database configuration
        $servername = "127.0.0.1";
        $username = "root";
        $password = "";
        $dbname = "test_db";

        $conn = new mysqli($servername, $username, $password,  $dbname);


        // $createUsersTable = "CREATE TABLE users (
        //     id INT AUTO_INCREMENT PRIMARY KEY,
        //     name VARCHAR(100),
        //     email VARCHAR(100),
        //     age INT
        // )";
        // if($conn->query($createUsersTable) === TRUE) 
        // {
        //     echo "Users table created!";
        // }

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

        // // Create connection
        // $conn = new mysqli($servername, $username, $password, $dbname);

        // // Check connection
        // if ($conn->connect_error) {
        //     die("Connection failed: " . $conn->connect_error);
        // }
        // echo "Connected successfully!";

        // // Close connection
        // $conn->close();
    ?>
    
    <p class="mt-4 text-base text-gray-800">PHP - Backend Development</p>
    </div>
</body>
</html>