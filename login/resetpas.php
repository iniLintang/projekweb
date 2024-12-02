<?php
// Koneksi ke database
$host = "localhost";
$username = "root";
$password = "";
$database = "lookwork2";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Periksa jika permintaan adalah POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $new_password = $_POST['kata_sandi'];

    // Validasi input
    if (!empty($email) && !empty($new_password)) {
        // Hash password baru
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Perbarui kata sandi di database
        $stmt = $conn->prepare("UPDATE pengguna SET kata_sandi = ? WHERE email = ?");
        $stmt->bind_param("ss", $hashed_password, $email);

        if ($stmt->execute() && $stmt->affected_rows > 0) {
            echo "Password berhasil diperbarui.";
        } else {
            echo "Email tidak ditemukan atau gagal memperbarui password.";
        }
    } else {
        echo "Semua kolom wajib diisi.";
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="reset_password.css"> 
</head>
<body>
    <div class="container">
        <div class="card">
            <h1>Atur Ulang Kata Sandi</h1>
            <form method="post">
                <label for="email">Masukkan Email Anda</label>
                <input type="email" id="email" name="email" required>
                
                <label for="new_password">Masukkan Kata Sandi Baru</label>
                <input type="password" id="new_password" name="kata_sandi" required>
                
                <input type="submit" value="Perbarui Kata Sandi">
            </form>
            <p class="text-center mt-3">Ingat Kata Sandi? <a href="login.php">Login</a></p>
        </div>
    </div>
</body>
</html>
