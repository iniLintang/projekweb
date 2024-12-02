<?php
include('db.php');
session_start();
// Filter berdasarkan rentang waktu
$start_date = isset($_POST['start_date']) ? $_POST['start_date'] : '';
$end_date = isset($_POST['end_date']) ? $_POST['end_date'] : '';

// Query untuk laporan
$sql = "SELECT 
            perusahaan.nama_perusahaan, 
            perusahaan.lokasi_perusahaan,
            COUNT(pekerjaan.id_pekerjaan) AS total_lowongan,
            SUM(CASE WHEN pekerjaan.jenis_pekerjaan = 'Full-time' THEN 1 ELSE 0 END) AS full_time,
            SUM(CASE WHEN pekerjaan.jenis_pekerjaan = 'Part-time' THEN 1 ELSE 0 END) AS part_time,
            SUM(CASE WHEN pekerjaan.jenis_pekerjaan = 'Contract' THEN 1 ELSE 0 END) AS contract,
            SUM(CASE WHEN pekerjaan.jenis_pekerjaan = 'Internship' THEN 1 ELSE 0 END) AS internship
        FROM perusahaan
        LEFT JOIN pekerjaan ON perusahaan.id_perusahaan = pekerjaan.id_perusahaan
        WHERE 1=1";

// Menambahkan filter berdasarkan rentang waktu
if (!empty($start_date) && !empty($end_date)) {
    $sql .= " AND pekerjaan.tanggal_posting BETWEEN '$start_date' AND '$end_date'";
}

$sql .= " GROUP BY perusahaan.id_perusahaan";
$result = $conn->query($sql);
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



</style>


<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
        <a href="index.php" class="navbar-brand d-flex align-items-center text-center py-0 px-4 px-lg-5">
            <h1 class="m-0" style="color: #16423C;">LookWork</h1>
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <a href="index.php" class="nav-item nav-link">Beranda</a>
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
                    <a href="#" class="nav-link active dropdown-toggle" data-bs-toggle="dropdown">Laporan</a>
                    <div class="dropdown-menu rounded-0 m-0">
                        <a href="report1.php" class="dropdown-item">Pekerjaan</a>
                        <a href="report2.php" class="dropdown-item">Perusahaan</a>
                        <a href="report3.php" class="dropdown-item">Pengguna</a>
                    </div>
                </div>

                <div class="dropdown">
                    <a href="#" class="btn btn-primary rounded-0 py-4 px-lg-5 d-none d-lg-block dropdown-toggle" style="background-color: #6A9C89; border-color: #6A9C89;" data-bs-toggle="dropdown"></a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="logout.php">Keluar</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Judul -->
    <h1 class="text-center my-4">Laporan Pekerjaan Per Perusahaan</h1>

    <!-- Form Filter (Container dengan lebar tengah) -->
<div class="container" style="max-width: 600px;">
    <form method="POST" action="" class="mb-3 text-center">
        <div class="row g-2 justify-content-center">
            <div class="col-md-6">
                <label for="start_date" class="form-label">Start Date:</label>
                <input type="date" name="start_date" id="start_date" class="form-control" value="<?php echo htmlspecialchars($start_date); ?>">
            </div>
            <div class="col-md-6">
                <label for="end_date" class="form-label">End Date:</label>
                <input type="date" name="end_date" id="end_date" class="form-control" value="<?php echo htmlspecialchars($end_date); ?>">
            </div>
        </div>
        <div class="row g-2 justify-content-center mt-3">
            <div class="col-md-6">
                <button type="submit" name="filter" class="btn btn-primary w-100">Filter</button>
            </div>
            <div class="col-md-6 mb-2">
                <button type="button" class="btn btn-danger w-100" onclick="location.href='export/export_pdf_pekerjaan.php'">Export to PDF</button>
            </div>
        </div>
    </form>
</div>


    <!-- Tabel Laporan -->
    <table class="table table-bordered mt-4" id="data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Perusahaan</th>
                <th>Total Lowongan</th>
                <th>Full-time</th>
                <th>Part-time</th>
                <th>Contract</th>
                <th>Internship</th>
                <th>Lokasi Perusahaan</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1; // Inisialisasi nomor urut
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>
                        <td>' . $no++ . '</td> <!-- Menampilkan nomor urut -->
                        <td>' . htmlspecialchars($row['nama_perusahaan']) . '</td>
                        <td>' . htmlspecialchars($row['total_lowongan']) . '</td>
                        <td>' . htmlspecialchars($row['full_time']) . '</td>
                        <td>' . htmlspecialchars($row['part_time']) . '</td>
                        <td>' . htmlspecialchars($row['contract']) . '</td>
                        <td>' . htmlspecialchars($row['internship']) . '</td>
                        <td>' . htmlspecialchars($row['lokasi_perusahaan']) . '</td>
                    </tr>';
                }
            } else {
                echo '<tr><td colspan="8" class="text-center">Data Not Found</td></tr>';
            }
            ?>
        </tbody>
    </table>
</body>


   
    <script>
        document.getElementById('export_pdf').addEventListener('click', function () {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            // Menambahkan judul
            doc.setFontSize(18);
            doc.text('Laporan Lowongan Kerja per Perusahaan', 105, 10, null, null, 'center');

            
            const tableColumn = ['Nama Perusahaan', 'Total Lowongan', 'Full-time', 'Part-time', 'Contract', 'Internship', 'Lokasi Perusahaan'];
            const tableRows = [];

            const rows = document.querySelectorAll('#data-table tbody tr');
            rows.forEach((row) => {
                const rowData = [];
                row.querySelectorAll('td').forEach((cell) => {
                    rowData.push(cell.innerText);
                });
                tableRows.push(rowData);
            });

            doc.autoTable({
                head: [tableColumn],
                body: tableRows,
                startY: 20,
            });

            doc.save('laporan_lowongan.pdf');
        });

        document.getElementById('print_report').addEventListener('click', function () {
            var printContent = document.querySelector('.p-4').innerHTML;
            var originalContent = document.body.innerHTML;

            document.body.innerHTML = printContent;
            window.print();
            document.body.innerHTML = originalContent;
            window.location.reload();
        });
    </script>
<script src="../assets/js/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.0/chart.min.js" integrity="sha512-sW/w8s4RWTdFFSduOTGtk4isV1+190E/GghVffMA9XczdJ2MDzSzLEubKAs5h0wzgSJOQTRYyaz73L3d6RtJSg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/script.js"></script>
</body>

</html>
