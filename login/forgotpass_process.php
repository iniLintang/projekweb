<?php
session_start();

// Include file koneksi database
include "db_connect.php";

// Import PHPMailer dengan namespace yang benar
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

// Path ke file PHPMailer
require_once "PHPMailer-master/src/Exception.php";
require_once "PHPMailer-master/src/PHPMailer.php";
require_once "PHPMailer-master/src/SMTP.php";

class ForgotPassword {

    private function response($status, $message, $error_detail = null) {
        $response = ['status' => $status, 'message' => $message];
        if ($error_detail) {
            $response['error_detail'] = $error_detail;
        }
        return json_encode($response);
    }

    public function processRequest($db, $email) {
        if (empty($email)) {
            return $this->response('error', 'Email tidak boleh kosong.');
        }

        if (!$db) {
            return $this->response('error', 'Koneksi database gagal.');
        }

        // Cek apakah email ada dalam database
        $select = $db->prepare("SELECT email, kata_sandi FROM pengguna WHERE email = ?");
        $select->bind_param("s", $email);
        $select->execute();
        $result = $select->get_result();

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $pass = md5($row['kata_sandi']);
            $reset_url = "http://localhost/projeklow23/login/resetpas.php?reset=$pass&key={$email}";

            // Set up PHPMailer
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'netflixforus764@gmail.com'; // Email Anda
                $mail->Password = 'pdvs nhwp jrzj scun'; // App Password Gmail
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Bisa coba ENCRYPTION_SMTPS untuk port 465
                $mail->Port = 587; // Gunakan 465 jika ENCRYPTION_SMTPS

                $mail->setFrom('netflixforus764@gmail.com', 'LOOKWORK');
                $mail->addAddress($email);

                $mail->isHTML(true);
                $mail->Subject = 'Permintaan Reset Password';
                $mail->Body = "
                <!DOCTYPE html>
                <html>
                <head>
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            margin: 0;
                            padding: 0;
                            background-color: #f4f4f4;
                            color: #333;
                        }
                        .email-container {
                            max-width: 600px;
                            margin: 20px auto;
                            background-color: #ffffff;
                            border: 1px solid #ddd;
                            border-radius: 8px;
                            overflow: hidden;
                            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                        }
                        .email-header {
                            background-color: #004d00; /* Hijau Gelap */
                            color: #ffffff;
                            padding: 20px;
                            text-align: center;
                        }
                        .email-body {
                            padding: 20px;
                            line-height: 1.6;
                            color: #004d00; /* Hijau Gelap */
                        }
                        .email-footer {
                            background-color: #e6ffe6; /* Hijau Terang */
                            color: #666;
                            padding: 15px;
                            text-align: center;
                            font-size: 14px;
                        }
                        .reset-button {
                            display: inline-block;
                            padding: 10px 20px;
                            margin-top: 20px;
                            background-color: #008000; /* Hijau */
                            color: white;
                            text-decoration: none;
                            border-radius: 5px;
                            font-weight: bold;
                            border: 2px solid #004d00; /* Hijau Gelap */
                        }
                        .reset-button:hover {
                            background-color: #004d00; /* Hijau Gelap */
                            color: #ffffff;
                        }
                    </style>
                </head>
                <body>
                    <div class='email-container'>
                        <div class='email-header'>
                            <h1>Reset Password</h1>
                        </div>
                        <div class='email-body'>
                            <p>Hai,</p>
                            <p>Kami menerima permintaan untuk mereset password akun Anda. Jika ini adalah permintaan Anda, silakan klik tombol di bawah untuk melanjutkan:</p>
                            <a href='$reset_url' class='reset-button' center>Reset Password</a>
                            <p>Jika Anda tidak meminta pengaturan ulang password, abaikan email ini.</p>
                        </div>
                        <div class='email-footer'>
                            <p>&copy; 2024 LookWork. All rights reserved.</p>
                        </div>
                    </div>
                </body>
                </html>
                ";
                $mail->AltBody = "Klik link berikut untuk reset password Anda: $reset_url";

                if ($mail->send()) {
                    $_SESSION['alert'] = [
                        'type' => 'success',
                        'message' => 'Link reset password telah dikirim ke email Anda.'
                    ];
                } else {
                    $_SESSION['alert'] = [
                        'type' => 'error',
                        'message' => 'Gagal mengirim email. ' . $mail->ErrorInfo
                    ];
                }
            } catch (Exception $e) {
                $_SESSION['alert'] = [
                    'type' => 'error',
                    'message' => 'Terjadi kesalahan saat mengirim email. ' . $e->getMessage()
                ];
            }
        } else {
            return $this->response('error', 'Email tidak ditemukan.');
        }
    }
}

// Proses permintaan
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
    $email = $_POST['email'];
    $forgotPassword = new ForgotPassword();

    if (isset($db) && $db) {
        echo $forgotPassword->processRequest($db, $email);
        $db->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Koneksi database gagal.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Email tidak boleh kosong.']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Reset Password Terkirim</title>
    <link rel="stylesheet" href="forgotpass_process.css">
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="icon-wrapper">
                <img src="https://img.icons8.com/color/96/000000/checked-2--v1.png" alt="Success Icon">
            </div>
            <h1>Email Terkirim</h1>
            <p>Kami telah mengirimkan link untuk mereset password ke email Anda.</p>
            <p>Silakan cek email Anda dan ikuti instruksi untuk mereset password.</p>
            <div class="btn-wrapper">
                <a href="login.php" class="button">Kembali ke Halaman Login</a>
            </div>
        </div>
    </div>
</body>
</html>
