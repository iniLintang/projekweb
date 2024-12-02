<?php
// Menghubungkan ke database
include('db.php'); // Pastikan koneksi ke database sudah benar

// Mengambil ID perusahaan dari URL
if (isset($_GET['id'])) {
    $id_perusahaan = $_GET['id'];

    // Mengambil data perusahaan berdasarkan ID menggunakan MySQLi
    $query = "SELECT * FROM perusahaan WHERE id_perusahaan = ?";
    $stmt = $conn->prepare($query); // Persiapkan statement
    $stmt->bind_param("i", $id_perusahaan); // Bind parameter (i untuk integer)

    $stmt->execute(); // Eksekusi query
    $result = $stmt->get_result(); // Ambil hasil query

    // Mengecek apakah data ditemukan
    if ($result->num_rows > 0) {
        $data_perusahaan = $result->fetch_assoc(); // Ambil data perusahaan
    } else {
        echo "ID Perusahaan tidak valid!";
        exit;
    }

    $stmt->close(); // Menutup statement
} else {
    echo "ID Perusahaan tidak ditemukan!";
    exit;
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Perusahaan</title>
    <!-- Bisa tambahkan link ke CSS jika diperlukan -->
</head>
<body>
    <div class="container mt-4">
        <h2>Profil Perusahaan</h2>

        <div class="card">
            <div class="card-body">
                <h4 class="card-title"><?php echo htmlspecialchars($data_perusahaan['nama_perusahaan']); ?></h4>
                <p><strong>Lokasi:</strong> <?php echo htmlspecialchars($data_perusahaan['lokasi_perusahaan']); ?></p>
                <p><strong>Industri:</strong> <?php echo htmlspecialchars($data_perusahaan['industri']); ?></p>
                <p><strong>Deskripsi:</strong> <?php echo nl2br(htmlspecialchars($data_perusahaan['deskripsi_perusahaan'])); ?></p>
            </div>
        </div>
        <a href="javascript:history.back()" class="btn btn-secondary">Kembali</a>
    </div>
</body>
</html>
