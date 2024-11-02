<?php
include 'db_connect.php'; 

$query_kategori_pekerjaan = "SELECT * FROM kategori_pekerjaan";
$result_kategori_pekerjaan = mysqli_query($conn, $query_kategori_pekerjaan);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $judul_pekerjaan = mysqli_real_escape_string($conn, $_POST['judul_pekerjaan']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $lokasi = mysqli_real_escape_string($conn, $_POST['lokasi']);
    $jenis_pekerjaan = mysqli_real_escape_string($conn, $_POST['jenis_pekerjaan']);
    $tipe_kerja = mysqli_real_escape_string($conn, $_POST['tipe_kerja']);
    $gaji = mysqli_real_escape_string($conn, $_POST['gaji']);
    
    if (isset($_POST['kategori'])) {
        $kategori_pekerjaan = implode(", ", $_POST['kategori']); 
    } else {
        $kategori_pekerjaan = ""; 
    }

    $id_perusahaan = 1;
    
    $query = "INSERT INTO pekerjaan (judul_pekerjaan, deskripsi, lokasi, jenis_pekerjaan, tipe_kerja, gaji, kategori_pekerjaan, id_perusahaan) 
              VALUES ('$judul_pekerjaan', '$deskripsi', '$lokasi', '$jenis_pekerjaan', '$tipe_kerja', '$gaji', '$kategori_pekerjaan', '$id_perusahaan')";
    
    if (mysqli_query($conn, $query)) {
        header("Location: index.php?success=true");
        exit;
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
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
<style>
        body {
            font-family: 'Roboto', sans-serif; 
        }

        .form-group {
            margin-bottom: 20px; 
        }

        .navbar-nav .nav-item .nav-link {
            margin-right: 15px; 
        }

        h1, h2, h3 {
            margin-bottom: 15px; 
        }

        .container {
            padding: 20px; 
        }
    </style>
</head>

<body data-bs-spy="scroll" data-bs-target=".navbar" data-bs-offset="70">

 
<body>
    <div class="container-xxl bg-white p-0">
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>

       <nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
       <a href="index.php" class="navbar-brand d-flex align-items-center text-center py-0 px-4 px-lg-5">
                <h1 class="m-0 text-primary">LookWork</h1>
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
            </div>
        </nav>
    </div>

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
                <small class="form-text text-danger">Masukkan lokasi (kota, provinsi) dengan huruf kapital di awal.</small>
            </div>

            <div class="form-group">
    <label>Jenis Pekerjaan</label>
    <select name="jenis_pekerjaan" class="form-control" required>
        <option value="" disabled selected></option>
        <option value="full_time">Full Time</option>
        <option value="part_time">Part Time</option>
        <option value="freelance">Freelance</option>
        <option value="internship">Internship</option>
    </select>
</div>

<div class="form-group">
    <label>Tipe Kerja</label>
    <select name="tipe_kerja" class="form-control" required>
        <option value="" disabled selected></option>
        <option value="remote">Remote</option>
        <option value="wfo">WFO (Work from Office)</option>
        <option value="hybrid">Hybrid</option>
    </select>
</div>


<div class="form-group">
    <label for="gaji" style="font-size: 14px;">Range Gaji</label>
    <div class="row mt-2">
        <div class="col-md-6">
            <label for="gaji_dari" style="font-size: 12px;">Dari</label>
            <input type="text" class="form-control" id="gaji_dari" name="gaji_dari" placeholder="Masukkan gaji minimum" required oninput="formatCurrency(this)">
        </div>
        <div class="col-md-6">
            <label for="gaji_hingga" style="font-size: 12px;">Hingga</label>
            <input type="text" class="form-control" id="gaji_hingga" name="gaji_hingga" placeholder="Masukkan gaji maksimum" required oninput="formatCurrency(this)">
        </div>
    </div>
</div>


        <div class="form-group">
            <label for="kategori_pekerjaan">Kategori Pekerjaan</label><br>
            <?php while ($row_kategori_pekerjaan = mysqli_fetch_assoc($result_kategori_pekerjaan)): ?>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="kategori[]" value="<?php echo $row_kategori_pekerjaan['nama_kategori']; ?>">
                    <label class="form-check-label"><?php echo $row_kategori_pekerjaan['nama_kategori']; ?></label>
                </div>
            <?php endwhile; ?>
        </div>

            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Tambah Pekerjaan</button>
            <a href="daftar_loker.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Batal</a>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <script src="js/main.js"></script>
    
    <script src="js/bootstrap.bundle.min.js"></script>

    <script src="js/main.js"></script>
    
    <script src="js/bootstrap.bundle.min.js"></script>
    <script>
    function formatCurrency(input) {
        // Menghapus semua karakter non-digit
        let value = input.value.replace(/\D/g, '');
        // Memformat dengan pemisah ribuan
        if (value) {
            value = parseInt(value, 10).toLocaleString();
        }
        input.value = value;
    }
</script>
</html>
