<?php
// Sertakan file koneksi database
include 'db_connect.php';
session_start();

// Cek apakah ada ID pekerjaan yang diteruskan ke URL
if (isset($_GET['id_pekerjaan'])) {
    $id_pekerjaan = $_GET['id_pekerjaan'];

    // Ambil data pekerjaan berdasarkan ID
    $query = "SELECT * FROM pekerjaan WHERE id_pekerjaan = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_pekerjaan);
    $stmt->execute();
    $result = $stmt->get_result();
    $pekerjaan = $result->fetch_assoc();

    // Jika pekerjaan tidak ditemukan
    if (!$pekerjaan) {
        echo "Pekerjaan tidak ditemukan.";
        exit;
    }
} else {
    echo "ID pekerjaan tidak diterima.";
    exit;
}

// Ambil data kategori pekerjaan dari tabel 'kategori_pekerjaan'
$query_kategori = "SELECT * FROM kategori_pekerjaan";
$result_kategori = $conn->query($query_kategori);
$kategori_pekerjaan = $result_kategori->fetch_all(MYSQLI_ASSOC);

// Proses jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $id_perusahaan = $_POST['id_perusahaan'];
    $id_kategori = implode(',', $_POST['kategori']); // Menggabungkan kategori yang dipilih
    $judul_pekerjaan = $_POST['judul_pekerjaan'];
    $deskripsi = $_POST['deskripsi'];
    $lokasi = $_POST['lokasi'];
    $jenis_pekerjaan = $_POST['jenis_pekerjaan'];
    $gaji_dari = $_POST['gaji_dari'];
    $gaji_hingga = $_POST['gaji_hingga'];

    // Proses update data pekerjaan
    $update_query = "UPDATE pekerjaan SET 
                     id_perusahaan = ?, 
                     id_kategori = ?, 
                     judul_pekerjaan = ?, 
                     deskripsi = ?, 
                     lokasi = ?, 
                     jenis_pekerjaan = ?, 
                     gaji_dari = ?, 
                     gaji_hingga = ? 
                     WHERE id_pekerjaan = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("iissssdii", $id_perusahaan, $id_kategori, $judul_pekerjaan, $deskripsi, $lokasi, $jenis_pekerjaan, $gaji_dari, $gaji_hingga, $id_pekerjaan);
    $stmt->execute();

    // Cek apakah query berhasil
    if ($stmt->affected_rows > 0) {
        echo "Data berhasil diperbarui.";
    } else {
        echo "Terjadi kesalahan atau data tidak berubah.";
    }

    // Redirect setelah update
    header("Location: daftar_loker.php");
    exit;
}
?>
