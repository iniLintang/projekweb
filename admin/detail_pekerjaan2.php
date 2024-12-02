<?php
include('db.php');
session_start();

// Cek apakah ID pekerjaan ada di URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_pekerjaan = $_GET['id'];

    // Query untuk mendapatkan detail pekerjaan berdasarkan id_pekerjaan
    $sql = "SELECT 
                p.id_pekerjaan, 
                p.judul_pekerjaan, 
                p.deskripsi, 
                p.jenis_pekerjaan, 
                p.tipe_kerja, 
                p.lokasi, 
                p.gaji_dari, 
                p.gaji_hingga, 
                p.tanggal_posting, 
                perusahaan.nama_perusahaan, 
                kategori_pekerjaan.nama_kategori
            FROM pekerjaan p
            LEFT JOIN perusahaan ON p.id_perusahaan = perusahaan.id_perusahaan
            LEFT JOIN kategori_pekerjaan ON p.id_kategori = kategori_pekerjaan.id_kategori
            WHERE p.id_pekerjaan = '$id_pekerjaan'";

    // Eksekusi query
    $result = $conn->query($sql);

    // Cek apakah data ditemukan
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "ID Pekerjaan tidak valid!";
        exit;
    }
} else {
    echo "ID Pekerjaan tidak valid!";
    exit;
}
?>

<!-- Tampilan Detail Pekerjaan -->
<h2>Detail Pekerjaan</h2>
<table class="table">
    <tr>
        <th>Judul Pekerjaan</th>
        <td><?php echo htmlspecialchars($row['judul_pekerjaan']); ?></td>
    </tr>
    <tr>
        <th>Perusahaan</th>
        <td><?php echo htmlspecialchars($row['nama_perusahaan']); ?></td>
    </tr>
    <tr>
        <th>Kategori</th>
        <td><?php echo htmlspecialchars($row['nama_kategori']); ?></td>
    </tr>
    <tr>
        <th>Deskripsi</th>
        <td><?php echo nl2br(htmlspecialchars($row['deskripsi'])); ?></td>
    </tr>
    <tr>
        <th>Jenis Pekerjaan</th>
        <td><?php echo htmlspecialchars($row['jenis_pekerjaan']); ?></td>
    </tr>
    <tr>
        <th>Tipe Kerja</th>
        <td><?php echo htmlspecialchars($row['tipe_kerja']); ?></td>
    </tr>
    <tr>
        <th>Lokasi</th>
        <td><?php echo htmlspecialchars($row['lokasi']); ?></td>
    </tr>
    <tr>
        <th>Gaji Dari</th>
        <td><?php echo htmlspecialchars($row['gaji_dari']); ?></td>
    </tr>
    <tr>
        <th>Gaji Hingga</th>
        <td><?php echo htmlspecialchars($row['gaji_hingga']); ?></td>
    </tr>
    <tr>
        <th>Tanggal Posting</th>
        <td><?php echo htmlspecialchars($row['tanggal_posting']); ?></td>
    </tr>
</table>

<a href="javascript:history.back()" class="btn btn-secondary">Kembali</a>
