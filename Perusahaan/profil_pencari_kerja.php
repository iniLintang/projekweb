<?php
session_start(); // Memulai sesi

// Konfigurasi database
$host = 'localhost';
$dbname = 'lookwork2';
$username = 'root';
$password = '';

try {
    // Membuat koneksi database menggunakan PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}

// Pastikan pengguna yang melihat adalah perusahaan
if (!isset($_SESSION['pengguna_id']) || $_SESSION['peran'] !== 'perusahaan') {
    die("Anda tidak memiliki akses untuk melihat halaman ini.");
}

// Mendapatkan ID pengguna (pencari kerja) yang ingin dilihat
if (!isset($_GET['id_pengguna'])) {
    die("ID pengguna tidak ditemukan.");
}

$id_pengguna = $_GET['id_pengguna'];

// Mengambil data profil pengguna
$stmt = $pdo->prepare("SELECT * FROM pengguna WHERE id_pengguna = :id_pengguna AND peran = 'pencari_kerja'");
$stmt->execute(['id_pengguna' => $id_pengguna]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("Profil pengguna tidak ditemukan.");
}

// Mengambil data pengalaman
$stmt = $pdo->prepare("SELECT * FROM pengalaman WHERE id_pencari_kerja = :id_pencari_kerja");
$stmt->execute(['id_pencari_kerja' => $id_pengguna]);
$experiences = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Mengambil data keterampilan
$stmt = $pdo->prepare("SELECT * FROM keterampilan WHERE id_pencari_kerja = :id_pencari_kerja");
$stmt->execute(['id_pencari_kerja' => $id_pengguna]);
$skills = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Mengambil data pendidikan
$stmt = $pdo->prepare("SELECT * FROM pendidikan WHERE id_pencari_kerja = :id_pencari_kerja");
$stmt->execute(['id_pencari_kerja' => $id_pengguna]);
$educations = $stmt->fetchAll(PDO::FETCH_ASSOC);
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

            .btn {
            background-color: #6A9C89;
            border: none;
            color: white;
            border-radius: 5px;
            padding: 10px 20px;
            font-size: 14px;
            cursor: pointer;
        }
        .card {
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
        transform: translateY(-10px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
    }

    .profile-img {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border-radius: 50%;
        transition: transform 0.3s ease;
    }

    .profile-img:hover {
        transform: scale(1.1);
    }

    .profile-card, .experience-card, .skills-card, .education-card {
        opacity: 0;
        transform: translateY(20px);
        animation: fadeInUp 0.6s forwards;
    }

    .experience-card {
        animation-delay: 0.2s;
    }

    .skills-card {
        animation-delay: 0.4s;
    }

    .education-card {
        animation-delay: 0.6s;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    </style>
</head>
<body>
    <div class="container-xxl bg-white p-0">
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        </div>

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
                        <a href="#" class="nav-link active dropdown-toggle" data-bs-toggle="dropdown">Pekerjaan</a>
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
        
    <div class="container my-5">
        <!-- Profil Pengguna -->
        <div class="card profile-card mb-4">
            <div class="card-header">
                <h3>Profil Pencari Kerja</h3>
            </div>
            <div class="card-body d-flex align-items-center">
                <img src="<?php echo htmlspecialchars($user['foto_profil']); ?>" alt="Foto Profil" class="img-thumbnail profile-img me-4">
                <div>
                    <h4><?php echo htmlspecialchars($user['nama']); ?></h4>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                    <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
                </div>
            </div>
        </div>
    
        <!-- Pengalaman -->
        <div class="card mb-4 experience-card">
            <div class="card-header">
                <h3>Pengalaman</h3>
            </div>
            <div class="card-body">
                <?php foreach ($experiences as $experience): ?>
                    <div class="mb-3">
                        <h5><?php echo htmlspecialchars($experience['nama_institusi']); ?></h5>
                        <p><strong>Jenis Pengalaman:</strong> <?php echo ucfirst(htmlspecialchars($experience['jenis_pengalaman'])); ?></p>
                        <p><strong>Periode:</strong> <?php echo date('d M Y', strtotime($experience['tanggal_mulai'])); ?> - <?php echo date('d M Y', strtotime($experience['tanggal_selesai'])); ?></p>
                        <p><strong>Deskripsi:</strong> <?php echo htmlspecialchars($experience['deskripsi_pengalaman']); ?></p>
                    </div>
                    <hr>
                <?php endforeach; ?>
            </div>
        </div>
    
        <!-- Keterampilan -->
        <div class="card mb-4 skills-card">
            <div class="card-header">
                <h3>Keterampilan</h3>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    <?php foreach ($skills as $skill): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <?php echo htmlspecialchars($skill['nama_keterampilan']); ?>
                            <?php if (!empty($skill['sertifikat_url'])): ?>
                                <a href="<?php echo htmlspecialchars($skill['sertifikat_url']); ?>" target="_blank" class="btn btn-outline-primary btn-sm">Lihat Sertifikat</a>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    
        <!-- Pendidikan -->
        <div class="card mb-4 education-card">
            <div class="card-header">
                <h3>Pendidikan</h3>
            </div>
            <div class="card-body">
                <?php foreach ($educations as $education): ?>
                    <div class="mb-3">
                        <h5><?php echo htmlspecialchars($education['institusi']); ?></h5>
                        <p><strong>Gelar:</strong> <?php echo htmlspecialchars($education['gelar']); ?> (<?php echo htmlspecialchars($education['bidang_studi']); ?>)</p>
                        <p><strong>Periode:</strong> <?php echo htmlspecialchars($education['tahun_mulai']); ?> - <?php echo htmlspecialchars($education['tahun_selesai']); ?></p>
                    </div>
                    <hr>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <!-- JS Files -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>
