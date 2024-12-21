<?php
$server = "wstif23.myhost.id";
$user = "wstifmy1_kelas_int";
$password = "@Polije164Int";
$nama_database = "wstifmy1_int_team3";


// Buat koneksi
$db = new mysqli($server, $user, $password, $nama_database);

// Cek koneksi
if ($db->connect_error) {
    die("Koneksi gagal: " . $db->connect_error);
}
?>
