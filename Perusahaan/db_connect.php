<?php
// Koneksi ke database
$server = "wstif23.myhost.id";
$user = "wstifmy1_kelas_int";
$password = "@Polije164Int";
$nama_database = "wstifmy1_int_team3";


// Buat koneksi
$conn = new mysqli($server, $user, $password, $nama_database);

// Check for connection error
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


?>
