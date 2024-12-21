<?php
if (!empty($_POST['email']) && !empty($_POST['kata_sandi'])) {
    $email = $_POST['email'];
    $password = $_POST['kata_sandi'];
    $result = array();
    
    // Koneksi ke database
    $con = mysqli_connect("wstif23.myhost.id", "wstifmy1_kelas_int", "@Polije164Int", "wstifmy1_int_team3");
    if ($con) {
        // Modifikasi query untuk mendapatkan id_pencari_kerja
        $sql = "SELECT p.*, pk.id_pencari_kerja 
                FROM pengguna p 
                LEFT JOIN pencari_kerja pk ON p.id_pengguna = pk.id_pengguna 
                WHERE p.email = '".$email."'";
        $res = mysqli_query($con, $sql);
        
        if (mysqli_num_rows($res) != 0) {
            $row = mysqli_fetch_assoc($res);
            
            // Verifikasi email dan password
            if ($email == $row['email'] && password_verify($password, $row['kata_sandi'])) {
                try {
                    $apikey = bin2hex(random_bytes(23));
                } catch (Exception $e) {
                    $apikey = bin2hex(uniqid($email, true));
                }
                
                // Update API key di database
                $sqlUpdate = "UPDATE pengguna SET apikey = '".$apikey."' WHERE email = '".$email."'";
                if (mysqli_query($con, $sqlUpdate)) {
                    $result = array(
                        "status" => "success", 
                        "message" => "Login successful",
                        "nama" => $row['nama'], 
                        "email" => $row['email'], 
                        "username" => $row['username'],
                        "id_pengguna" => $row['id_pengguna'],
                        "id_pencari_kerja" => $row['id_pencari_kerja'], // Tambahkan id_pencari_kerja
                        "apikey" => $apikey
                    );
                } else {
                    $result = array("status" => "failed", "message" => "Login failed, please try again");
                }
            } else {
                $result = array("status" => "failed", "message" => "Incorrect email or password");
            }
        } else {
            $result = array("status" => "failed", "message" => "Incorrect email or password");
        }
    } else {
        $result = array("status" => "failed", "message" => "Database connection failed");
    }
} else {
    $result = array("status" => "failed", "message" => "All fields are required");
}

// Output hasil sebagai JSON
echo json_encode($result, JSON_PRETTY_PRINT);
?>
