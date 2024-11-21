<?php
session_start();

// Koneksi ke database
include 'db_connect.php';

// Mengecek apakah parameter ID sudah ada dan valid
if (isset($_GET['id_pekerjaan']) && intval($_GET['id_pekerjaan'])) {
    $id_pekerjaan = intval($_GET['id_pekerjaan']);

    // Query untuk mendapatkan detail pekerjaan berdasarkan id_pekerjaan
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
                c.deskripsi_perusahaan 
              FROM pekerjaan p
              JOIN perusahaan c ON p.id_perusahaan = c.id_perusahaan
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

<body>
    <div class="container-xxl bg-white p-0">
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>

        <nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
                <a href="index_2.html" class="navbar-brand d-flex align-items-center text-center py-0 px-4 px-lg-5">
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

                        <a href="#kontak" class="nav-item nav-link">Kontak</a>
                    </div>
                    
                    <!-- Tombol di kanan -->
                    <?php if(isset($_SESSION['username'])): ?>
                        <div class="dropdown">
                            <a href="#" class="btn btn-primary rounded-0 py-4 px-lg-5 d-none d-lg-block dropdown-toggle" style="background-color: #6A9C89; border-color: #6A9C89;" data-bs-toggle="dropdown" aria-expanded="false">
                                <?= $_SESSION['username']; ?>
                            </a>
                            <ul class="dropdown-menu position-relative">
                                <li><a class="dropdown-item" href="profil.php">Profil</a></li>
                                <li><a class="dropdown-item" href="../login/logout.php">Keluar</a></li>
                            </ul>
                        </div>
                        <?php else: ?>
                        <a href="../login/login.php" class="btn btn-primary rounded-0 py-4 px-lg-5 d-none d-lg-block" style="background-color: #6A9C89; border-color: #6A9C89;">
                            Mulai Karirmu!<i class="fa fa-arrow-right ms-3"></i>
                        </a>
                        <?php endif; ?>

            </div>
        </nav>
 
        <div class="container my-4">
        <div class="row">
    <div class="col-md-8">
        <!-- Menampilkan detail pekerjaan -->
        <div class="job-item p-4 border rounded">
            <div class="d-flex">
                <!-- Menampilkan gambar pekerjaan atau logo default -->
                <img class="img-fluid rounded" src="img/<?= isset($job['logo']) && $job['logo'] ? htmlspecialchars($job['logo']) : 'default-job.png'; ?>" alt="<?= htmlspecialchars($job['judul_pekerjaan']); ?>" style="width: 100px; height: 100px;">
                <div class="ms-3">
                    <h3><?= htmlspecialchars($job['judul_pekerjaan']); ?></h3>
                    <p class="mb-1"><i class="fa fa-map-marker-alt text-primary"></i> <?= htmlspecialchars($job['lokasi']); ?></p>
                    <p class="mb-1"><i class="fa fa-clock text-primary"></i> <?= ucfirst(htmlspecialchars($job['jenis_pekerjaan'])); ?></p>
                    <p class="mb-1"><i class="fa fa-laptop-house text-primary"></i> <?= ucfirst(htmlspecialchars($job['tipe_kerja'])); ?></p>
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
    </div>

    <!-- Menampilkan detail perusahaan -->
    <div class="col-md-4">
        <div class="p-4 border rounded">
            <h5 class="mb-4">Perusahaan</h5>
            <p><strong><?= htmlspecialchars($job['nama_perusahaan']); ?></strong></p>
            <p><i class="fa fa-map-marker-alt text-primary"></i> <?= htmlspecialchars($job['lokasi_perusahaan']); ?></p>
            <p><strong>Deskripsi Perusahaan:</strong></p>
            <p><?= nl2br(htmlspecialchars($job['deskripsi_perusahaan'])); ?></p>
            <a href="profil_perusahaan.php?id_perusahaan=<?= $job['id_perusahaan']; ?>" class="btn btn-primary">Lihat Perusahaan</a>
        </div>
    </div>
</div>
</div>
    </div>



        

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