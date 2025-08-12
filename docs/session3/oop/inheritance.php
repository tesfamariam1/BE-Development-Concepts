<?php
// PARENT CLASS - the "mom/dad"
class Animal {
    public $name;
    public $age;
    
    public function __construct($name, $age) {
        $this->name = $name;
        $this->age = $age;
    }
    
    // All animals can do this
    public function eat() {
        echo $this->name . " is eating.";
    }
    
    public function sleep() {
        echo $this->name . " is sleeping.";
    }
}

// CHILD CLASS - inherits from Animal
class Dog extends Animal {
    // Dogs get all Animal abilities PLUS their own
    public function bark() {
        echo $this->name . " says: Woof! Woof!";
    }
    
    public function wagTail() {
        echo $this->name . " is wagging tail happily!";
    }
}

// Using inheritance
$myDog = new Dog("Buddy", 3);

// Dogs can do everything Animals can do:
$myDog->eat();    // Inherited from Animal
$myDog->sleep();  // Inherited from Animal

// PLUS their own special abilities:
$myDog->bark();     // Dog's own method
$myDog->wagTail();  // Dog's own method