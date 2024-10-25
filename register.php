<?php
session_start(); // Memulai sesi

// Konfigurasi database
$host = "localhost"; 
$username_db = "root"; 
$password_db = ""; 
$database = "lookwork2";  

// Membuat koneksi ke database
$conn = new mysqli($host, $username_db, $password_db, $database);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Menangani proses registrasi saat form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $nama = $_POST['full_name']; // Disesuaikan dengan kolom 'nama' di tabel
    $email = $_POST['email'];
    $kata_sandi = $_POST['password']; // Disesuaikan dengan kolom 'kata_sandi'
    $confirm_password = $_POST['confirm_password'];

    // Mencegah SQL Injection
    $username = mysqli_real_escape_string($conn, $username);
    $nama = mysqli_real_escape_string($conn, $nama);
    $email = mysqli_real_escape_string($conn, $email);

    // Memeriksa apakah username atau email sudah ada di database
    $sql = "SELECT * FROM pengguna WHERE username = ? OR email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Jika ada hasil, artinya username atau email sudah digunakan
        $error = "Username atau Email sudah terpakai!";
    } else {
        // Memeriksa apakah password dan konfirmasi password cocok
        if ($kata_sandi === $confirm_password) {
            // Meng-hash password
            $hashed_password = password_hash($kata_sandi, PASSWORD_DEFAULT);

            // Query untuk menyimpan data pengguna ke database
            $sql = "INSERT INTO pengguna (username, nama, email, kata_sandi) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssss", $username, $nama, $email, $hashed_password);

            if ($stmt->execute()) {
                // Ambil id_pengguna yang baru saja diinsert
                $id_pengguna = $conn->insert_id;

                // Masukkan data ke tabel pencari_kerja
                $sql_pencari_kerja = "INSERT INTO pencari_kerja (id_pengguna) VALUES (?)";
                $stmt_pencari_kerja = $conn->prepare($sql_pencari_kerja);
                $stmt_pencari_kerja->bind_param("i", $id_pengguna);

                if ($stmt_pencari_kerja->execute()) {
                    // Redirect ke halaman login setelah berhasil registrasi
                    header("Location: login.php");
                    exit();
                } else {
                    $error = "Terjadi kesalahan pada saat menyimpan data pencari kerja: " . $conn->error;
                }
            } else {
                $error = "Terjadi kesalahan: " . $conn->error;
            }
        } else {
            $error = "Password dan konfirmasi password tidak cocok!";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register - LookWork</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="sign-in.css">
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            background-color: #f8f9fa;
        }

        .login-form {
            width: 400px;
            padding: 40px;
            background: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .error {
            color: red;
        }
    </style>
</head>
<body>
    <div class="login-form" style="color : #16423C">
        <h2><b>Register LookWork</b></h2>

        <?php if (isset($error)): ?>
            <div class="error"><?= $error; ?></div>
        <?php endif; ?>

        <form action="register.php" method="post">
            <div class="form-group"><br>
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="full_name">Full Name:</label>
                <input type="text" id="full_name" name="full_name" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-info">Register</button>
            <p class="text-center mt-3" >Sudah memiliki Akun? <a href="login.php">Login</a></p>
        </form>
    </div>
</body>
</html>
