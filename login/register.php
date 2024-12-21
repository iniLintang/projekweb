<?php
session_start();

// Konfigurasi database
$server = "wstif23.myhost.id";
$user = "wstifmy1_kelas_int";
$password = "@Polije164Int";
$nama_database = "wstifmy1_int_team3";

// Buat koneksi
$db = new mysqli($server, $user, $password, $nama_database);

// Memeriksa koneksi
if ($db->connect_error) {
    die("Koneksi gagal: " . $db->connect_error);
}

// Menangani proses registrasi saat form disubmit
$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $nama = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $kata_sandi = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $peran = $_POST['peran'];

    // Validasi input
    if (empty($username) || empty($nama) || empty($email) || empty($kata_sandi) || empty($confirm_password)) {
        $error = "Semua kolom harus diisi!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Format email tidak valid!";
    } elseif ($kata_sandi !== $confirm_password) {
        $error = "Password dan konfirmasi password tidak cocok!";
    } else {
        // Memeriksa apakah username atau email sudah ada di database
        $sql = "SELECT * FROM pengguna WHERE username = ? OR email = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error = "Username atau Email sudah terpakai!";
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Peringatan',
                        text: '$error',
                        confirmButtonText: 'OK',
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    });
                });
            </script>";
        } else {
            // Meng-hash password
            $hashed_password = password_hash($kata_sandi, PASSWORD_DEFAULT);

            // Query untuk menyimpan data pengguna
            $sql = "INSERT INTO pengguna (username, nama, email, kata_sandi, peran) VALUES (?, ?, ?, ?, ?)";
            $stmt = $db->prepare($sql);
            $stmt->bind_param("sssss", $username, $nama, $email, $hashed_password, $peran);

            if ($stmt->execute()) {
                $id_pengguna = $db->insert_id;

                // Masukkan data ke tabel sesuai peran
                if ($peran == 'pencari_kerja') {
                    $sql_pencari_kerja = "INSERT INTO pencari_kerja (id_pengguna) VALUES (?)";
                    $stmt_pencari_kerja = $db->prepare($sql_pencari_kerja);
                    $stmt_pencari_kerja->bind_param("i", $id_pengguna);
                    $stmt_pencari_kerja->execute();
                } elseif ($peran == 'perusahaan') {
                    $nama_perusahaan = trim($_POST['nama_perusahaan']);
                    $sql_perusahaan = "INSERT INTO perusahaan (id_pengguna, nama_perusahaan) VALUES (?, ?)";
                    $stmt_perusahaan = $db->prepare($sql_perusahaan);
                    $stmt_perusahaan->bind_param("is", $id_pengguna, $nama_perusahaan);
                    $stmt_perusahaan->execute();
                }

                // Redirect ke halaman login
                header("Location: login.php");
                exit();
            } else {
                $error = "Terjadi kesalahan: " . $db->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - LookWork</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="register-form">
        <h2><b>LookWork</b></h2>

        <?php if (isset($error)): ?>
            <div class="error"><?= $error; ?></div>
        <?php endif; ?>

        <form action="register.php" method="post">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="full_name">Nama Lengkap:</label>
                <input type="text" id="full_name" name="full_name" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="password">Kata Sandi:</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="confirm_password">konfirmasi Kata Sandi:</label>
                <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="peran">Peran:</label>
                <select id="peran" name="peran" class="form-control" required>
                    <option value="pencari_kerja">Pencari Kerja</option>
                    <option value="perusahaan">Perusahaan</option>
                </select>
            </div>

            <div class="form-group" id="nama_perusahaan_container" style="display: none;">
                <label for="nama_perusahaan">Nama Perusahaan:</label>
                <input type="text" id="nama_perusahaan" name="nama_perusahaan" class="form-control">
            </div>

            <button type="submit" class="btn btn-info">Register</button>
            <p class="text-center mt-3">Sudah memiliki Akun? <a href="login.php">Login</a></p>
        </form>
    </div>

    <script>
        // Menampilkan kolom nama_perusahaan hanya jika peran yang dipilih adalah 'perusahaan'
        document.getElementById('peran').addEventListener('change', function () {
            const perusahaanField = document.getElementById('nama_perusahaan_container');
            perusahaanField.style.display = this.value === 'perusahaan' ? 'block' : 'none';
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>
</html>
