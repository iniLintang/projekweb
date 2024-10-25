<?php
include('db.php'); // Pastikan file ini ada dan terkoneksi dengan benar ke database

// Filter berdasarkan rentang waktu dan lokasi
$start_date = isset($_POST['start_date']) ? $_POST['start_date'] : '';
$end_date = isset($_POST['end_date']) ? $_POST['end_date'] : '';
$location = isset($_POST['location']) ? $_POST['location'] : '';

// Query untuk laporan
$sql = "SELECT jobs.job_type, COUNT(jobs.job_id) AS job_count
        FROM jobs
        WHERE 1=1";

// Menambahkan filter ke query
if (!empty($start_date) && !empty($end_date)) {
    $sql .= " AND jobs.created_at BETWEEN '$start_date' AND '$end_date'";
}
if (!empty($location)) {
    $sql .= " AND jobs.location = '$location'";
}

$sql .= " GROUP BY jobs.job_type";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Laporan Lowongan Berdasarkan Jenis Pekerjaan</title>
</head>

<body>
    <div class="sidebar position-fixed top-0 bottom-0 bg-white border-end">
        <div class="d-flex align-items-center p-3">
            <a href="#" class="sidebar-logo fw-bold text-decoration-none text-uppercase fs-4" style="color: #425C5A;">LookWork</a>
            <i class="sidebar-toggle ri-arrow-left-circle-line ms-auto fs-5 d-none d-md-block"></i>
        </div>
        <ul class="sidebar-menu p-3 m-0 mb-0">
            <li class="sidebar-menu-item active">
                <a href="index.php" style="color: #425C5A; background-color: #ffffff;">
                    <i class="ri-dashboard-line sidebar-menu-item-icon"></i>
                    Menu Utama
                </a>
            </li>
            <li class="sidebar-menu-item has-dropdown">
                <a href="#">
                    <i class="ri-pages-line sidebar-menu-item-icon"></i>
                    Data
                    <i class="ri-arrow-down-s-line sidebar-menu-item-accordion ms-auto"></i>
                </a>
                <ul class="sidebar-dropdown-menu">
                    <li class="sidebar-dropdown-menu-item">
                        <a href="data-pekerjaan.php">
                            <i class="ri-briefcase-line"></i>
                            Pekerjaan
                        </a>
                    </li>
                    <li class="sidebar-dropdown-menu-item">
                        <a href="data-perusahaan.php">
                            <i class="ri-building-line"></i>
                            Perusahaan
                        </a>
                    </li>
                    <li class="sidebar-dropdown-menu-item">
                        <a href="data-user.php">
                            <i class="ri-user-3-line"></i>
                            Pengguna
                        </a>
                    </li>
                </ul>
            </li>
            <li class="sidebar-menu-item has-dropdown">
                <a href="#">
                    <i class="ri-pages-line sidebar-menu-item-icon"></i>
                    Laporan
                    <i class="ri-arrow-down-s-line sidebar-menu-item-accordion ms-auto"></i>
                </a>
                <ul class="sidebar-dropdown-menu">
                    <li class="sidebar-dropdown-menu-item">
                        <a href="report1.php">
                            <i class="ri-briefcase-line"></i>
                            Pekerjaan per Perusahaan
                        </a>
                    </li>
                    <li class="sidebar-dropdown-menu-item">
                        <a href="report2.php">
                            <i class="ri-building-line"></i>
                            Pekerjaan Berdasarkan Jenis Pekerjaan
                        </a>
                    </li>
                    <li class="sidebar-dropdown-menu-item">
                        <a href="data-user.php">
                            <i class="ri-user-3-line"></i>
                            Pengguna
                        </a>
                    </li>
                </ul>
            </li>
            <li class="sidebar-menu-item">
                <a href="logout.php">
                    <i class="ri-logout-box-line sidebar-menu-item-icon"></i>
                    Logout
                </a>
            </li>
        </ul>
    </div>
    <div class="sidebar-overlay"></div>

    <main class="bg-light">
        <div class="p-4">
            <nav class="px-3 py-2 bg-white rounded shadow-sm">
                <h5 class="fw-bold mb-0 me-auto">Laporan Lowongan Berdasarkan Jenis Pekerjaan</h5>
                <div class="dropdown me-3 d-none d-sm-block">
                    <div class="d-flex align-items-center cursor-pointer dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="me-2 d-none d-sm-block">Welcome, Lintang Raina</span>
                    </div>
                </div>
            </nav>

            <form method="POST" action="">
                <div class="form-group">
                    <label>Start Date:</label>
                    <input type="date" name="start_date" class="form-control" value="<?php echo htmlspecialchars($start_date); ?>">
                </div>
                <div class="form-group">
                    <label>End Date:</label>
                    <input type="date" name="end_date" class="form-control" value="<?php echo htmlspecialchars($end_date); ?>">
                </div>
                <div class="form-group">
                    <label>Location:</label>
                    <input type="text" name="location" class="form-control" value="<?php echo htmlspecialchars($location); ?>">
                </div>
                <button type="submit" class="btn btn-primary mt-3">Filter</button>
                <a href="export_excel_job_type.php?start_date=<?php echo $start_date; ?>&end_date=<?php echo $end_date; ?>&location=<?php echo $location; ?>" class="btn btn-success mt-3">Export to Excel</a>
                <a href="export_pdf_job_type.php?start_date=<?php echo $start_date; ?>&end_date=<?php echo $end_date; ?>&location=<?php echo $location; ?>" class="btn btn-danger mt-3">Export to PDF</a>
            </form>

            <table class="table table-bordered mt-4">
                <thead>
                    <tr>
                        <th>Job Type</th>
                        <th>Job Count</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>" . htmlspecialchars($row['job_type']) . "</td>
                                    <td>" . htmlspecialchars($row['job_count']) . "</td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='2'>No data found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <script src="../assets/js/jquery.min.js"></script>
        <script src="../assets/js/bootstrap.bundle.min.js"></script>
        <script src="../assets/js/script.js"></script>
    </main>
</body>

</html>
