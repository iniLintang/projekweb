<?php
include 'db_connect.php'; 
session_start();

// Ensure the logged-in company ID is retrieved from the session
$id_perusahaan = $_SESSION['id_perusahaan']; // Example session value for the logged-in company

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the posted values
    $id_pekerjaan = $_POST['id_pekerjaan'];
    $judul_pekerjaan = $_POST['judul_pekerjaan'];
    $deskripsi = $_POST['deskripsi'];
    $lokasi = $_POST['lokasi'];
    $jenis_pekerjaan = $_POST['jenis_pekerjaan'];
    $tipe_kerja = $_POST['tipe_kerja'];
    $gaji_dari = $_POST['gaji_dari'];
    $gaji_hingga = $_POST['gaji_hingga'];
    $id_kategori = $_POST['id_kategori'];

    // Create a connection using MySQLi
    $conn = new mysqli('localhost', 'root', '', 'lookwork2');

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare the SQL update statement
    $query = "UPDATE pekerjaan 
              SET judul_pekerjaan = ?, deskripsi = ?, lokasi = ?, jenis_pekerjaan = ?, tipe_kerja = ?, gaji_dari = ?, gaji_hingga = ?, id_kategori = ? 
              WHERE id_pekerjaan = ? AND id_perusahaan = ?";

    // Prepare the statement
    if ($stmt = $conn->prepare($query)) {
        // Bind parameters: adjust types for each column based on your table definition
        $stmt->bind_param("sssssdiis", $judul_pekerjaan, $deskripsi, $lokasi, $jenis_pekerjaan, $tipe_kerja, $gaji_dari, $gaji_hingga, $id_kategori, $id_pekerjaan, $id_perusahaan);

        // Execute the query
        if ($stmt->execute()) {
            // Redirect if successful
            header('Location: daftar_loker.php');
            exit;
        } else {
            echo "Error executing query: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }

    // Close the connection
    $conn->close();
}
?>
