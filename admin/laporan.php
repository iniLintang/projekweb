<?php
// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "lowongan_kerja");

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Menambah lowongan
if (isset($_POST['submit_create'])) {
    $nama_lowongan = $_POST['nama_lowongan'];
    $deskripsi = $_POST['deskripsi'];
    $tanggal_dibuka = $_POST['tanggal_dibuka'];
    $tanggal_ditutup = $_POST['tanggal_ditutup'];

    $sql_create = "INSERT INTO lowongan (nama_lowongan, deskripsi, tanggal_dibuka, tanggal_ditutup) 
            VALUES ('$nama_lowongan', '$deskripsi', '$tanggal_dibuka', '$tanggal_ditutup')";

    if ($conn->query($sql_create) === TRUE) {
        header("Location: index.php");
    } else {
        echo "Error: " . $sql_create . "<br>" . $conn->error;
    }
}

// Mengupdate lowongan
if (isset($_POST['submit_update'])) {
    $id = $_POST['id'];
    $nama_lowongan = $_POST['nama_lowongan'];
    $deskripsi = $_POST['deskripsi'];
    $tanggal_dibuka = $_POST['tanggal_dibuka'];
    $tanggal_ditutup = $_POST['tanggal_ditutup'];

    $sql_update = "UPDATE lowongan SET nama_lowongan='$nama_lowongan', deskripsi='$deskripsi', tanggal_dibuka='$tanggal_dibuka', tanggal_ditutup='$tanggal_ditutup' WHERE id=$id";

    if ($conn->query($sql_update) === TRUE) {
        header("Location: index.php");
    } else {
        echo "Error: " . $sql_update . "<br>" . $conn->error;
    }
}

// Menghapus lowongan
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $sql_delete = "DELETE FROM lowongan WHERE id=$id";

    if ($conn->query($sql_delete) === TRUE) {
        header("Location: index.php");
    } else {
        echo "Error: " . $sql_delete . "<br>" . $conn->error;
    }
}

// Mendapatkan data untuk update
$edit_row = null;
if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
    $sql_edit = "SELECT * FROM lowongan WHERE id=$edit_id";
    $edit_result = $conn->query($sql_edit);
    $edit_row = $edit_result->fetch_assoc();
}

// Ambil semua data lowongan
$sql = "SELECT * FROM lowongan";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Lowongan</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Daftar Lowongan</h2>

        <!-- Form Tambah/Update Lowongan -->
        <h4><?php echo isset($edit_row) ? 'Edit Lowongan' : 'Tambah Lowongan'; ?></h4>
        <form method="POST" action="">
            <input type="hidden" name="id" value="<?php echo isset($edit_row) ? $edit_row['id'] : ''; ?>">
            <div class="mb-3">
                <label for="nama_lowongan" class="form-label">Nama Lowongan</label>
                <input type="text" class="form-control" id="nama_lowongan" name="nama_lowongan" 
                       value="<?php echo isset($edit_row) ? $edit_row['nama_lowongan'] : ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required><?php echo isset($edit_row) ? $edit_row['deskripsi'] : ''; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="tanggal_dibuka" class="form-label">Tanggal Dibuka</label>
                <input type="date" class="form-control" id="tanggal_dibuka" name="tanggal_dibuka" 
                       value="<?php echo isset($edit_row) ? $edit_row['tanggal_dibuka'] : ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="tanggal_ditutup" class="form-label">Tanggal Ditutup</label>
                <input type="date" class="form-control" id="tanggal_ditutup" name="tanggal_ditutup" 
                       value="<?php echo isset($edit_row) ? $edit_row['tanggal_ditutup'] : ''; ?>" required>
            </div>
            <button type="submit" name="<?php echo isset($edit_row) ? 'submit_update' : 'submit_create'; ?>" class="btn btn-success">
                <?php echo isset($edit_row) ? 'Update Lowongan' : 'Simpan Lowongan'; ?>
            </button>
        </form>

        <!-- Tabel Daftar Lowongan -->
        <h2 class="mt-5">Daftar Lowongan</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Lowongan</th>
                    <th>Deskripsi</th>
                    <th>Tanggal Dibuka</th>
                    <th>Tanggal Ditutup</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['nama_lowongan']; ?></td>
                        <td><?php echo $row['deskripsi']; ?></td>
                        <td><?php echo $row['tanggal_dibuka']; ?></td>
                        <td><?php echo $row['tanggal_ditutup']; ?></td>
                        <td>
                            <a href="index.php?edit_id=<?php echo $row['id']; ?>" class="btn btn-warning">Edit</a>
                            <a href="index.php?delete_id=<?php echo $row['id']; ?>" class="btn btn-danger" 
                               onclick="return confirm('Yakin ingin menghapus lowongan ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
$conn->close();
?>

