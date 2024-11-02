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
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Perusahaan_LookWork</title>
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

</head>
<body data-bs-spy="scroll" data-bs-target=".navbar" data-bs-offset="70">
    <div class="container-xxl bg-white p-0">

        <nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
            <a href="index.php" class="navbar-brand d-flex align-items-center text-center py-0 px-4 px-lg-5">
                <h1 class="m-0 text-primary">LookWork</h1>
            </a>
            <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav ms-auto p-4 p-lg-0">
                    <a href="index.php" class="nav-item nav-link active">Beranda</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pekerjaan</a>
                        <div class="dropdown-menu rounded-0 m-0">
                            <a href="daftar_loker.php" class="dropdown-item">Daftar Lowongan Pekerjaan</a>
                            <a href="daftar_lamaran.php" class="dropdown-item">Daftar Lamaran Pekerjaan</a>
                        </div>
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Profil</a>
                        <div class="dropdown-menu rounded-0 m-0">
                            <a href="pengaturan_profil.php" class="dropdown-item">Pengaturan Profil</a>
                            <a href="keluar.php" class="dropdown-item">Keluar</a>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </div>

    <body>
    <div class="container mt-5">
    <h2>Daftar Lamaran Pekerjaan</h2>
    <div class="table-responsive">
    <table class="table table-striped">
        <thead>
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


<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <script src="js/main.js"></script>
    
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>