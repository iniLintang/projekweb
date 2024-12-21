<?php
// Database connection settings
$server = "wstif23.myhost.id";
$user = "wstifmy1_kelas_int";
$password = "@Polije164Int";
$nama_database = "wstifmy1_int_team3";

try {
    // Create a new PDO connection
    $conn = new PDO("mysql:host=$server;dbname=$nama_database", $user, $password);
    
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

