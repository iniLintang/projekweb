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

</head>
<body data-bs-spy="scroll" data-bs-target=".navbar" data-bs-offset="70">
    <div class="container-xxl bg-white p-0">


    <nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
       <a href="index.php" class="navbar-brand d-flex align-items-center text-center py-0 px-4 px-lg-5">
    <h1 class="m-0" style="color: #16423C;">LookWork</h1>
</a>

            </a>
            <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav ms-auto p-4 p-lg-0">
                    <a href="index.php" class="nav-item nav-link active">Beranda</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pekerjaan</a>
                        <div class="dropdown-menu rounded-0 m-0">
                            <a href="daftar_loker.php" class="dropdown-item">Daftar Lowongan Pekerjaan</a>
                            <a href="daftar_lamaran.php" class="dropdown-item">Daftar Lamaran Pekerjaan</a>
                        </div>
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Profil</a>
                        <div class="dropdown-menu rounded-0 m-0">
                            <a href="pengaturan_profil.php" class="dropdown-item">Pengaturan Profil</a>
                            <a href="keluar.php" class="dropdown-item">Keluar</a>
                        </div>
                </div>
                <a href="tambah_pekerjaan.php" class="btn btn-primary rounded-0 py-4 px-lg-5 d-none d-lg-block" style="background-color: #6A9C89; border-color: #6A9C89;">Tambahkan Loker<i class="fa fa-arrow-right ms-3"></i></a>
                </div>
        </nav>
    </div>

    <body>
        <div class="container my-5">
            <!-- Profil Pengguna -->
            <div class="card mb-4">
                <div class="card-header">
                    <h3>Profil Pencari Kerja</h3>
                </div>
                <div class="card-body d-flex align-items-center">
                    <img src="<?php echo $user['foto_profil']; ?>" alt="Foto Profil" class="img-thumbnail me-4" style="width: 150px; height: 150px; object-fit: cover;">
                    <div>
                        <h4><?php echo $user['nama']; ?></h4>
                        <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
                        <p><strong>Keterangan:</strong> <?php echo $user['keterangan']; ?></p>
                        <a href="<?php echo $user['cv_url']; ?>" class="btn btn-primary btn-sm" target="_blank">Lihat CV</a>
                    </div>
                </div>
            </div>
    
            <!-- Pengalaman -->
            <div class="card mb-4">
                <div class="card-header">
                    <h3>Pengalaman</h3>
                </div>
                <div class="card-body">
                    <?php foreach ($experiences as $experience): ?>
                        <div class="mb-3">
                            <h5><?php echo $experience['nama_institusi']; ?></h5>
                            <p><strong>Jenis Pengalaman:</strong> <?php echo ucfirst($experience['jenis_pengalaman']); ?></p>
                            <p><strong>Periode:</strong> <?php echo date('d M Y', strtotime($experience['tanggal_mulai'])); ?> - <?php echo date('d M Y', strtotime($experience['tanggal_selesai'])); ?></p>
                            <p><strong>Deskripsi:</strong> <?php echo $experience['deskripsi_pengalaman']; ?></p>
                        </div>
                        <hr>
                    <?php endforeach; ?>
                </div>
            </div>
    
            <!-- Keterampilan -->
            <div class="card mb-4">
                <div class="card-header">
                    <h3>Keterampilan</h3>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <?php foreach ($skills as $skill): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <?php echo $skill['nama_keterampilan']; ?>
                                <a href="<?php echo $skill['sertifikat_url']; ?>" target="_blank" class="btn btn-outline-primary btn-sm">Lihat Sertifikat</a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
    
            <!-- Pendidikan -->
            <div class="card mb-4">
                <div class="card-header">
                    <h3>Pendidikan</h3>
                </div>
                <div class="card-body">
                    <?php foreach ($educations as $education): ?>
                        <div class="mb-3">
                            <h5><?php echo $education['institusi']; ?></h5>
                            <p><strong>Gelar:</strong> <?php echo $education['gelar']; ?> (<?php echo $education['bidang_studi']; ?>)</p>
                            <p><strong>Periode:</strong> <?php echo $education['tahun_mulai']; ?> - <?php echo $education['tahun_selesai']; ?></p>
                        </div>
                        <hr>
                    <?php endforeach; ?>
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

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <script src="js/main.js"></script>
    
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>