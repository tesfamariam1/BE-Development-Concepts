<?php
// Abstract class - like a template
abstract class Vehicle {
    protected $fuel;
    protected $speed = 0;
    
    // Concrete method - all vehicles have this
    public function addFuel($amount) {
        $this->fuel += $amount;
        echo "Added {$amount} units of fuel.";
    }
    
    // Abstract method - each vehicle must implement this differently
    abstract public function start();
    abstract public function accelerate();
}

// Car implements the abstract vehicle
class Car extends Vehicle {
    // Must implement abstract methods
    public function start() {
        echo "Turning key... Car engine started!";
    }
    
    public function accelerate() {
        $this->speed += 10;
        echo "Car accelerating... Speed: {$this->speed} mph";
    }
}

// Motorcycle implements the abstract vehicle
class Motorcycle extends Vehicle {
    // Must implement abstract methods
    public function start() {
        echo "Pressing button... Motorcycle started! 🏍️";
    }
    
    public function accelerate() {
        $this->speed += 15;  // Motorcycles accelerate faster!
        echo "Motorcycle accelerating... Speed: {$this->speed} mph";
    }
}

// Using abstraction
$myCar = new Car();
$myBike = new Motorcycle();

// Simple interface, complex implementation hidden
$myCar->start();        // Different starting process
$myCar->accelerate();   // Different acceleration

$myBike->start();       // Different starting process  
$myBike->accelerate();  // Different acceleration