<?php
ob_start(); // Tangkap semua output tambahan
header('Content-Type: application/json'); // Pastikan output berupa JSON
error_reporting(E_ERROR | E_PARSE); // Hanya laporkan error penting

// Konfigurasi database
$server = "wstif23.myhost.id";
$user = "wstifmy1_kelas_int";
$password = "@Polije164Int";
$nama_database = "wstifmy1_int_team3";


// Buat koneksi
$conn = new mysqli($server, $user, $password, $nama_database);

// Periksa koneksi
if ($conn->connect_error) {
    ob_end_clean();
    echo json_encode(array("status" => "error", "message" => "Koneksi gagal: " . $conn->connect_error));
    exit();
}

// Mendapatkan data dari POST
$id_pencari_kerja = isset($_POST['id_pencari_kerja']) ? $_POST['id_pencari_kerja'] : null;
$judul_pekerjaan = isset($_POST['judul_pekerjaan']) ? $_POST['judul_pekerjaan'] : null;
$link = isset($_POST['link']) ? $_POST['link'] : null;

// Periksa apakah semua data telah diisi
if (!$id_pencari_kerja || !$judul_pekerjaan || !$link) {
    ob_end_clean();
    echo json_encode(array("status" => "error", "message" => "Semua data wajib diisi"));
    $conn->close();
    exit();
}

// Validasi id_pencari_kerja
$stmt = $conn->prepare("SELECT id_pencari_kerja FROM pencari_kerja WHERE id_pencari_kerja = ?");
$stmt->bind_param("i", $id_pencari_kerja);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    ob_end_clean();
    echo json_encode(array("status" => "error", "message" => "Pencari kerja tidak ditemukan"));
    $conn->close();
    exit();
}

// Validasi pekerjaan berdasarkan judul
$stmt = $conn->prepare("SELECT id_pekerjaan FROM pekerjaan WHERE judul_pekerjaan = ?");
$stmt->bind_param("s", $judul_pekerjaan);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    ob_end_clean();
    echo json_encode(array("status" => "error", "message" => "Pekerjaan dengan judul tersebut tidak ditemukan"));
    $conn->close();
    exit();
}

$pekerjaan = $result->fetch_assoc();
$id_pekerjaan = $pekerjaan['id_pekerjaan'];

// Simpan data lamaran
$stmt = $conn->prepare("INSERT INTO lamaran (id_pencari_kerja, id_pekerjaan, link, status) VALUES (?, ?, ?, 'dikirim')");
$stmt->bind_param("iis", $id_pencari_kerja, $id_pekerjaan, $link);

if ($stmt->execute()) {
    ob_end_clean();
    echo json_encode(array("status" => "success", "message" => "Data berhasil disimpan"));
} else {
    ob_end_clean();
    echo json_encode(array("status" => "error", "message" => "Gagal menyimpan data"));
}

$conn->close();
?>