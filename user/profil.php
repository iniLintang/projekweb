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
        .section {
    margin-bottom: 30px;
    padding: 20px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease, border-radius 0.3s ease;

}

h1 {
    text-align: center;
    margin-top: 30px;
    margin-bottom: 20px;
}
h2 {
    color: #333;
    font-size: 22px;
    margin-bottom: 10px;
}

    .profile {
        display: flex;
    align-items: center;
    margin-bottom: 20px;
}

.profile-img img {
    width: 120px;
    height: 120px;
    object-fit: cover;
    margin-right: 20px;
}
.profile-info p {
    margin: 8px 0;
    font-size: 16px;
}

.profile-info strong {
        color: #16423C;
    }

    .edit-link {
    text-align: center;
    margin-top: 10px;
}
.btn-edit {
    display: inline-block;
    padding: 10px 20px;
    background-color: #6A9C89;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    font-weight: bold;
}

.btn-edit:hover {
    background-color: #333;
    }
   /* Edit Profil Button */
   .kelola-link a {
    color: #6A9C89;
    text-decoration: none;
    font-size: 14px;
}

.kelola-link a:hover {
    text-decoration: underline;
}

/* List Styles */
ul {
    list-style-type: none;
    padding-left: 0;
}

ul li {
    margin: 8px 0;
    font-size: 16px;
    background-color: #f9f9f9;
    padding: 10px;
    border-radius: 5px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}
.section:hover {
    transform: translateY(-5px); 
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2); 
    border-radius: 12px; 
}
@media (max-width: 768px) {
    .container {
        width: 95%;
    }

    .profile {
        flex-direction: column;
        text-align: center;
    }

    .profile-info {
        margin-top: 15px;
    }

    .profile-img img {
        width: 100px;
        height: 100px;
    }

    .section {
        padding: 15px;
    }
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


<body>
    <div class="container">
        <h1>Profil Pengguna</h1>
        
        <!-- Profil Section -->
        <div class="section profile-container">
            <div class="profile">
                <div class="profile-img">
                    <img src="<?= $user['foto_profil'] ? '../foto/' . $user['foto_profil'] : 'default.jpg'; ?>" alt="Foto Profil">
                </div>
                <div class="profile-info">
                    <p><strong>Nama:</strong> <?= htmlspecialchars($user['nama']); ?></p>
                    <p><strong>Email:</strong> <?= htmlspecialchars($user['email']); ?></p>
                    <p><strong>Username:</strong> <?= htmlspecialchars($user['username']); ?></p>
                    <p><strong>Peran:</strong> <?= htmlspecialchars($user['peran']); ?></p>
                </div>
            </div>
            <div class="edit-link">
                <a href="update_profile.php" class="btn-edit">Edit Profil</a>
            </div>
        </div>

        <!-- Pendidikan Section -->
        <div class="section pendidikan-container">
            <h2>Pendidikan</h2>
            <span class="kelola-link"><a href="education.php">Kelola Pendidikan</a></span>
            <ul>
                <?php while ($row = $pendidikan->fetch_assoc()): ?>
                    <li><?= htmlspecialchars($row['institusi']); ?> (<?= htmlspecialchars($row['tahun_mulai']); ?> - <?= htmlspecialchars($row['tahun_selesai']); ?>)</li>
                <?php endwhile; ?>
            </ul>
        </div>

        <!-- Pengalaman Section -->
        <div class="section pengalaman-container">
            <h2>Pengalaman</h2>
            <span class="kelola-link"><a href="experience.php">Kelola Pengalaman</a></span>
            <ul>
                <?php while ($row = $pengalaman->fetch_assoc()): ?>
                    <li><?= htmlspecialchars($row['nama_institusi']); ?> - <?= htmlspecialchars($row['jenis_pengalaman']); ?> (<?= htmlspecialchars($row['tanggal_mulai']); ?> - <?= htmlspecialchars($row['tanggal_selesai']); ?>)</li>
                <?php endwhile; ?>
            </ul>
        </div>

        <!-- Keterampilan Section -->
        <div class="section keterampilan-container">
            <h2>Keterampilan</h2>
            <span class="kelola-link"><a href="skills.php">Kelola Keterampilan</a></span>
            <ul>
                <?php while ($row = $keterampilan->fetch_assoc()): ?>
                    <li><?= htmlspecialchars($row['nama_keterampilan']); ?></li>
                <?php endwhile; ?>
            </ul>
        </div>
    </div>
</body>



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
