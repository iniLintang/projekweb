<?php
session_start();
require 'db_connect.php'; // File koneksi ke database

// Cek apakah pengguna telah login
if (!isset($_SESSION['pengguna_id'])) {
    header("Location: ../login/login.php");
    exit();
}

$id_pengguna = $_SESSION['pengguna_id'];

// Ambil data pengguna
$query = $conn->prepare("
    SELECT nama, email, username, foto_profil, peran 
    FROM pengguna 
    WHERE id_pengguna = ?");
$query->bind_param("i", $id_pengguna);
$query->execute();
$result = $query->get_result();
$user = $result->fetch_assoc();

// Ambil data pendidikan
$query_pendidikan = $conn->prepare("
    SELECT * FROM pendidikan 
    WHERE id_pencari_kerja = ?");
$query_pendidikan->bind_param("i", $id_pengguna);
$query_pendidikan->execute();
$pendidikan = $query_pendidikan->get_result();

// Ambil data pengalaman
$query_pengalaman = $conn->prepare("
    SELECT * FROM pengalaman 
    WHERE id_pencari_kerja = ?");
$query_pengalaman->bind_param("i", $id_pengguna);
$query_pengalaman->execute();
$pengalaman = $query_pengalaman->get_result();

// Ambil data keterampilan
$query_keterampilan = $conn->prepare("
    SELECT * FROM keterampilan 
    WHERE id_pencari_kerja = ?");
$query_keterampilan->bind_param("i", $id_pengguna);
$query_keterampilan->execute();
$keterampilan = $query_keterampilan->get_result();
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
        }

h1 {
        color: #16423C;
        font-size: 2.5rem;
        text-align: center;
        margin-top: 30px;
        font-weight: bold;
    }
    .profile {
        text-align: center;
        margin-bottom: 40px;
    }

    .profile img {
        border-radius: 50%;
        border: 4px solid #6A9C89;
        width: 150px;
        height: 150px;
        object-fit: cover;
        margin-bottom: 20px;
    }
    .profile p {
        font-size: 1.2rem;
        margin: 10px 0;
    }

    .profile p strong {
        color: #16423C;
        font-weight: bold;
    }
    h2 {
        color: #16423C;
        font-size: 1.8rem;
        display: inline-block;
        margin-top: 30px;
        margin-bottom: 10px;
        border-bottom: 2px solid #6A9C89;
        padding-bottom: 10px;
    }
    .kelola-link {
        float: right;
        font-size: 0.9rem;
        margin-top: 10px;
    }

    .kelola-link a {
        color: #6A9C89;
        text-decoration: none;
    }

    .kelola-link a:hover {
        color: #333;
    }
   /* Edit Profil Button */
   .edit-link {
        text-align: center;
        font-size: 0.9rem;
        margin-bottom: 10px;
    }

    .edit-link a {
        color: #6A9C89;
        text-decoration: none;
    }

    .edit-link a:hover {
        color: #333;
    }


.profil-list ul {
    list-style-type: none;
    padding: 0;
    font-size: 1.1rem;
}

.profil-list ul li {
    background-color: #f9f9f9;
    margin-bottom: 15px;
    padding: 15px;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.profil ul li:hover {
    background-color: #6A9C89;
    color: #fff;
    cursor: pointer;
}



</style>

    
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


        <body>
    <div class="container">
        <h1>Profil Pengguna</h1>
         <!-- Profil Section -->
         <div class="profile">
            <img src="<?= $user['foto_profil'] ? '../foto/' . $user['foto_profil'] : ''; ?>" alt="Foto Profil">
            <p><strong>Nama:</strong> <?= htmlspecialchars($user['nama']); ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($user['email']); ?></p>
            <p><strong>Username:</strong> <?= htmlspecialchars($user['username']); ?></p>
            <p><strong>Peran:</strong> <?= htmlspecialchars($user['peran']); ?></p>
        </div>

        <!-- Edit Profil Link -->
        <div class="edit-link">
            <a href="update_profile.php">Edit Profil</a>
        </div>

        <!-- Pendidikan Section -->
        <div class="pendidikan">
            <h2>Pendidikan</h2>
            <span class="kelola-link"><a href="education.php">Kelola Pendidikan</a></span>
            <ul>
                <?php while ($row = $pendidikan->fetch_assoc()): ?>
                    <li><?= htmlspecialchars($row['institusi']); ?> (<?= htmlspecialchars($row['tahun_mulai']); ?> - <?= htmlspecialchars($row['tahun_selesai']); ?>)</li>
                <?php endwhile; ?>
            </ul>
        </div>

        <!-- Pengalaman Section -->
        <div class="pengalaman">
            <h2>Pengalaman</h2>
            <span class="kelola-link"><a href="experience.php">Kelola Pengalaman</a></span>
            <ul>
                <?php while ($row = $pengalaman->fetch_assoc()): ?>
                    <li><?= htmlspecialchars($row['nama_institusi']); ?> - <?= htmlspecialchars($row['jenis_pengalaman']); ?> (<?= htmlspecialchars($row['tanggal_mulai']); ?> - <?= htmlspecialchars($row['tanggal_selesai']); ?>)</li>
                <?php endwhile; ?>
            </ul>
        </div>

        <!-- Keterampilan Section -->
        <div class="keterampilan">
            <h2>Keterampilan</h2>
            <span class="kelola-link"><a href="skills.php">Kelola Keterampilan</a></span>
            <ul>
                <?php while ($row = $keterampilan->fetch_assoc()): ?>
                    <li><?= htmlspecialchars($row['nama_keterampilan']); ?></li>
                <?php endwhile; ?>
            </ul>
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
