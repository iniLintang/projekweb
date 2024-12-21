<?php
// Koneksi database
include('db.php'); // Pastikan file ini benar-benar ada dan terkoneksi dengan database Anda
session_start();

if (!isset($_SESSION['peran'])) {
    // Redirect ke halaman login jika belum login
    header("Location: login.php");
    exit();
}

// Periksa apakah pengguna adalah admin
if ($_SESSION['peran'] !== 'admin') {
    // Jika bukan admin, redirect ke halaman lain atau tampilkan pesan
    echo "<script>
            alert('Anda tidak memiliki akses ke halaman ini!');
            window.location.href = 'index.php'; // Redirect ke halaman utama atau halaman lain
          </script>";
    exit();
}

// Query 1: Jumlah lowongan aktif
$sql_jobs = "SELECT COUNT(*) AS jumlah_pekerjaan FROM pekerjaan WHERE tipe_kerja = 'Aktif'";
$result_jobs = $conn->query($sql_jobs);

if ($result_jobs) {
    $row = $result_jobs->fetch_assoc();
    $jumlah_pekerjaan = $row['jumlah_pekerjaan'] ?? 0; // Default 0 jika hasil NULL
} else {
    $jumlah_pekerjaan = 0; // Default jika query gagal
}

// Query 2: Jumlah pengguna berdasarkan peran
$sql_users = "SELECT peran, COUNT(id_pengguna) AS jumlah_pengguna FROM pengguna GROUP BY peran";
$result_users = $conn->query($sql_users);

$user_roles = [];
$user_counts = [];

if ($result_users && $result_users->num_rows > 0) {
    while ($row = $result_users->fetch_assoc()) {
        $user_roles[] = $row['peran']; // Ambil data peran
        $user_counts[] = $row['jumlah_pengguna']; // Ambil data jumlah pengguna
    }
}

// Query 3: Perusahaan paling aktif
$sql_companies = "SELECT perusahaan.nama_perusahaan, 
                         COUNT(pekerjaan.id_pekerjaan) AS job_count, 
                         MAX(pekerjaan.tanggal_posting) AS last_posted
                  FROM perusahaan
                  LEFT JOIN pekerjaan ON perusahaan.id_perusahaan = pekerjaan.id_perusahaan
                  GROUP BY perusahaan.id_perusahaan
                  ORDER BY job_count DESC
                  LIMIT 5";
$result_companies = $conn->query($sql_companies);



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Perusahaan_LookWork</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
    .panel-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease, background-color 0.3s ease;
        border-radius: 10px; 
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); 
    }

    .panel-card:hover {
        transform: translateY(-10px); 
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); 
        background-color: #f8f9fa; 
    }
    .table-container {
    max-width: 80%; 
    margin: 0 auto; 
}
.table {
    width: 100%;
}

    .chart-container {
        max-width: 300px; 
        margin: 0 auto;   
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
       <a href="index.php" class="navbar-brand d-flex align-items-center text-center py-0 px-4 px-lg-5">
       <h1 class="m-0" style="color: #16423C;">LookWork</h1>
       </a>
            <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">              
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                    <a href="index.php" class="nav-item active nav-link ">Beranda</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Manajemen Data</a>
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

    <div class="container mt-4"> <!-- Menambah margin top untuk memberi jarak antara navbar dan konten -->
    <div class="row justify-content-center">
        <!-- Panel 1: Lowongan Aktif -->
                <?php
        // Koneksi ke database
        include('db.php'); // Pastikan file ini berisi koneksi ke database

        // Ambil jumlah lowongan
        $sql_lowongan = "SELECT COUNT(id_pekerjaan) AS jumlah_lowongan FROM pekerjaan";
        $result_lowongan = $conn->query($sql_lowongan);
        $row_lowongan = $result_lowongan->fetch_assoc();
        $jumlah_lowongan = $row_lowongan['jumlah_lowongan'];

        // Ambil jumlah perusahaan
        $sql_perusahaan = "SELECT COUNT(id_perusahaan) AS jumlah_perusahaan FROM perusahaan";
        $result_perusahaan = $conn->query($sql_perusahaan);
        $row_perusahaan = $result_perusahaan->fetch_assoc();
        $jumlah_perusahaan = $row_perusahaan['jumlah_perusahaan'];

        // Ambil jumlah pengguna
        $sql_pengguna = "SELECT COUNT(id_pengguna) AS jumlah_pengguna FROM pengguna";
        $result_pengguna = $conn->query($sql_pengguna);
        $row_pengguna = $result_pengguna->fetch_assoc();
        $jumlah_pengguna = $row_pengguna['jumlah_pengguna'];
        ?>

        <div class="row justify-content-center">
            <!-- Panel 1: Lowongan Aktif -->
            <div class="col-md-3 mb-4"> 
                <div class="card panel-card" style="background-color: white; color: #6A9C89; border: 2px solid #6A9C89; border-radius: 10px;">
                    <div class="card-body text-center">
                        <h5>Jumlah Lowongan Aktif</h5>
                        <h2><?php echo $jumlah_lowongan; ?></h2>
                    </div>
                </div>
            </div>

            <!-- Panel 2: Jumlah Perusahaan -->
            <div class="col-md-3 mb-4">
                <div class="card panel-card" style="background-color: white; color: #f0ad4e; border: 2px solid #f0ad4e; border-radius: 10px;">
                    <div class="card-body text-center">
                        <h5>Jumlah Perusahaan</h5>
                        <h2><?php echo $jumlah_perusahaan; ?></h2>
                    </div>
                </div>
            </div>

            <!-- Panel 3: Jumlah Pengguna -->
            <div class="col-md-3 mb-4">
                <div class="card panel-card" style="background-color: white; color: #d9534f; border: 2px solid #d9534f; border-radius: 10px;">
                    <div class="card-body text-center">
                        <h5>Jumlah Pengguna</h5>
                        <h2><?php echo $jumlah_pengguna; ?></h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



 <!-- Grafik Jumlah Lowongan Aktif per Bulan -->
 <?php
// Koneksi ke database
include('db.php'); // Pastikan file ini berisi koneksi ke database

// Ambil jumlah lowongan
$sql_lowongan = "SELECT COUNT(id_pekerjaan) AS jumlah_lowongan FROM pekerjaan";
$result_lowongan = $conn->query($sql_lowongan);
$row_lowongan = $result_lowongan->fetch_assoc();
$jumlah_lowongan = $row_lowongan['jumlah_lowongan'];

// Ambil jumlah perusahaan
$sql_perusahaan = "SELECT COUNT(id_perusahaan) AS jumlah_perusahaan FROM perusahaan";
$result_perusahaan = $conn->query($sql_perusahaan);
$row_perusahaan = $result_perusahaan->fetch_assoc();
$jumlah_perusahaan = $row_perusahaan['jumlah_perusahaan'];

// Ambil jumlah pengguna
$sql_pengguna = "SELECT COUNT(id_pengguna) AS jumlah_pengguna FROM pengguna";
$result_pengguna = $conn->query($sql_pengguna);
$row_pengguna = $result_pengguna->fetch_assoc();
$jumlah_pengguna = $row_pengguna['jumlah_pengguna'];
?>

<div class="col-md-12">
    <h3 class="text-center">Distribusi Jumlah Lowongan, Pengguna, dan Perusahaan</h3>
    <div class="row justify-content-center"> <!-- Pusatkan diagram -->
        <!-- Diagram Lingkaran Lowongan -->
        <div class="col-md-4">
            <div class="chart-container">
                <canvas id="lowonganPieChart" width="400" height="400"></canvas>
            </div>
        </div>

        <!-- Diagram Lingkaran Pengguna -->
        <div class="col-md-4">
            <div class="chart-container">
                <canvas id="penggunaPieChart" width="400" height="400"></canvas>
            </div>
        </div>

        <!-- Diagram Lingkaran Perusahaan -->
        <div class="col-md-4">
            <div class="chart-container">
                <canvas id="perusahaanPieChart" width="400" height="400"></canvas>
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Menambahkan Chart.js -->

<script>
    // Diagram Lingkaran Lowongan
    var ctx1 = document.getElementById('lowonganPieChart').getContext('2d');
    var lowonganPieChart = new Chart(ctx1, {
        type: 'pie',
        data: {
            labels: ['Lowongan Aktif'],
            datasets: [{
                data: [<?php echo $jumlah_lowongan; ?>],
                backgroundColor: ['rgba(70, 130, 70, 0.6)'], // Warna hijau
                borderColor: ['rgba(70, 130, 70, 1)'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return tooltipItem.raw + ' Lowongan';
                        }
                    }
                }
            }
        }
    });

    // Diagram Lingkaran Pengguna
    var ctx2 = document.getElementById('penggunaPieChart').getContext('2d');
    var penggunaPieChart = new Chart(ctx2, {
        type: 'pie',
        data: {
            labels: ['Pengguna Aktif'],
            datasets: [{
                data: [<?php echo $jumlah_pengguna; ?>],
                backgroundColor: ['rgba(255, 165, 0, 0.6)'], // Warna oranye
                borderColor: ['rgba(255, 165, 0, 1)'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return tooltipItem.raw + ' Pengguna';
                        }
                    }
                }
            }
        }
    });

    // Diagram Lingkaran Perusahaan
    var ctx3 = document.getElementById('perusahaanPieChart').getContext('2d');
    var perusahaanPieChart = new Chart(ctx3, {
        type: 'pie',
        data: {
            labels: ['Perusahaan Aktif'],
            datasets: [{
                data: [<?php echo $jumlah_perusahaan; ?>],
                backgroundColor: ['rgba(220, 53, 69, 0.6)'], // Warna merah
                borderColor: ['rgba(220, 53, 69, 1)'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return tooltipItem.raw + ' Perusahaan';
                        }
                    }
                }
            }
        }
    });
</script>

<!-- Company Report Table -->
<div class="table-container mt-4">
    <h4 class="mt-4">Perusahaan Paling Aktif</h4>
    <table class="table table-bordered mt-2">
        <thead>
            <tr>
                <th>Nama Perusahaan</th>
                <th>Jumlah Lowongan</th>
                <th>Lowongan Terakhir</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result_companies && $result_companies->num_rows > 0): ?>
                <?php while ($row = $result_companies->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['nama_perusahaan']); ?></td>
                        <td><?= htmlspecialchars($row['job_count']); ?></td>
                        <td><?= htmlspecialchars($row['last_posted']); ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3">Tidak ada data</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
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
