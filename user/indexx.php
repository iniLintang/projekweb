<?php
session_start();
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
    .nav-pills .nav-item a {
    font-size: 16px;
    padding: 12px 20px;
    color: #333;
    border: 1px solid transparent;
    border-radius: 20px;
    transition: all 0.3s ease-in-out;
}
/* Styling untuk tab yang aktif */
.nav-pills .nav-item a.active {
    background-color: #6A9C89; /* Warna hijau sesuai tema */
    color: white;
    border-color: #6A9C89;
    box-shadow: 0 4px 10px rgba(106, 156, 137, 0.4);
}

    .job-item {
        background-color: #ffffff; /* Warna background putih */
        border-radius: 10px; /* Membuat sudut sedikit membulat */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Menambahkan bayangan untuk efek kedalaman */
        padding: 20px; /* Menambahkan jarak di dalam box */
        transition: transform 0.3s ease, box-shadow 0.3s ease; /* Animasi saat hover */
    }

    .job-item:hover {
        transform: translateY(-5px); /* Efek naik sedikit saat dihover */
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15); /* Memperkuat bayangan saat hover */
    }

    .tab-class {
        border-radius: 10px;
        padding: 20px; /* Jarak di dalam container utama */
    }

    .tab-content {
        margin-top: 30px;
    }

    .container {
        max-width: 1200px; /* Mengatur lebar maksimum container */
        margin: auto; /* Memposisikan container di tengah */
    }
    
/* Tombol Pekerjaan Sesuai dengan Tema */
.btn-primary {
    background-color: #6A9C89; /* Warna tombol sesuai tema */
    border-color: #6A9C89; /* Warna border tombol */
}

.btn-primary:hover {
    background-color: #5b876f; /* Warna tombol saat hover */
    border-color: #5b876f; /* Warna border saat hover */
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
        <?php if(isset($_SESSION['username'])): ?>
            <div class="dropdown">
                <a href="#" class="btn btn-primary rounded-0 py-4 px-lg-5 d-none d-lg-block dropdown-toggle" style="background-color: #6A9C89; border-color: #6A9C89;" data-bs-toggle="dropdown" aria-expanded="false">
                    <?= $_SESSION['username']; ?>
                </a>
                <ul class="dropdown-menu position-absolute">
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

    <div class="container-fluid p-0" id="beranda">
            <div class="owl-carousel header-carousel position-relative">
                <div class="owl-carousel-item position-relative">
                    <img class="img-fluid" src="img/carausel-1.jpg" alt="">
                    <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center" style="background: rgba(43, 57, 64, .5);">
                        <div class="container">
                            <div class="row justify-content-start">
                                <div class="col-10 col-lg-8">
                                    <h1 class="display-3 text-white animated slideInDown mb-4">Karier yang Tepat, Masa Depan Cerah!</h1>
                                    
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
</div>


                <div class="tab-content">
<!-- Tab untuk pekerjaan -->
<div id="tab-1" class="tab-pane fade show active p-0">
    <?php
    // Include file koneksi database
    include 'db_connect.php';

    // Query untuk mengambil data pekerjaan beserta foto profil dari pengguna
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
    perusahaan.nama_perusahaan, 
    pengguna.foto_profil
  FROM pekerjaan
  JOIN perusahaan ON pekerjaan.id_perusahaan = perusahaan.id_perusahaan
  JOIN pengguna ON perusahaan.id_pengguna = pengguna.id_pengguna
  WHERE pengguna.peran = 'perusahaan'
  ORDER BY pekerjaan.tanggal_posting DESC LIMIT 4";

    $result = $conn->query($query);

    if ($result && $result->num_rows > 0): 
    ?>

    <?php while ($job = $result->fetch_assoc()): ?>
        <div class="job-item p-4 mb-4">
            <div class="row g-4">
                <!-- Kolom untuk logo perusahaan (foto_profil dari pengguna) -->
                <div class="col-sm-12 col-md-2 d-flex align-items-center justify-content-center">
                    <!-- Menampilkan foto profil perusahaan atau gambar default -->
                    <img src="../foto/<?= !empty($job['foto_profil']) ? htmlspecialchars($job['foto_profil']) : '../imgbk/default_logo.png'; ?>" 
                         class="img-fluid rounded" 
                         style="width: 100px; height: 100px; object-fit: cover;">
                </div>

                <!-- Kolom untuk detail pekerjaan -->
                <div class="col-sm-12 col-md-6 d-flex align-items-center">
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

                <!-- Kolom untuk tombol detail -->
                <div class="col-sm-12 col-md-4 d-flex flex-column align-items-start align-items-md-end justify-content-center">
                    <div class="d-flex mb-3">
                        <a href="detail_pekerjaan.php?id_pekerjaan=<?= $job['id_pekerjaan']; ?>" class="btn btn-primary mt-2">Lihat Detail Pekerjaan</a>
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
        echo '<div class="text-center mt-4">
                <button class="btn btn-lg btn-primary" onclick="window.location.href=\'daftar_pekerjaan.php\'">Cari Lebih Lanjut</button>
              </div>';
    } else {
        echo '<div class="text-center mt-4">
                <button class="btn btn-lg btn-primary" onclick="window.location.href=\'../login/login.php\'">Cari Lebih Lanjut</button>
              </div>';
    }
    ?>

    <?php else: ?>
        <p class="text-center">Tidak ada pekerjaan yang tersedia saat ini.</p>
    <?php endif; ?>
    <?php $conn->close(); ?>
</div>


                    <!-- Tab untuk perusahaan -->
                    <div id="tab-2" class="tab-pane fade p-0">
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
                        <?php if (!empty($companies)): ?>
                            <?php foreach ($companies as $company): ?>
                            <div class="job-item p-4 mb-4">
                                <div class="row g-4">
                                    <!-- Kolom untuk foto profil perusahaan -->
                                    <div class="col-sm-12 col-md-2 d-flex align-items-center justify-content-center">
                                     <!-- Menampilkan foto profil perusahaan atau gambar default -->
                                    <img src="../foto/<?= !empty($company['foto_profil']) ? htmlspecialchars($company['foto_profil']) : '../imgbk/default_logo.png'; ?>" 
                                        class="img-fluid rounded" 
                                        style="width: 100px; height: 100px; object-fit: cover;">
                                      </div>


                                    <!-- Kolom untuk detail perusahaan -->
                                    <div class="col-sm-12 col-md-6 d-flex align-items-center">
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

                                    <!-- Kolom untuk tombol detail -->
                                    <div class="col-sm-12 col-md-4 d-flex flex-column align-items-start align-items-md-end justify-content-center">
                                        <?php if (isset($_SESSION['pengguna_id']) && !empty($_SESSION['pengguna_id'])): ?>
                                            <a href="profil_perusahaan.php?id_perusahaan=<?= htmlspecialchars($company['id_perusahaan']); ?>" class="btn btn-primary">Lihat Detail</a>
                                        <?php else: ?>
                                            <a href="../login/login.php" class="btn btn-primary">Lihat Detail</a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>

                            <!-- Tombol Cari Lebih Lanjut -->
                            <div class="text-center mt-4">
                            <?php if (isset($_SESSION['pengguna_id'])): ?>
                                <button class="btn btn-lg btn-primary" onclick="window.location.href='daftar_perusahaan.php'">Cari Lebih Lanjut</button>
                            <?php else: ?>
                                <button class="btn btn-lg btn-primary" onclick="window.location.href='../login/login.php'">Cari Lebih Lanjut</button>
                            <?php endif; ?>
                            </div>
                        <?php else: ?>
                            <p class="text-center">Tidak ada perusahaan yang tersedia saat ini.</p>
                        <?php endif; ?>
                        <?php $conn->close(); ?>
                    </div>
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
