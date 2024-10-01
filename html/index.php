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
                        <i class="ri-building-line"></i> <!-- Pastikan Anda memiliki ikon dari `remixicon` atau pustaka ikon yang benar -->
                        Perusahaan
                    </a>
                </li>

                    <li class="sidebar-dropdown-menu-item">
                        <a href="#">
                        <i class="ri-user-3-line"></i>
                            Pengguna
                        </a>
                </ul>
            </li>
            <li class="sidebar-menu-item">
                <a href="#">
                <i class="ri-file-list-line sidebar-menu-item-icon"></i>
                    Laporan
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="#">
                <i class="ri-logout-box-line sidebar-menu-item-icon"></i>
                    Logout
                </a>
        </div>
    <div class="sidebar-overlay"></div>
    <!-- end: Sidebar -->

    <!-- start: Main -->
    <main class="bg-light">
        <div class="p-2">
            <!-- start: Navbar -->
            <nav class="px-3 py-2 bg-white rounded shadow-sm">
                <i class="ri-menu-line sidebar-toggle me-3 d-block d-md-none"></i>
                <h5 class="fw-bold mb-0 me-auto">Menu Utama</h5>
                <div class="dropdown me-3 d-none d-sm-block">
                    <div class="cursor-pointer dropdown-toggle navbar-link" data-bs-toggle="dropdown"
                        aria-expanded="false">
                    </div>
                <div class="dropdown">
                    <div class="d-flex align-items-center cursor-pointer dropdown-toggle" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <span class="me-2 d-none d-sm-block">Welcome, Lintang Raina</span>
                    </div>
            </nav>
            <!-- end: Navbar -->

            <!-- start: Content -->
            <div class="py-4">
                <!-- start: Summary -->
                <div class="row g-3">
                    <div class="col-12 col-sm-6 col-lg-3">
                        <a href="#"
                            class="text-dark text-decoration-none bg-white p-3 rounded shadow-sm d-flex justify-content-between align-items-center summary-primary">
                            <div class="text-end">
                                <div>Jumlah Lowongan Aktif</div>
                                <h4 class="number-display">120</h4>
                            </div>
                            <i class="ri-briefcase-line summary-icon bg-primary mb-2"></i>
                        </a>          
                    </div>
                    <div class="col-12 col-sm-6 col-lg-3">
                        <a href="#"
                            class="text-dark text-decoration-none bg-white p-3 rounded shadow-sm d-flex justify-content-between align-items-center summary-indigo">
                            <div class="text-end">
                                <div>Jumlah Pelamar Terbaru</div>
                            <h4 class="number-display">50</h4>
                            </div>
                            <i class="ri-user-line summary-icon bg-indigo mb-2"></i>
                        </a>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-3">
                        <a href="#"
                            class="text-dark text-decoration-none bg-white p-3 rounded shadow-sm d-flex justify-content-between align-items-center summary-success">
                            <div class="text-end">
                                <div>Perusahaan Terdaftar</div>
                            <h4 class="number-display">50</h4>
                            </div>
                            <i class="ri-building-line summary-icon bg-success mb-2"></i>
                        </a>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-3">
                        <a href="#"
                            class="text-dark text-decoration-none bg-white p-3 rounded shadow-sm d-flex justify-content-between align-items-center summary-danger">
                            <div class="text-end">
                                <div>Pencari Kerja Terdaftar</div>
                            <h4 class="number-display">50</h4>
                            </div>
                            <i class="ri-user-add-line summary-icon bg-danger mb-2"></i>
                        </a>
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