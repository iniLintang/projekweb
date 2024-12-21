<?php
include('db.php');
session_start();
// CREATE Logic (Menambahkan data kategori pekerjaan)
if (isset($_POST['create'])) {
    $nama_kategori = $_POST['nama_kategori'];

    // Query untuk tabel kategori_pekerjaan
    $sql_kategori = "INSERT INTO kategori_pekerjaan (nama_kategori) VALUES (?)";
    $stmt_kategori = $conn->prepare($sql_kategori);
    $stmt_kategori->bind_param("s", $nama_kategori);

    // Eksekusi query ke tabel kategori_pekerjaan
    if ($stmt_kategori->execute()) {
        header("Location: kategori-pekerjaan.php");
        exit;
    } else {
        echo "Error: " . $sql_kategori . "<br>" . $conn->error;
    }
}

// UPDATE Logic (Mengedit data kategori pekerjaan)
if (isset($_POST['update'])) {
    $id_kategori = $_POST['id_kategori'];
    $nama_kategori = $_POST['nama_kategori'];

    $sql = "UPDATE kategori_pekerjaan SET nama_kategori = ? WHERE id_kategori = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $nama_kategori, $id_kategori);

    if ($stmt->execute()) {
        header("Location: kategori-pekerjaan.php");
        exit;
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

// DELETE Logic (Menghapus data kategori pekerjaan)
$conn->query("SET foreign_key_checks = 0;");

// Menghapus kategori
if (isset($_GET['delete_id'])) {
    $id_kategori = $_GET['delete_id'];
    $sql = "DELETE FROM kategori_pekerjaan WHERE id_kategori = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_kategori);

    if ($stmt->execute()) {
        header("Location: kategori-pekerjaan.php");
        exit;
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// Mengaktifkan kembali constraint
$conn->query("SET foreign_key_checks = 1;");

// SEARCH Logic (Pencarian data kategori pekerjaan)
$search_query = '';
if (isset($_POST['search'])) {
    $search_query = $_POST['search'];
}

// Query untuk mengambil data dari tabel kategori_pekerjaan
$sql = "SELECT * FROM kategori_pekerjaan";
if (!empty($search_query)) {
    $sql .= " WHERE nama_kategori LIKE ?";
}
$stmt = $conn->prepare($sql);
if (!empty($search_query)) {
    $search_param = "%$search_query%";
    $stmt->bind_param("s", $search_param);
}
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>LookWork</title>
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
</head>
<style>
    body {
            font-family: 'Heebo', sans-serif;
            background-color: #f4f4f9;
    }

    .table {
    width: 90%; /* Menetapkan lebar tabel menjadi 90% dari lebar kontainer */
    margin: 0 auto; /* Menjadikan tabel terpusat di tengah */
}
@media (max-width: 1200px) {
    .table {
        width: 85%; /* Lebar tabel lebih kecil untuk layar yang lebih kecil */
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
                    <a href="index.php" class="nav-item nav-link ">Beranda</a>
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
                    <a href="#" class="btn btn-primary rounded-0 py-4 px-lg-5 d-none d-lg-block dropdown-toggle" style="background-color: #6A9C89; border-color: #6A9C89;" data-bs-toggle="dropdown">
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="logout.php">Keluar</a></li>
                    </ul>
                </div>
        </nav>
    </div>  
   <!-- Judul Data Pengguna -->
   <h1 class="text-center my-4">Data Kategori</h1>
<!-- Form Pencarian dan Tombol Tambah Kategori -->
<div class="d-flex justify-content-center mb-3">
    <div class="d-flex w-100 justify-content-between align-items-center" style="max-width: 900px;">
        <form method="POST" action="" class="d-flex w-75">
            <div class="input-group w-100">
                <input type="text" class="form-control" name="search" placeholder="Cari kategori pekerjaan..." value="<?php echo htmlspecialchars($search_query); ?>">
                <button class="btn btn-outline-secondary" type="submit">Cari</button>
            </div>
        </form>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
            Tambah Kategori
        </button>
    </div>
</div>


    <!-- Modal untuk Tambah Kategori -->
    <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCategoryModalLabel">Tambah Kategori Pekerjaan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama_kategori" class="form-label">Nama Kategori</label>
                            <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary" name="create">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal untuk Edit Kategori -->
    <div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCategoryModalLabel">Edit Kategori Pekerjaan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="">
                    <div class="modal-body">
                        <input type="hidden" id="edit_id_kategori" name="id_kategori">
                        <div class="mb-3">
                            <label for="edit_nama_kategori" class="form-label">Nama Kategori</label>
                            <input type="text" class="form-control" id="edit_nama_kategori" name="nama_kategori" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary" name="update">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


<!-- Table Displaying Categories -->
<table class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>ID Kategori</th>
            <th>Nama Kategori</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1; // Inisialisasi nomor urut
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>" . $no++ . "</td> <!-- Menampilkan nomor urut -->
                    <td>" . htmlspecialchars($row['id_kategori']) . "</td>
                    <td>" . htmlspecialchars($row['nama_kategori']) . "</td>
                    <td>
                        <!-- Ikon Edit -->
                        <a href='#' class='text-warning me-2' data-bs-toggle='modal' data-bs-target='#editCategoryModal' 
                           data-id_kategori='" . $row['id_kategori'] . "' 
                           data-nama_kategori='" . htmlspecialchars($row['nama_kategori']) . "' title='Edit'>
                            <i class='fas fa-edit'></i>
                        </a>
                        <!-- Ikon Hapus -->
                        <a href='?delete_id=" . $row['id_kategori'] . "' class='text-danger' title='Hapus' onclick='event.stopPropagation(); return confirm(\"Yakin ingin menghapus data ini?\");'>
                            <i class='fas fa-trash-alt'></i>
                        </a>
                    </td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='4'>Tidak ada data</td></tr>"; // Sesuaikan colspan dengan jumlah kolom
        }
        ?>
    </tbody>
</table>



<script src="../assets/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var editModal = document.getElementById('editCategoryModal');
    editModal.addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget;
        var idKategori = button.getAttribute('data-id_kategori');
        var namaKategori = button.getAttribute('data-nama_kategori');

        var modalIdInput = editModal.querySelector('#edit_id_kategori');
        var modalNamaInput = editModal.querySelector('#edit_nama_kategori');

        modalIdInput.value = idKategori;
        modalNamaInput.value = namaKategori;
    });
});
</script>
<script src="../assets/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html>
