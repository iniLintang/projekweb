<?php
// Koneksi ke database
$server = "wstif23.myhost.id";
$user = "wstifmy1_kelas_int";
$password = "@Polije164Int";
$nama_database = "wstifmy1_int_team3";


// Buat koneksi
$db = new mysqli($server, $user, $password, $nama_database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = ""; // Variable untuk pesan
$success = false; // Variable untuk menandakan keberhasilan

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
            $message = "Password berhasil diperbarui."; // Pesan berhasil
            $success = true; // Tandai berhasil
        } else {
            $message = "Email tidak ditemukan atau gagal memperbarui password."; // Pesan gagal
        }
    } else {
        $message = "Semua kolom wajib diisi."; // Validasi input
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

    <!-- JavaScript untuk menampilkan pop-up dan redirect -->
    <script>
        // Cek apakah ada pesan dari PHP
        var message = "<?php echo $message; ?>";
        var success = "<?php echo $success; ?>"; // Cek status keberhasilan

        if (message) {
            alert(message); // Tampilkan pesan sebagai pop-up alert
        }

        // Jika password berhasil diperbarui, redirect ke halaman login setelah menampilkan pesan
        if (success) {
            window.location.href = "login.php"; // Redirect ke halaman login
        }
    </script>
</body>
</html>
