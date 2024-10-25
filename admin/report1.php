<?php
include('db.php');

// Filter berdasarkan rentang waktu, jenis pekerjaan, dan lokasi
$start_date = isset($_POST['start_date']) ? $_POST['start_date'] : '';
$end_date = isset($_POST['end_date']) ? $_POST['end_date'] : '';
$job_type = isset($_POST['job_type']) ? $_POST['job_type'] : '';
$location = isset($_POST['location']) ? $_POST['location'] : '';

// Query untuk laporan
$sql = "SELECT companies.company_name, jobs.job_type, jobs.location, COUNT(jobs.job_id) AS job_count
        FROM jobs
        JOIN companies ON jobs.company_id = companies.company_id
        WHERE 1=1";

// Menambahkan filter ke query
if (!empty($start_date) && !empty($end_date)) {
    $sql .= " AND jobs.created_at BETWEEN '$start_date' AND '$end_date'";
}
if (!empty($job_type)) {
    $sql .= " AND jobs.job_type = '$job_type'";
}
if (!empty($location)) {
    $sql .= " AND jobs.location = '$location'";
}

$sql .= " GROUP BY companies.company_name, jobs.job_type, jobs.location";
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
    <title>LookWork Laporan Lowongan Kerja Per Perusahaan</title>
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
                            Pekerjaan Berdasarkan Jenis pekerjaan
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
                <h5 class="fw-bold mb-0 me-auto">Laporan Lowongan Kerja Per Perusahaan</h5>
                <div class="dropdown me-3 d-none d-sm-block">
                    <div class="d-flex align-items-center cursor-pointer dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="me-2 d-none d-sm-block">Welcome, Lintang Raina</span>
                    </div>
                </div>
            </nav>

            <form method="POST" action="" class="my-3">
                <div class="mb-3">
                    <label for="start_date" class="form-label">Start Date:</label>
                    <input type="date" name="start_date" id="start_date" class="form-control" value="<?php echo htmlspecialchars($start_date); ?>">
                </div>
                <div class="mb-3">
                    <label for="end_date" class="form-label">End Date:</label>
                    <input type="date" name="end_date" id="end_date" class="form-control" value="<?php echo htmlspecialchars($end_date); ?>">
                </div>
                <div class="mb-3">
                    <label for="job_type" class="form-label">Job Type:</label>
                    <select name="job_type" id="job_type" class="form-select">
                        <option value="">All</option>
                        <option value="Full-Time" <?php if ($job_type == 'Full-Time') echo 'selected'; ?>>Full-Time</option>
                        <option value="Part-Time" <?php if ($job_type == 'Part-Time') echo 'selected'; ?>>Part-Time</option>
                        <option value="Contract" <?php if ($job_type == 'Contract') echo 'selected'; ?>>Contract</option>
                        <option value="Internship" <?php if ($job_type == 'Internship') echo 'selected'; ?>>Internship</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="location" class="form-label">Location:</label>
                    <input type="text" name="location" id="location" class="form-control" value="<?php echo htmlspecialchars($location); ?>">
                </div>
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="export_excel.php?start_date=<?php echo $start_date; ?>&end_date=<?php echo $end_date; ?>&job_type=<?php echo $job_type; ?>&location=<?php echo $location; ?>" class="btn btn-success">Export to Excel</a>
                <a href="export_pdf.php?start_date=<?php echo urlencode($start_date); ?>&end_date=<?php echo urlencode($end_date); ?>&job_type=<?php echo urlencode($job_type); ?>&location=<?php echo urlencode($location); ?>" class="btn btn-danger">Export to PDF</a>

            </form>

            <table class="table table-bordered mt-4">
                <thead>
                    <tr>
                        <th>Company Name</th>
                        <th>Job Type</th>
                        <th>Location</th>
                        <th>Job Count</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>" . htmlspecialchars($row['company_name']) . "</td>
                                    <td>" . htmlspecialchars($row['job_type']) . "</td>
                                    <td>" . htmlspecialchars($row['location']) . "</td>
                                    <td>" . htmlspecialchars($row['job_count']) . "</td>
                                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>No data found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </main>

    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/script.js"></script>
</body>

</html>
