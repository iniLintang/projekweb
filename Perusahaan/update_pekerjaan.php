<?php
include 'db_connect.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_pekerjaan = $_POST['id_pekerjaan'];
    $judul_pekerjaan = $_POST['judul_pekerjaan'];
    $deskripsi = $_POST['deskripsi'];
    $lokasi = $_POST['lokasi'];
    $jenis_pekerjaan = $_POST['jenis_pekerjaan'];
    $tipe_kerja = $_POST['tipe_kerja'];
    $gaji_dari = $_POST['gaji_dari'];
    $gaji_hingga = $_POST['gaji_hingga'];
    $id_kategori = $_POST['id_kategori'];
    $id_perusahaan = 1; // Replace with the actual session value for logged-in company

    $query = $pdo->prepare("UPDATE pekerjaan SET judul_pekerjaan = :judul_pekerjaan, deskripsi = :deskripsi, lokasi = :lokasi, jenis_pekerjaan = :jenis_pekerjaan, tipe_kerja = :tipe_kerja, gaji_dari = :gaji_dari, gaji_hingga = :gaji_hingga, id_kategori = :id_kategori WHERE id_pekerjaan = :id_pekerjaan AND id_perusahaan = :id_perusahaan");

    $query->execute([
        'judul_pekerjaan' => $judul_pekerjaan,
        'deskripsi' => $deskripsi,
        'lokasi' => $lokasi,
        'jenis_pekerjaan' => $jenis_pekerjaan,
        'tipe_kerja' => $tipe_kerja,
        'gaji_dari' => $gaji_dari,
        'gaji_hingga' => $gaji_hingga,
        'id_kategori' => $id_kategori,
        'id_pekerjaan' => $id_pekerjaan,
        'id_perusahaan' => $id_perusahaan
    ]);

    header('Location: daftar_loker.php');
    exit;
}
?>
