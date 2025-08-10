<?php
echo "<h1>🎯 Variable Scope Explained</h1>";

// GLOBAL SCOPE
$globalMessage = "I am a global variable";
$globalCounter = 0;

function demonstrateScope() {
    // LOCAL SCOPE
    $localMessage = "I am a local variable";
    
    // Accessing global variable inside function
    global $globalMessage, $globalCounter;
    $globalCounter++;
    
    echo "<h3>🏠 Inside Function:</h3>";
    echo "Local: $localMessage<br>";
    echo "Global: $globalMessage<br>";
    echo "Counter: $globalCounter<br><br>";
}

echo "<h2>🌍 Global Scope Test</h2>";
echo "Before function call - Counter: $globalCounter<br>";

demonstrateScope();
demonstrateScope();

echo "After function calls - Counter: $globalCounter<br><br>";

// STATIC VARIABLES
function countCalls() {
    static $callCount = 0;
    $regularVar = 0;
    
    $callCount++;
    $regularVar++;
    
    echo "📞 Function called $callCount times<br>";
    echo "Regular variable: $regularVar<br><br>";
}

echo "<h2>📊 Static Variables</h2>";
countCalls();
countCalls();
countCalls();
?>