<?php
include('db.php');
session_start();

// Cek apakah ID perusahaan ada di URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_perusahaan = $_GET['id'];

    // Query untuk menghapus perusahaan berdasarkan ID
    $sql = "DELETE FROM perusahaan WHERE id_perusahaan = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_perusahaan); // "i" untuk integer
    if ($stmt->execute()) {
        echo "Perusahaan berhasil dihapus.";
        header("Location: data-perusahaan.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
    
} else {
    echo "ID perusahaan tidak valid!";
}
?>
