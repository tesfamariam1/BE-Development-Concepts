<?php
echo "<h1>PHP Variables Masterclass</h1>";

// 1. STRING VARIABLES
$studentName = "Tesfamariam";
$courseName = "Laravel Backend Development";
$university = 'Jimma University'; // Single or double quotes

echo "<h2>Student Information</h2>";
echo "Student: " . $studentName . "<br>";
echo "Course: " . $courseName . "<br>";
echo "University: " . $university . "<br><br>";

// 2. NUMERIC VARIABLES
$age = 23;                    // Integer
$gpa = 3.85;                 // Float/Double
$courseCredits = 4;          // Integer
$tuitionFee = 15000.50;      // Float

echo "<h2>Academic Details</h2>";
echo "Age: " . $age . " years<br>";
echo "GPA: " . $gpa . "/4.0<br>";
echo "Course Credits: " . $courseCredits . "<br>";
echo "Tuition Fee: $" . $tuitionFee . "<br><br>";

// 3. BOOLEAN VARIABLES
$isEnrolled = true;
$hasScholarship = false;
$isGraduating = true;

echo "<h2>Status Check</h2>";
echo "Enrolled: " . ($isEnrolled ? "Yes" : "No") . "<br>";
echo "Has Scholarship: " . ($hasScholarship ? "Yes" : "No") . "<br>";
echo "Graduating: " . ($isGraduating ? "Yes" : "No") . "<br><br>";

// 4. ARRAY VARIABLES
$subjects = ["Mathematics", "Computer Science", "Physics", "English"];
$grades = [85, 92, 78, 88];

echo "<h2>Subjects & Grades</h2>";
echo "Subject 1: " . $subjects[0] . " - Grade: " . $grades[0] . "%<br>";
echo "Subject 2: " . $subjects[1] . " - Grade: " . $grades[1] . "%<br>";
echo "Subject 3: " . $subjects[2] . " - Grade: " . $grades[2] . "%<br>";
echo "Subject 4: " . $subjects[3] . " - Grade: " . $grades[3] . "%<br>";
?>