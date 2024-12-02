<?php
session_start();
// Koneksi ke database
include 'db_connect.php';

try {
    // Query untuk mendapatkan semua data perusahaan dengan tanggal_dibuat dari tabel pengguna
    $query = "
        SELECT perusahaan.*, pengguna.tanggal_dibuat 
        FROM perusahaan 
        JOIN pengguna ON perusahaan.id_pengguna = pengguna.id_pengguna 
        ORDER BY pengguna.tanggal_dibuat DESC
    ";
    
    $result = $conn->query($query);

    // Mengecek apakah ada data yang ditemukan
    if (!$result) {
        throw new Exception("Query error: " . $conn->error);
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>PencariKerja_LookWork</title>
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
            /* Styling untuk Daftar Perusahaan */
}
.company-item {
    background-color: #ffffff;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease, border-radius 0.3s ease;
}

.company-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    border-radius: 12px;
}

/* Penyesuaian gambar logo perusahaan */
.company-item img {
    width: 80px;
    height: 80px;
    object-fit: cover;
}

/* Button Lihat Profil */
.btn-primary {
    background-color: #6A9C89;
    border-color: #6A9C89;
    transition: background-color 0.3s ease;
}

.btn-primary:hover {
    background-color: #5b876f;
    border-color: #5b876f;
}

        </style>
<body>
    <div class="container-xxl bg-white p-0">
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div> 
        </div>
        </div>


        <nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
       <a href="indexx.php" class="navbar-brand d-flex align-items-center text-center py-0 px-4 px-lg-5">
       <h1 class="m-0" style="color: #16423C;">LookWork</h1>
       </a>
            <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                    <!-- Navigasi di kiri -->
                    <div class="navbar-nav me-auto p-4 p-lg-0">
                        <a href="indexx.php#beranda" class="nav-item nav-link ">Beranda</a>
                        <a href="indexx.php#tentang" class="nav-item nav-link">Tentang</a>
        
                        <?php if(isset($_SESSION['username']) && $_SESSION['peran'] === 'pencari_kerja'): ?>
                        <a href="daftar_pekerjaan.php" class="nav-item nav-link ">Pekerjaan</a>
                        <a href="daftar_perusahaan.php" class="nav-item nav-link">Perusahaan</a>
                        <a href="notifikasi.php" class="nav-item nav-link">Notifikasi</a>
                        <?php endif; ?>

                    </div>
                    
                    <!-- Tombol di kanan -->
                    <?php if (isset($_SESSION['username'])): ?>
                <div class="dropdown">
                    <a href="#" class="btn btn-primary rounded-0 py-4 px-lg-5 d-none d-lg-block dropdown-toggle" style="background-color: #6A9C89; border-color: #6A9C89;" data-bs-toggle="dropdown">
                        <?= $_SESSION['username']; ?>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="profil.php">Profil</a></li>
                        <li><a class="dropdown-item" href="logout.php">Keluar</a></li>
                    </ul>
                </div>
            <?php endif; ?>

        </nav>
        <!-- Navbar End -->
        </div>
        </div>

            <!-- Pencarian -->
            <?php
            // Mulai sesi dan sambungkan ke database
            include 'db_connect.php'; // Pastikan file koneksi sudah benar

            // Ambil data dari form pencarian (jika ada)
            $nama_perusahaan = isset($_GET['nama_perusahaan']) ? trim($_GET['nama_perusahaan']) : '';
            $lokasi_perusahaan = isset($_GET['lokasi_perusahaan']) ? trim($_GET['lokasi_perusahaan']) : '';
            $industri = isset($_GET['industri']) ? trim($_GET['industri']) : '';

            // Query untuk mendapatkan daftar industri unik dari tabel perusahaan
            $industriQuery = "SELECT DISTINCT industri FROM perusahaan WHERE industri IS NOT NULL AND industri != ''";
            $industriResult = $conn->query($industriQuery);

            // Query dasar untuk mendapatkan perusahaan dengan join ke tabel pengguna untuk mendapatkan tanggal_dibuat
            $query = "SELECT p.*, u.tanggal_dibuat 
                    FROM perusahaan p
                    LEFT JOIN pengguna u ON p.id_pengguna = u.id_pengguna
                    WHERE 1";

            // Tambahkan filter pencarian berdasarkan input
            if (!empty($nama_perusahaan)) {
                $query .= " AND p.nama_perusahaan LIKE '%$nama_perusahaan%'";
            }
            if (!empty($lokasi_perusahaan)) {
                $query .= " AND p.lokasi_perusahaan LIKE '%$lokasi_perusahaan%'";
            }
            if (!empty($industri)) {
                $query .= " AND p.industri = '$industri'";
            }

            // Jalankan query untuk mencari perusahaan
            $result = $conn->query($query);
            ?>

            <!-- Tampilan Form Pencarian -->
            <div class="container my-4">
                <form method="GET" action="" class="row g-3 align-items-center justify-content-center">
                    <!-- Nama Perusahaan -->
                    <div class="col-md-3">
                        <input type="text" name="nama_perusahaan" class="form-control" placeholder="Nama Perusahaan" value="<?= htmlspecialchars($nama_perusahaan); ?>">
                    </div>

                    <!-- Lokasi -->
                    <div class="col-md-3">
                        <input type="text" name="lokasi_perusahaan" class="form-control" placeholder="Lokasi Perusahaan (Juanda, Jawa Timur)" value="<?= htmlspecialchars($lokasi_perusahaan); ?>">
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

<!-- Daftar Perusahaan -->
<div class="container my-4">
    <div class="row">
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($company = $result->fetch_assoc()): ?>
                <div class="col-md-4 mb-4"> <!-- Ubah ukuran kolom menjadi lebih kecil agar lebih rapat -->
                    <div class="company-item p-4 border rounded shadow-sm transition-all" style="min-height: 250px; display: flex; flex-direction: column; justify-content: space-between;">
                        <div class="d-flex align-items-center">
                           <img src="../foto/<?= !empty($company['foto_profil']) ? htmlspecialchars($company['foto_profil']) : '../imgbk/default.png'; ?>" 
                                        class="img-fluid rounded-circle" 
                                        style="width: 100px; height: 100px; object-fit: cover;">

                            <div class="ms-3">
                                <h5 class="fw-bold"><?= $company['nama_perusahaan']; ?></h5>
                                <p class="mb-1 text-muted"><i class="fa fa-map-marker-alt text-primary"></i> <?= $company['lokasi_perusahaan']; ?></p>
                                <p class="mb-1 text-muted"><i class="fa fa-building text-primary"></i> <?= $company['industri']; ?></p>
                            </div>
                        </div>

                        <!-- Tombol dan Tanggal Bergabung di bagian bawah -->
                        <div class="d-flex flex-column align-items-end">
                            <a href="profil_perusahaan.php?id_perusahaan=<?= $company['id_perusahaan']; ?>" class="btn btn-primary">Lihat Profil</a>
                            <small class="text-truncate mt-2"><i class="fa fa-calendar-alt text-primary"></i> Bergabung sejak: <?= date('d M, Y', strtotime($company['tanggal_dibuat'])); ?></small>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="text-center">Belum ada perusahaan yang ditemukan.</p>
        <?php endif; ?>
    </div>
</div>




<?php
// Tutup koneksi database
$conn->close();
?>

        
        <!-- Footer  -->
        <?php
        $no_wa = 6282266479716;
        ?>
        <div id="kontak" class="container-fluid bg-dark text-white-50 footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
            <div class="container py-5">
                <div class="row justify-content-center">
                    <div class="col-lg-3 col-md-6 text-center">
                        <h5 class="text-white mb-4">Kontak</h5>
                        <p class="mb-2">
                            <a href="https://www.instagram.com/lookwork__/" target="_blank" class="text-white-50">
                                <i class="fab fa-instagram me-3"></i>Instagram : @lookwork__
                            </a>
                        </p>
                        <p class="mb-2">
                            <a href="https://wa.me/<?php echo $no_wa; ?>?text=Halo%20saya%20ingin%20bertanya" target="_blank" class="text-white-50">
                                <i class="fa fa-phone-alt me-3"></i>WhatsApp: +6282266479716
                            </a>
                        </p>
                        <p class="mb-2">
                            <a href="mailto:custsercices@lookwork.com?subject=Subject%20Anda&body=Halo,%20saya%20ingin%20bertanya." target="_blank" class="text-white-50">
                                <i class="fa fa-envelope me-3"></i>Email: info@lookwork.com
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html>