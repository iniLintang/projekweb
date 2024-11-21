<?php
include('db_connect.php'); 
session_start();
// Ambil id_lamaran dari parameter URL
$id_lamaran = isset($_GET['id']) ? $_GET['id'] : null;

if ($id_lamaran) {
    // Query untuk mengambil data surat lamaran berdasarkan id_lamaran
    $sql = "SELECT l.id_lamaran, l.id_pekerjaan, l.id_pencari_kerja, l.status, l.deskripsi, l.tanggal_lamaran,
                   p.nama AS nama_pencari, p.email, p.telepon, p.cv_url, l.surat_lamaran
            FROM lamaran l
            JOIN pengguna p ON l.id_pencari_kerja = p.id_pengguna
            WHERE l.id_lamaran = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_lamaran]);
    $lamaran = $stmt->fetch();

    if ($lamaran) {
        // Tampilkan surat lamaran yang sesuai
        $surat_lamaran = nl2br(htmlspecialchars($lamaran['surat_lamaran'])); // Konversi newlines dan mencegah XSS
    } else {
        echo "Surat lamaran tidak ditemukan.";
        exit;
    }
} else {
    echo "ID lamaran tidak valid.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Lamaran</title>
</head>
<body>
    <h3>Surat Lamaran dari <?= htmlspecialchars($lamaran['nama_pencari']) ?></h3>
    
    <p><strong>Nama Pencari Kerja:</strong> <?= htmlspecialchars($lamaran['nama_pencari']) ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($lamaran['email']) ?></p>
    
    <h4>Isi Surat Lamaran:</h4>
    <div>
        <?= $surat_lamaran ?>
    </div>
    
    <a href="daftar_lamaran.html">Kembali ke Daftar Lamaran</a>
</body>
</html>
