<?php
session_start();

// Include file koneksi database
include "db_connect.php";

// Import PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once "PHPMailer/PHPMailer/src/Exception.php";
require_once "PHPMailer/PHPMailer/src/PHPMailer.php";
require_once "PHPMailer/PHPMailer/src/SMTP.php";

class ForgotPassword {

    private function response($status, $message, $error_detail = null) {
        $response = ['status' => $status, 'message' => $message];
        if ($error_detail) {
            $response['error_detail'] = $error_detail;
        }
        return json_encode($response);
    }

    // Proses permintaan reset password
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

            // URL reset password
            $reset_url = "http://localhost/projeklow2/login/reset_password.php?reset=$pass&key={$email}";

            // Set up PHPMailer
            $mail = new PHPMailer(true);
            $body = "
            <html>
            <head>
                <style>
                    .email-container { max-width: 600px; margin: auto; font-family: Arial, sans-serif; background-color: #f9f9f9; padding: 20px; border-radius: 8px; }
                    .email-header { background-color: #0077b6; color: white; text-align: center; padding: 15px; border-radius: 8px 8px 0 0; }
                    .email-content { text-align: center; }
                    .btn { display: inline-block; margin-top: 20px; padding: 12px 24px; background-color: #0077b6; color: white; text-decoration: none; border-radius: 4px; }
                    .btn:hover { background-color: #005f8a; }
                    .footer { font-size: 12px; color: #888; text-align: center; margin-top: 20px; }
                </style>
            </head>
            <body>
                <div class='email-container'>
                    <div class='email-header'>
                        <h2>Reset Password Anda</h2>
                    </div>
                    <div class='email-content'>
                        <p>Kami menerima permintaan untuk mereset password Anda di LookWork.</p>
                        <p>Silakan klik tombol di bawah ini untuk melanjutkan:</p>
                        <a href='$reset_url' class='btn'>Reset Password</a>
                        <p>Link ini akan kedaluwarsa dalam 24 jam.</p>
                    </div>
                    <div class='footer'>
                        &copy; 2024 LookWork. Semua hak dilindungi.
                    </div>
                </div>
            </body>
            </html>
            ";

            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'lookworkv2@gmail.com';
                $mail->Password = 'bukl ftpj mxse wgrd'; // Gantilah dengan password yang benar
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('lookworkv2@gmail.com', 'LOOKWORK');
                $mail->addAddress($email);

                $mail->isHTML(true);
                $mail->Subject = 'Permintaan Reset Password';
                $mail->Body = $body;
                $mail->AltBody = "Klik link berikut untuk reset password Anda: $reset_url";

                if ($mail->send()) {
                    return $this->response('success', 'Link reset password telah dikirim ke email Anda.');
                } else {
                    return $this->response('error', 'Gagal mengirim email.', $mail->ErrorInfo);
                }
            } catch (Exception $e) {
                return $this->response('error', 'Terjadi kesalahan saat mengirim email.', $e->getMessage());
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
