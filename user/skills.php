<?php
session_start();
require 'db_connect.php';

if (!isset($_SESSION['pengguna_id'])) {
    header("Location: login.php");
    exit();
}

$id_pengguna = $_SESSION['pengguna_id'];

// Ambil data keterampilan
$query = $conn->prepare("SELECT * FROM keterampilan WHERE id_pencari_kerja = ?");
$query->bind_param("i", $id_pengguna);
$query->execute();
$keterampilan = $query->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Keterampilan</title>
</head>
<body>
    <h1>Kelola Keterampilan</h1>
    <form action="process.php" method="POST">
        <input type="hidden" name="action" value="add_skill">
        <label>Nama Keterampilan:</label>
        <input type="text" name="nama_keterampilan" required><br>
        <label>Sertifikat URL:</label>
        <input type="url" name="sertifikat_url"><br>
        <button type="submit">Tambah</button>
    </form>

    <h2>Daftar Keterampilan</h2>
    <table border="1">
        <tr>
            <th>Nama Keterampilan</th>
            <th>Sertifikat</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = $keterampilan->fetch_assoc()): ?>
            <tr>
                <form action="process.php" method="POST">
                    <input type="hidden" name="action" value="update_skill">
                    <input type="hidden" name="id_keterampilan" value="<?= $row['id_keterampilan']; ?>">
                    <td><input type="text" name="nama_keterampilan" value="<?= $row['nama_keterampilan']; ?>"></td>
                    <td><input type="url" name="sertifikat_url" value="<?= $row['sertifikat_url']; ?>"></td>
                    <td>
                        <button type="submit">Update</button>
                        <a href="process.php?action=delete_skill&id_keterampilan=<?= $row['id_keterampilan']; ?>">Hapus</a>
                    </td>
                </form>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
