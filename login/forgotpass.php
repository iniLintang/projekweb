<?php
session_start();

if (isset($_SESSION['alert'])) {
    $alert = $_SESSION['alert'];
    unset($_SESSION['alert']); // Hapus pesan setelah ditampilkan
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - LookWork</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="forgot-password.css"> 
</head>
<body>
    <div class="forgot-password-container">
        <div class="forgot-password-form">
            <h2><b>LookWork</b></h2>

            <?php if (isset($alert)): ?>
                <div class="alert alert-<?php echo $alert['type'] === 'success' ? 'success' : 'danger'; ?> alert-dismissible fade show" role="alert">
                    <?php echo $alert['message']; ?>
                </div>
            <?php endif; ?>

            <form method="post" action="forgotpass_process.php">
                <div class="form-group">
                    <label for="email">Masukkan alamat email anda:</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>

                <input type="submit" value="Submit" class="btn btn-info">
            </form>
            <p class="text-center mt-3">Ingat Kata Sandi? <a href="login.php">Login</a></p>
        </div>
    </div>
</body>
</html>

