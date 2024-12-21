<?php
session_start();

// Koneksi ke database
include 'db_connect.php';

// Mengecek apakah parameter ID sudah ada dan valid
if (isset($_GET['id_pekerjaan']) && intval($_GET['id_pekerjaan'])) {
    $id_pekerjaan = intval($_GET['id_pekerjaan']);

    // Query untuk mendapatkan detail pekerjaan dan foto profil perusahaan
    $query = "SELECT 
    p.id_pekerjaan, 
    p.judul_pekerjaan, 
    p.deskripsi, 
    p.lokasi, 
    p.jenis_pekerjaan, 
    p.tipe_kerja, 
    p.gaji_dari, 
    p.gaji_hingga, 
    p.tanggal_posting, 
    c.id_perusahaan, 
    c.nama_perusahaan, 
    c.lokasi_perusahaan, 
    c.deskripsi_perusahaan,
    u.foto_profil  -- Ambil foto profil dari tabel pengguna
  FROM pekerjaan p
  JOIN perusahaan c ON p.id_perusahaan = c.id_perusahaan
LEFT JOIN pengguna u ON u.id_pengguna = c.id_pengguna  -- Sesuaikan hubungan perusahaan dengan pengguna
  WHERE p.id_pekerjaan = ?";


    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_pekerjaan);
    $stmt->execute();
    $result = $stmt->get_result();

    // Memeriksa apakah pekerjaan ditemukan
    if ($result->num_rows > 0) {
        $job = $result->fetch_assoc();
    } else {
        echo "<p>Pekerjaan tidak ditemukan!</p>";
        exit;
    }
} else {
    echo "<p>ID Pekerjaan tidak valid!</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>LookWork</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <link href="img/favicon.ico" rel="icon">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

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
        
.btn-primary {
    background-color: #6A9C89; 
    border-color: #6A9C89; 
}

.btn-primary:hover {
    background-color: #5b876f;
    border-color: #5b876f; 
}
.job-item {
    background-color: #ffffff; 
    border-radius: 15px; 
    transition: transform 0.3s ease, box-shadow 0.3s ease, border-radius 0.3s ease; 
}

.job-item:hover {
    transform: translateY(-5px); 
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1); 
    border-radius: 20px; 
}

.job-item img {
    transition: transform 0.3s ease; 
}


.job-item:hover img {
    transform: scale(1.05); 
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
 
        <div class="container my-4">
    <div class="row">
        <div class="col-md-8">
            <!-- Menampilkan detail pekerjaan dengan background putih dan border radius yang lebih halus -->
            <div class="job-item p-4 border rounded" style="background-color: #ffffff; border-radius: 15px;">
                <div class="d-flex flex-column">
                    <!-- Menampilkan gambar pekerjaan atau logo default -->
                    <h3><?= htmlspecialchars($job['judul_pekerjaan']); ?></h3>
                    <p class="mb-1"><i class="fa fa-map-marker-alt text-primary"></i> <?= htmlspecialchars($job['lokasi']); ?></p>
                    <p class="mb-1"><i class="fa fa-clock text-primary"></i> <?= htmlspecialchars($job['jenis_pekerjaan']); ?></p>
                    <p class="mb-1"><i class="fa fa-briefcase text-primary"></i> <?= htmlspecialchars($job['tipe_kerja']); ?></p>
                    <p class="mb-1">
                        <i class="fa fa-money-bill-alt text-primary"></i> 
                        <?php 
                        if ($job['gaji_dari'] > 0 && $job['gaji_hingga'] > 0) {
                            echo 'Rp ' . number_format($job['gaji_dari'], 0, ',', '.') . ' - Rp ' . number_format($job['gaji_hingga'], 0, ',', '.');
                        } else {
                            echo 'Gaji Tidak Tersedia';
                        }
                        ?>
                    </p>
                    <p><strong>Deskripsi:</strong></p>
                    <p><?= nl2br(htmlspecialchars($job['deskripsi'])); ?></p>
                    <p><strong>Tanggal Posting:</strong> <?= date('d M, Y', strtotime($job['tanggal_posting'])); ?></p>

                    <!-- Tombol Lamar Pekerjaan -->
                    <?php if (isset($_SESSION['pengguna_id'])): ?>
                        <!-- Jika sudah login, arahkan ke halaman lamar pekerjaan -->
                        <a href="lamar_pekerjaan.php?id_pekerjaan=<?= $job['id_pekerjaan']; ?>" class="btn btn-primary mt-3">Lamar Pekerjaan</a>
                    <?php else: ?>
                        <!-- Jika belum login, arahkan ke halaman login -->
                        <button class="btn btn-primary mt-3" onclick="window.location.href='../login/login.php?redirect=detail_pekerjaan.php?id_pekerjaan=<?= $job['id_pekerjaan']; ?>'">Lamar Pekerjaan</button>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Menampilkan detail perusahaan di kolom kanan -->
        <div class="col-md-4">
            <div class="job-item p-4 border rounded" style="background-color: #ffffff; border-radius: 15px;">
                <h4>Profil Perusahaan</h4>
                    <div class="d-flex align-items-center mb-3">
                        <!-- Menampilkan foto profil perusahaan -->
                        <?php if (!empty($job['foto_profil'])): ?>
                            <img src="../foto/<?= htmlspecialchars($job['foto_profil']); ?>" class="img-fluid rounded" style="max-width: 150px; max-height: 150px; border-radius: 50%;">
                        <?php else: ?>
                            <img src="../imgbk/default_logo.png" class="img-fluid rounded" style="max-width: 150px; max-height: 150px; border-radius: 50%;">
                        <?php endif; ?>
                    </div>
                <p><strong>Nama Perusahaan:</strong> <?= htmlspecialchars($job['nama_perusahaan']); ?></p>
                <p><strong>Lokasi Perusahaan:</strong> <?= htmlspecialchars($job['lokasi_perusahaan']); ?></p>
                <p><strong>Deskripsi:</strong> <?= nl2br(htmlspecialchars($job['deskripsi_perusahaan'])); ?></p>
            </div>
        </div>
    </div>
</div>


<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
           
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
            <script src="lib/wow/wow.min.js"></script>
            <script src="lib/easing/easing.min.js"></script>
            <script src="lib/waypoints/waypoints.min.js"></script>
            <script src="lib/owlcarousel/owl.carousel.min.js"></script>
            <script src="js/main.js"></script>

        </body>
        
        </html>