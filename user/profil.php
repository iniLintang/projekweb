<?php
session_start();
require 'db_connect.php'; // File koneksi ke database

// Cek apakah pengguna telah login
if (!isset($_SESSION['pengguna_id'])) {
    header("Location: login.php");
    exit();
}

$id_pengguna = $_SESSION['pengguna_id'];

// Ambil data pengguna
$query = $conn->prepare("
    SELECT nama, email, username, foto_profil, peran 
    FROM pengguna 
    WHERE id_pengguna = ?");
$query->bind_param("i", $id_pengguna);
$query->execute();
$result = $query->get_result();
$user = $result->fetch_assoc();

// Ambil data pendidikan
$query_pendidikan = $conn->prepare("
    SELECT * FROM pendidikan 
    WHERE id_pencari_kerja = ?");
$query_pendidikan->bind_param("i", $id_pengguna);
$query_pendidikan->execute();
$pendidikan = $query_pendidikan->get_result();

// Ambil data pengalaman
$query_pengalaman = $conn->prepare("
    SELECT * FROM pengalaman 
    WHERE id_pencari_kerja = ?");
$query_pengalaman->bind_param("i", $id_pengguna);
$query_pengalaman->execute();
$pengalaman = $query_pengalaman->get_result();

// Ambil data keterampilan
$query_keterampilan = $conn->prepare("
    SELECT * FROM keterampilan 
    WHERE id_pencari_kerja = ?");
$query_keterampilan->bind_param("i", $id_pengguna);
$query_keterampilan->execute();
$keterampilan = $query_keterampilan->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pengguna</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Profil Pengguna</h1>
    <div class="profile">
        <img src="<?= $user['foto_profil'] ? 'uploads/' . $user['foto_profil'] : 'default.png'; ?>" alt="Foto Profil" width="150">
        <p><strong>Nama:</strong> <?= htmlspecialchars($user['nama']); ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($user['email']); ?></p>
        <p><strong>Username:</strong> <?= htmlspecialchars($user['username']); ?></p>
        <p><strong>Peran:</strong> <?= htmlspecialchars($user['peran']); ?></p>
    </div>

    <h2>Pendidikan</h2>
    <ul>
        <?php while ($row = $pendidikan->fetch_assoc()): ?>
            <li><?= htmlspecialchars($row['institusi']); ?> (<?= htmlspecialchars($row['tahun_mulai']); ?> - <?= htmlspecialchars($row['tahun_selesai']); ?>)</li>
        <?php endwhile; ?>
    </ul>

    <h2>Pengalaman</h2>
    <ul>
        <?php while ($row = $pengalaman->fetch_assoc()): ?>
            <li><?= htmlspecialchars($row['nama_institusi']); ?> - <?= htmlspecialchars($row['jenis_pengalaman']); ?> (<?= htmlspecialchars($row['tanggal_mulai']); ?> - <?= htmlspecialchars($row['tanggal_selesai']); ?>)</li>
        <?php endwhile; ?>
    </ul>

    <h2>Keterampilan</h2>
    <ul>
        <?php while ($row = $keterampilan->fetch_assoc()): ?>
            <li><?= htmlspecialchars($row['nama_keterampilan']); ?></li>
        <?php endwhile; ?>
    </ul>

    <h2>Kelola Data</h2>
<ul>
    <li><a href="update_profile.php">Edit Profil</a></li>
    <li><a href="education.php">Kelola Pendidikan</a></li>
    <li><a href="experience.php">Kelola Pengalaman</a></li>
    <li><a href="skills.php">Kelola Keterampilan</a></li>
</ul>

</body>
</html>
