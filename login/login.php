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
                header("Location: admin/index.php");
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
<html>
<head>
    <title>Login - LookWork</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="sign-in.css">
    <style>
        body { display: flex; align-items: center; justify-content: center; height: 100vh; margin: 0; }
        .login-form { width: 400px; padding: 40px; background: #fff; border-radius: 5px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); }
        .password-wrapper { position: relative; }
        .password-wrapper i { position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer; color: #16423C; }
    </style>
</head>
<body>
    <div class="login-form">
        <h2 style="color : #16423C"><b>Login LookWork</b></h2>
        <br/>
        <?php if (isset($error)) { ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php } ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="email" style="color : #16423C">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group password-wrapper">
                <label for="password" style="color : #16423C">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
                <i class="fas fa-eye" id="togglePassword"></i>
            </div>
            <p class="text-left mt-3"> <a href="forgotpass.php">Lupa password?</a></p>
            <button type="submit" class="btn btn-info btn-block">Login</button>
        </form>
        <p class="text-center mt-3">Belum punya akun? <a href="register.php">Register</a></p>
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
