<?php
// Koneksi ke database
include 'db_connect.php';

// Mendapatkan pekerjaan yang diposting oleh perusahaan yang login
$id_perusahaan = 1; // Ini biasanya berasal dari sesi login perusahaan
$query = "SELECT * FROM pekerjaan WHERE id_perusahaan = $id_perusahaan";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Dashboard Perusahaan</title>
    <!-- Link ke Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="text-center my-4">Selamat Datang di Dashboard Perusahaan</h1>

        <!-- Navigasi -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">Lowongan Kerja</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="index.php">Daftar Pekerjaan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="tambah_pekerjaan.php">Tambah Pekerjaan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="lamaran.php">Daftar Lamaran</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </nav>

        <h2 class="my-4">Daftar Pekerjaan yang Diposting</h2>
        
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Judul Pekerjaan</th>
                    <th scope="col">Deskripsi</th>
                    <th scope="col">Lokasi</th>
                    <th scope="col">Jenis Pekerjaan</th>
                    <th scope="col">Tipe Kerja</th>
                    <th scope="col">Gaji</th>
                    <th scope="col">Tanggal Posting</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo $row['judul_pekerjaan']; ?></td>
                    <td><?php echo $row['deskripsi']; ?></td>
                    <td><?php echo $row['lokasi']; ?></td>
                    <td><?php echo $row['jenis_pekerjaan']; ?></td>
                    <td><?php echo $row['tipe_kerja']; ?></td>
                    <td><?php echo $row['gaji']; ?></td>
                    <td><?php echo $row['tanggal_posting']; ?></td>
                    <td>
                        <a href="edit_pekerjaan.php?id_pekerjaan=<?php echo $row['id_pekerjaan']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="hapus_pekerjaan.php?id_pekerjaan=<?php echo $row['id_pekerjaan']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus pekerjaan ini?')">Hapus</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Link ke jQuery dan Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
