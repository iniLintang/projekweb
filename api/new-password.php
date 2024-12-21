<?php

require "phpmailer/vendor/autoload.php";

if (!empty($_POST['email']) && !empty($_POST['otp']) && !empty($_POST['new_password'])) {
    $email = $_POST['email'];
    $otp = $_POST['otp'];
    // Change 'new-password' to 'new_password' to be consistent
    $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT); 
    $con = mysqli_connect("wstif23.myhost.id", "wstifmy1_kelas_int", "@Polije164Int", "wstifmy1_int_team3");

    if ($con) {
        // Prepare statement to prevent SQL injection
        $stmt = $con->prepare("UPDATE pengguna SET kata_sandi = ?, reset_password_otp = '', reset_password_created_at = '' WHERE email = ? AND reset_password_otp = ?");
        $stmt->bind_param("sss", $new_password, $email, $otp); // Bind parameters

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                echo "success"; // Corrected spelling
            } else {
                echo "Reset Password Failed: Invalid OTP or email.";
            }
        } else {
            echo "Reset Password Failed: " . $stmt->error; // Show error message if execution fails
        }

        $stmt->close(); // Close the statement
    } else {
        echo "Database connection failed";
    }
} else {
    echo "All fields are required";
}
?>
