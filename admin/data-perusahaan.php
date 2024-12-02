<?php
include('db.php');
session_start();

// Inisialisasi variabel pencarian
$nama_perusahaan = '';
$lokasi_perusahaan = '';
$industri = '';

// Periksa apakah form disubmit dengan metode GET
if (isset($_GET['nama_perusahaan'])) {
    $nama_perusahaan = $_GET['nama_perusahaan'];
}

if (isset($_GET['lokasi_perusahaan'])) {
    $lokasi_perusahaan = $_GET['lokasi_perusahaan'];
}

if (isset($_GET['industri'])) {
    $industri = $_GET['industri'];
}

// Query untuk mendapatkan data industri
$industriResult = $conn->query("SELECT DISTINCT industri FROM perusahaan");

// Query dasar untuk menampilkan data perusahaan berdasarkan pencarian
$sql = "SELECT perusahaan.*, 
               pengguna.email, 
               pengguna.tanggal_dibuat, 
               COUNT(pekerjaan.id_pekerjaan) AS total_lowongan
        FROM perusahaan 
        LEFT JOIN pengguna ON perusahaan.id_pengguna = pengguna.id_pengguna
        LEFT JOIN pekerjaan ON pekerjaan.id_perusahaan = perusahaan.id_perusahaan
        WHERE 1=1"; // Kondisi dasar

// Tentukan kondisi pencarian
$conditions = [];
$types = ''; // Menyimpan jenis parameter yang akan dibind

if (!empty($nama_perusahaan)) {
    $conditions[] = "nama_perusahaan LIKE ?";
    $types .= "s"; // Menambahkan jenis parameter string
}

if (!empty($lokasi_perusahaan)) {
    $conditions[] = "lokasi_perusahaan LIKE ?";
    $types .= "s"; // Menambahkan jenis parameter string
}

if (!empty($industri)) {
    $conditions[] = "industri = ?";
    $types .= "s"; // Menambahkan jenis parameter string
}

// Menambahkan kondisi pencarian ke query
if (count($conditions) > 0) {
    $sql .= " AND " . implode(" AND ", $conditions);
}

// Menambahkan group by
$sql .= " GROUP BY perusahaan.id_perusahaan";

// Persiapkan statement
$stmt = $conn->prepare($sql);

// Bind parameter jika ada pencarian
$params = [];
if (!empty($nama_perusahaan)) {
    $params[] = "%" . $conn->real_escape_string($nama_perusahaan) . "%";
}

if (!empty($lokasi_perusahaan)) {
    $params[] = "%" . $conn->real_escape_string($lokasi_perusahaan) . "%";
}

if (!empty($industri)) {
    $params[] = $conn->real_escape_string($industri);
}

// Bind parameter sesuai dengan jenis parameter dan nilai yang ada
if (count($params) > 0) {
    $stmt->bind_param($types, ...$params);
}

// Eksekusi query
$stmt->execute();
$result = $stmt->get_result();
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
                    <a href="index.php" class="nav-item  nav-link ">Beranda</a>
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
<!-- Judul Data Perusahaan -->
<h1 class="text-center my-4">Data Perusahaan</h1> <!-- Tambahkan judul di sini -->

            <!-- Tampilan Form Pencarian -->
            <div class="container my-4">
                <form method="GET" action="" class="row g-3 align-items-center justify-content-center">
                    <!-- Nama Perusahaan -->
                    <div class="col-md-3">
                        <input type="text" name="nama_perusahaan" class="form-control" placeholder="Nama Perusahaan" value="<?= htmlspecialchars($nama_perusahaan); ?>">
                    </div>

                    <!-- Lokasi -->
                    <div class="col-md-3">
                        <input type="text" name="lokasi_perusahaan" class="form-control" placeholder="Lokasi Perusahaan" value="<?= htmlspecialchars($lokasi_perusahaan); ?>">
                    </div>

                    <!-- Industri -->
                    <div class="col-md-3">
                        <select name="industri" class="form-select">
                            <option value="">Pilih Industri</option>
                            <?php if ($industriResult && $industriResult->num_rows > 0): ?>
                                <?php while ($row = $industriResult->fetch_assoc()): ?>
                                    <option value="<?= $row['industri']; ?>" <?= ($industri == $row['industri']) ? 'selected' : ''; ?>>
                                        <?= htmlspecialchars($row['industri']); ?>
                                    </option>
                                <?php endwhile; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <!-- Tombol Cari -->
                    <div class="col-md-2 text-center">
                        <button type="submit" class="btn btn-primary w-100">Cari Perusahaan</button>
                    </div>
                </form>
            </div>
            


            <table class="table table-bordered">
    <thead>
        <tr>
            <th>No</th> <!-- Kolom nomor ditambahkan di sini -->
            <th>ID Perusahaan</th>
            <th>Nama Perusahaan</th>
            <th>Deskripsi Perusahaan</th>
            <th>Lokasi Perusahaan</th>
            <th>Email</th>
            <th>Tanggal Dibuat</th>
            <th>Total Lowongan</th> <!-- Kolom Total Lowongan ditambahkan di sini -->
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $no = 1; // Inisialisasi variabel nomor urut
        if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $no++; ?></td> <!-- Menampilkan nomor urut -->
                    <td><?php echo htmlspecialchars($row['id_perusahaan']); ?></td>
                    <td><?php echo htmlspecialchars($row['nama_perusahaan']); ?></td>
                    <td><?php echo htmlspecialchars($row['deskripsi_perusahaan']); ?></td>
                    <td><?php echo htmlspecialchars($row['lokasi_perusahaan']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['tanggal_dibuat']); ?></td>
                    <td><?php echo htmlspecialchars($row['total_lowongan']); ?></td> <!-- Menampilkan total lowongan -->
                    <td>
                        <!-- Ikon Aksi -->
                        <a href="profil_perusahaan.php?id=<?php echo $row['id_perusahaan']; ?>" class="text-info me-2" title="Lihat Detail">
                            <i class="fas fa-eye"></i> <!-- Ikon 'Lihat Detail' -->
                        </a>

                        <a href="hapus_perusahaan.php?id=<?php echo $row['id_perusahaan']; ?>" class="text-danger" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus perusahaan ini?');">
                            <i class="fas fa-trash-alt"></i> <!-- Ikon 'Hapus' -->
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="9">Tidak ada data</td></tr> <!-- Sesuaikan colspan dengan jumlah kolom -->
        <?php endif; ?>
    </tbody>
</table>


</div>
<script src="../assets/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html>