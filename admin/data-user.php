<?php
include('db.php');
session_start();
// DELETE Logic (Menghapus data pengguna)
if (isset($_GET['delete_id'])) {
    $user_id = $_GET['delete_id'];
    $stmt = $conn->prepare("DELETE FROM pengguna WHERE id_pengguna = ?");
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        header("Location: data-user.php");
        exit; // Pastikan untuk menghentikan skrip setelah pengalihan
    } else {
        echo "Error deleting record: " . $conn->error;
    }
    $stmt->close();
}

// SEARCH Logic (Pencarian data pengguna berdasarkan nama, username, dan role)
$search_query = '';
$selected_role = ''; // Default role kosong

if (isset($_POST['search']) || isset($_POST['peran'])) {  // Pastikan ini sesuai dengan nama input HTML
    $search_query = $_POST['search'] ?? '';
    $selected_role = $_POST['peran'] ?? '';  // Menggunakan 'peran' karena itu nama input dropdown role di HTML
}

// Query untuk mengambil data dari tabel pengguna dengan filter pencarian
$sql = "SELECT id_pengguna, nama, email, username, peran, tanggal_dibuat FROM pengguna";
$conditions = [];

if (!empty($search_query)) {
    $conditions[] = "(nama LIKE ? OR username LIKE ?)";
}

if (!empty($selected_role)) {
    $conditions[] = "peran = ?";  // Pastikan nama kolom di query adalah 'peran'
}

if ($conditions) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
}

$stmt = $conn->prepare($sql);

// Jika ada pencarian, bind parameter
if (!empty($search_query) && !empty($selected_role)) {
    $search_param = "%" . $search_query . "%";
    $stmt->bind_param("sss", $search_param, $search_param, $selected_role);
} elseif (!empty($search_query)) {
    $search_param = "%" . $search_query . "%";
    $stmt->bind_param("ss", $search_param, $search_param);
} elseif (!empty($selected_role)) {
    $stmt->bind_param("s", $selected_role);
}

$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Pengguna_LookWork</title>
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<style>
    body {
        font-family: 'Heebo', sans-serif;
        background-color: #f4f4f9;
    }

    .table {
        width: 90%;
        margin: 0 auto;
    }

    @media (max-width: 1200px) {
        .table {
            width: 85%;
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
                    <a href="#" class="nav-link active dropdown-toggle" data-bs-toggle="dropdown">Manajemen Data</a>
                    <div class="dropdown-menu rounded-0 m-0">
                        <a href="data-pekerjaan.php" class="dropdown-item">Pekerjaan</a>
                        <a href="data-perusahaan.php" class="dropdown-item">Perusahaan</a>
                        <a href="data-user.php" class="dropdown-item">Pengguna</a>
                        <a href="kategori-pekerjaan.php" class="dropdown-item">Kategori Pekerjaan</a>
                    </div>
                </div>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Laporan</a>
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

    <!-- Judul Data Pengguna -->
    <h1 class="text-center my-4">Data Pengguna</h1>

<!-- Tombol dan Form Pencarian -->
<div class="d-flex justify-content-between align-items-center mb-3" style="max-width: 800px; margin: 0 auto;">
    <!-- Form Pencarian -->
    <form method="POST" action="" class="d-flex" style="gap: 10px; width: 100%;">
        <div class="input-group">
            <input type="text" class="form-control" name="search" id="searchInput" placeholder="Cari nama atau username" value="<?php echo htmlspecialchars($search_query); ?>">
        </div>
        <div class="input-group">
            <select class="form-select" name="peran" id="roleSelect">  <!-- Pastikan name="peran" sesuai -->
                <option value="">Pilih Peran</option>
                <option value="admin" <?php if ($selected_role == 'admin') echo 'selected'; ?>>Admin</option>
                <option value="perusahaan" <?php if ($selected_role == 'perusahaan') echo 'selected'; ?>>Perusahaan</option>
                <option value="pencari_kerja" <?php if ($selected_role == 'pencari_kerja') echo 'selected'; ?>>Pencari Kerja</option>
            </select>
        </div>
        <div>
            <button type="submit" class="btn btn-primary">Cari</button>
        </div>
    </form>

    <!-- Tombol untuk membuka Modal -->
    <button class="btn btn-success ml-auto" data-bs-toggle="modal" data-bs-target="#addAdminModal" style="margin-left: 20px;">Tambah Admin</button>
</div>

<!-- Modal Tambah Admin -->
<div class="modal fade" id="addAdminModal" tabindex="-1" aria-labelledby="addAdminModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addAdminModalLabel">Tambah Admin Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form Tambah Admin -->
                <form action="proses-tambah-admin.php" method="POST">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>

                    <!-- Peran Admin akan disetel secara otomatis di backend -->
                    <input type="hidden" name="role" value="admin">
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>




    <!-- Tabel Data Pengguna -->
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Username</th>
                <th>Peran</th>
                <th>Tanggal Dibuat</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
    <?php
    $no = 1;
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $no++ . "</td>";
        echo "<td>" . htmlspecialchars($row['nama']) . "</td>";
        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
        echo "<td>" . htmlspecialchars($row['username']) . "</td>";
        echo "<td>" . htmlspecialchars($row['peran']) . "</td>";
        echo "<td>" . htmlspecialchars($row['tanggal_dibuat']) . "</td>";
        echo "<td>
            <a href='?delete_id=" . $row['id_pengguna'] . "'  style='color: red;'>
                <i class='fas fa-trash-alt'></i>
            </a>
        </td>";
        echo "</tr>";
    }
    ?>
</tbody>



    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
