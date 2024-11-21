<?php
// Include file koneksi database
include 'db_connect.php';

// Cek apakah ada ID pekerjaan yang diteruskan ke URL
if (isset($_GET['id_pekerjaan'])) {
    $id_pekerjaan = $_GET['id_pekerjaan'];

    // Cek apakah ID pekerjaan valid (angka)
    if (is_numeric($id_pekerjaan)) {
        // Persiapkan query untuk menghapus data pekerjaan
        $delete_query = "DELETE FROM pekerjaan WHERE id_pekerjaan = ?";
        $stmt = $conn->prepare($delete_query);

        // Cek apakah prepare berhasil
        if ($stmt) {
            // Bind parameter dan eksekusi statement
            $stmt->bind_param("i", $id_pekerjaan);
            $stmt->execute();

            // Cek apakah data berhasil dihapus
            if ($stmt->affected_rows > 0) {
                // Redirect ke halaman daftar pekerjaan setelah penghapusan berhasil
                header("Location: daftar_loker.php?message=Data%20Pekerjaan%20Berhasil%20Dihapus");
                exit;
            } else {
                echo "Data pekerjaan tidak ditemukan atau gagal dihapus.";
            }

            // Tutup statement
            $stmt->close();
        } else {
            echo "Query gagal dipersiapkan.";
        }
    } else {
        echo "ID pekerjaan tidak valid.";
    }
} else {
    echo "ID pekerjaan tidak diterima.";
}

// Tutup koneksi
$conn->close();
?>
