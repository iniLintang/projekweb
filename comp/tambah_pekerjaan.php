<?php
// Pastikan koneksi ke database telah dilakukan sebelumnya
include 'db_connect.php';

// Cek apakah form telah disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $judul_pekerjaan = $_POST['judul_pekerjaan'];
    $deskripsi = $_POST['deskripsi'];
    $lokasi = $_POST['lokasi'];
    $jenis_pekerjaan = $_POST['jenis_pekerjaan'];
    $tipe_kerja = $_POST['tipe_kerja'];
    $gaji = $_POST['gaji'];
    
    // Tentukan gaji dari dan gaji hingga
    $gaji_dari = $gaji;  // Asumsi gaji yang dimasukkan adalah gaji maksimum
    $gaji_hingga = $gaji; // Anda bisa menambahkan logika untuk mengatur rentang gaji yang lebih spesifik

    // Ambil ID perusahaan dan ID kategori dari tabel yang sesuai (misalnya, berdasarkan sesi atau form input)
    // Untuk contoh ini, kita menggunakan ID perusahaan yang diambil dari sesi pengguna yang sedang login
    $id_perusahaan = $_SESSION['id_perusahaan'];  // Pastikan ini valid dan diset sebelumnya
    $id_kategori = $_POST['id_kategori']; // Anda harus menambahkan pilihan kategori pekerjaan dalam form

    // Query untuk menyimpan data pekerjaan ke dalam database
    $query = "INSERT INTO pekerjaan (id_perusahaan, id_kategori, judul_pekerjaan, deskripsi, lokasi, jenis_pekerjaan, tipe_kerja, gaji_dari, gaji_hingga)
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Persiapkan dan eksekusi query
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("iissssddi", $id_perusahaan, $id_kategori, $judul_pekerjaan, $deskripsi, $lokasi, $jenis_pekerjaan, $tipe_kerja, $gaji_dari, $gaji_hingga);
        
        if ($stmt->execute()) {
            // Redirect atau tampilkan pesan sukses setelah pekerjaan berhasil ditambahkan
            echo "<div class='alert alert-success'>Pekerjaan berhasil ditambahkan!</div>";
            // Anda bisa melakukan redirect ke halaman daftar pekerjaan atau halaman lain setelah berhasil menambahkan
            header("Location: daftar_pekerjaan.php");
            exit;
        } else {
            // Tampilkan pesan error jika query gagal
            echo "<div class='alert alert-danger'>Terjadi kesalahan. Pekerjaan gagal ditambahkan.</div>";
        }
        
        $stmt->close();
    } else {
        echo "<div class='alert alert-danger'>Terjadi kesalahan dalam persiapan query.</div>";
    }
    
    // Tutup koneksi ke database
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Tambah Pekerjaan</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        h1 {
            color: #2c3e50;
        }
        .container {
            margin-top: 50px;
        }
        .form-control {
            border-radius: 0.25rem;
        }
        .btn-primary {
            background-color: #3498db;
            border: none;
        }
        .btn-primary:hover {
            background-color: #2980b9;
        }
        .btn-secondary {
            background-color: #95a5a6;
            border: none;
        }
    </style>
</head>
<body>
<div class="container">
    <h1 class="text-center my-4"><i class="fas fa-plus-circle"></i> Tambah Pekerjaan</h1>

    <form action="" method="post">
        <div class="form-group">
            <label for="judul_pekerjaan">Judul Pekerjaan</label>
            <input type="text" class="form-control" id="judul_pekerjaan" name="judul_pekerjaan" required>
        </div>
        <div class="form-group">
            <label for="deskripsi">Deskripsi</label>
            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required></textarea>
        </div>
        <div class="form-group">
            <label for="lokasi">Lokasi</label>
            <input type="text" class="form-control" id="lokasi" name="lokasi" required>
        </div>
        <div class="form-group">
            <label>Jenis Pekerjaan:</label>
            <select name="jenis_pekerjaan" class="form-control" required>
                <option value="full_time">Full Time</option>
                <option value="part_time">Part Time</option>
                <option value="freelance">Freelance</option>
                <option value="internship">Internship</option>
            </select>
        </div>
        <div class="form-group">
            <label>Tipe Kerja:</label>
            <select name="tipe_kerja" class="form-control" required>
                <option value="remote">Remote</option>
                <option value="wfo">WFO</option>
                <option value="hybrid">Hybrid</option>
            </select>
        </div>
        <div class="form-group">
            <label for="gaji_dari">Gaji Dari</label>
            <input type="number" class="form-control" id="gaji_dari" name="gaji_dari" min="0" required>
        </div>
        <div class="form-group">
            <label for="gaji_hingga">Gaji Hingga</label>
            <input type="number" class="form-control" id="gaji_hingga" name="gaji_hingga" min="0" required>
        </div>
        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Tambah Pekerjaan</button>
        <a href="index.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Batal</a>
    </form>
</div>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
