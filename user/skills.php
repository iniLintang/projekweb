<?php
session_start();
require 'db_connect.php';

if (!isset($_SESSION['pengguna_id'])) {
    header("Location: ../login/login.php");
    exit();
}

$id_pengguna = $_SESSION['pengguna_id'];

// Ambil data keterampilan
$query = $conn->prepare("SELECT * FROM keterampilan WHERE id_pencari_kerja = ?");
$query->bind_param("i", $id_pengguna);
$query->execute();
$keterampilan = $query->get_result();
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
            text-align: center;
        }
.form-style {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        .form-label {
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .table th {
            background-color: #ffffff;
            color: #393e44;
            padding: 12px 15px;
            text-align: left;
            font-weight: bold;
        }

        .table tr:nth-child(even) {
            background-color: #393e44;
            color: white;
        }

        .table tr:nth-child(odd) {
            background-color: #f8f9fa;
        }

        .table td {
            padding: 12px 15px;
            border: 1px solid #dee2e6;
            text-align: left;
        }

        .btn {
            border-radius: 5px;
            padding: 10px 20px;
            font-size: 14px;
            cursor: pointer;
        }

        .btn-warning {
            background-color: #ffcc00;
            border: none;
            color: white;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            color: white;
        }

        .btn-success {
            background-color: #6A9C89;
            border: none;
            color: white;
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
        <div class="container mt-5">
        <h1>Kelola Keterampilan</h1>
        <form action="process.php" method="POST" class="form-style">
            <input type="hidden" name="action" value="add_skill">
            <div class="mb-3">
                <label for="nama_keterampilan" class="form-label">Nama Keterampilan:</label>
                <input type="text" name="nama_keterampilan" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="sertifikat_url" class="form-label">Sertifikat URL:</label>
                <input type="url" name="sertifikat_url" class="form-control">
            </div>
            <button type="submit" class="btn btn-success">Tambah</button>
        </form>

        <h2 class="mt-5">Daftar Keterampilan</h2>
        <table class="table table-bordered table-striped mt-3">
            <thead>
                <tr>
                    <th>Nama Keterampilan</th>
                    <th>Sertifikat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $keterampilan->fetch_assoc()): ?>
                <tr>
                    <form action="process.php" method="POST">
                        <input type="hidden" name="action" value="update_skill">
                        <input type="hidden" name="id_keterampilan" value="<?= $row['id_keterampilan']; ?>">
                        <td><input type="text" name="nama_keterampilan" value="<?= htmlspecialchars($row['nama_keterampilan']); ?>" class="form-control"></td>
                        <td><input type="url" name="sertifikat_url" value="<?= htmlspecialchars($row['sertifikat_url']); ?>" class="form-control"></td>
                        <td>
                            <button type="submit" class="btn btn-warning">Update</button>
                            <a href="process.php?action=delete_skill&id_keterampilan=<?= $row['id_keterampilan']; ?>" class="btn btn-danger">Hapus</a>
                        </td>
                    </form>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
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
