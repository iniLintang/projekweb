<?php
session_start();
$no_wa = '6282266479716';

include 'db_connect.php';

// Query untuk mendapatkan semua data pekerjaan
$query = "SELECT p.*, c.nama_perusahaan
          FROM pekerjaan p 
          JOIN perusahaan c ON p.id_perusahaan = c.id_perusahaan 
          ORDER BY p.tanggal_posting DESC";
$result = $conn->query($query);

// Mengecek apakah ada data yang ditemukan
if (!$result) {
    die("Query error: " . $conn->error);
}
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

<body>
    <div class="container-xxl bg-white p-0">
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>

        <nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
                <a href="index_2.html" class="navbar-brand d-flex align-items-center text-center py-0 px-4 px-lg-5">
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

                        <a href="#kontak" class="nav-item nav-link">Kontak</a>
                    </div>
                    
                    <!-- Tombol di kanan -->
                                <?php if (isset($_SESSION['username'])): ?>
                <div class="dropdown">
                    <a href="#" class="btn btn-primary rounded-0 py-4 px-lg-5 d-none d-lg-block dropdown-toggle" style="background-color: #6A9C89; border-color: #6A9C89;" data-bs-toggle="dropdown">
                        <?= $_SESSION['username']; ?>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="profil.html">Profil</a></li>
                        <li><a class="dropdown-item" href="logout.php">Keluar</a></li>
                    </ul>
                </div>
            <?php endif; ?>

        </nav>

<!-- Pencarian -->
<?php
// Memulai sesi dan koneksi ke database
include 'db_connect.php'; // Pastikan koneksi database benar

// Mendapatkan data dari form pencarian
$kategori = isset($_GET['kategori']) ? $_GET['kategori'] : [];
$judul = isset($_GET['judul']) ? trim($_GET['judul']) : '';
$jenis_pekerjaan = isset($_GET['jenis_pekerjaan']) ? $_GET['jenis_pekerjaan'] : '';
$tipe_kerja = isset($_GET['tipe_kerja']) ? $_GET['tipe_kerja'] : '';
$lokasi = isset($_GET['lokasi']) ? trim($_GET['lokasi']) : '';
$gaji_dari = isset($_GET['gaji_dari']) ? (float)$_GET['gaji_dari'] : 0;
$gaji_hingga = isset($_GET['gaji_hingga']) ? (float)$_GET['gaji_hingga'] : 0;

// Query untuk mendapatkan kategori pekerjaan
$kategoriQuery = "SELECT id_kategori, nama_kategori FROM kategori_pekerjaan";
$kategoriResult = $conn->query($kategoriQuery);

// Query untuk mendapatkan jenis pekerjaan dan tipe kerja
$jenisPekerjaanQuery = "SELECT DISTINCT jenis_pekerjaan FROM pekerjaan WHERE jenis_pekerjaan IS NOT NULL";
$jenisPekerjaanResult = $conn->query($jenisPekerjaanQuery);

$tipeKerjaQuery = "SELECT DISTINCT tipe_kerja FROM pekerjaan WHERE tipe_kerja IS NOT NULL";
$tipeKerjaResult = $conn->query($tipeKerjaQuery);

// Query untuk mencari pekerjaan berdasarkan filter
$query = "SELECT p.*, k.nama_kategori 
          FROM pekerjaan p
          LEFT JOIN kategori_pekerjaan k ON p.id_kategori = k.id_kategori
          WHERE 1";

// Menambahkan filter berdasarkan input dari form
if (!empty($judul)) {
    $query .= " AND p.judul_pekerjaan LIKE '%$judul%'";
}
if (!empty($jenis_pekerjaan)) {
    $query .= " AND p.jenis_pekerjaan = '$jenis_pekerjaan'";
}
if (!empty($tipe_kerja)) {
    $query .= " AND p.tipe_kerja = '$tipe_kerja'";
}
if (!empty($lokasi)) {
    $query .= " AND p.lokasi LIKE '%$lokasi%'";
}
if ($gaji_dari > 0 || $gaji_hingga > 0) {
    $query .= " AND p.gaji_dari >= $gaji_dari AND p.gaji_hingga <= $gaji_hingga";
}

// Jika kategori dipilih, tambahkan filter kategori
if (!empty($kategori)) {
    $kategoriValues = implode("','", $kategori); // Ubah array menjadi format untuk query
    $query .= " AND p.id_kategori IN ('$kategoriValues')";
}

// Menjalankan query untuk mencari pekerjaan
$result = $conn->query($query);
?>

<!-- Form Pencarian -->
<div class="container my-4">
    <form method="GET" action="" class="row g-3 align-items-center">

        <!-- Kategori Pekerjaan -->
        <div class="col-md-3">
            <label><strong>Kategori Pekerjaan:</strong></label><br>
            <?php if ($kategoriResult && $kategoriResult->num_rows > 0): ?>
                <?php while ($row = $kategoriResult->fetch_assoc()): ?>
                    <input class="form-check-input" type="checkbox" name="kategori[]" value="<?= $row['id_kategori']; ?>" 
                    <?= in_array($row['id_kategori'], $kategori) ? 'checked' : ''; ?>>
                    <label class="form-check-label"><?= $row['nama_kategori']; ?></label><br>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>

        <!-- Judul Pekerjaan -->
        <div class="col-md-3">
            <input type="text" name="judul" class="form-control" placeholder="Judul Pekerjaan" value="<?= htmlspecialchars($judul); ?>">
        </div>

        <!-- Jenis Pekerjaan -->
        <div class="col-md-2">
            <select name="jenis_pekerjaan" class="form-select">
                <option value="">Pilih Jenis Pekerjaan</option>
                <?php if ($jenisPekerjaanResult && $jenisPekerjaanResult->num_rows > 0): ?>
                    <?php while ($row = $jenisPekerjaanResult->fetch_assoc()): ?>
                        <option value="<?= $row['jenis_pekerjaan']; ?>" <?= $jenis_pekerjaan == $row['jenis_pekerjaan'] ? 'selected' : ''; ?>>
                            <?= ucfirst($row['jenis_pekerjaan']); ?>
                        </option>
                    <?php endwhile; ?>
                <?php endif; ?>
            </select>
        </div>

        <!-- Tipe Kerja -->
        <div class="col-md-2">
            <select name="tipe_kerja" class="form-select">
                <option value="">Pilih Tipe Kerja</option>
                <?php if ($tipeKerjaResult && $tipeKerjaResult->num_rows > 0): ?>
                    <?php while ($row = $tipeKerjaResult->fetch_assoc()): ?>
                        <option value="<?= $row['tipe_kerja']; ?>" <?= $tipe_kerja == $row['tipe_kerja'] ? 'selected' : ''; ?>>
                            <?= ucfirst($row['tipe_kerja']); ?>
                        </option>
                    <?php endwhile; ?>
                <?php endif; ?>
            </select>
        </div>

        <!-- Lokasi -->
        <div class="col-md-2">
            <input type="text" name="lokasi" class="form-control" placeholder="Lokasi" value="<?= htmlspecialchars($lokasi); ?>">
        </div>

        <!-- Rentang Gaji -->
        <div class="col-md-2">
            <input type="number" name="gaji_dari" class="form-control" placeholder="Gaji Dari" value="<?= $gaji_dari; ?>">
        </div>
        <div class="col-md-2">
            <input type="number" name="gaji_hingga" class="form-control" placeholder="Gaji Hingga" value="<?= $gaji_hingga; ?>">
        </div>

        <!-- Tombol Cari -->
        <div class="col-md-2 text-end">
            <button type="submit" class="btn btn-primary">Cari Pekerjaan</button>
        </div>
    </form>
</div>

<!-- Job List -->
<div class="container my-4">
    <div class="row">
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($job = $result->fetch_assoc()): ?>
                <div class="col-md-6 mb-4">
                    <div class="job-item p-4 border rounded">
                        <h5><?= $job['judul_pekerjaan']; ?></h5>
                        <p><i class="fa fa-map-marker-alt"></i> <?= $job['lokasi']; ?></p>
                        <p><i class="fa fa-money-bill-alt"></i> Rp <?= number_format($job['gaji_dari'], 0, ',', '.'); ?> - Rp <?= number_format($job['gaji_hingga'], 0, ',', '.'); ?></p>
                        <a href="detail_pekerjaan.php?id=<?= $job['id_pekerjaan']; ?>" class="btn btn-primary btn-sm">Lihat Detail</a>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12 text-center">
                <p>Tidak ada pekerjaan yang ditemukan.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
// Update salary range display value
function updateGajiDari(value) {
    document.getElementById("gajiDariValue").innerHTML = "Rp " + value.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

function updateGajiHingga(value) {
    document.getElementById("gajiHinggaValue").innerHTML = "Rp " + value.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}
</script>


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


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
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
