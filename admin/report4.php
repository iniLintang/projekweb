<?php
include('db.php'); // Pastikan file ini ada dan terkoneksi dengan benar ke database

// Menangkap tanggal awal dan akhir dari parameter GET (jika ada)
$startDate = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-d', strtotime('-1 month'));
$endDate = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-d');

// Query untuk menghitung jumlah pengguna yang mendaftar dalam rentang waktu tertentu
$sql = "SELECT DATE(created_at) AS registration_date, COUNT(user_id) AS user_count
        FROM users
        WHERE created_at BETWEEN '$startDate 00:00:00' AND '$endDate 23:59:59'
        GROUP BY registration_date
        ORDER BY registration_date";

$result = $conn->query($sql);

// Pastikan hasil query tidak null atau error
if ($result === false) {
    echo "Error: " . $conn->error;
    exit();
}
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.0/chart.min.js"></script>
    <title>Laporan Aktivitas Pengguna</title>
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
                        <a href="report_activity.php">
                            <i class="ri-user-3-line"></i>
                            Aktivitas Pengguna
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
                <h5 class="fw-bold mb-0 me-auto">Laporan Aktivitas Pengguna</h5>
            </nav>

            <form method="GET" class="mt-4">
                <div class="mb-3">
                    <label for="start_date" class="form-label">Tanggal Mulai:</label>
                    <input type="date" class="form-control" id="start_date" name="start_date" value="<?php echo $startDate; ?>">
                </div>
                <div class="mb-3">
                    <label for="end_date" class="form-label">Tanggal Akhir:</label>
                    <input type="date" class="form-control" id="end_date" name="end_date" value="<?php echo $endDate; ?>">
                </div>
                <button type="submit" class="btn btn-primary">Tampilkan Laporan</button>
            </form>

            <table class="table table-bordered mt-4">
                <thead>
                    <tr>
                        <th>Tanggal Pendaftaran</th>
                        <th>Jumlah Pengguna</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['registration_date']); ?></td>
                                <td><?php echo htmlspecialchars($row['user_count']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan='2'>Tidak ada data ditemukan</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
            
            <canvas id="userActivityChart" width="400" height="200"></canvas>

            <script>
                const ctx = document.getElementById('userActivityChart').getContext('2d');
                const userActivityChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: [], // Tanggal
                        datasets: [{
                            label: 'Jumlah Pengguna',
                            data: [], // Jumlah pengguna
                            fill: false,
                            borderColor: 'rgba(75, 192, 192, 1)',
                            tension: 0.1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Jumlah Pengguna'
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: 'Tanggal'
                                }
                            }
                        }
                    }
                });

                // Mengisi data untuk grafik
                const labels = [];
                const userCounts = [];
                
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        labels.push("<?php echo htmlspecialchars($row['registration_date']); ?>");
                        userCounts.push(<?php echo $row['user_count']; ?>);
                    <?php endwhile; ?>
                <?php endif; ?>

                userActivityChart.data.labels = labels;
                userActivityChart.data.datasets[0].data = userCounts;
                userActivityChart.update(); // Memperbarui grafik
            </script>
        </div>

        <script src="../assets/js/jquery.min.js"></script>
        <script src="../assets/js/bootstrap.bundle.min.js"></script>
        <script src="../assets/js/script.js"></script>
    </main>
</body>
</html>
