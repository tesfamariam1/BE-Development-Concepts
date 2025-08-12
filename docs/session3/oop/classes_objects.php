<?php
// Class (blueprint)
class Car {
    // Properties (characteristics)
    public $brand;
    public $color;
    public $speed = 0;
    // Methods (actions)
    public function start() {
        echo "Car is starting!";
    }

    public function accelerate($amount) {
        $this->speed += $amount;
        echo "Speed increased to {$this->speed} km/h\n";
    }
    
    public function brake() {
        $this->speed = 0;
        echo "Car stopped!\n";
    }
}

// Creating objects (actual cars)
$myCar = new Car();
$myCar->brand = "Toyota";
$myCar->color = "Red";
$myCar->start();
$myCar->accelerate(50);
