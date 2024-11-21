<?php
session_start();
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

<body>
    <div class="container-xxl bg-white p-0">
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>

       <nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
       <a href="index.php" class="navbar-brand d-flex align-items-center text-center py-0 px-4 px-lg-5">
                <h1 class="m-0 text-primary">LookWork</h1>
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

                        <a href="indexx.php#kontak" class="nav-item nav-link">Kontak</a>
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
    </div>


    <div class="container-fluid p-0" id="beranda">
            <div class="owl-carousel header-carousel position-relative">
                <div class="owl-carousel-item position-relative">
                    <img class="img-fluid" src="img/carausel-1.jpg" alt="">
                    <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center" style="background: rgba(43, 57, 64, .5);">
                        <div class="container">
                            <div class="row justify-content-start">
                                <div class="col-10 col-lg-8">
                                    <h1 class="display-3 text-white animated slideInDown mb-4">Karier yang Tepat, Masa Depan Cerah!</h1>
                                    <a href="index_2.html" class="btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft">Cari Pekerjaan</a>
                                    <a href="index.php" class="btn btn-secondary py-md-3 px-md-5 animated slideInRight">Cari Kandidat</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="owl-carousel-item position-relative">
                    <img class="img-fluid" src="img/carausel-2.jpg" alt="">
                    <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center" style="background: rgba(43, 57, 64, .5);">
                        <div class="container">
                            <div class="row justify-content-start">
                                <div class="col-10 col-lg-8">
                                    <h1 class="display-3 text-white animated slideInDown mb-4">Langkah Awal Menuju Sukses, Temukan Pekerjaanmu Sekarang!</h1>
                                    <a href="index_2.html" class="btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft">Cari Pekerjaan</a>
                                    <a href="index.php" class="btn btn-secondary py-md-3 px-md-5 animated slideInRight">Cari Kandidat</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

                <div class="container-xxl py-5">
            <div class="container" id="tentang">
                <div class="row g-5 align-items-center">
                    <div class="col-lg-6 wow fadeIn" data-wow-delay="0.1s">
                        <div class="row g-0 about-bg rounded overflow-hidden">
                            <div class="col-6 text-start">
                                <img class="img-fluid w-100" src="img/tentang-1.jpg">
                            </div>
                            <div class="col-6 text-start">
                                <img class="img-fluid" src="img/tentang-2.jpg" style="width: 85%; margin-top: 15%;">
                            </div>
                            <div class="col-6 text-end">
                                <img class="img-fluid" src="img/tentang-3.jpg" style="width: 85%;">
                            </div>
                            <div class="col-6 text-end">
                                <img class="img-fluid w-100" src="img/tentang-4.jpg">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                        <h1 class="mb-4">LookWork: Mencari Kerja, Menemukan Talenta</h1>
                        <p class="mb-4">Bergabunglah dengan komunitas kami dan temukan pekerjaan impian atau talenta terbaik hanya dengan beberapa klik!</p>
                        <p><i class="fa fa-check text-primary me-3"></i>Koneksi Langsung antara Pencari Kerja dan Perusahaan</p>
                        <p><i class="fa fa-check text-primary me-3"></i>Antarmuka Pengguna yang Intuitif dan Mudah Digunakan</p>
                        <p><i class="fa fa-check text-primary me-3"></i>Fitur Pencarian Kerja yang Disesuaikan dengan Kebutuhan Pengguna</p>
                    </div>
                </div>
            </div>
        </div>

       
        <div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container-xxl py-5">
    <div class="container">
        <h1 class="text-center mb-5 wow fadeInUp" data-wow-delay="0.1s">Jelajahi Peluang Karir dan Perusahaan Terbaik</h1>
        <div class="tab-class text-center wow fadeInUp" data-wow-delay="0.3s">
            <ul class="nav nav-pills d-inline-flex justify-content-center border-bottom mb-5">
                <li class="nav-item">
                    <a class="d-flex align-items-center text-start mx-3 ms-0 pb-3 active" data-bs-toggle="pill" href="#tab-1">
                        <h6 class="mt-n1 mb-0">Pekerjaan</h6>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="d-flex align-items-center text-start mx-3 pb-3" data-bs-toggle="pill" href="#tab-2">
                        <h6 class="mt-n1 mb-0">Perusahaan</h6>
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <!-- Tab untuk pekerjaan -->
                <?php
    // Include file koneksi database
    include 'db_connect.php';

    // Query untuk mengambil data pekerjaan dari tabel `pekerjaan` dan `perusahaan`
    $query = "SELECT 
                pekerjaan.id_pekerjaan, 
                pekerjaan.judul_pekerjaan, 
                pekerjaan.deskripsi, 
                pekerjaan.lokasi, 
                pekerjaan.jenis_pekerjaan, 
                pekerjaan.tipe_kerja, 
                pekerjaan.gaji_dari, 
                pekerjaan.gaji_hingga, 
                pekerjaan.tanggal_posting, 
                perusahaan.nama_perusahaan
            FROM pekerjaan
            JOIN perusahaan ON pekerjaan.id_perusahaan = perusahaan.id_perusahaan
            ORDER BY pekerjaan.tanggal_posting DESC LIMIT 4";

    $result = $conn->query($query);

    if ($result && $result->num_rows > 0): 
    ?>
    <div id="tab-1" class="tab-pane fade show p-0 active">
        <?php while ($job = $result->fetch_assoc()): ?> 
            <div class="job-item p-4 mb-4">
                <div class="row g-4">
                    <div class="col-sm-12 col-md-8 d-flex align-items-center">
                        <img class="flex-shrink-0 img-fluid border rounded" src="img/default-job.png" alt="Job Image" style="width: 80px; height: 80px;"> 
                        <div class="text-start ps-4">
                            <h5 class="mb-3"><?= htmlspecialchars($job['judul_pekerjaan']); ?></h5>
                            <span class="text-truncate me-3"><i class="fa fa-map-marker-alt text-primary me-2"></i><?= htmlspecialchars($job['lokasi']); ?></span>
                            <span class="text-truncate me-3"><i class="far fa-clock text-primary me-2"></i><?= htmlspecialchars($job['jenis_pekerjaan']); ?></span>
                            <span class="text-truncate me-3"><i class="fa fa-building text-primary me-2"></i><?= htmlspecialchars($job['nama_perusahaan']); ?></span>
                            <span class="text-truncate me-0">
                                <i class="far fa-money-bill-alt text-primary me-2"></i>
                                <?php 
                                if ($job['gaji_dari'] > 0 && $job['gaji_hingga'] > 0) {
                                    echo 'Rp ' . number_format($job['gaji_dari'], 0, ',', '.') . ' - Rp ' . number_format($job['gaji_hingga'], 0, ',', '.');
                                } else {
                                    echo 'Gaji Tidak Tersedia';
                                }
                                ?>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4 d-flex flex-column align-items-start align-items-md-end justify-content-center">
                    <div class="d-flex mb-3">
                    <div class="ms-3">
                    <div class="ms-3">
                    <?php if (isset($_SESSION['pengguna_id'])): ?>
                  <!-- Jika pengguna sudah login, tampilkan tombol untuk melihat detail pekerjaan -->
                        <a href="detail_pekerjaan.php?id_pekerjaan=<?= $job['id_pekerjaan']; ?>" class="btn btn-primary mt-2">Lihat Detail Pekerjaan</a>
                    <?php else: ?>
                        <!-- Jika pengguna belum login, arahkan ke halaman login -->
                        <a href="../login/login.php" class="btn btn-primary mt-2">Lihat Detail Pekerjaan</a>
                    <?php endif; ?>
                    </div>
                     </div>
                    </div>
                    <small class="text-truncate">
                        <i class="far fa-calendar-alt text-primary me-2"></i>Tanggal Posting: <?= date('d M, Y', strtotime($job['tanggal_posting'])); ?>
                    </small>
                </div>
                </div>
            </div>
        <?php endwhile; ?>
        <?php
            if (isset($_SESSION['pengguna_id'])) {
                echo '<button class="btn btn-lg btn-primary" onclick="window.location.href=\'daftar_pekerjaan.php\'">Cari Lebih Lanjut</button>';
            } else {
                echo '<button class="btn btn-lg btn-primary" onclick="window.location.href=\'../login/login.php\'">Cari Lebih Lanjut</button>';
            }
        ?>
    </div>
    <?php 
    else: 
        echo "<p class='text-center'>Tidak ada pekerjaan yang tersedia saat ini.</p>";
    endif;
    // Tutup koneksi
    $conn->close();
    ?>

    <!-- Tab untuk perusahaan -->
    <?php
        include 'db_connect.php';

        // Query untuk mengambil data perusahaan beserta foto profil dari tabel `pengguna`
        $query = "
            SELECT perusahaan.id_perusahaan, perusahaan.nama_perusahaan, perusahaan.lokasi_perusahaan, 
                perusahaan.industri, perusahaan.deskripsi_perusahaan, pengguna.foto_profil
            FROM perusahaan 
            JOIN pengguna ON perusahaan.id_pengguna = pengguna.id_pengguna
            ORDER BY perusahaan.nama_perusahaan ASC
        ";
        $result = $conn->query($query);

        if ($result && $result->num_rows > 0) {
            $companies = $result->fetch_all(MYSQLI_ASSOC);
        } else {
            $companies = [];
        }
        ?>

    <!-- Menampilkan Data Perusahaan -->
    <div id="tab-2" class="tab-pane fade show p-0">
    <?php if (!empty($companies)): ?>
        <?php foreach ($companies as $company): ?>
        <div class="job-item p-4 mb-4">
            <div class="row g-4">
                <div class="col-sm-12 col-md-8 d-flex align-items-center">
                    <!-- Menampilkan foto profil perusahaan -->
                    <?php if (!empty($company['foto_profil'])): ?>
                        <img class="img-fluid border rounded" src="img/<?= htmlspecialchars($company['foto_profil']); ?>" alt="Foto Profil" style="width: 80px; height: 80px;">
                    <?php else: ?>
                        <img class="img-fluid border rounded" src="img/default-logo.png" alt="Logo Perusahaan" style="width: 80px; height: 80px;">
                    <?php endif; ?>

                    <div class="text-start ps-4">
                        <h5 class="mb-3"><?= htmlspecialchars($company['nama_perusahaan']); ?></h5>
                        <span class="text-truncate me-3">
                            <i class="fa fa-map-marker-alt text-primary me-2"></i>
                            <?= htmlspecialchars($company['lokasi_perusahaan']); ?>
                        </span>
                        <span class="text-truncate me-3">
                            <i class="fa fa-industry text-primary me-2"></i>
                            <?= htmlspecialchars($company['industri']); ?>
                        </span>
                        <p class="mt-2"><?= htmlspecialchars(substr($company['deskripsi_perusahaan'], 0, 100)); ?>...</p>
                    </div>
                </div>

                <div class="col-sm-12 col-md-4 d-flex flex-column align-items-start align-items-md-end justify-content-center">
                <div class="d-flex mb-3">
    <?php if (isset($_SESSION['pengguna_id']) && !empty($_SESSION['pengguna_id'])): ?>
        <!-- Jika pengguna sudah login, arahkan ke halaman profil perusahaan -->
        <a href="profil_perusahaan.php?id_perusahaan=<?= htmlspecialchars($company['id_perusahaan']); ?>" class="btn btn-primary">Lihat Detail</a>
    <?php else: ?>
        <!-- Jika pengguna belum login, arahkan ke halaman login -->
        <a href="../login/login.php" class="btn btn-primary">Lihat Detail</a>
    <?php endif; ?>
</div>

            </div>
        </div>
        <?php endforeach; ?>

            <!-- Tombol Cari Lebih Lanjut -->
            <div class="text-center mt-4">
            <?php if (isset($_SESSION['id_pengguna'])): ?>
                <button class="btn btn-lg btn-primary" onclick="window.location.href='daftar_perusahaan.php'">Cari Lebih Lanjut</button>
            <?php else: ?>
                <button class="btn btn-lg btn-primary" onclick="window.location.href='../login/login.php'">Cari Lebih Lanjut</button>
            <?php endif; ?>
        </div>

        <?php else: ?>
            <p class="text-center">Tidak ada perusahaan yang tersedia saat ini.</p>
        <?php endif; ?>
    </div>

    <?php
    // Tutup koneksi database
    $conn->close();
    ?>

                </div>
            </div>
        </div>
    </div>
    </div>


        
<div class="container-fluid bg-dark text-white-50 footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container py-5" id="kontak">
        <div class="row justify-content-center">
            <div class="col-lg-3 col-md-6 text-center">
                <h5 class="text-white mb-4">Kontak</h5>
                <p class="mb-2"><i class="fab fa-instagram me-3"></i> @lookwork__</p>
                <p class="mb-2"><i class="fa fa-phone-alt me-3"></i> +62 857-9148-3603</p>
                <p class="mb-2"><i class="fa fa-envelope me-3"></i> info@lookwork.com</p>
            </div>
        </div>
    </div>
</div>

        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

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
</body>

</html>