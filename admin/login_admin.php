<?php
session_start();

// Sertakan file koneksi database
include('db.php'); // Pastikan path ke file 'db.php' sudah benar

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Mencegah SQL Injection dengan menggunakan prepared statements
    $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Memeriksa apakah username ditemukan
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        
        // Memverifikasi password yang di-hash
        if (password_verify($password, $row['password'])) {
            // Set session variables
            $_SESSION['admin_id'] = $row['admin_id'];  // Menggunakan admin_id dari tabel admin
            $_SESSION['username'] = $row['username'];  // Menyimpan username admin dalam sesi
            
            header("Location: index.php"); // Redirect ke halaman utama setelah login
            exit();
        } else {
            $error = "Username atau Password salah!";
        }
    } else {
        $error = "Username atau Password salah!";
    }

    $stmt->close(); // Menutup statement
}
?>



<!DOCTYPE html>
<html>
<head>
    <title>Login - LookWork</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Menambahkan font-awesome untuk ikon -->
    <link rel="stylesheet" href="sign-in.css">
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .login-form {
            width: 400px;
            padding: 40px;
            background: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .password-wrapper {
            position: relative;
        }

        .password-wrapper i {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #16423C;
        }
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
                <label for="username" style="color : #16423C">Username:</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group password-wrapper">
                <label for="password" style="color : #16423C">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
                <i class="fas fa-eye" id="togglePassword"></i> <!-- Ikon mata untuk toggle -->
            </div>
            <button type="submit" class="btn btn-info btn-block">Login</button>
        </form>
        <p class="text-center mt-3">Belum punya akun? <a href="register.php">Register</a></p>
        <p class="text-center mt-3"> <a href="pass/forgotpass.php">lupa password?</a></p>
    </div>

    <script>
        const togglePassword = document.querySelector("#togglePassword");
        const password = document.querySelector("#password");

        togglePassword.addEventListener("click", function () {
            // Toggle tipe input antara password dan text
            const type = password.getAttribute("type") === "password" ? "text" : "password";
            password.setAttribute("type", type);
            
            // Ubah ikon mata saat password terlihat atau tersembunyi
            this.classList.toggle("fa-eye-slash");
        });
    </script>
</body>
</html>
