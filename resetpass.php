<?php
// Koneksi ke database
$conn = new mysqli("localhost", "username", "password", "lowongankerja");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $token = $_POST['token'];
    $newPassword = password_hash($_POST['new_password'], PASSWORD_BCRYPT);

    // Periksa apakah token valid
    $sql = "SELECT * FROM users WHERE reset_token = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Update password di database
        $sql = "UPDATE users SET password = ?, reset_token = NULL WHERE reset_token = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $newPassword, $token);
        $stmt->execute();

        echo "Password berhasil direset.";
    } else {
        echo "Token tidak valid.";
    }
} else if (isset($_GET['token'])) {
    $token = $_GET['token'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
</head>
<body>
    <h2>Reset Password</h2>
    <form method="POST" action="">
        <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>" />
        <label for="new_password">Kata Sandi Baru:</label><br>
        <input type="password" id="new_password" name="new_password" required><br><br>
        <button type="submit">Reset Password</button>
    </form>
</body>
</html>

<?php
}
?>
