<?php
include('db.php');
session_start();

if (isset($_SESSION['username'])) {
    $adminName = $_SESSION['username']; // You can use 'admin_username' if you prefer username
} 
// DELETE Logic (Menghapus data pengguna)
if (isset($_GET['delete_id'])) {
    $user_id = $_GET['delete_id'];
    $stmt = $conn->prepare("DELETE FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        header("Location:data-users.php");
        exit; // Pastikan untuk menghentikan skrip setelah pengalihan
    } else {
        echo "Error deleting record: " . $conn->error;
    }
    $stmt->close();
}

// SEARCH Logic (Pencarian data pengguna)
$search_query = '';
if (isset($_POST['search'])) {
    $search_query = $_POST['search'];
}

// Query untuk mengambil data dari tabel users dengan filter pencarian
$sql = "SELECT * FROM users";
if (!empty($search_query)) {
    $sql .= " WHERE username LIKE '%$search_query%'";
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
    <title>LookWork Data Pengguna</title>
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
            <li class="sidebar-menu-item">
                <a href="#">
                    <i class="ri-file-list-line sidebar-menu-item-icon"></i>
                    Laporan
                </a>
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
        <div class="p-2">
            <nav class="px-3 py-2 bg-white rounded shadow-sm">
                <i class="ri-menu-line sidebar-toggle me-3 d-block d-md-none"></i>
                <h5 class="fw-bold mb-0 me-auto">Data Pengguna</h5>
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

            <!-- Form Pencarian -->
            <form method="POST" action="" class="mb-3">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" id="searchInput" placeholder="Cari nama" value="<?php echo htmlspecialchars($search_query); ?>">
                    <button class="btn btn-outline-secondary" type="submit">Cari</button>
                </div>
            </form>

            <!-- Tabel Data Pengguna -->
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>User ID</th>
                            <th>Username</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                    <td>{$row['user_id']}</td>
                                    <td>{$row['username']}</td>
                                    <td>{$row['full_name']}</td>
                                    <td>{$row['email']}</td>
                                    <td>{$row['created_at']}</td>
                                    <td>
                                        <a href='?delete_id=" . $row['user_id'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Yakin ingin menghapus data ini?\")'>
                                            <i class='ri-delete-bin-line'></i>
                                        </a>
                                    </td>
                                </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>Tidak ada data</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <script src="../assets/js/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.0/chart.min.js" integrity="sha512-sW/w8s4RWTdFFSduOTGtk4isV1+190E/GghVffMA9XczdJ2MDzSzLEubKAs5h0wzgSJOQTRYyaz73L3d6RtJSg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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
    </script>
</body>

</html>
