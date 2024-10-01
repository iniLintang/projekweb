<?php
include('db.php');

// CREATE Logic (Menambahkan data perusahaan)
if (isset($_POST['create'])) {
    $company_name = $_POST['company_name'];
    $company_description = $_POST['company_description'];
    $contact_email = $_POST['contact_email'];

    $sql = "INSERT INTO companies (company_name, company_description, contact_email) 
            VALUES ('$company_name', '$company_description', '$contact_email')";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
        exit; // Pastikan untuk menghentikan skrip setelah pengalihan
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// DELETE Logic (Menghapus data perusahaan)
if (isset($_GET['delete_id'])) {
    $company_id = $_GET['delete_id'];
    $sql = "DELETE FROM companies WHERE company_id = $company_id";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
        exit; // Pastikan untuk menghentikan skrip setelah pengalihan
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// SEARCH Logic (Pencarian data perusahaan)
$search_query = '';
if (isset($_POST['search'])) {
    $search_query = $_POST['search'];
}

// Query untuk mengambil data dari tabel companies dengan filter pencarian
$sql = "SELECT * FROM companies";
if (!empty($search_query)) {
    $sql .= " WHERE company_name LIKE '%$search_query%' OR contact_email LIKE '%$search_query%'";
}
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
    <title>LookWork Data Perusahaan</title>
</head>

<body>
    <div class="sidebar position-fixed top-0 bottom-0 bg-white border-end">
        <div class="d-flex align-items-center p-3">
            <a href="#" class="sidebar-logo fw-bold text-decoration-none text-uppercase fs-4"
                style="color: #425C5A;">LookWork</a>
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
                        <a href="#">
                        <i class="ri-briefcase-line"></i>
                            Pekerjaan
                        </a>
                    </li>
                    <li class="sidebar-dropdown-menu-item">
                        <a href="#">
                        <i class="ri-building-line"></i>
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

        <main class="bg-light">
            <div class="p-2">
                <nav class="px-3 py-2 bg-white rounded shadow-sm">
                    <i class="ri-menu-line sidebar-toggle me-3 d-block d-md-none"></i>
                    <h5 class="fw-bold mb-0 me-auto">Data Perusahaan</h5>
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

                <div class="container mt-3">
                    <button class="btn btn-primary mb-2" onclick="toggleForm()">Tambah Data</button>

                    <!-- Form Pencarian -->
                    <form method="POST" action="" class="mb-3">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" id="searchInput" placeholder="Cari perusahaan atau email..." value="<?php echo htmlspecialchars($search_query); ?>">
                            <button class="btn btn-outline-secondary" type="submit">Cari</button>
                        </div>
                    </form>

                    <!-- Form Tambah Data Perusahaan -->
                    <div id="formTambah" class="card p-4 mb-4" style="display: none;">
                        <h5 class="card-title">Form Tambah Data Perusahaan</h5>
                        <form method="POST" action="">
                            <div class="form-group">
                                <label>Company Name</label>
                                <input type="text" name="company_name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Company Description</label>
                                <textarea name="company_description" class="form-control" required></textarea>
                            </div>
                            <div class="form-group">
                                <label>Contact Email</label>
                                <input type="email" name="contact_email" class="form-control" required>
                            </div>
                            <button type="submit" name="create" class="btn btn-success mt-3">Simpan Perusahaan</button>
                        </form>
                    </div>

                    <!-- Tabel Data Perusahaan -->
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Company ID</th>
                                    <th>Company Name</th>
                                    <th>Company Description</th>
                                    <th>Contact Email</th>
                                    <th>Created At</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Menampilkan data perusahaan setelah pencarian
                                if ($result->num_rows > 0) {
                                    // Looping setiap baris data perusahaan
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>
                                            <td>" . htmlspecialchars($row['company_id']) . "</td>
                                            <td>" . htmlspecialchars($row['company_name']) . "</td>
                                            <td>" . htmlspecialchars($row['company_description']) . "</td>
                                            <td>" . htmlspecialchars($row['contact_email']) . "</td>
                                            <td>" . htmlspecialchars($row['created_at']) . "</td>
                                            <td>
                                                <a href='update.php?id=" . $row['company_id'] . "' class='btn btn-warning btn-sm'>
                                                    <i class='ri-edit-line'></i>
                                                </a>
                                                <a href='?delete_id=" . $row['company_id'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Yakin ingin menghapus data ini?\")'>
                                                    <i class='ri-delete-bin-line'></i>
                                                </a>
                                            </td>
                                        </tr>";
                                    }
                                } else {
                                    // Jika tidak ada data
                                    echo "<tr><td colspan='6'>Tidak ada data</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>

        <script src="../assets/js/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.0/chart.min.js"
            integrity="sha512-sW/w8s4RWTdFFSduOTGtk4isV1+190E/GghVffMA9XczdJ2MDzSzLEubKAs5h0wzgSJOQTRYyaz73L3d6RtJSg=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="../assets/js/bootstrap.bundle.min.js"></script>
        <script src="../assets/js/script.js"></script>
        <script>
            function toggleForm() {
                var form = document.getElementById('formTambah');
                if (form.style.display === 'none') {
                    form.style.display = 'block';
                } else {
                    form.style.display = 'none';
                }
            }
        </script>
</body>

</html>
