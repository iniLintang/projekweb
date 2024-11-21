<?php
// Koneksi ke database
$host = 'localhost'; // Ganti dengan host Anda
$dbname = 'lookwork2'; // Ganti dengan nama database Anda
$username = 'root'; // Ganti dengan username Anda
$password = ''; // Ganti dengan password Anda

$conn = new mysqli($host, $username, $password, $dbname);

// Check for connection error
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


?>
