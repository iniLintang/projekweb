<?php
include('db.php'); // Pastikan file ini ada dan terkoneksi dengan benar ke database

// Query untuk laporan perusahaan yang paling aktif
$sql = "SELECT companies.company_name, COUNT(jobs.job_id) AS job_count, MAX(jobs.created_at) AS last_posted
        FROM companies
        LEFT JOIN jobs ON companies.company_id = jobs.company_id
        GROUP BY companies.company_id
        ORDER BY job_count DESC"; // Mengurutkan berdasarkan jumlah lowongan

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
    <title>Laporan Perusahaan Paling Aktif</title>
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
                    <li class="sidebar-dropdown-menu-item active">
                        <a href="report_active_companies.php">
                            <i class="ri-building-line"></i>
                            Perusahaan Paling Aktif
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
                <h5 class="fw-bold mb-0 me-auto">Laporan Perusahaan Paling Aktif</h5>
            </nav>

            <table class="table table-bordered mt-4">
                <thead>
                    <tr>
                        <th>Nama Perusahaan</th>
                        <th>Jumlah Lowongan</th>
                        <th>Lowongan Terakhir Diposting</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>" . htmlspecialchars($row['company_name']) . "</td>
                                    <td>" . htmlspecialchars($row['job_count']) . "</td>
                                    <td>" . htmlspecialchars($row['last_posted']) . "</td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>Tidak ada data ditemukan</td></tr>";
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
