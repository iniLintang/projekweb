<?php
session_start();

// Cek apakah pengguna sudah login sebagai perusahaan
if (!isset($_SESSION['peran']) || $_SESSION['peran'] !== 'perusahaan') {
    echo "Silahkan login sebagai perusahaan untuk mengakses halaman ini.";
    exit;  // Jika pengguna belum login, hentikan eksekusi script
}

// Koneksi ke database
$server = "wstif23.myhost.id";
$user = "wstifmy1_kelas_int";
$password = "@Polije164Int";
$nama_database = "wstifmy1_int_team3";


// Buat koneksi
$conn = new mysqli($server, $user, $password, $nama_database);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil ID pengguna dari sesi
$id_pengguna = $_SESSION['pengguna_id'];

// Dapatkan id_perusahaan berdasarkan id_pengguna
$sql_perusahaan = "SELECT id_perusahaan FROM perusahaan WHERE id_pengguna = ?";
$stmt_perusahaan = $conn->prepare($sql_perusahaan);
$stmt_perusahaan->bind_param("i", $id_pengguna);
$stmt_perusahaan->execute();
$result_perusahaan = $stmt_perusahaan->get_result();
$id_perusahaan = $result_perusahaan->fetch_assoc()['id_perusahaan'];

// Ambil data pekerjaan berdasarkan ID perusahaan
$sql = "
    SELECT 
        p.id_pekerjaan, 
        p.judul_pekerjaan, 
        p.deskripsi, 
        p.lokasi, 
        p.jenis_pekerjaan, 
        p.tipe_kerja, 
        p.gaji_dari, 
        p.gaji_hingga, 
        p.tanggal_posting, 
        k.nama_kategori
    FROM pekerjaan p
    JOIN kategori_pekerjaan k ON p.id_kategori = k.id_kategori
    WHERE p.id_perusahaan = ?
";
$stmt = $conn->prepare($sql);

// Cek jika query berhasil
if (!$stmt) {
    die("Error dalam persiapan statement: " . $conn->error);
}

$stmt->bind_param("i", $id_perusahaan);
$stmt->execute();
$result = $stmt->get_result();
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

        h2 {
            color: #343a40;
            margin-top: 30px;
            font-size: 32px;
            text-align: center;
        }

        .table {
            font-size: 14px;
            width: 100%;
        }

        .table thead {
            background-color: #f1f1f1;
        }



        .btn {
            font-size: 14px;
            padding: 8px 16px;
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

        .text {
            margin-bottom: 20px;
        }

        .table td, .table th {
            padding: 12px;
            text-align: left;
        }

        .table td:nth-child(2), .table th:nth-child(2) {
            max-width: 300px;
            word-wrap: break-word;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .action-icons a {
            font-size: 18px;
            color: #495057;
            margin-right: 10px;
            text-decoration: none;
        }

        .action-icons a:hover {
            color: #007bff;
        }

        .tooltip-inner {
            background-color: #495057;
            color: #ffffff;
            font-size: 14px;
        }
    /* Container agar rata tengah */
    .container-pekerjaan {
        background-color: #f8f9fa; /* Background terang untuk container */
        padding: 20px;
        border-radius: 10px; /* Memberikan efek sudut melengkung pada container */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Efek bayangan */
        margin: 0 auto; /* Agar container rata tengah */
        max-width: 1200px; /* Maksimal lebar container */
    }

    .table {
        width: 100%;
        margin-top: 20px;
    }

    .table th, .table td {
        max-width: 250px;
        overflow: hidden;
        text-overflow: ellipsis;
        word-wrap: break-word;
    }

    .table td:nth-child(1), .table th:nth-child(1) {
        width: 5%;
    }

    .row.mb-3 {
        display: flex;
        justify-content: flex-start;
        align-items: center;
    }

    .col-md-6 {
        padding-left: 0;
    }


</style>
</style>
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
        
    <h2>Daftar Pekerjaan</h2>

<!-- Container untuk tombol dan tabel -->
<div class="container-pekerjaan">
    <div class="row mb-3">
        <div class="col-md-6">
            <a href="tambah_pekerjaan.php" class="btn btn-primary">Tambah Pekerjaan</a>
        </div>
    </div>

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>No</th> <!-- Kolom Nomor -->
                <th>Id Pekerjaan</th>
                <th>Nama Pekerjaan</th>
                <th>Deskripsi</th>
                <th>Lokasi</th>
                <th>Jenis Pekerjaan</th>
                <th>Tipe Kerja</th>
                <th>Gaji (Dari)</th>
                <th>Gaji (Hingga)</th>
                <th>Kategori Pekerjaan</th>
                <th>Tanggal Posting</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php
            $max_length = 100; // Set the maximum length of description
            $no = 1; // Inisialisasi nomor urut
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $no++ . "</td>"; // Menampilkan nomor urut
                    $description = htmlspecialchars($row['deskripsi']);
                    if (strlen($description) > $max_length) {
                        $description = substr($description, 0, $max_length) . "...";
                    }
                    echo "<td>" . htmlspecialchars($row['id_pekerjaan']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['judul_pekerjaan']) . "</td>";
                    echo "<td style='white-space: normal;'>" . nl2br($description) . "</td>";
                    echo "<td>" . htmlspecialchars($row['lokasi']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['jenis_pekerjaan']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['tipe_kerja']) . "</td>";
                    echo "<td>Rp " . number_format($row['gaji_dari'], 2, ',', '.') . "</td>";
                    echo "<td>Rp " . number_format($row['gaji_hingga'], 2, ',', '.') . "</td>";
                    echo "<td>" . htmlspecialchars($row['nama_kategori']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['tanggal_posting']) . "</td>";
                    echo "<td class='action-icons'>
                            <a href='edit_pekerjaan.php?id_pekerjaan=" . $row['id_pekerjaan'] . "' data-toggle='tooltip' title='Edit'>
                                <i class='fas fa-edit'></i>
                            </a>
                            <a href='hapus_pekerjaan.php?id_pekerjaan=" . htmlspecialchars($row['id_pekerjaan']) . "' 
                            onclick='return confirm(\"Apakah Anda yakin ingin menghapus pekerjaan ini?\")' 
                            data-toggle='tooltip' 
                            title='Hapus'>
                            <i class='fas fa-trash-alt'></i>
                            </a>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='11'>Tidak ada pekerjaan yang ditemukan.</td></tr>";
            }
        ?>
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
    
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>

<?php
// Tutup koneksi
$conn->close();
?>
