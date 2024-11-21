<?php
session_start();

// Cek apakah pengguna sudah login sebagai perusahaan
if (!isset($_SESSION['peran']) || $_SESSION['peran'] !== 'perusahaan') {
    echo "Silahkan login sebagai perusahaan untuk mengakses halaman ini.";
    exit;  // Jika pengguna belum login, hentikan eksekusi script
}

// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lookwork2";

$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil ID pengguna dari sesi
$id_pengguna = $_SESSION['pengguna_id'];

// Dapatkan id_perusahaan berdasarkan id_pengguna
$sql_perusahaan = "SELECT id_perusahaan FROM perusahaan WHERE id_pengguna = ?";
$stmt_perusahaan = $conn->prepare($sql_perusahaan);
$stmt_perusahaan->bind_param("i", $id_pengguna);
$stmt_perusahaan->execute();
$result_perusahaan = $stmt_perusahaan->get_result();
$id_perusahaan = $result_perusahaan->fetch_assoc()['id_perusahaan'];

// Ambil data pekerjaan berdasarkan ID perusahaan
$sql = "
    SELECT 
        p.id_pekerjaan, 
        p.judul_pekerjaan, 
        p.deskripsi, 
        p.lokasi, 
        p.jenis_pekerjaan, 
        p.tipe_kerja, 
        p.gaji_dari, 
        p.gaji_hingga, 
        p.tanggal_posting, 
        k.nama_kategori
    FROM pekerjaan p
    JOIN kategori_pekerjaan k ON p.id_kategori = k.id_kategori
    WHERE p.id_perusahaan = ?
";
$stmt = $conn->prepare($sql);

// Cek jika query berhasil
if (!$stmt) {
    die("Error dalam persiapan statement: " . $conn->error);
}

$stmt->bind_param("i", $id_perusahaan);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Perusahaan_LookWork</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="img/favicon.ico" rel="icon">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2>Daftar Pekerjaan</h2>
    <div class="text mb-3">
        <a href="tambah_pekerjaan.php" class="btn btn-primary">Tambah Pekerjaan</a>
    </div>

    <div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nama Pekerjaan</th>
                <th>Deskripsi</th>
                <th>Lokasi</th>
                <th>Jenis Pekerjaan</th>
                <th>Tipe Kerja</th>
                <th>Gaji (Dari)</th>
                <th>Gaji (Hingga)</th>
                <th>Kategori Pekerjaan</th>
                <th>Tanggal Posting</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php
            // Check if any jobs were found
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['judul_pekerjaan']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['deskripsi']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['lokasi']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['jenis_pekerjaan']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['tipe_kerja']) . "</td>";
                    echo "<td>Rp " . number_format($row['gaji_dari'], 2, ',', '.') . "</td>";
                    echo "<td>Rp " . number_format($row['gaji_hingga'], 2, ',', '.') . "</td>";
                    echo "<td>" . htmlspecialchars($row['nama_kategori']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['tanggal_posting']) . "</td>";
                    echo "<td>
                        <a href='edit_pekerjaan.php?id_pekerjaan=" . $row['id_pekerjaan'] . "' class='btn btn-primary'>Edit</a>
                        <a href='hapus_pekerjaan.php?id_pekerjaan=" . $row['id_pekerjaan'] . "' class='btn btn-danger' onclick='return confirm(\"Apakah Anda yakin ingin menghapus pekerjaan ini?\")'>Hapus</a>
                    </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='10'>Tidak ada pekerjaan yang ditemukan.</td></tr>";
            }
            ?>

        </tbody>
    </table>
</div>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>

</body>
</html>

<?php
// Tutup koneksi
$conn->close();
?>
