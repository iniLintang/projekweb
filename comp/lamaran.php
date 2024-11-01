<?php
include 'db_connect.php';

$id_perusahaan = 1; 
$query = "SELECT l.*, p.judul_pekerjaan, u.nama 
          FROM lamaran l 
          JOIN pekerjaan p ON l.id_pekerjaan = p.id_pekerjaan 
          JOIN pengguna u ON l.id_pencari_kerja = u.id_pengguna
          WHERE p.id_perusahaan = $id_perusahaan";

$result = mysqli_query($conn, $query);

if (isset($_POST['update_status'])) {
    $id_lamaran = $_POST['id_lamaran'];
    $status_baru = $_POST['status_lamaran'];

    $update_query = "UPDATE lamaran SET status = '$status_baru' WHERE id_lamaran = $id_lamaran";
    
    if (mysqli_query($conn, $update_query)) {
        $email_query = "SELECT email FROM pengguna WHERE id_pengguna = (SELECT id_pencari_kerja FROM lamaran WHERE id_lamaran = $id_lamaran)";
        $email_result = mysqli_query($conn, $email_query);
        $email_row = mysqli_fetch_assoc($email_result);
        $email_pencari_kerja = $email_row['email'];
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Daftar Lamaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 20px;
        }
        table {
            margin-top: 20px;
            background-color: white;
        }
        th, td {
            vertical-align: middle;
        }
        .btn-primary {
            margin-left: 10px;
        }
        .form-select {
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mb-4">Daftar Lamaran Masuk</h1>

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Nama Pelamar</th>
                        <th>Judul Pekerjaan</th>
                        <th>Status Saat Ini</th>
                        <th>Ubah Status</th>
                        <th>Tanggal Lamaran</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $row['nama']; ?></td>
                        <td><?php echo $row['judul_pekerjaan']; ?></td>
                        <td><?php echo $row['status']; ?></td>
                        <td>
                            <form method="post" action="">
                                <input type="hidden" name="id_lamaran" value="<?php echo $row['id_lamaran']; ?>">
                                <select name="status_lamaran" class="form-select">
                                    <option value="dikirim" <?php if ($row['status'] == 'dikirim') echo 'selected'; ?>>Dikirim</option>
                                    <option value="diproses" <?php if ($row['status'] == 'diproses') echo 'selected'; ?>>Diproses</option>
                                    <option value="diterima" <?php if ($row['status'] == 'diterima') echo 'selected'; ?>>Diterima</option>
                                    <option value="ditolak" <?php if ($row['status'] == 'ditolak') echo 'selected'; ?>>Ditolak</option>
                                </select>
                                <button type="submit" name="update_status" class="btn btn-primary">Update</button>
                            </form>
                        </td>
                        <td><?php echo $row['tanggal_lamaran']; ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>