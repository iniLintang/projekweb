<?php
session_start();
include 'db_connect.php';


// Pastikan pengguna sudah login sebelum mengakses halaman ini
if (!isset($_SESSION['pengguna_id'])) {
    header("Location: ../login/login.php");
    exit;
}

// Mendapatkan ID pengguna dari sesi
$id_pengguna = intval($_SESSION['pengguna_id']);
if (!$id_pengguna) {
    echo "ID pengguna tidak valid.";
    exit;
}

// Mendapatkan ID perusahaan berdasarkan ID pengguna (gunakan prepared statement)
$perusahaanQuery = $conn->prepare("SELECT id_perusahaan FROM perusahaan WHERE id_pengguna = ?");
$perusahaanQuery->bind_param("i", $id_pengguna);
$perusahaanQuery->execute();
$perusahaanResult = $perusahaanQuery->get_result();
$perusahaanRow = $perusahaanResult->fetch_assoc();

if (!$perusahaanRow) {
    echo "Perusahaan tidak ditemukan untuk pengguna ini.";
    exit;
}

$id_perusahaan = $perusahaanRow['id_perusahaan'];

// Query untuk mendapatkan daftar pekerjaan yang diposting oleh perusahaan ini
$pekerjaanQuery = $conn->prepare("SELECT id_pekerjaan, judul_pekerjaan FROM pekerjaan WHERE id_perusahaan = ?");
$pekerjaanQuery->bind_param("i", $id_perusahaan);
$pekerjaanQuery->execute();
$pekerjaanResult = $pekerjaanQuery->get_result();
$pekerjaanList = $pekerjaanResult->fetch_all(MYSQLI_ASSOC);

// Memeriksa apakah pekerjaan dipilih
$id_pekerjaan = isset($_GET['id_pekerjaan']) ? intval($_GET['id_pekerjaan']) : null;

// Query untuk mendapatkan daftar lamaran jika pekerjaan dipilih
$lamaranList = [];
if ($id_pekerjaan) {
    $query = $conn->prepare(
        "SELECT l.id_lamaran, l.status, l.deskripsi, p.judul_pekerjaan, u.nama AS nama_pencari 
         FROM lamaran l 
         JOIN pekerjaan p ON l.id_pekerjaan = p.id_pekerjaan 
         JOIN pengguna u ON l.id_pencari_kerja = u.id_pengguna 
         WHERE p.id_perusahaan = ? AND l.id_pekerjaan = ?"
    );
    $query->bind_param("ii", $id_perusahaan, $id_pekerjaan);
    $query->execute();
    $result = $query->get_result();
    $lamaranList = $result->fetch_all(MYSQLI_ASSOC);
}


// Update status lamaran dan kirim email
if (isset($_POST['update_status'])) {
    $id_lamaran = intval($_POST['id_lamaran']);
    $status_baru = mysqli_real_escape_string($conn, $_POST['status_lamaran']);

    // Gunakan prepared statement untuk update
    $update_query = $conn->prepare("UPDATE lamaran SET status = ? WHERE id_lamaran = ?");
    $update_query->bind_param("si", $status_baru, $id_lamaran);
    if ($update_query->execute()) {
        // Mengambil email pengguna
        $email_query = $conn->prepare(
            "SELECT u.email 
             FROM lamaran l 
             JOIN pengguna u ON l.id_pencari_kerja = u.id_pengguna 
             WHERE l.id_lamaran = ?"
        );
        $email_query->bind_param("i", $id_lamaran);
        $email_query->execute();
        $email_result = $email_query->get_result();
        $email_row = $email_result->fetch_assoc();

        if ($email_row && !empty($email_row['email'])) {
            $email_pencari_kerja = $email_row['email'];
            // Kirim email pemberitahuan status lamaran
            $subject = "Update Status Lamaran";
            $message = "Status lamaran Anda telah diperbarui menjadi: $status_baru.";
            $headers = "From: info@lookwork.com";

            if (mail($email_pencari_kerja, $subject, $message, $headers)) {
                echo "Email berhasil dikirim.";
            } else {
                echo "Gagal mengirim email.";
            }
        }
    } else {
        echo "Gagal memperbarui status lamaran.";
    }
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
    <div class="container mt-5">
        <h2>Daftar Lamaran Pekerjaan</h2>

        <!-- Filter Pekerjaan -->
        <form method="GET" action="daftar_lamaran.php" class="mb-3">
            <label for="pekerjaan">Pilih Pekerjaan:</label>
            <select name="id_pekerjaan" id="pekerjaan" class="form-select">
                <option value="">-- Pilih Pekerjaan --</option>
                <?php foreach ($pekerjaanList as $pekerjaan): ?>
                    <option value="<?= $pekerjaan['id_pekerjaan']; ?>" <?= ($id_pekerjaan == $pekerjaan['id_pekerjaan']) ? 'selected' : ''; ?>>
                        <?= htmlspecialchars($pekerjaan['judul_pekerjaan']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="btn btn-primary">Tampilkan Lamaran</button>
        </form>

        <!-- Menampilkan Daftar Lamaran -->
        <?php if ($id_pekerjaan): ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama Pencari Kerja</th>
                        <th>Status</th>
                        <th>Surat Lamaran</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lamaranList as $data): ?>
                        <tr>
                        <td>
                            <a href="profile_pencari_kerja.php?id_pengguna=<?= urlencode($data['id_pencari_kerja']); ?>" 
                            class="btn btn-primary">
                            <?= htmlspecialchars($data['nama_pencari']); ?>
                            </a>
                        </td>
                            <td><?= htmlspecialchars($data['status']); ?></td>
                            <td><a href="surat_lamaran.php?id=<?= urlencode($data['id_lamaran']); ?>">Lihat Surat Lamaran</a></td>
                            <td>
                                <form method="POST">
                                    <input type="hidden" name="id_lamaran" value="<?= $data['id_lamaran']; ?>">
                                    <select name="status_lamaran" class="form-select">
                                        <option value="Dikirim" <?= $data['status'] === 'Dikirim' ? 'selected' : ''; ?>>Dikirim</option>
                                        <option value="Diproses" <?= $data['status'] === 'Diproses' ? 'selected' : ''; ?>>Diproses</option>
                                        <option value="Diterima" <?= $data['status'] === 'Diterima' ? 'selected' : ''; ?>>Diterima</option>
                                        <option value="Ditolak" <?= $data['status'] === 'Ditolak' ? 'selected' : ''; ?>>Ditolak</option>
                                    </select>
                                    <button type="submit" name="update_status">Ubah Status</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
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