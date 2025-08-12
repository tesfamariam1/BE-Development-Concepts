<?php
// Different classes, same method name
class Cow {
    // Method - Action
    public function makeSound() {
        echo "Moo!";
    }
}

class Duck {
    // Method - Action
    public function makeSound() {
        echo "Quack!";
    }
}

// Same method name, different results!
$animals = [
    new Cow(),
    new Duck()
];

// Call the same method on different objects
foreach ($animals as $animal) {
    $animal->makeSound();  // Each animal makes its own sound!
}
// Output: 
// "Moo!"
// "Quack!"