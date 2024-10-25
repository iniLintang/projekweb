<?php
// Load PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Pastikan path benar jika kamu menggunakan Composer

// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "lowongankerja");

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Periksa apakah email ada di database
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die('Statement gagal dipersiapkan: ' . $conn->error);
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $token = bin2hex(random_bytes(50)); // Token reset password
        $sql = "UPDATE users SET reset_token = ? WHERE email = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            die('Statement gagal dipersiapkan: ' . $conn->error);
        }

        $stmt->bind_param("ss", $token, $email);
        $stmt->execute();

        // Setup PHPMailer
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com';                       // Specify SMTP server
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'netflixforus764@gmail.com';             // SMTP username
            $mail->Password = 'netflixforus12345';              // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption
            $mail->Port = 587;                                    // TCP port to connect to

            // Recipients
            $mail->setFrom('cs@Lookwork.com', 'LookWork Support');
            $mail->addAddress($email);                            // Add a recipient

            // Content
            $resetLink = "http://localhost/projeklow/resetpass.php" . $token;
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Reset Password';
            $mail->Body    = "Klik tautan ini untuk mereset kata sandi Anda: <a href='$resetLink'>$resetLink</a>";

            $mail->send();
            echo "Email reset password telah dikirim.";
        } catch (Exception $e) {
            echo "Gagal mengirim email. Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "Email tidak ditemukan.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
</head>
<body>
    <h2>Forgot Password</h2>
    <form method="POST" action="">
        <label for="email">Masukkan Email Anda:</label><br>
        <input type="email" id="email" name="email" required><br><br>
        <button type="submit">Submit</button>
    </form>
</body>
</html>
