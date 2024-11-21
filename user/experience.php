<?php
session_start();
require 'db_connect.php';

if (!isset($_SESSION['pengguna_id'])) {
    header("Location: login.php");
    exit();
}

$id_pengguna = $_SESSION['pengguna_id'];

// Ambil data pengalaman
$query = $conn->prepare("SELECT * FROM pengalaman WHERE id_pencari_kerja = ?");
$query->bind_param("i", $id_pengguna);
$query->execute();
$pengalaman = $query->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pengalaman</title>
</head>
<body>
    <h1>Kelola Pengalaman</h1>

    <!-- Form Tambah Pengalaman -->
    <form action="process.php" method="POST">
        <input type="hidden" name="action" value="add_experience">
        <label>Nama Institusi:</label>
        <input type="text" name="nama_institusi" required><br>

        <label>Jenis Pengalaman:</label>
        <select name="jenis_pengalaman" required>
            <option value="pekerjaan">Pekerjaan</option>
            <option value="magang">Magang</option>
            <option value="sukarela">Sukarela</option>
            <option value="organisasi">Organisasi</option>
            <option value="lainnya">Lainnya</option>
        </select><br>

        <label>Tanggal Mulai:</label>
        <input type="date" name="tanggal_mulai" required><br>

        <label>Tanggal Selesai:</label>
        <input type="date" name="tanggal_selesai"><br>

        <label>Deskripsi Pengalaman:</label>
        <textarea name="deskripsi_pengalaman" rows="4" cols="50" required></textarea><br>

        <button type="submit">Tambah</button>
    </form>

    <h2>Daftar Pengalaman</h2>
    <table border="1">
        <tr>
            <th>Nama Institusi</th>
            <th>Jenis Pengalaman</th>
            <th>Tanggal Mulai</th>
            <th>Tanggal Selesai</th>
            <th>Deskripsi</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = $pengalaman->fetch_assoc()): ?>
            <tr>
                <!-- Form Update Pengalaman -->
                <form action="process.php" method="POST">
                    <input type="hidden" name="action" value="update_experience">
                    <input type="hidden" name="id_pengalaman" value="<?= $row['id_pengalaman']; ?>">
                    <td><input type="text" name="nama_institusi" value="<?= htmlspecialchars($row['nama_institusi']); ?>"></td>
                    <td>
                        <select name="jenis_pengalaman">
                            <option value="pekerjaan" <?= $row['jenis_pengalaman'] === 'pekerjaan' ? 'selected' : ''; ?>>Pekerjaan</option>
                            <option value="magang" <?= $row['jenis_pengalaman'] === 'magang' ? 'selected' : ''; ?>>Magang</option>
                            <option value="sukarela" <?= $row['jenis_pengalaman'] === 'sukarela' ? 'selected' : ''; ?>>Sukarela</option>
                            <option value="organisasi" <?= $row['jenis_pengalaman'] === 'organisasi' ? 'selected' : ''; ?>>Organisasi</option>
                            <option value="lainnya" <?= $row['jenis_pengalaman'] === 'lainnya' ? 'selected' : ''; ?>>Lainnya</option>
                        </select>
                    </td>
                    <td><input type="date" name="tanggal_mulai" value="<?= $row['tanggal_mulai']; ?>"></td>
                    <td><input type="date" name="tanggal_selesai" value="<?= $row['tanggal_selesai']; ?>"></td>
                    <td><textarea name="deskripsi_pengalaman" rows="2" cols="40"><?= htmlspecialchars($row['deskripsi_pengalaman']); ?></textarea></td>
                    <td>
                        <button type="submit">Update</button>
                        <a href="process.php?action=delete_experience&id_pengalaman=<?= $row['id_pengalaman']; ?>">Hapus</a>
                    </td>
                </form>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
