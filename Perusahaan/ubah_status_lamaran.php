<?php
require_once 'db_connect.php'; 
session_start();
// Mengecek apakah ada parameter id dan status yang dikirimkan
if (isset($_GET['id']) && isset($_GET['status'])) {
    $id_lamaran = $_GET['id'];
    $status_baru = $_GET['status'];

    // Mengambil data lamaran untuk memastikan lamaran yang dimaksud ada
    $sql = "SELECT l.id_lamaran, l.status, p.nama AS nama_pencari, p.cv_url, p.surat_lamaran, l.id_pekerjaan
            FROM lamaran l
            JOIN pengguna p ON l.id_pencari_kerja = p.id_pengguna
            WHERE l.id_lamaran = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_lamaran]);
    $lamaran = $stmt->fetch();

    if ($lamaran) {
        if ($status_baru == 'Diproses' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $deskripsi = $_POST['deskripsi'];
            // Update status menjadi Diproses dan tambahkan deskripsi
            $sql_update = "UPDATE lamaran SET status = ?, deskripsi = ? WHERE id_lamaran = ?";
            $stmt_update = $pdo->prepare($sql_update);
            $stmt_update->execute([$status_baru, $deskripsi, $id_lamaran]);
        } else {
            // Update status tanpa deskripsi tambahan
            $sql_update = "UPDATE lamaran SET status = ? WHERE id_lamaran = ?";
            $stmt_update = $pdo->prepare($sql_update);
            $stmt_update->execute([$status_baru, $id_lamaran]);
        }

        // Redirect ke halaman daftar lamaran setelah update
        header("Location: view_lamaran.php?id_pekerjaan=" . $lamaran['id_pekerjaan']);
        exit();
    } else {
        echo "<p>Lamaran tidak ditemukan!</p>";
    }
} else {
    echo "<p>ID lamaran atau status tidak diberikan!</p>";
}
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
            h1 {
                text-align: center;
                margin-bottom: 30px
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

    <div class="container mt-5">
    <h1>Perbarui Status Lamaran</h1>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi (Opsional):</label>
                            <textarea id="deskripsi" name="deskripsi" class="form-control" rows="4" placeholder="Masukkan deskripsi tambahan jika diperlukan..."></textarea>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-success px-4 py-2">Simpan Status</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        

        <!-- Footer -->
        <?php $no_wa = 6282266479716; ?>
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
        <!-- End Footer -->

        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
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
