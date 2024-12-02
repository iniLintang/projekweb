<?php
session_start();
require 'db_connect.php'; // Pastikan file koneksi database sesuai

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['pengguna_id'])) {
    header("Location: ../login/login.php");
    exit();
}

// Ambil `id_pekerjaan` dari parameter GET dan validasi
if (!isset($_GET['id_pekerjaan']) || !is_numeric($_GET['id_pekerjaan'])) {
    die("ID pekerjaan tidak valid.");
}

$id_pekerjaan = intval($_GET['id_pekerjaan']);
$id_pengguna = $_SESSION['pengguna_id'];

// Ambil data pekerjaan berdasarkan `id_pekerjaan`
$query_pekerjaan = $conn->prepare("
    SELECT 
        p.judul_pekerjaan
    FROM pekerjaan p
    WHERE p.id_pekerjaan = ?
");
$query_pekerjaan->bind_param("i", $id_pekerjaan);
$query_pekerjaan->execute();
$result_pekerjaan = $query_pekerjaan->get_result();

if ($result_pekerjaan->num_rows > 0) {
    $pekerjaan = $result_pekerjaan->fetch_assoc();
} else {
    die("Pekerjaan tidak ditemukan.");
}

// Ambil data pengguna berdasarkan `id_pengguna`
$query_pengguna = $conn->prepare("
    SELECT 
        nama
    FROM pengguna 
    WHERE id_pengguna = ?
");
$query_pengguna->bind_param("i", $id_pengguna);
$query_pengguna->execute();
$result_pengguna = $query_pengguna->get_result();

if ($result_pengguna->num_rows > 0) {
    $pengguna = $result_pengguna->fetch_assoc();
} else {
    die("Pengguna tidak ditemukan.");
}

// Tampilkan nama pengguna dan judul pekerjaan
$nama_pengguna = $pengguna['nama'];
$judul_pekerjaan = $pekerjaan['judul_pekerjaan'];
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
    <style>
        body {
            font-family: 'Heebo', sans-serif;
            background-color: #f4f4f9;
        }
        .form-container {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 30px;
            max-width: 600px;
            margin: 50px auto;
        }
        .form-container h2 {
            color: #16423C;
            font-weight: 700;
            margin-bottom: 20px;
            text-align: center;
        }
        .form-group label {
            font-weight: 600;
            color: #333;
        }
        .form-group input[type="file"] {
            border: 2px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            width: 100%;
            margin-top: 5px;
        }
        .form-group input[type="file"]:focus {
            border-color: #6A9C89;
            box-shadow: 0 0 5px rgba(106, 156, 137, 0.5);
        }
        .btn-submit {
            background-color: #6A9C89;
            border-color: #6A9C89;
            color: white;
            margin-top: 20px; 
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: 600;
            width: 100%;
            transition: background-color 0.3s ease;
        }
        .btn-submit:hover {
            background-color: #548b74;
        }
        .file-details {
            margin: 15px 0;
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

    <!-- Form Upload Surat Lamaran -->
    <div class="form-container">
            <h2>Upload Surat Lamaran dan CV</h2>
            <form action="upload_lamaran.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="judul_pekerjaan">Nama Pekerjaan:</label>
                    <p class="file-details"><strong><?= htmlspecialchars($judul_pekerjaan); ?></strong></p>
                    <input type="hidden" name="judul_pekerjaan" value="<?= htmlspecialchars($judul_pekerjaan); ?>">
                </div>

                <div class="form-group">
                    <label for="nama_pengguna">Nama:</label>
                    <p class="file-details"><strong><?= htmlspecialchars($nama_pengguna); ?></strong></p>
                    <input type="hidden" name="nama" value="<?= htmlspecialchars($nama_pengguna); ?>">
                </div>

                <div class="form-group">
                    <label for="surat_lamaran">Upload Surat Lamaran (PDF):</label>
                    <input type="file" id="surat_lamaran" name="surat_lamaran" accept=".pdf" required>
                </div>

                <div class="form-group">
                    <label for="cv">Upload CV (PDF):</label>
                    <input type="file" id="cv" name="cv" accept=".pdf" required>
                </div>

                <button type="submit" class="btn-submit">Kirim</button>
            </form>
        </div>
    </div>
        
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="lib/wow/wow.min.js"></script>
        <script src="lib/easing/easing.min.js"></script>
        <script src="lib/waypoints/waypoints.min.js"></script>
        <script src="lib/owlcarousel/owl.carousel.min.js"></script>
        <script src="js/main.js"></script>

    </body>
</body>
</html>
