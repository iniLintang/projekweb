<?php
include('db.php');
session_start();

// Cek apakah ID pekerjaan ada di URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_pekerjaan = $_GET['id'];

    // Query untuk mendapatkan detail pekerjaan berdasarkan id_pekerjaan
    $sql = "SELECT 
                p.id_pekerjaan, 
                p.judul_pekerjaan, 
                p.deskripsi, 
                p.jenis_pekerjaan, 
                p.tipe_kerja, 
                p.lokasi, 
                p.gaji_dari, 
                p.gaji_hingga, 
                p.tanggal_posting, 
                perusahaan.nama_perusahaan, 
                kategori_pekerjaan.nama_kategori
            FROM pekerjaan p
            LEFT JOIN perusahaan ON p.id_perusahaan = perusahaan.id_perusahaan
            LEFT JOIN kategori_pekerjaan ON p.id_kategori = kategori_pekerjaan.id_kategori
            WHERE p.id_pekerjaan = '$id_pekerjaan'";

    // Eksekusi query
    $result = $conn->query($sql);

    // Cek apakah data ditemukan
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "ID Pekerjaan tidak valid!";
        exit;
    }
} else {
    echo "ID Pekerjaan tidak valid!";
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
        .job-detail-card {
            max-width: 800px;
            margin: 30px auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        .job-detail-header {
            text-align: center;
            color: #16423C;
        }

        .job-info {
            margin-top: 20px;
            display: flex;
            flex-direction: column;
        }

        .job-info-item {
            margin-bottom: 15px;
        }

        .job-info-item h4 {
            margin: 0;
            font-size: 16px;
            color: #6A9C89;
        }

        .job-info-item p {
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
</head>

</style>
<body>
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
    <div class="job-detail-card">
        <div class="job-detail-header">
            <h2><?php echo htmlspecialchars($row['judul_pekerjaan']); ?></h2>
            <h4><?php echo htmlspecialchars($row['nama_perusahaan']); ?></h4>
        </div>
        
        <div class="job-info">
            <div class="job-info-item">
                <h4>Kategori:</h4>
                <p><?php echo htmlspecialchars($row['nama_kategori']); ?></p>
            </div>
            <div class="job-info-item">
                <h4>Deskripsi:</h4>
                <p><?php echo nl2br(htmlspecialchars($row['deskripsi'])); ?></p>
            </div>
            <div class="job-info-item">
                <h4>Jenis Pekerjaan:</h4>
                <p><?php echo htmlspecialchars($row['jenis_pekerjaan']); ?></p>
            </div>
            <div class="job-info-item">
                <h4>Tipe Kerja:</h4>
                <p><?php echo htmlspecialchars($row['tipe_kerja']); ?></p>
            </div>
            <div class="job-info-item">
                <h4>Lokasi:</h4>
                <p><?php echo htmlspecialchars($row['lokasi']); ?></p>
            </div>
            <div class="job-info-item">
                <h4>Gaji:</h4>
                <p><?php echo htmlspecialchars($row['gaji_dari']); ?> - <?php echo htmlspecialchars($row['gaji_hingga']); ?></p>
            </div>
            <div class="job-info-item">
                <h4>Tanggal Posting:</h4>
                <p><?php echo htmlspecialchars($row['tanggal_posting']); ?></p>
            </div>
        </div>


<a href="javascript:history.back()" class="btn btn-secondary">Kembali</a>
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