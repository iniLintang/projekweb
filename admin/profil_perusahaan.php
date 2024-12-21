<?php
// Menghubungkan ke database
include('db.php'); // Pastikan koneksi ke database sudah benar

// Mengambil ID perusahaan dari URL
if (isset($_GET['id'])) {
    $id_perusahaan = $_GET['id'];

    // Mengambil data perusahaan dan foto profil pengguna berdasarkan ID perusahaan
    $query = "
        SELECT p.*, u.foto_profil 
        FROM perusahaan p
        JOIN pengguna u ON p.id_pengguna = u.id_pengguna
        WHERE p.id_perusahaan = ?";
    
    $stmt = $conn->prepare($query); // Persiapkan statement
    $stmt->bind_param("i", $id_perusahaan); // Bind parameter (i untuk integer)

    $stmt->execute(); // Eksekusi query
    $result = $stmt->get_result(); // Ambil hasil query

    // Mengecek apakah data ditemukan
    if ($result->num_rows > 0) {
        $data_perusahaan = $result->fetch_assoc(); // Ambil data perusahaan dan foto profil
    } else {
        echo "ID Perusahaan tidak valid!";
        exit;
    }

    $stmt->close(); // Menutup statement
} else {
    echo "ID Perusahaan tidak ditemukan!";
    exit;
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

    .table {
    width: 90%; /* Menetapkan lebar tabel menjadi 90% dari lebar kontainer */
    margin: 0 auto; /* Menjadikan tabel terpusat di tengah */
}
@media (max-width: 1200px) {
    .table {
        width: 85%; /* Lebar tabel lebih kecil untuk layar yang lebih kecil */
    }
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
            max-width: 800px;
            margin: 30px auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        .card-header {
            text-align: center;
            color: #16423C;
        }

        .card-info {
            margin-top: 20px;
            display: flex;
            flex-direction: column;
        }

        .card-info-item {
            margin-bottom: 15px;
        }

        .card-info-item h4 {
            margin: 0;
            font-size: 16px;
            color: #6A9C89;
        }

        .card-info-item p {
            margin: 5px 0;
            font-size: 14px;
            color: #333;
        }

        .btn-back {
            display: block;
            width: 150px;
            margin: 20px auto;
            padding: 10px;
            background-color: #6A9C89;
            color: #fff;
            text-align: center;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
        }

        .btn-back:hover {
            background-color: #577f6b;
        }        
</style>
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
                        <a href="#" class="nav-link active dropdown-toggle" data-bs-toggle="dropdown">Manajemen Data</a>
                        <div class="dropdown-menu rounded-0 m-0">
                            <a href="data-pekerjaan.php" class="dropdown-item">Pekerjaan</a>
                            <a href="data-perusahaan.php" class="dropdown-item">Perusahaan</a>
                            <a href="data-user.php" class="dropdown-item">Pengguna</a>
                            <a href="kategori-pekerjaan.php" class="dropdown-item">Kategori Pekerjaan</a>
                        </div>
                    </div>
                    <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Laporan</a>
                    <div class="dropdown-menu rounded-0 m-0">
                        <a href="report1.php" class="dropdown-item">Pekerjaan</a>
                        <a href="report2.php" class="dropdown-item">Perusahaan</a>
                        <a href="report3.php" class="dropdown-item">Pengguna</a>
                    </div>
                    </div>

                <div class="dropdown">
                    <a href="#" class="btn btn-primary rounded-0 py-4 px-lg-5 d-none d-lg-block dropdown-toggle" style="background-color: #6A9C89; border-color: #6A9C89;" data-bs-toggle="dropdown">
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="logout.php">Keluar</a></li>
                    </ul>
                </div>
        </nav>
    </div> 
<body>

<div class="card">
    <div class="card-header">
        <h2 class="card-title"><?php echo htmlspecialchars($data_perusahaan['nama_perusahaan']); ?></h2>
    </div>

    <div class="card-info"> 
        <div class="card-info-item"> 
            <h4>Foto Profil:</h4>
            <p>
                <?php if (isset($data_perusahaan['foto_profil']) && !empty($data_perusahaan['foto_profil']) && file_exists("../foto/" . $data_perusahaan['foto_profil'])): ?>
                    <img src="../foto/<?= htmlspecialchars($data_perusahaan['foto_profil']); ?>" alt="Foto Profil" class="img-fluid" style="max-width: 100px; height: auto;">
                <?php else: ?>
                    <img src="../imgbk/default_logo.png" alt="Default Foto Profil" class="img-fluid" style="max-width: 100px; height: auto;">
                <?php endif; ?>
            </p>
        </div>
        <div class="card-info-item"> 
            <h4>Lokasi:</h4>
            <p><?php echo htmlspecialchars($data_perusahaan['lokasi_perusahaan']); ?></p>
        </div>
        <div class="card-info-item"> 
            <h4>Industri:</h4>
            <p><?php echo htmlspecialchars($data_perusahaan['industri']); ?></p>
        </div>
        <div class="card-info-item"> 
            <h4>Deskripsi:</h4>
            <p><?php echo nl2br(htmlspecialchars($data_perusahaan['deskripsi_perusahaan'])); ?></p>
        </div>
    </div>
    <a href="javascript:history.back()" class="btn btn-secondary">Kembali</a>
</div>
    </script>
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

