<?php
// Sertakan file koneksi database
include 'db_connect.php';

// Ambil data kategori pekerjaan dari tabel 'kategori_pekerjaan'
$query_kategori = "SELECT * FROM kategori_pekerjaan";
$result_kategori = $conn->query($query_kategori);
$kategori_pekerjaan = $result_kategori->fetch_all(MYSQLI_ASSOC);

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

// Proses jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_perusahaan = $_POST['id_perusahaan'];
    $id_kategori = $_POST['id_kategori'];
    $judul_pekerjaan = $_POST['judul_pekerjaan'];
    $deskripsi = $_POST['deskripsi'];
    $lokasi = $_POST['lokasi'];
    $jenis_pekerjaan = $_POST['jenis_pekerjaan'];
    $tipe_kerja = $_POST['tipe_kerja'];
    $gaji_dari = $_POST['gaji_dari'];
    $gaji_hingga = $_POST['gaji_hingga'];

    // Update data pekerjaan di database
    $update_query = "UPDATE pekerjaan SET 
                     id_perusahaan = ?, 
                     id_kategori = ?, 
                     judul_pekerjaan = ?, 
                     deskripsi = ?, 
                     lokasi = ?, 
                     jenis_pekerjaan = ?, 
                     tipe_kerja = ?, 
                     gaji_dari = ?, 
                     gaji_hingga = ? 
                     WHERE id_pekerjaan = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("iissssddii", $id_perusahaan, $id_kategori, $judul_pekerjaan, $deskripsi, $lokasi, $jenis_pekerjaan, $tipe_kerja, $gaji_dari, $gaji_hingga, $id_pekerjaan);
    $stmt->execute();

    // Redirect ke halaman lain setelah update berhasil
    header("Location: daftar_loker.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pekerjaan</title>
</head>
<body>
    <h2>Edit Pekerjaan</h2>
    <form method="POST">
        <label for="id_perusahaan">Perusahaan:</label>
        <input type="number" name="id_perusahaan" value="<?= htmlspecialchars($pekerjaan['id_perusahaan']) ?>" required><br>

        <label for="id_kategori">Kategori Pekerjaan:</label>
        <select name="id_kategori" required>
            <?php foreach ($kategori_pekerjaan as $kategori): ?>
                <option value="<?= htmlspecialchars($kategori['id_kategori']) ?>" <?= $pekerjaan['id_kategori'] == $kategori['id_kategori'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($kategori['nama_kategori']) ?>
                </option>
            <?php endforeach; ?>
        </select><br>

        <label for="judul_pekerjaan">Judul Pekerjaan:</label>
        <input type="text" name="judul_pekerjaan" value="<?= htmlspecialchars($pekerjaan['judul_pekerjaan']) ?>" required><br>

        <label for="deskripsi">Deskripsi:</label>
        <textarea name="deskripsi" required><?= htmlspecialchars($pekerjaan['deskripsi']) ?></textarea><br>

        <label for="lokasi">Lokasi:</label>
        <input type="text" name="lokasi" value="<?= htmlspecialchars($pekerjaan['lokasi']) ?>" required><br>

        <label for="jenis_pekerjaan">Jenis Pekerjaan:</label>
        <select name="jenis_pekerjaan" required>
            <option value="full_time" <?= $pekerjaan['jenis_pekerjaan'] == 'full_time' ? 'selected' : '' ?>>Full Time</option>
            <option value="part_time" <?= $pekerjaan['jenis_pekerjaan'] == 'part_time' ? 'selected' : '' ?>>Part Time</option>
            <option value="freelance" <?= $pekerjaan['jenis_pekerjaan'] == 'freelance' ? 'selected' : '' ?>>Freelance</option>
            <option value="internship" <?= $pekerjaan['jenis_pekerjaan'] == 'internship' ? 'selected' : '' ?>>Internship</option>
        </select><br>

        <label for="tipe_kerja">Tipe Kerja:</label>
        <select name="tipe_kerja" required>
            <option value="remote" <?= $pekerjaan['tipe_kerja'] == 'remote' ? 'selected' : '' ?>>Remote</option>
            <option value="wfo" <?= $pekerjaan['tipe_kerja'] == 'wfo' ? 'selected' : '' ?>>WFO</option>
            <option value="hybrid" <?= $pekerjaan['tipe_kerja'] == 'hybrid' ? 'selected' : '' ?>>Hybrid</option>
        </select><br>

        <label for="gaji_dari">Gaji Dari:</label>
        <input type="number" name="gaji_dari" step="0.01" value="<?= htmlspecialchars($pekerjaan['gaji_dari']) ?>"><br>

        <label for="gaji_hingga">Gaji Hingga:</label>
        <input type="number" name="gaji_hingga" step="0.01" value="<?= htmlspecialchars($pekerjaan['gaji_hingga']) ?>" required><br>

        <button type="submit">Simpan Perubahan</button>
    </form>
</body>
</html>
