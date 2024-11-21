<?php
require 'db_connect.php';
session_start();

// Periksa apakah pengguna sudah login
$id_pengguna = $_SESSION['pengguna_id'] ?? null;

if (!$id_pengguna) {
    header("Location: login.php");
    exit();
}

// Dapatkan aksi
$action = $_POST['action'] ?? $_GET['action'] ?? '';

try {
    switch ($action) {
        case 'add_education':
            $query = $conn->prepare("
                INSERT INTO pendidikan (id_pencari_kerja, institusi, gelar, bidang_studi, tahun_mulai, tahun_selesai) 
                VALUES (?, ?, ?, ?, ?, ?)");
            $query->bind_param("isssii", $id_pengguna, $_POST['institusi'], $_POST['gelar'], $_POST['bidang_studi'], $_POST['tahun_mulai'], $_POST['tahun_selesai']);
            break;

        case 'update_education':
            $query = $conn->prepare("
                UPDATE pendidikan 
                SET institusi = ?, gelar = ?, bidang_studi = ?, tahun_mulai = ?, tahun_selesai = ? 
                WHERE id_pendidikan = ?");
            $query->bind_param("sssiii", $_POST['institusi'], $_POST['gelar'], $_POST['bidang_studi'], $_POST['tahun_mulai'], $_POST['tahun_selesai'], $_POST['id_pendidikan']);
            break;

        case 'delete_education':
            $query = $conn->prepare("DELETE FROM pendidikan WHERE id_pendidikan = ?");
            $query->bind_param("i", $_GET['id_pendidikan']);
            break;

        case 'add_experience':
            $query = $conn->prepare("
                INSERT INTO pengalaman (id_pencari_kerja, nama_institusi, jenis_pengalaman, tanggal_mulai, tanggal_selesai, deskripsi_pengalaman) 
                VALUES (?, ?, ?, ?, ?, ?)");
            $query->bind_param(
                "isssss", 
                $id_pengguna, 
                $_POST['nama_institusi'], 
                $_POST['jenis_pengalaman'], 
                $_POST['tanggal_mulai'], 
                $_POST['tanggal_selesai'], 
                $_POST['deskripsi_pengalaman']
            );
            break;

        case 'update_experience':
            $query = $conn->prepare("
                UPDATE pengalaman 
                SET nama_institusi = ?, jenis_pengalaman = ?, tanggal_mulai = ?, tanggal_selesai = ?, deskripsi_pengalaman = ? 
                WHERE id_pengalaman = ?");
            $query->bind_param(
                "sssssi", 
                $_POST['nama_institusi'], 
                $_POST['jenis_pengalaman'], 
                $_POST['tanggal_mulai'], 
                $_POST['tanggal_selesai'], 
                $_POST['deskripsi_pengalaman'], 
                $_POST['id_pengalaman']
            );
            break;

        case 'delete_experience':
            $query = $conn->prepare("DELETE FROM pengalaman WHERE id_pengalaman = ?");
            $query->bind_param("i", $_GET['id_pengalaman']);
            break;

        case 'add_skill':
            $query = $conn->prepare("
                INSERT INTO keterampilan (id_pencari_kerja, nama_keterampilan, sertifikat_url) 
                VALUES (?, ?, ?)");
            $query->bind_param("iss", $id_pengguna, $_POST['nama_keterampilan'], $_POST['sertifikat_url']);
            break;

        case 'update_skill':
            $query = $conn->prepare("
                UPDATE keterampilan 
                SET nama_keterampilan = ?, sertifikat_url = ? 
                WHERE id_keterampilan = ?");
            $query->bind_param("ssi", $_POST['nama_keterampilan'], $_POST['sertifikat_url'], $_POST['id_keterampilan']);
            break;

        case 'delete_skill':
            $query = $conn->prepare("DELETE FROM keterampilan WHERE id_keterampilan = ?");
            $query->bind_param("i", $_GET['id_keterampilan']);
            break;

        default:
            throw new Exception("Aksi tidak valid!");
    }

    // Eksekusi query jika tersedia
    if (isset($query) && $query->execute()) {
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit();
    } else {
        throw new Exception("Operasi gagal!");
    }
} catch (Exception $e) {
    // Tampilkan error jika ada
    echo "Error: " . $e->getMessage();
}
