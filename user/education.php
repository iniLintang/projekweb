<?php
session_start();
require 'db_connect.php';

if (!isset($_SESSION['pengguna_id'])) {
    header("Location: login.php");
    exit();
}

$id_pengguna = $_SESSION['pengguna_id'];

// Ambil data pendidikan
$query = $conn->prepare("SELECT * FROM pendidikan WHERE id_pencari_kerja = ?");
$query->bind_param("i", $id_pengguna);
$query->execute();
$pendidikan = $query->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pendidikan</title>
</head>
<body>
    <h1>Kelola Pendidikan</h1>
    <form action="process.php" method="POST">
        <input type="hidden" name="action" value="add_education">
        <label>Institusi:</label>
        <input type="text" name="institusi" required><br>
        <label>Gelar:</label>
        <input type="text" name="gelar" required><br>
        <label>Bidang Studi:</label>
        <input type="text" name="bidang_studi" required><br>
        <label>Tahun Mulai:</label>
        <input type="number" name="tahun_mulai" required><br>
        <label>Tahun Selesai:</label>
        <input type="number" name="tahun_selesai"><br>
        <button type="submit">Tambah</button>
    </form>

    <h2>Daftar Pendidikan</h2>
    <table border="1">
        <tr>
            <th>Institusi</th>
            <th>Gelar</th>
            <th>Bidang Studi</th>
            <th>Tahun Mulai</th>
            <th>Tahun Selesai</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = $pendidikan->fetch_assoc()): ?>
            <tr>
                <form action="process.php" method="POST">
                    <input type="hidden" name="action" value="update_education">
                    <input type="hidden" name="id_pendidikan" value="<?= $row['id_pendidikan']; ?>">
                    <td><input type="text" name="institusi" value="<?= $row['institusi']; ?>"></td>
                    <td><input type="text" name="gelar" value="<?= $row['gelar']; ?>"></td>
                    <td><input type="text" name="bidang_studi" value="<?= $row['bidang_studi']; ?>"></td>
                    <td><input type="number" name="tahun_mulai" value="<?= $row['tahun_mulai']; ?>"></td>
                    <td><input type="number" name="tahun_selesai" value="<?= $row['tahun_selesai']; ?>"></td>
                    <td>
                        <button type="submit">Update</button>
                        <a href="process.php?action=delete_education&id_pendidikan=<?= $row['id_pendidikan']; ?>">Hapus</a>
                    </td>
                </form>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
