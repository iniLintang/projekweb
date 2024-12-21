<?php
// Koneksi ke database
session_start();
include 'db_connect.php';

// Mengecek apakah parameter id_perusahaan ada di URL
if (isset($_GET['id_perusahaan'])) {
    $id_perusahaan = $_GET['id_perusahaan'];

    // Query untuk mendapatkan pekerjaan berdasarkan id_perusahaan
    $query = "SELECT * FROM pekerjaan WHERE id_perusahaan = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_perusahaan);
    $stmt->execute();
    $result_jobs = $stmt->get_result();

    // Query untuk mendapatkan detail perusahaan
    $query_company = "SELECT * FROM perusahaan WHERE id_perusahaan = ?";
    $stmt_company = $conn->prepare($query_company);
    $stmt_company->bind_param("i", $id_perusahaan);
    $stmt_company->execute();
    $result_company = $stmt_company->get_result();
    $company = $result_company->fetch_assoc();
} else {
    echo "ID Perusahaan tidak valid!";
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
    border-radius: 10px; 
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); 
    padding: 20px; 
    transition: transform 0.3s ease, box-shadow 0.3s ease, border-radius 0.3s ease; 
}

.job-item:hover {
    transform: translateY(-5px); 
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15); 
    border-radius: 12px; 
}

.container .row .col-md-4 {
    display: flex;
    justify-content: center; 
    align-items: center; 
}

.container .row .col-md-4 .profile-container {
    background-color: #f9f9f9; 
    padding: 15px; 
    border-radius: 10px; 
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); 
    max-width: 200px; 
 
}
.profile-container:hover {
    transform: translateY(-5px); 
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15); 
    border-radius: 12px; 
}
.container .row .col-md-4 img {
    width: 100%; 
    height: auto; 
    border-radius: 10px; 
}

.container .row .col-md-8 {
    padding-left: 15px; 
}
.detail-container {
    background-color: #ffffff; 
    padding: 20px; 
    border-radius: 10px; 
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); 
    margin-top: 20px; 
    transition: transform 0.3s ease, box-shadow 0.3s ease, border-radius 0.3s ease; 

}

.detail-container h2 {
    color: #333; 
    font-size: 24px; 
}


.detail-container p {
    color: #666; 
    font-size: 16px; 
}
.detail-container:hover {
    transform: translateY(-5px); 
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15); 
    border-radius: 12px; 
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

<!-- Profil Perusahaan -->
        <div class="container my-4">
        <?php
        // Query untuk mendapatkan detail pengguna berdasarkan id_pengguna
        $query_user = "SELECT * FROM pengguna WHERE id_pengguna = ?";
        $stmt_user = $conn->prepare($query_user);
        $stmt_user->bind_param("i", $company['id_pengguna']);
        $stmt_user->execute();
        $result_user = $stmt_user->get_result();
        $user = $result_user->fetch_assoc();
        ?>

        <div class="container my-4">
            <div class="row align-items-center">
                <div class="col-md-4">
                    <!-- Menampilkan foto profil pengguna (pemilik perusahaan) -->
                    <div class="profile-container">
                        <?php if (!empty($user['foto_profil'])): ?>
                            <img class="img-fluid rounded" src="../foto/<?= htmlspecialchars($user['foto_profil']); ?>" alt="<?= htmlspecialchars($user['nama']); ?>">
                        <?php else: ?>
                            <img src="../imgbk/default_user.png" class="img-fluid rounded" alt="Foto Profil Pengguna">
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-7">
                    <!-- Menampilkan detail perusahaan -->
                    <div class="detail-container">
                        <h2><?= !empty($company['nama_perusahaan']) ? $company['nama_perusahaan'] : 'Tidak Tersedia'; ?></h2>
                        <p><strong>Industri:</strong> <?= !empty($company['industri']) ? $company['industri'] : 'Industri tidak tersedia'; ?></p>
                        <p><strong>Lokasi:</strong> <?= !empty($company['lokasi_perusahaan']) ? $company['lokasi_perusahaan'] : 'Lokasi tidak tersedia'; ?></p>
                        <p><strong>Deskripsi:</strong></p>
                        <p><?= !empty($company['deskripsi_perusahaan']) ? nl2br($company['deskripsi_perusahaan']) : 'Tidak ada deskripsi.'; ?></p>
                    </div>
                </div>
            </div>
        </div>

        </div>



<!-- Daftar Pekerjaan di Perusahaan -->
<div class="container my-4">
    <h3>Pekerjaan yang Tersedia</h3>
    <div class="row">
        <?php if ($result_jobs->num_rows > 0): ?>
            <?php while ($job = $result_jobs->fetch_assoc()): ?>
                <div class="col-md-6 mb-4">
                    <!-- Job Item dengan Background -->
                    <div class="job-item p-4 border rounded shadow-sm" style="background-color: #f9f9fb; min-height: 200px; display: flex; flex-direction: column; justify-content: space-between;">
                        <div>
                            <h5><?= $job['judul_pekerjaan']; ?></h5>
                            <p class="mb-1"><i class="fa fa-map-marker-alt text-primary"></i> <?= $job['lokasi']; ?></p>
                            <p class="mb-1"><i class="fa fa-building text-primary"></i> <?= $job['jenis_pekerjaan']; ?></p>
                            <p class="mb-1"><i class="fa fa-money-bill-alt text-primary"></i> <?= $job['gaji_dari']; ?> - <?= $job['gaji_hingga']; ?></p>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <!-- Add margin to button for spacing -->
                            <a href="detail_pekerjaan.php?id_pekerjaan=<?= $job['id_pekerjaan']; ?>" class="btn btn-primary" style="margin-left: auto; margin-top: 10px;">Lihat Detail Pekerjaan</a>
                        </div>
                        <small class="text-muted d-block text-end mt-2"><i class="fa fa-calendar-alt text-primary"></i> Diposting pada <?= date('d M, Y', strtotime($job['tanggal_posting'])); ?></small>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Belum ada pekerjaan yang tersedia di perusahaan ini.</p>
        <?php endif; ?>
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
        
        </html>