<?php
// Memeriksa apakah semua field pada form telah diisi
if (!empty($_POST['apikey']) && !empty($_POST['username']) && !empty($_POST['nama']) && !empty($_POST['email']) && !empty($_POST['kata_sandi'])) {
    $apikey = $_POST['apikey'];
    $username = $_POST['username'];
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    
    // Menggunakan password_hash untuk mengenkripsi kata sandi
    $password = password_hash($_POST['kata_sandi'], PASSWORD_BCRYPT);
    $result = array();
    
    // Koneksi ke database
    $con = mysqli_connect("wstif23.myhost.id", "wstifmy1_kelas_int", "@Polije164Int", "wstifmy1_int_team3");
    if ($con) {
        // Memeriksa apakah apikey yang dikirim valid dengan mencocokkan di database
        $sql = "SELECT * FROM pengguna WHERE apikey = '".$apikey."'";
        $res = mysqli_query($con, $sql);
        
        // Jika apikey ditemukan di database
        if (mysqli_num_rows($res) != 0) {
            // Mengupdate informasi pengguna di database
            $sqlUpdate = "UPDATE pengguna SET 
                            username = '".$username."', 
                            nama = '".$nama."', 
                            email = '".$email."', 
                            kata_sandi = '".$password."' 
                          WHERE apikey = '".$apikey."'";
            
            // Mengeksekusi query update dan memeriksa keberhasilan
            if (mysqli_query($con, $sqlUpdate)) {
                // Mengisi hasil dengan status berhasil jika update berhasil
                $result = array(
                    "status" => "success",
                    "message" => "User information updated successfully",
                    "username" => $username,
                    "nama" => $nama,
                    "email" => $email
                );
            } else {
                // Mengisi hasil dengan pesan gagal jika update gagal
                $result = array("status" => "failed", "message" => "Failed to update user information, please try again");
            }
        } else {
            // Mengisi hasil dengan pesan gagal jika apikey tidak valid
            $result = array("status" => "failed", "message" => "Invalid API key");
        }
    } else {
        // Mengisi hasil dengan pesan gagal jika koneksi database gagal
        $result = array("status" => "failed", "message" => "Database connection failed");
    }
} else {
    // Mengisi hasil dengan pesan gagal jika ada field yang kosong
    $result = array("status" => "failed", "message" => "All fields are required");
}

// Mengeluarkan hasil dalam bentuk JSON
echo json_encode($result, JSON_PRETTY_PRINT);
?>
