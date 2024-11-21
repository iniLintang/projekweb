<?php
// Konfigurasi koneksi database
$host = 'localhost'; // Host database
$user = 'root';      // Username database
$password = '';      // Password database
$dbname = 'lookwork2'; // Nama database

$conn = new mysqli($host, $user, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Mulai sesi
session_start();
$id_pencari_kerja = $_SESSION['pengguna_id'] ?? null; // Ambil ID pengguna dari sesi

if (!$id_pencari_kerja) {
    die("Silakan login untuk melihat perkembangan lamaran Anda.");
}

// Filter status
$status_filter = '';
if (isset($_GET['status']) && !empty($_GET['status'])) {
    $status_filter = "AND l.status = '" . $conn->real_escape_string($_GET['status']) . "'";
}

// Query untuk mendapatkan data lamaran
$sql = "
    SELECT 
        l.id_lamaran,
        p.judul_pekerjaan,
        l.status,
        l.tanggal_lamaran,
        l.deskripsi
    FROM 
        lamaran l
    JOIN 
        pekerjaan p ON l.id_pekerjaan = p.id_pekerjaan
    WHERE 
        l.id_pencari_kerja = ? $status_filter
    ORDER BY 
        l.tanggal_lamaran DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_pencari_kerja);
$stmt->execute();
$result = $stmt->get_result();
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
        <!-- Spinner -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->

        <!-- Navbar -->
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
                    <a href="index_2.html" class="nav-item nav-link active">Beranda</a>
                    <a href="index_2.html#tentang" class="nav-item nav-link">Tentang</a>
                    <a href="index_2.html#testi" class="nav-item nav-link">Testi</a>
                    <a href="index_2.html#kontak" class="nav-item nav-link">Kontak</a>
                    <a href="daftar_pekerjaan.html" class="nav-item nav-link">Pekerjaan</a>
                    <a href="daftar_perusahaan.html" class="nav-item nav-link">Perusahaan</a>
                    <a href="notifikasi.html" class="nav-item nav-link">Notifikasi</a>
                </div>
                
                <!-- Tombol di kanan -->
                <?php if(isset($_SESSION['username'])): ?>
                    <div class="dropdown">
                        <a href="#" class="btn btn-primary rounded-0 py-4 px-lg-5 d-none d-lg-block dropdown-toggle" style="background-color: #6A9C89; border-color: #6A9C89;" data-bs-toggle="dropdown">
                            <?php echo htmlspecialchars($_SESSION['username']); ?>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="profil.html">Profil</a></li>
                            <li><a class="dropdown-item" href="logout.php">Keluar</a></li>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
        </nav>
        <!-- Navbar End -->

        <!-- Notifikasi Lamaran -->
        <div class="container my-4">
    <h2>Notifikasi Lamaran Anda</h2>
    <form method="GET" action="" class="mb-3">
        <div class="row">
            <div class="col-md-4">
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="dikirim" <?= (isset($_GET['status']) && $_GET['status'] == 'dikirim') ? 'selected' : ''; ?>>Dikirim</option>
                    <option value="diproses" <?= (isset($_GET['status']) && $_GET['status'] == 'diproses') ? 'selected' : ''; ?>>Diproses</option>
                    <option value="diterima" <?= (isset($_GET['status']) && $_GET['status'] == 'diterima') ? 'selected' : ''; ?>>Diterima</option>
                    <option value="ditolak" <?= (isset($_GET['status']) && $_GET['status'] == 'ditolak') ? 'selected' : ''; ?>>Ditolak</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
        </div>
    </form>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Pekerjaan</th>
                <th>Status</th>
                <th>Tanggal Lamaran</th>
                <th>Deskripsi</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php $i = 1; ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $i++; ?></td>
                        <td><?= htmlspecialchars($row['judul_pekerjaan']); ?></td>
                        <td>
                            <?php if ($row['status'] == 'dikirim'): ?>
                                <span class="badge bg-warning text-dark">Dikirim</span>
                            <?php elseif ($row['status'] == 'diproses'): ?>
                                <span class="badge bg-info text-white">Diproses</span>
                            <?php elseif ($row['status'] == 'diterima'): ?>
                                <span class="badge bg-success text-white">Diterima</span>
                            <?php elseif ($row['status'] == 'ditolak'): ?>
                                <span class="badge bg-danger text-white">Ditolak</span>
                            <?php endif; ?>
                        </td>
                        <td><?= date('d M, Y', strtotime($row['tanggal_lamaran'])); ?></td>
                        <td><?= htmlspecialchars($row['deskripsi']); ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">Tidak ada lamaran dengan status tersebut.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
        <!-- Footer -->
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
                                <i class="fa fa-envelope me-3"></i>Whatsapp : +<?php echo $no_wa; ?>
                            </a>
                        </p>
                    </div>
                </div>
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