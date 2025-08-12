<?php
class Student {
    public $name;
    public $age;
    public $grade;
    
    // Constructor - runs when object is created
    public function __construct($name, $age, $grade) {
        $this->name = $name;
        $this->age = $age;
        $this->grade = $grade;
        echo "New student {$name} enrolled!\n";
    }
    
    public function study($subject) {
        echo "{$this->name} is studying {$subject}\n";
    }
    
    public function getInfo() {
        return "Name: {$this->name}, Age: {$this->age}, Grade: {$this->grade}";
    }
}

// Using constructor
$student1 = new Student("Alice", 20, "A");
$student2 = new Student("Bob", 19, "B");

echo $student1->getInfo();
?>