<?php
include 'db_connect.php';

if (isset($_POST['submit'])) {
    $id_pekerjaan = $_POST['id_pekerjaan'];
    $judul_pekerjaan = $_POST['judul_pekerjaan'];
    $lokasi = $_POST['lokasi'];
    $tipe_kerja = $_POST['tipe_kerja'];
    $gaji = $_POST['gaji'];

    $query = "UPDATE pekerjaan SET judul_pekerjaan='$judul_pekerjaan', lokasi='$lokasi', tipe_kerja='$tipe_kerja', gaji='$gaji' WHERE id_pekerjaan=$id_pekerjaan";
    
    if (mysqli_query($conn, $query)) {
        header('Location: index.php');
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

$id_pekerjaan = $_GET['id_pekerjaan'];
$query = "SELECT * FROM pekerjaan WHERE id_pekerjaan = $id_pekerjaan";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Edit Pekerjaan</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="my-4">Edit Pekerjaan</h1>
        <form method="post" action="">
            <input type="hidden" name="id_pekerjaan" value="<?php echo $row['id_pekerjaan']; ?>">

            <div class="form-group">
                <label>Judul Pekerjaan:</label>
                <input type="text" name="judul_pekerjaan" class="form-control" value="<?php echo $row['judul_pekerjaan']; ?>" required>
            </div>

            <div class="form-group">
                <label>Deskripsi:</label>
                <input type="text" name="deskripsi" class="form-control" value="<?php echo $row['deskripsi']; ?>" required>
            </div>

            <div class="form-group">
                <label>Lokasi:</label>
                <input type="text" name="lokasi" class="form-control" value="<?php echo $row['lokasi']; ?>" required>
            </div>

            <div class="form-group">
                <label>Jenis Pekerjaan:</label>
                <select name="tipe_kerja" class="form-control">
                    <option value="full_time" <?php if($row['jenis_pekerjaan'] == 'full_time') echo 'selected'; ?>>Full Time</option>
                    <option value="part_time" <?php if($row['jenis_pekerjaan'] == 'part_time') echo 'selected'; ?>>Part Time</option>
                    <option value="freelance" <?php if($row['jenis_pekerjaan'] == 'freelance') echo 'selected'; ?>>Freelance</option>
                    <option value="internship" <?php if($row['jenis_pekerjaan'] == 'internship') echo 'selected'; ?>>Internship</option>
                </select>
            </div>

            <div class="form-group">
                <label>Tipe Kerja:</label>
                <select name="tipe_kerja" class="form-control">
                    <option value="Remote" <?php if($row['tipe_kerja'] == 'remote') echo 'selected'; ?>>Remote</option>
                    <option value="Wfo" <?php if($row['tipe_kerja'] == 'Wfo') echo 'selected'; ?>>Wfo</option>
                    <option value="Hybrid" <?php if($row['tipe_kerja'] == 'Hybrid') echo 'selected'; ?>>Hybrid</option>
                </select>
            </div>

            <div class="form-group">
                <label>Gaji:</label>
                <input type="number" name="gaji" class="form-control" value="<?php echo $row['gaji']; ?>" required>
            </div>

            <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
            <a href="index.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
