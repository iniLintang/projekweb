<?php
// Include the database connection
include 'koneksi.php';
session_start();

$id_pengguna = $_SESSION['pengguna_id'];

// Get the company ID based on id_pengguna
$query_perusahaan = "SELECT id_perusahaan FROM perusahaan WHERE id_pengguna = :id_pengguna";
$stmt_perusahaan = $conn->prepare($query_perusahaan);
$stmt_perusahaan->bindParam(':id_pengguna', $id_pengguna, PDO::PARAM_INT);
$stmt_perusahaan->execute();
$id_perusahaan = $stmt_perusahaan->fetch(PDO::FETCH_ASSOC)['id_perusahaan'];

// Get job categories
$query_kategori_pekerjaan = "SELECT * FROM kategori_pekerjaan";
$stmt_kategori_pekerjaan = $conn->prepare($query_kategori_pekerjaan);
$stmt_kategori_pekerjaan->execute();
$result_kategori_pekerjaan = $stmt_kategori_pekerjaan->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input
    $judul_pekerjaan = htmlspecialchars($_POST['judul_pekerjaan']);
    $deskripsi = htmlspecialchars($_POST['deskripsi']);
    $lokasi = htmlspecialchars($_POST['lokasi']);
    $jenis_pekerjaan = htmlspecialchars($_POST['jenis_pekerjaan']);
    $tipe_kerja = htmlspecialchars($_POST['tipe_kerja']);
    $gaji_dari = isset($_POST['gaji_dari']) ? str_replace(',', '', $_POST['gaji_dari']) : 0;
    $gaji_hingga = isset($_POST['gaji_hingga']) ? str_replace(',', '', $_POST['gaji_hingga']) : 0;

    // Validate salary input
    if ($gaji_dari > $gaji_hingga) {
        echo "Gaji minimum tidak boleh lebih besar dari gaji maksimum.";
        exit;
    }

    if (isset($_POST['kategori'])) {
        foreach ($_POST['kategori'] as $id_kategori) {
            // Ensure $id_kategori is an integer
            $id_kategori = (int)$id_kategori;

            // Insert the job data into the database
            $query = "
                INSERT INTO pekerjaan 
                (id_perusahaan, id_kategori, judul_pekerjaan, deskripsi, lokasi, jenis_pekerjaan, tipe_kerja, gaji_dari, gaji_hingga) 
                VALUES (:id_perusahaan, :id_kategori, :judul_pekerjaan, :deskripsi, :lokasi, :jenis_pekerjaan, :tipe_kerja, :gaji_dari, :gaji_hingga)";
            
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':id_perusahaan', $id_perusahaan, PDO::PARAM_INT);
            $stmt->bindParam(':id_kategori', $id_kategori, PDO::PARAM_INT);
            $stmt->bindParam(':judul_pekerjaan', $judul_pekerjaan, PDO::PARAM_STR);
            $stmt->bindParam(':deskripsi', $deskripsi, PDO::PARAM_STR);
            $stmt->bindParam(':lokasi', $lokasi, PDO::PARAM_STR);
            $stmt->bindParam(':jenis_pekerjaan', $jenis_pekerjaan, PDO::PARAM_STR);
            $stmt->bindParam(':tipe_kerja', $tipe_kerja, PDO::PARAM_STR);
            $stmt->bindParam(':gaji_dari', $gaji_dari, PDO::PARAM_INT);
            $stmt->bindParam(':gaji_hingga', $gaji_hingga, PDO::PARAM_INT);

            if ($stmt->execute()) {
                header("Location: daftar_loker.php?success=true");
                exit;
            } else {
                echo "Error: " . $stmt->errorInfo()[2];
                exit;
            }
        }
    } else {
        echo "Pilih setidaknya satu kategori pekerjaan.";
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


        .container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.1);
            margin-top: 10px;
        }

        h1 {
            color: #343a40;
            margin-bottom: 30px;
            font-size: 32px;
        }

        .form-group label {
            font-weight: bold;
            color: #495057;
        }

        .form-control, .form-check-input {
            border-radius: 5px;
            padding: 12px;
            font-size: 14px;
        }

        .btn {
            font-size: 16px;
            padding: 10px 20px;
            border-radius: 5px;
        }

        .btn-primary {
            background-color: #6A9C89;
            border-color: #6A9C89;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }

        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #4e555b;
        }

        .form-check-label {
            font-size: 14px;
            margin-left: 5px;
        }

        .row .col-md-6 {
            margin-bottom: 20px;
        }

        .form-check-inline {
            margin-right: 15px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-check-inline input {
            margin-top: 10px;
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
<div class="container">
        <h1 class="text-center my-4"><i class="fas fa-plus-circle"></i> Tambahkan Lowongan Kerja Anda!</h1>
        <form action="" method="post">
            <div class="form-group">
                <label for="judul_pekerjaan">Judul Pekerjaan</label>
                <input type="text" class="form-control" id="judul_pekerjaan" name="judul_pekerjaan" required>
            </div>

            <div class="form-group">
                <label for="deskripsi">Deskripsi</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required></textarea>
            </div>

            <div class="form-group">
                <label for="lokasi">Lokasi</label>
                <input type="text" class="form-control" id="lokasi" name="lokasi" required>
            </div>

            <div class="form-group">
                <label>Jenis Pekerjaan</label>
                <select name="jenis_pekerjaan" class="form-control" required>
                    <option value="" disabled selected>Pilih jenis pekerjaan</option>
                    <option value="full_time">Full Time</option>
                    <option value="part_time">Part Time</option>
                    <option value="freelance">Freelance</option>
                    <option value="internship">Internship</option>
                </select>
            </div>

            <div class="form-group">
                <label>Tipe Kerja</label>
                <select name="tipe_kerja" class="form-control" required>
                    <option value="" disabled selected>Pilih tipe kerja</option>
                    <option value="remote">Remote</option>
                    <option value="wfo">WFO (Work from Office)</option>
                    <option value="hybrid">Hybrid</option>
                </select>
            </div>

            <div class="form-group">
                <label>Range Gaji</label>
                <div class="row">
                    <div class="col-md-6">
                        <label>Dari</label>
                        <input type="text" class="form-control" id="gaji_dari" name="gaji_dari" required>
                    </div>
                    <div class="col-md-6">
                        <label>Hingga</label>
                        <input type="text" class="form-control" id="gaji_hingga" name="gaji_hingga" required>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="kategori_pekerjaan">Kategori Pekerjaan</label><br>
                <?php foreach ($result_kategori_pekerjaan as $row_kategori_pekerjaan): ?>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="kategori[]" value="<?php echo $row_kategori_pekerjaan['id_kategori']; ?>">
                        <label class="form-check-label"><?php echo $row_kategori_pekerjaan['nama_kategori']; ?></label>
                    </div>
                <?php endforeach; ?>
            </div>

            <button type="submit" class="btn btn-primary">Tambah Pekerjaan</button>
            <a href="daftar_loker.php" class="btn btn-secondary">Batal</a>
        </form>
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
