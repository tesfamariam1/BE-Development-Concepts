<?php
// ASSOCIATIVE ARRAYS
echo "<h2>🗝️ Associative Arrays</h2>";

// Student information
$student = [
    "name" => "John Doe",
    "age" => 22,
    "email" => "john@university.edu",
    "gpa" => 3.75,
    "major" => "Computer Science",
    "isActive" => true
];

echo "<h3>👨‍🎓 Student Profile:</h3>";
echo "Name: " . $student["name"] . "<br>";
echo "Age: " . $student["age"] . "<br>";
echo "Email: " . $student["email"] . "<br>";
echo "GPA: " . $student["gpa"] . "<br>";
echo "Major: " . $student["major"] . "<br>";
echo "Status: " . ($student["isActive"] ? "Active" : "Inactive") . "<br><br>";

// Course grades
$grades = [
    "Mathematics" => 85,
    "Physics" => 92,
    "Chemistry" => 78,
    "Computer Science" => 96,
    "English" => 88
];

echo "<h3>📊 Course Grades:</h3>";
$totalGrades = 0;
$courseCount = 0;

foreach ($grades as $course => $grade) {
    echo "$course: $grade%<br>";
    $totalGrades += $grade;
    $courseCount++;
}

$average = $totalGrades / $courseCount;
echo "<hr>";
echo "<strong>📈 Average Grade: " . round($average, 2) . "%</strong><br><br>";

// Multidimensional arrays
$classroom = [
    "student1" => [
        "name" => "Alice Johnson",
        "grades" => [85, 90, 78, 92],
        "email" => "alice@school.com"
    ],
    "student2" => [
        "name" => "Bob Smith",
        "grades" => [76, 88, 85, 79],
        "email" => "bob@school.com"
    ],
    "student3" => [
        "name" => "Carol Davis",
        "grades" => [94, 87, 91, 96],
        "email" => "carol@school.com"
    ]
];

echo "<h3>🏫 Classroom Report:</h3>";
foreach ($classroom as $studentId => $studentData) {
    $name = $studentData["name"];
    $average = array_sum($studentData["grades"]) / count($studentData["grades"]);
    
    echo "<strong>$name</strong><br>";
    echo "Email: " . $studentData["email"] . "<br>";
    echo "Grades: " . implode(", ", $studentData["grades"]) . "<br>";
    echo "Average: " . round($average, 2) . "%<br><br>";
}

// Array manipulation
echo "<h2>🛠️ Array Manipulation</h2>";

$originalArray = [1, 2, 3, 4, 5];
echo "Original: " . implode(", ", $originalArray) . "<br>";

// Add elements
array_push($originalArray, 6, 7);
echo "After push: " . implode(", ", $originalArray) . "<br>";

// Remove elements
$removed = array_pop($originalArray);
echo "Removed: $removed<br>";
echo "After pop: " . implode(", ", $originalArray) . "<br>";

// Sort array
sort($originalArray);
echo "Sorted: " . implode(", ", $originalArray) . "<br>";

// Reverse array
$reversed = array_reverse($originalArray);
echo "Reversed: " . implode(", ", $reversed) . "<br>";
?>