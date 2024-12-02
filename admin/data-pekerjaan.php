<?php
include('db.php');
session_start();

// Mengambil data pekerjaan
$search_query = '';
if (isset($_POST['search'])) {
    $search_query = mysqli_real_escape_string($conn, $_POST['search']);
}

// Inisialisasi variabel untuk form pencarian
$judul = isset($_GET['judul']) ? $_GET['judul'] : '';
$jenis_pekerjaan = isset($_GET['jenis_pekerjaan']) ? $_GET['jenis_pekerjaan'] : '';
$tipe_kerja = isset($_GET['tipe_kerja']) ? $_GET['tipe_kerja'] : '';
$lokasi = isset($_GET['lokasi']) ? $_GET['lokasi'] : '';

// Query untuk mendapatkan jenis pekerjaan
$jenisPekerjaanResult = $conn->query("SELECT DISTINCT jenis_pekerjaan FROM pekerjaan");

// Query untuk mendapatkan tipe kerja
$tipeKerjaResult = $conn->query("SELECT DISTINCT tipe_kerja FROM pekerjaan");

// Query utama untuk mencari data berdasarkan input
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
        WHERE 1=1"; // Menjaga kondisi dasar jika tidak ada pencarian

// Menambahkan kondisi pencarian berdasarkan input form
if (!empty($search_query)) {
    $sql .= " AND (p.judul_pekerjaan LIKE '%$search_query%' 
                OR p.lokasi LIKE '%$search_query%' 
                OR kategori_pekerjaan.nama_kategori LIKE '%$search_query%')";
}

if (!empty($judul)) {
    $sql .= " AND p.judul_pekerjaan LIKE '%" . $conn->real_escape_string($judul) . "%'";
}
if (!empty($jenis_pekerjaan)) {
    $sql .= " AND p.jenis_pekerjaan = '" . $conn->real_escape_string($jenis_pekerjaan) . "'";
}
if (!empty($tipe_kerja)) {
    $sql .= " AND p.tipe_kerja = '" . $conn->real_escape_string($tipe_kerja) . "'";
}
if (!empty($lokasi)) {
    $sql .= " AND p.lokasi LIKE '%" . $conn->real_escape_string($lokasi) . "%'";
}

// Jalankan query
$result = $conn->query($sql);
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Perusahaan_LookWork</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <link href="img/favicon.ico" rel="icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Inter:wght@700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<style>
    body {
            font-family: 'Heebo', sans-serif;
            background-color: #f4f4f9;
    }

    .table {
    width: 90%; /* Menetapkan lebar tabel menjadi 90% dari lebar kontainer */
    margin: 0 auto; /* Menjadikan tabel terpusat di tengah */
}
@media (max-width: 1200px) {
    .table {
        width: 85%; /* Lebar tabel lebih kecil untuk layar yang lebih kecil */
    }
}
.btn {
            background-color: #6A9C89;
            border: none;
            color: white;
            border-radius: 5px;
            padding: 10px 20px;
            font-size: 14px;
            cursor: pointer;
        }



</style>
<body>


        <nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
       <a href="index.php" class="navbar-brand d-flex align-items-center text-center py-0 px-4 px-lg-5">
       <h1 class="m-0" style="color: #16423C;">LookWork</h1>
       </a>
            <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">              
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                    <a href="index.php" class="nav-item nav-link ">Beranda</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link active dropdown-toggle" data-bs-toggle="dropdown">Manajemen Data</a>
                        <div class="dropdown-menu rounded-0 m-0">
                            <a href="data-pekerjaan.php" class="dropdown-item">Pekerjaan</a>
                            <a href="data-perusahaan.php" class="dropdown-item">Perusahaan</a>
                            <a href="data-user.php" class="dropdown-item">Pengguna</a>
                            <a href="kategori-pekerjaan.php" class="dropdown-item">Kategori Pekerjaan</a>
                        </div>
                    </div>
                    <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Laporan</a>
                    <div class="dropdown-menu rounded-0 m-0">
                        <a href="report1.php" class="dropdown-item">Pekerjaan</a>
                        <a href="report2.php" class="dropdown-item">Perusahaan</a>
                        <a href="report3.php" class="dropdown-item">Pengguna</a>
                    </div>
                    </div>

                <div class="dropdown">
                    <a href="#" class="btn btn-primary rounded-0 py-4 px-lg-5 d-none d-lg-block dropdown-toggle" style="background-color: #6A9C89; border-color: #6A9C89;" data-bs-toggle="dropdown">
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="logout.php">Keluar</a></li>
                    </ul>
                </div>
        </nav>
    </div> 
<!-- Judul Data Pekerjaan -->
<h1 class="text-center my-4">Data Pekerjaan</h1> <!-- Tambahkan judul di sini -->

            <!-- Tampilan Form Pencarian -->
            <div class="container my-4">
                <form method="GET" action="" class="row g-3 align-items-center justify-content-center">
                <!-- Judul Pekerjaan -->
                <div class="col-md-3">
                    <input type="text" name="judul" class="form-control" placeholder="Judul Pekerjaan" value="<?= htmlspecialchars($judul); ?>">
                </div>

                <!-- Jenis Pekerjaan -->
                <div class="col-md-3">
                    <select name="jenis_pekerjaan" class="form-select">
                        <option value="">Pilih Jenis Pekerjaan</option>
                        <?php if ($jenisPekerjaanResult && $jenisPekerjaanResult->num_rows > 0): ?>
                            <?php while ($row = $jenisPekerjaanResult->fetch_assoc()): ?>
                                <option value="<?= $row['jenis_pekerjaan']; ?>" <?= $jenis_pekerjaan == $row['jenis_pekerjaan'] ? 'selected' : ''; ?>>
                                    <?= ucfirst($row['jenis_pekerjaan']); ?>
                                </option>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </select>
                </div>

                 <!-- Tipe Kerja -->
                 <div class="col-md-3">
                    <select name="tipe_kerja" class="form-select">
                        <option value="">Pilih Tipe Kerja</option>
                        <?php if ($tipeKerjaResult && $tipeKerjaResult->num_rows > 0): ?>
                            <?php while ($row = $tipeKerjaResult->fetch_assoc()): ?>
                                <option value="<?= $row['tipe_kerja']; ?>" <?= $tipe_kerja == $row['tipe_kerja'] ? 'selected' : ''; ?>>
                                    <?= ucfirst($row['tipe_kerja']); ?>
                                </option>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </select>
                </div>
                                <!-- Lokasi -->
                                <div class="col-md-3">
                    <input type="text" name="lokasi" class="form-control" placeholder="Lokasi" value="<?= htmlspecialchars($lokasi); ?>">
                </div>

                    <!-- Tombol Cari -->
                    <div class="col-md-2 text-center">
                        <button type="submit" class="btn btn-primary w-100">Cari Pekerjaan</button>
                    </div>
                </form>
            </div>



<!-- Tabel Data Pekerjaan -->
<table class="table table-bordered">
    <thead>
        <tr>
            <th>No</th> <!-- Kolom nomor ditambahkan di sini -->
            <th>ID</th>
            <th>Judul Pekerjaan</th>
            <th>Perusahaan</th>
            <th>Kategori</th>
            <th>Deskripsi</th>
            <th>Jenis Pekerjaan</th>
            <th>Tipe Kerja</th>
            <th>Lokasi</th>
            <th>Gaji Dari</th>
            <th>Gaji Hingga</th>
            <th>Tanggal Posting</th>
            <th>Aksi</th> <!-- Kolom Aksi ditambahkan di sini -->
        </tr>
    </thead>
    <tbody>
    <?php 
        $max_length = 100; // Set the maximum length of description
        $no = 1; // Inisialisasi nomor urut
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Memotong deskripsi jika terlalu panjang
                $description = htmlspecialchars($row['deskripsi']);
                if (strlen($description) > $max_length) {
                    $description = substr($description, 0, $max_length) . "...";
                }
        ?>
        <tr>
            <td><?php echo $no++; ?></td> <!-- Nomor urut -->
            <td><?php echo htmlspecialchars($row['id_pekerjaan']); ?></td>
            <td><?php echo htmlspecialchars($row['judul_pekerjaan']); ?></td>
            <td><?php echo isset($row['nama_perusahaan']) ? htmlspecialchars($row['nama_perusahaan']) : "Tidak tersedia"; ?></td>
            <td><?php echo isset($row['nama_kategori']) ? htmlspecialchars($row['nama_kategori']) : "Tidak tersedia"; ?></td>
            <td style="white-space: normal;"><?php echo nl2br($description); ?></td> <!-- Deskripsi yang dipotong -->
            <td><?php echo htmlspecialchars($row['jenis_pekerjaan']); ?></td>
            <td><?php echo htmlspecialchars($row['tipe_kerja']); ?></td>
            <td><?php echo htmlspecialchars($row['lokasi']); ?></td>
            <td><?php echo htmlspecialchars($row['gaji_dari']); ?></td>
            <td><?php echo htmlspecialchars($row['gaji_hingga']); ?></td>
            <td><?php echo htmlspecialchars($row['tanggal_posting']); ?></td>
            <td>
                <!-- Ikon Aksi -->
                <a href="detail_pekerjaan2.php?id=<?php echo $row['id_pekerjaan']; ?>" class="text-info me-2" title="Lihat Detail">
                    <i class="fas fa-eye"></i> <!-- Ikon 'Lihat Detail' -->
                </a>

                <a href="hapus_pekerjaan.php?id=<?php echo $row['id_pekerjaan']; ?>" class="text-danger" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus pekerjaan ini?');">
                    <i class="fas fa-trash-alt"></i> <!-- Ikon 'Hapus' -->
                </a>
            </td>
        </tr>
        <?php 
            } // End of while
        } else {
            echo "<tr><td colspan='13'>Tidak ada data pekerjaan yang ditemukan.</td></tr>";
        }
        ?>
    </tbody>
</table>


<!-- Tambahkan ini dalam tag <head> -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">



    </script>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <script src="js/main.js"></script>
    
    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>

