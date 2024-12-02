<?php
include('db.php');
session_start();

// Cek apakah ID pekerjaan ada di URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_pekerjaan = $_GET['id'];

    // Query untuk menghapus pekerjaan berdasarkan ID
    $sql = "DELETE FROM pekerjaan WHERE id_pekerjaan = '$id_pekerjaan'";

    if ($conn->query($sql) === TRUE) {
        echo "Pekerjaan berhasil dihapus.";
        header("Location: data-pekerjaan.php"); // Redirect ke halaman daftar pekerjaan setelah menghapus
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "ID pekerjaan tidak valid!";
}
?>
