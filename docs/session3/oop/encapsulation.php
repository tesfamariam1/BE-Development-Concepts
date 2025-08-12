<?php
class BankAccount {
    private $balance = 1000;        // PRIVATE - hidden from outside
    private $accountNumber = "123"; // PRIVATE - hidden from outside
    public $ownerName = "John";     // PUBLIC - anyone can see
    
    // PUBLIC method - safe way to access private data
    public function checkBalance() {
        return "Your balance is: $" . $this->balance;
    }
    
    // PUBLIC method - safe way to change private data
    public function deposit($amount) {
        if ($amount > 0) {  // Safety check!
            $this->balance += $amount;
            echo "Deposited $" . $amount;
        } else {
            echo "Invalid amount!";
        }
    }
}

// Object
$myAccount = new BankAccount();

// This works - using public methods
echo $myAccount->checkBalance();  // "Your balance is: $1000"
$myAccount->deposit(100);

// This would cause an ERROR - trying to access private data
// echo $myAccount->balance;  // Can't do this!