<?php
session_start();
include 'db_connect.php';

// Pastikan pengguna sudah login
if (!isset($_SESSION['pengguna_id'])) {
    header("Location: ../login/login.php");
    exit;
}

$id_pengguna = intval($_SESSION['pengguna_id']);
if (!$id_pengguna) {
    echo "ID pengguna tidak valid.";
    exit;
}

// Mendapatkan ID perusahaan
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

// Mendapatkan daftar pekerjaan
$pekerjaanQuery = $conn->prepare("SELECT id_pekerjaan, judul_pekerjaan FROM pekerjaan WHERE id_perusahaan = ?");
$pekerjaanQuery->bind_param("i", $id_perusahaan);
$pekerjaanQuery->execute();
$pekerjaanResult = $pekerjaanQuery->get_result();
$pekerjaanList = $pekerjaanResult->fetch_all(MYSQLI_ASSOC);

$id_pekerjaan = isset($_GET['id_pekerjaan']) ? intval($_GET['id_pekerjaan']) : null;

// Mendapatkan daftar lamaran untuk pekerjaan yang dipilih
$lamaranList = [];
if ($id_pekerjaan) {
    $query = $conn->prepare("
        SELECT 
            l.id_lamaran, 
            l.status, 
            l.surat_lamaran, 
            l.cv, 
            l.link,
            l.deskripsi, 
            p.judul_pekerjaan, 
            u.nama AS nama_pencari, 
            u.id_pengguna AS id_pencari_kerja
        FROM lamaran l
        JOIN pekerjaan p ON l.id_pekerjaan = p.id_pekerjaan
        JOIN pengguna u ON l.id_pencari_kerja = u.id_pengguna
        WHERE p.id_perusahaan = ? AND l.id_pekerjaan = ?
    ");
    $query->bind_param("ii", $id_perusahaan, $id_pekerjaan);
    $query->execute();
    $result = $query->get_result();
    $lamaranList = $result->fetch_all(MYSQLI_ASSOC);
}

// Update status lamaran
if (isset($_POST['update_status'])) {
    $id_lamaran = intval($_POST['id_lamaran']);
    $status_baru = mysqli_real_escape_string($conn, $_POST['status_lamaran']);

    $update_query = $conn->prepare("UPDATE lamaran SET status = ? WHERE id_lamaran = ?");
    $update_query->bind_param("si", $status_baru, $id_lamaran);

    if ($update_query->execute()) {
        echo "<script>alert('Status lamaran berhasil diperbarui.');</script>";
    } else {
        echo "<script>alert('Gagal memperbarui status lamaran.');</script>";
    }
}

$nama_pencari = isset($_GET['nama_pencari']) ? "%" . $_GET['nama_pencari'] . "%" : "%";

$query = $conn->prepare("
    SELECT 
        l.id_lamaran, 
        l.status, 
        l.surat_lamaran, 
        l.cv,
         l.link, 
        l.deskripsi, 
        p.judul_pekerjaan, 
        u.nama AS nama_pencari, 
        u.id_pengguna AS id_pencari_kerja
    FROM lamaran l
    JOIN pekerjaan p ON l.id_pekerjaan = p.id_pekerjaan
    JOIN pengguna u ON l.id_pencari_kerja = u.id_pengguna
    WHERE p.id_perusahaan = ? 
        AND l.id_pekerjaan = ?
        AND u.nama LIKE ?
");
$query->bind_param("iis", $id_perusahaan, $id_pekerjaan, $nama_pencari);
$query->execute();
$result = $query->get_result();
$lamaranList = $result->fetch_all(MYSQLI_ASSOC);


if (isset($_POST['update_deskripsi'])) {
    $id_lamaran = intval($_POST['id_lamaran']);
    $deskripsi_baru = trim($_POST['deskripsi']);

    if (empty($deskripsi_baru)) {
        echo "<script>alert('Deskripsi tidak boleh kosong.');</script>";
    } else {
        $update_query = $conn->prepare("UPDATE lamaran SET deskripsi = ? WHERE id_lamaran = ?");
        $update_query->bind_param("si", $deskripsi_baru, $id_lamaran);

        if ($update_query->execute()) {
            echo "<script>alert('Deskripsi lamaran berhasil diperbarui.');</script>";
        } else {
            echo "Error: " . $update_query->error; // Debugging
        }
    }
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

    <body>
    <div class="container mt-5">
    <h1>Daftar Lamaran Pekerjaan</h1>

    <!-- Filter Pekerjaan -->
   <!-- Filter Pekerjaan dan Pencarian -->
<form method="GET" action="daftar_lamaran.php" class="mb-3">
    <div class="row mb-2">
        <div class="col-md-6">
            <label for="pekerjaan">Pilih Pekerjaan:</label>
            <select name="id_pekerjaan" id="pekerjaan" class="form-select">
                <option value="">-- Pilih Pekerjaan --</option>
                <?php foreach ($pekerjaanList as $pekerjaan): ?>
                    <option value="<?= $pekerjaan['id_pekerjaan']; ?>" <?= ($id_pekerjaan == $pekerjaan['id_pekerjaan']) ? 'selected' : ''; ?>>
                        <?= htmlspecialchars($pekerjaan['judul_pekerjaan']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-6">
            <label for="nama_pencari">Cari Nama Pelamar:</label>
            <input type="text" name="nama_pencari" id="nama_pencari" class="form-control" value="<?= htmlspecialchars($_GET['nama_pencari'] ?? ''); ?>" placeholder="Masukkan nama pelamar">
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Tampilkan Lamaran</button>
</form>


    <!-- Daftar Lamaran -->
        <?php if ($id_pekerjaan): ?>
            <table class="table table-bordered">
            <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Pencari Kerja</th>
                <th>Status</th>
                <th>Surat Lamaran</th>
                <th>CV</th>
                <th>Link G-Drive</th>
                <th>Deskripsi</th>
                <th>Opsi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($lamaranList as $data): ?>
                <tr>
                    <td>
                        <a href="profil_pencari_kerja.php?id_pengguna=<?= urlencode($data['id_pencari_kerja']); ?>" class="btn btn-primary">
                            <?= htmlspecialchars($data['nama_pencari']); ?>
                        </a>
                    </td>
                    <td><?= htmlspecialchars($data['status']); ?></td>
                    <td>
                        <?php if (!empty($data['surat_lamaran'])): ?>
                            <a href="<?= '../uploads/' . htmlspecialchars($data['surat_lamaran']); ?>" target="_blank">Lihat Surat Lamaran</a>
                        <?php else: ?>
                            <span>Belum diunggah</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if (!empty($data['cv'])): ?>
                            <a href="<?= '../uploads/' . htmlspecialchars($data['cv']); ?>" target="_blank">Lihat CV</a>
                        <?php else: ?>
                            <span>Belum diunggah</span>
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($data['link']); ?></td>
                    <td><?= nl2br(htmlspecialchars($data['deskripsi'])); ?></td>
                    <td>
                        <form method="POST">
                            <input type="hidden" name="id_lamaran" value="<?= htmlspecialchars($data['id_lamaran']); ?>">
                            <select name="status_lamaran" class="form-select">
                                <option value="diproses" <?= $data['status'] === 'diproses' ? 'selected' : ''; ?>>Diproses</option>
                                <option value="diterima" <?= $data['status'] === 'diterima' ? 'selected' : ''; ?>>Diterima</option>
                                <option value="ditolak" <?= $data['status'] === 'ditolak' ? 'selected' : ''; ?>>Ditolak</option>
                            </select>
                            <input type="hidden" name="id_lamaran" value="<?= htmlspecialchars($data['id_lamaran']); ?>">
                            <textarea name="deskripsi" class="form-control" placeholder="Masukkan deskripsi"><?= htmlspecialchars($data['deskripsi']); ?></textarea>
                            <button type="submit" name="update_status" class="btn btn-primary mt-2">Ubah Status</button>
                            <button type="submit" name="update_deskripsi" class="btn btn-success mt-2">Simpan Deskripsi</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php else: ?>
        <p>Silakan pilih pekerjaan untuk melihat lamaran.</p>
    <?php endif; ?>
</div>


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