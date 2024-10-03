<?php
include('db.php');

// CREATE Logic (Menambahkan data pekerjaan)
if (isset($_POST['create'])) {
    $company_id = $_POST['company_id'];
    $job_title = $_POST['job_title'];
    $job_description = $_POST['job_description'];
    $location = $_POST['location'];
    $salary_range = $_POST['salary_range'];
    $job_type = $_POST['job_type'];

    $sql = "INSERT INTO jobs (company_id, job_title, job_description, location, salary_range, job_type) 
            VALUES ('$company_id', '$job_title', '$job_description', '$location', '$salary_range', '$job_type')";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
        exit; // Pastikan untuk menghentikan skrip setelah pengalihan
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// DELETE Logic (Menghapus data pekerjaan)
if (isset($_GET['delete_id'])) {
    $job_id = $_GET['delete_id'];
    $sql = "DELETE FROM jobs WHERE job_id = $job_id";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
        exit; // Pastikan untuk menghentikan skrip setelah pengalihan
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// SEARCH Logic (Pencarian data pekerjaan)
$search_query = '';
if (isset($_POST['search'])) {
    $search_query = $_POST['search'];
}

// Query untuk mengambil data dari tabel jobs dengan filter pencarian
$sql = "SELECT * FROM jobs";
if (!empty($search_query)) {
    $sql .= " WHERE job_title LIKE '%$search_query%' OR location LIKE '%$search_query%'";
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
    <title>LookWork Data Pekerjaan</title>
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
                    <h5 class="fw-bold mb-0 me-auto">Data Pekerjaan</h5>
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
                            <input type="text" class="form-control" name="search" id="searchInput" placeholder="Cari pekerjaan atau lokasi..." value="<?php echo htmlspecialchars($search_query); ?>">
                            <button class="btn btn-outline-secondary" type="submit">Cari</button>
                        </div>
                    </form>

                    
                    <!-- Form Tambah Data Pekerjaan -->
<div id="formTambah" class="card p-4 mb-4">
    <h5 class="card-title">Form Tambah Data Pekerjaan</h5>
    <form method="POST" action="">
        <div class="form-group">
            <label>Company ID</label>
            <input type="text" name="company_id" class="form-control" value="<?php echo htmlspecialchars($company_id); ?>" readonly>

        <div class="form-group">
            <label>Job Title</label>
            <input type="text" name="job_title" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Job Description</label>
            <textarea name="job_description" class="form-control" required></textarea>
        </div>
        <div class="form-group">
            <label>Location</label>
            <input type="text" name="location" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Salary Range</label>
            <input type="text" name="salary_range" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Job Type</label>
            <select name="job_type" class="form-control" required>
                <option value="Full-Time">Full-Time</option>
                <option value="Part-Time">Part-Time</option>
                <option value="Contract">Contract</option>
                <option value="Internship">Internship</option>
            </select>
        </div>
        <button type="submit" name="create" class="btn btn-success mt-3">Simpan Pekerjaan</button>
    </form>
</div>



                    <!-- Tabel Data Pekerjaan -->
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Job ID</th>
                                    <th>Company ID</th>
                                    <th>Job Title</th>
                                    <th>Job Description</th>
                                    <th>Location</th>
                                    <th>Salary Range</th>
                                    <th>Job Type</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Menampilkan data pekerjaan setelah pencarian
                                if ($result->num_rows > 0) {
                                    // Looping setiap baris data pekerjaan
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>
                                            <td>" . htmlspecialchars($row['job_id']) . "</td>
                                            <td>" . htmlspecialchars($row['company_id']) . "</td>
                                            <td>" . htmlspecialchars($row['job_title']) . "</td>
                                            <td>" . htmlspecialchars($row['job_description']) . "</td>
                                            <td>" . htmlspecialchars($row['location']) . "</td>
                                            <td>" . htmlspecialchars($row['salary_range']) . "</td>
                                            <td>" . htmlspecialchars($row['job_type']) . "</td>
                                            <td>
                                                <a href='update.php?id=" . $row['job_id'] . "' class='btn btn-warning btn-sm'>
                                                    <i class='ri-edit-line'></i>
                                                </a>
                                                <a href='?delete_id=" . $row['job_id'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Yakin ingin menghapus data ini?\")'>
                                                    <i class='ri-delete-bin-line'></i>
                                                </a>
                                            </td>
                                        </tr>";
                                    }
                                } else {
                                    // Jika tidak ada data
                                    echo "<tr><td colspan='8'>Tidak ada data</td></tr>";
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
            function clearSearch() {
                // Menghapus isi input pencarian
                document.getElementById("searchInput").value = "";
                // Menghapus nilai search_query
                document.forms[0].search.value = "";
                // Menyegarkan halaman untuk mengupdate tampilan data
                document.forms[0].submit();
            }

            function toggleForm() {
                var form = document.getElementById("formTambah");
                if (form.style.display === "none" || form.style.display === "") {
                    form.style.display = "block";
                } else {
                    form.style.display = "none";
                }
            }
        </script>
</body>

</html>
