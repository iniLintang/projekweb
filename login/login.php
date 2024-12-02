<?php
session_start();

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

// Menangani proses login saat form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Mencegah SQL Injection dengan menggunakan prepared statements
    $stmt = $conn->prepare("SELECT * FROM pengguna WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Memeriksa apakah email ditemukan
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        // Memverifikasi password yang di-hash
        if (password_verify($password, $row['kata_sandi'])) {
            // Set session variables
            $_SESSION['pengguna_id'] = $row['id_pengguna'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['peran'] = $row['peran'];

            // Redirect sesuai dengan peran
            if ($row['peran'] == 'pencari_kerja') {
                header("Location: ../user/indexx.php"); 
            } elseif ($row['peran'] == 'perusahaan') {
                header("Location: ../perusahaan/index.php");
            } elseif ($row['peran'] == 'admin') {
                header("Location: ../admin/index.php");
            }
            exit();
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Email tidak ditemukan!";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - LookWork</title>
    <!-- Link ke file CSS eksternal -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="login-form">
        <h2><b>LookWork</b></h2>
        <br/>
        <?php if (isset($error)) { ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php } ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
            </div>
            <div class="form-group password-wrapper">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                <i class="fas fa-eye" id="togglePassword"></i>
            </div>
            <p class="text-left mt-3"><a href="forgotpass.php">Lupa Sandi?</a></p>
            <button type="submit" class="btn btn-block">Login</button>
        </form>
        <p class="text-center mt-3">Belum punya akun? <a href="register.php">Daftar</a></p>
    </div>

    <script>
        const togglePassword = document.querySelector("#togglePassword");
        const password = document.querySelector("#password");

        togglePassword.addEventListener("click", function () {
            const type = password.getAttribute("type") === "password" ? "text" : "password";
            password.setAttribute("type", type);
            this.classList.toggle("fa-eye-slash");
        });
    </script>
</body>
</html>



