<?php
// Sertakan file koneksi database
include 'db_connect.php';
session_start();

// Ambil data kategori pekerjaan dari tabel 'kategori_pekerjaan'
$query_kategori = "SELECT * FROM kategori_pekerjaan";
$result_kategori = $conn->query($query_kategori);
$kategori_pekerjaan = $result_kategori->fetch_all(MYSQLI_ASSOC);

// Cek apakah ada ID pekerjaan yang diteruskan ke URL
if (isset($_GET['id_pekerjaan'])) {
    $id_pekerjaan = $_GET['id_pekerjaan'];
    
    // Ambil data pekerjaan berdasarkan ID
    $query = "SELECT * FROM pekerjaan WHERE id_pekerjaan = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_pekerjaan);
    $stmt->execute();
    $result = $stmt->get_result();
    $pekerjaan = $result->fetch_assoc();

    // Jika pekerjaan tidak ditemukan
    if (!$pekerjaan) {
        echo "Pekerjaan tidak ditemukan.";
        exit;
    }

    // Ambil id_perusahaan dan id_kategori dari pekerjaan yang ada
    $id_perusahaan = $pekerjaan['id_perusahaan'];
    $id_kategori = $pekerjaan['id_kategori']; // Pastikan ini adalah ID kategori yang dipisahkan koma (jika ada lebih dari satu kategori)

} else {
    echo "ID pekerjaan tidak diterima.";
    exit;
}

// Proses jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_perusahaan = $_POST['id_perusahaan'];
    $kategori = isset($_POST['kategori']) ? $_POST['kategori'] : [];
    $id_kategori = implode(',', $kategori);
    $judul_pekerjaan = $_POST['judul_pekerjaan'];
    $deskripsi = $_POST['deskripsi'];
    $lokasi = $_POST['lokasi'];
    $jenis_pekerjaan = $_POST['jenis_pekerjaan'];
    $tipe_kerja = $_POST['tipe_kerja']; // Pastikan ini sudah terdefinisi
    $gaji_dari = $_POST['gaji_dari'];
    $gaji_hingga = $_POST['gaji_hingga'];

    // Update data pekerjaan
    $update_query = "UPDATE pekerjaan SET 
                 id_perusahaan = ?, 
                 id_kategori = ?, 
                 judul_pekerjaan = ?, 
                 deskripsi = ?, 
                 lokasi = ?, 
                 jenis_pekerjaan = ?, 
                 tipe_kerja = ?, 
                 gaji_dari = ?, 
                 gaji_hingga = ? 
                 WHERE id_pekerjaan = ?";

    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("iissssddii", $id_perusahaan, $id_kategori, $judul_pekerjaan, $deskripsi, $lokasi, $jenis_pekerjaan, $tipe_kerja, $gaji_dari, $gaji_hingga, $id_pekerjaan);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Data berhasil diperbarui.";
    } 
    
    else {
        echo "Terjadi kesalahan atau data tidak berubah.";
    }

    header("Location: daftar_loker.php");
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
        .container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }

        h2 {
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
            border-color: #28a745;
            font-size: 16px;
            padding: 12px 20px;
        }

        .btn-primary:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }

        .form-check-label {
            font-size: 14px;
            margin-left: 5px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .row .col-md-6 {
            margin-bottom: 20px;
        }

        .form-check-inline {
            margin-right: 15px;
        }

        textarea {
            resize: vertical;
            height: 150px;
        }

        .action-btn {
            border: none;
            background: none;
            cursor: pointer;
            color: #007bff;
            font-size: 18px;
        }

        .action-btn:hover {
            color: #0056b3;
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
    <h2>Edit Pekerjaan</h2>
    <form method="POST">
        
        <div class="form-group">
        <label for="id_perusahaan">ID Perusahaan:</label>
        <input type="number" name="id_perusahaan" class="form-control" value="<?= htmlspecialchars($pekerjaan['id_perusahaan']) ?>" readonly required><br>
        </div>
        
        <div class="form-group">
            <label for="judul_pekerjaan">Judul Pekerjaan:</label>
            <input type="text" name="judul_pekerjaan" class="form-control" value="<?= htmlspecialchars($pekerjaan['judul_pekerjaan']) ?>" required>
        </div>

        <div class="form-group">
            <label for="deskripsi">Deskripsi:</label>
            <textarea name="deskripsi" class="form-control" required><?= htmlspecialchars($pekerjaan['deskripsi']) ?></textarea>
        </div>

        <div class="form-group">
            <label for="lokasi">Lokasi:</label>
            <input type="text" name="lokasi" class="form-control" value="<?= htmlspecialchars($pekerjaan['lokasi']) ?>" required>
        </div>

        <div class="form-group">
            <label for="jenis_pekerjaan">Jenis Pekerjaan:</label>
            <select name="jenis_pekerjaan" class="form-control" required>
                <option value="full_time" <?= $pekerjaan['jenis_pekerjaan'] == 'full_time' ? 'selected' : '' ?>>Full Time</option>
                <option value="part_time" <?= $pekerjaan['jenis_pekerjaan'] == 'part_time' ? 'selected' : '' ?>>Part Time</option>
                <option value="freelance" <?= $pekerjaan['jenis_pekerjaan'] == 'freelance' ? 'selected' : '' ?>>Freelance</option>
                <option value="internship" <?= $pekerjaan['jenis_pekerjaan'] == 'internship' ? 'selected' : '' ?>>Internship</option>
            </select>
        </div>

        <div class="form-group">
        <label for="tipe_kerja">Tipe Kerja:</label>
        <input type="text" name="tipe_kerja" class="form-control" value="<?= htmlspecialchars($pekerjaan['tipe_kerja']) ?>" readonly required><br>
        </div>


        <div class="form-group">
    <label for="id_kategori">Kategori Pekerjaan:</label>
    <select name="kategori[]" multiple required class="form-control">
        <?php foreach ($kategori_pekerjaan as $kategori): ?>
            <option value="<?= htmlspecialchars($kategori['id_kategori']) ?>" 
                <?= in_array($kategori['id_kategori'], explode(',', $pekerjaan['id_kategori'])) ? 'selected' : '' ?>>
                <?= htmlspecialchars($kategori['nama_kategori']) ?>
            </option>
        <?php endforeach; ?>
    </select><br>
    </div>


        <div class="form-group">
            <label for="gaji_dari">Gaji Dari:</label>
            <input type="number" name="gaji_dari" step="0.01" class="form-control" value="<?= htmlspecialchars($pekerjaan['gaji_dari']) ?>">
        </div>

        <div class="form-group">
            <label for="gaji_hingga">Gaji Hingga:</label>
            <input type="number" name="gaji_hingga" step="0.01" class="form-control" value="<?= htmlspecialchars($pekerjaan['gaji_hingga']) ?>" required>
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="daftar_loker.php" class="btn btn-secondary">Kembali</a>
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