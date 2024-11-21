<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "lookwork2";

// Buat koneksi
$db = new mysqli($servername, $username, $password, $database);

// Cek koneksi
if ($db->connect_error) {
    die("Koneksi gagal: " . $db->connect_error);
}
?>
