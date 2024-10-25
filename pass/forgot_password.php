<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $token = bin2hex(random_bytes(16));
            $stmt = $conn->prepare("UPDATE users SET reset_token = ? WHERE email = ?");
            $stmt->bind_param("ss", $token, $email);
            $stmt->execute();

            $resetLink = "reset_password.php?token=$token";
            
            // Send the email
            if (sendEmail($email, $resetLink)) {
                echo "A password reset link has been sent to your email.";
            } else {
                echo "Failed to send the email.";
            }
        } else {
            echo "Email not found.";
        }
    } else {
        echo "Please enter a valid email address.";
    }
}
?>