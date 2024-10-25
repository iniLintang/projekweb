<?php
session_start(); // Memastikan sesi dimulai

// Periksa apakah admin sudah login
if (isset($_SESSION['admin_id'])) {
    // Admin sudah login, biarkan akses
} else {
    // Jika bukan admin, hapus sesi dan hentikan akses
    session_unset(); // Hapus semua variabel sesi
    session_destroy(); // Menghancurkan sesi untuk keamanan tambahan
    header("Location: login.php"); // Redirect ke halaman login
    exit(); // Menghentikan eksekusi kode lebih lanjut
}
// Check if the admin is logged in and if the session has their username
if (isset($_SESSION['username'])) {
    $adminName = $_SESSION['username']; // You can use 'admin_username' if you prefer username
} 

include('db.php');

$sql = "SELECT MONTH(created_at) AS month, COUNT(*) AS total_jobs 
        FROM jobs 
        GROUP BY MONTH(created_at) 
        ORDER BY MONTH(created_at)";
$result = $conn->query($sql);

$months = [];
$total_jobs = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $months[] = $row['month'];
        $total_jobs[] = $row['total_jobs'];
    }
}

// Prepare data for JavaScript
$months_json = json_encode($months);
$total_jobs_json = json_encode($total_jobs);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- start: Icons -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <!-- start: Icons -->
    <!-- start: CSS -->
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <!-- end: CSS -->
    <!-- start charts-->
    <title>LookWork Dashboard</title>
</head>
<style>
     .namaadm {
        display: flex;
        justify-content: flex-end; /* Memastikan teks berada di kanan */
        align-items: center;
        margin-right: 20px; /* Memberikan sedikit jarak dari tepi kanan halaman */
    }

    /* Untuk mengatur teks agar tidak meluap keluar halaman */
    .namaadm div {
        white-space: nowrap; /* Menghindari teks terpotong atau meluap */
        overflow: hidden;
        text-overflow: ellipsis; /* Jika terlalu panjang, tambahkan '...' */
    }

    .menu {
        display: flex;
        justify-content: center; /* Mengatur elemen untuk berada di tengah secara horizontal */
        align-items: center; /* Mengatur elemen agar sejajar secara vertikal */
        margin: 10px; /* Jarak di sekeliling elemen */
    }

    .menu div {
            white-space: nowrap; /* Menghindari teks terpotong ke baris baru */
            margin: 0 15px; /* Menambahkan jarak horizontal antar item (15px) */
        }
        
    .summary-icon {
        width: 40px; /* Set a specific width */
        height: 40px; /* Set a specific height */
        border-radius: 50%; /* Make it circular */
        display: flex;
        justify-content: center; /* Center icon horizontally */
        align-items: center; /* Center icon vertically */
    }

</style>

<body>

    <!-- start: Sidebar -->
    <div class="sidebar position-fixed top-0 bottom-0 bg-white border-end">
        <div class="d-flex align-items-center p-3">
            <a href="#" class="sidebar-logo fw-bold text-decoration-none text-uppercase fs-4" style="color: #425C5A;">LookWork</a>
            <i class="sidebar-toggle ri-arrow-left-circle-line ms-auto fs-5 d-none d-md-block"></i>        
        </div>
        <ul class="sidebar-menu p-3 m-0 mb-0">
            <li class="sidebar-menu-item active">
                <a href="#" style="color: #425C5A; background-color: #ffffff;">
                    <i class="ri-dashboard-line sidebar-menu-item-icon"></i>
                    Menu Utama
                </a>
            </li>
            <li class="sidebar-menu-item has-dropdown">
            <a href="data-pekerjaan.php">
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
            <li class="sidebar-menu-item">
                <a href="logout.php">
                <i class="ri-logout-box-line sidebar-menu-item-icon"></i>
                    Logout
                </a>
        </div>
    <div class="sidebar-overlay"></div>
    <!-- end: Sidebar -->

    <!-- start: Main -->
    <main class="bg-light">
            <!-- start: Navbar -->
            <nav class="px-3 py-2 bg-white rounded shadow-sm">
                <i class="ri-menu-line sidebar-toggle me-3 d-block d-md-none"></i>
                <h5 class="fw-bold mb-0 me-auto">Menu Utama</h5>
                <div class="dropdown me-3 d-none d-sm-block">
                    <div class="cursor-pointer dropdown-toggle navbar-link" data-bs-toggle="dropdown" aria-expanded="false">
                    </div>
                    <div class="dropdown">
                    <div namaadm>
                    <div>Welcome, <?php echo htmlspecialchars($adminName); ?>!</div>
                    </div>
                    </div>
                </div>
            </nav>
            <!-- end: Navbar -->

            <!-- start: Content -->
            <div class="py-4">
            <div class="menu">
    <div class="col-12 col-sm-6 col-lg-3">
        <a href="dashboard.php?hal=jobs"
           class="text-dark text-decoration-none bg-white p-3 rounded shadow-sm d-flex justify-content-between align-items-center summary-primary">
            <div class="text-end">
                <?php  
                // Mengambil total data dari tabel jobs
                $jobs_query = mysqli_query($conn, "SELECT COUNT(*) as total_jobs FROM jobs");
                if ($jobs_query) {
                    $jobs_data = mysqli_fetch_assoc($jobs_query);
                    $total_jobs = $jobs_data['total_jobs'];
                } else {
                    $total_jobs = 0; // Default to 0 if query fails
                }
                ?>
                <div>Total Loker</div>
                <h4 class="number-display"><?php echo htmlspecialchars($total_jobs); ?></h4>
            </div>
            <i class="ri-briefcase-line summary-icon bg-primary mb-2"></i>
        </a>
    </div>
    
    <div class="col-12 col-sm-6 col-lg-3">
        <a href="dashboard.php?hal=companies"
           class="text-dark text-decoration-none bg-white p-3 rounded shadow-sm d-flex justify-content-between align-items-center summary-indigo">
            <div class="text-end">
                <?php  
                // Mengambil total data dari tabel companies
                $companies_query = mysqli_query($conn, "SELECT COUNT(*) as total_companies FROM companies");
                if ($companies_query) {
                    $companies_data = mysqli_fetch_assoc($companies_query);
                    $total_companies = $companies_data['total_companies'];
                } else {
                    $total_companies = 0; // Default to 0 if query fails
                }
                ?>
                <div>Total Perusahaan</div>
                <h4 class="number-display"><?php echo htmlspecialchars($total_companies); ?></h4>
            </div>
            <i class="ri-building-line summary-icon bg-success mb-2"></i>
        </a>
    </div>
    
    <div class="col-12 col-sm-6 col-lg-3">
        <a href="dashboard.php?hal=users"
           class="text-dark text-decoration-none bg-white p-3 rounded shadow-sm d-flex justify-content-between align-items-center summary-success">
            <div class="text-end">
                <?php  
                // Mengambil total data dari tabel users
                $users_query = mysqli_query($conn, "SELECT COUNT(*) as total_users FROM users");
                if ($users_query) {
                    $users_data = mysqli_fetch_assoc($users_query);
                    $total_users = $users_data['total_users'];
                } else {
                    $total_users = 0; // Default to 0 if query fails
                }
                ?>
                <div>Total Pengguna</div>
                <h4 class="number-display"><?php echo htmlspecialchars($total_users); ?></h4>
            </div>
            <i class="ri-user-add-line summary-icon bg-danger mb-2"></i>
        </a>
    </div>
</div>

</div>

                <!-- end: Summary -->
                <!-- start: Graph -->
                <div class="row g-3 mt-2 justify-content-center">
    <div class="col-12 col-md-8"> <!-- Kolom yang lebih sempit agar lebih mudah di tengah -->
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white">
                Tingkat Aktivitas pada LookWork
            </div>
            <div class="card-body">
                <canvas id="sales-chart"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Prepare data from PHP
    const months = <?php echo $months_json; ?>;
    const totalJobs = <?php echo $total_jobs_json; ?>;

    // Create chart
    const ctx = document.getElementById('sales-chart').getContext('2d');
    const salesChart = new Chart(ctx, {
        type: 'bar', // You can change this to 'line', 'pie', etc.
        data: {
            labels: months.map(month => month.toString()), // Convert month numbers to strings if needed
            datasets: [{
                label: 'Total Pekerjaan',
                data: totalJobs,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

<!-- end: Graph -->


    </main>
    <!-- end: Main -->

    <!-- start: JS -->
    <script src="../assets/js/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.0/chart.min.js" integrity="sha512-sW/w8s4RWTdFFSduOTGtk4isV1+190E/GghVffMA9XczdJ2MDzSzLEubKAs5h0wzgSJOQTRYyaz73L3d6RtJSg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/script.js"></script>
    <!-- end: JS -->
</body>

</html>