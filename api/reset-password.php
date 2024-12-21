<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require "phpmailer/vendor/autoload.php";

if (!empty($_POST['email'])) {
    $email = $_POST['email'];
    $con = mysqli_connect("localhost", "root", "", "lookwork2");

    if ($con) {
        try {
            $otp = random_int(100000, 999999);
        } catch (Exception $e) {
            $otp = rand(100000, 999999);
        }

        $sql = "UPDATE pengguna SET reset_password_otp = '".$otp."' , reset_password_created_at = '".date('Y-m-d H:i:s')."' WHERE email = '".$email."'";

        if (mysqli_query($con, $sql)) {
            if (mysqli_affected_rows($con) > 0) { // Menggunakan > 0 untuk memastikan ada baris yang terpengaruh
                $mail = new PHPMailer(true);

                try {
                    // Server settings
                    $mail->isSMTP();                                            // Send using SMTP
                    $mail->Host       = 'smtp.gmail.com';                     // Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                    $mail->Username   = 'lookworkv2@gmail.com';                     // SMTP username
                    $mail->Password   = 'bukl ftpj mxse wgrd';                               // SMTP password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;           // Enable implicit TLS encryption
                    $mail->Port       = 587;                                    // TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                    // Recipients
                    $mail->setFrom('lookworkv2@gmail.com', 'LOOKWORK');
                    $mail->addAddress($email);                                  // Add a recipient
                    $mail->addReplyTo('lookworkv2@gmail.com', 'LOOKWORK');      // Optional

                    
                    // Set email format to HTML
                    $mail->isHTML(true);    
                    $mail->Subject = 'Reset Password - LOOKWORK';

                    $mail->Body = '
                    <!DOCTYPE html>
                    <html lang="id">
                    <head>
                        <meta charset="UTF-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <style>
                            body {
                                font-family: Arial, sans-serif;
                                background-color: #f9f9f9;
                                margin: 0;
                                padding: 0;
                                color: #333333;
                            }
                            .email-container {
                                max-width: 600px;
                                margin: 0 auto;
                                background-color: #ffffff;
                                border-radius: 8px;
                                overflow: hidden;
                                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
                            }
                            .email-header {
                                background-color: #bdfafa;
                                padding: 20px;
                                text-align: center;
                            }
                            .email-header img {
                                max-width: 150px;
                                margin-bottom: 10px;
                            }
                            .email-body {
                                padding: 30px;
                                text-align: center;
                                font-size: 16px;
                                line-height: 1.6;
                            }
                            .otp-code {
                                font-size: 24px;
                                color: #91ddb7;
                                font-weight: bold;
                                margin: 20px 0;
                            }
                            .email-footer {
                                font-size: 14px;
                                color: #888888;
                                text-align: center;
                                padding: 20px;
                                border-top: 1px solid #dddddd;
                            }
                        </style>
                    </head>
                    <body>
                        <div class="email-container">
                            <div class="email-header">
                                <img src="https://photos.google.com/photo/AF1QipNpHpEM8iINmBK05absygVm_AL-MCo6_uuvG6EL" alt="Logo_LOOKWORK"> <!-- Ganti dengan URL logo perusahaan -->
                                <h2>LOOKWORK</h2>
                            </div>
                            <div class="email-body">
                                <p>Halo,</p>
                                <p>Terima kasih telah menggunakan layanan kami. Untuk melanjutkan proses reset password, silakan masukkan kode OTP berikut:</p>
                                <div class="otp-code">' . $otp . '</div>
                                <p>Harap jangan berikan kode ini kepada siapa pun demi keamanan akun Anda.</p>
                                <p>Jika Anda tidak meminta reset password ini, abaikan email ini.</p>
                                <p>Salam hangat,<br>Tim LOOKWORK</p>
                            </div>
                            <div class="email-footer">
                                <p>© ' . date("Y") . ' LOOKWORK. Semua hak dilindungi undang-undang.</p>
                            </div>
                        </div>
                    </body>
                    </html>
                    ';

                    $mail->AltBody = 'Halo, terima kasih telah menggunakan layanan kami. Kode OTP Anda adalah ' . $otp . '. Harap tidak memberikan kode ini kepada siapa pun demi keamanan akun Anda. Salam, Tim LOOKWORK.';

                    // Send email
                    if ($mail->send()) {
                        echo 'success';
                    } else {
                        echo 'failed to send OTP through mail';
                    }
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
            } else {
                echo "Reset Password Failed"; // Jika tidak ada baris yang terpengaruh
            }
        } else {
            echo "Reset Password Failed"; // Jika query gagal
        }
    } else {
        echo "Database connection failed"; // Jika koneksi database gagal
    }
} else {
    echo "All fields are required"; // Jika email tidak diisi
}
?>
