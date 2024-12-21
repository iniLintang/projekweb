<?php
session_start();
require 'db_connect.php';

if (!isset($_SESSION['pengguna_id'])) {
    header("Location: ../login/login.php");
    exit();
}

$id_pengguna = $_SESSION['pengguna_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $foto_profil = $_FILES['foto_profil'];
    $upload_error = '';

    // Proses upload foto profil
    if ($foto_profil['name']) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/jpg'];
        $max_size = 2 * 1024 * 1024; // Maksimal 2MB
        $target_dir = "../foto/";
        $file_name = uniqid() . "_" . basename($foto_profil["name"]);
        $target_file = $target_dir . $file_name;

        // Validasi tipe file
        if (!in_array($foto_profil['type'], $allowed_types)) {
            $upload_error = "Hanya file JPG, JPEG, dan PNG yang diperbolehkan.";
        }
        // Validasi ukuran file
        elseif ($foto_profil['size'] > $max_size) {
            $upload_error = "Ukuran file terlalu besar. Maksimal 2MB.";
        }
        // Pindahkan file jika valid
        elseif (!move_uploaded_file($foto_profil["tmp_name"], $target_file)) {
            $upload_error = "Gagal mengunggah file.";
        }
    }

    // Update data pengguna jika tidak ada error
    if (empty($upload_error)) {
        if (!empty($foto_profil['name'])) {
            $query = $conn->prepare("
                UPDATE pengguna 
                SET nama = ?, email = ?, username = ?, foto_profil = ? 
                WHERE id_pengguna = ?");
            $query->bind_param("ssssi", $nama, $email, $username, $target_file, $id_pengguna);
        } else {
            $query = $conn->prepare("
                UPDATE pengguna 
                SET nama = ?, email = ?, username = ? 
                WHERE id_pengguna = ?");
            $query->bind_param("sssi", $nama, $email, $username, $id_pengguna);
        }

        if ($query->execute()) {
            header("Location: profil.php");
            exit();
        } else {
            echo "Gagal memperbarui profil.";
        }
    } else {
        echo "<script>alert('$upload_error');</script>";  // Menampilkan alert dengan pesan error
    }
}

// Ambil data pengguna
$query = $conn->prepare("
    SELECT nama, email, username, foto_profil 
    FROM pengguna 
    WHERE id_pengguna = ?");
$query->bind_param("i", $id_pengguna);
$query->execute();
$user = $query->get_result()->fetch_assoc();
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
            background-color: #f4f4f4;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #f9f9f9;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #16423C;
            text-align: center;
            margin-bottom: 30px;
        }

        label {
            font-weight: bold;
            margin-top: 10px;
            color: #333;
            display: block;
            font-size: 1rem;
        }

        input[type="text"],
        input[type="email"],
        input[type="file"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
            background-color: #fff;
        }

        input[type="file"] {
            border: none;
            background-color: transparent;
            padding-left: 0;
        }

        button {
            width: 100%;
            padding: 10px 15px;
            background-color: #6A9C89;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 1.1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #4a7f6a;
        }

        @media (max-width: 768px) {
            .container {
                padding: 20px;
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

        <div class="container">
        <h1>Edit Profil</h1>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nama">Nama:</label>
                <input type="text" id="nama" name="nama" value="<?= htmlspecialchars($user['nama']) ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
            </div>
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>
            </div>
            <div class="form-group">
                <label for="foto_profil">Foto Profil:</label>
                <input type="file" id="foto_profil" name="foto_profil">
            </div>
            <button type="submit">Simpan Perubahan</button>
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
</html>
