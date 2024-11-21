<?php
// Database connection settings
$host = 'localhost';   // Your database host
$dbname = 'lookwork2';   // Your database name
$username = 'root';   // Your database username
$password = '';   // Your database password

try {
    // Create a new PDO connection
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Optionally, test if the connection is successful
    // echo "Connected successfully";
} catch (PDOException $e) {
    // Handle connection error
    echo "Connection failed: " . $e->getMessage();
    exit;
}
?>
