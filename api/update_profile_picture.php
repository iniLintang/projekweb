<?php
if (!empty($_POST['email']) && !empty($_POST['image'])) {
    $email = $_POST['email'];
    $image = $_POST['image']; // Gambar dalam format Base64
    $result = array();

    // Koneksi ke database
    $con = mysqli_connect("wstif23.myhost.id", "wstifmy1_kelas_int", "@Polije164Int", "wstifmy1_int_team3");
    if ($con) {
        // Cek apakah email valid
        $sql = "SELECT * FROM pengguna WHERE email = '".$email."'";
        $res = mysqli_query($con, $sql);

        if (mysqli_num_rows($res) != 0) {
            // Mendapatkan informasi pengguna
            $row = mysqli_fetch_assoc($res);
            
            // Simpan gambar ke folder server dan update di database
            $image_data = base64_decode($image);
            $image_name = "profile_" . $row['email'] . ".jpg"; // Nama file berdasarkan email
            file_put_contents("uploads/" . $image_name, $image_data);
            
            // Update foto profil di database
            $sqlUpdate = "UPDATE pengguna SET foto_profil = '".$image_name."' WHERE email = '".$email."'";
            if (mysqli_query($con, $sqlUpdate)) {
                $result = array(
                    "status" => "success", 
                    "message" => "Foto profil berhasil diubah",
                    "image" => $image_name
                );
            } else {
                $result = array("status" => "failed", "message" => "Gagal mengubah foto profil");
            }
        } else {
            $result = array("status" => "failed", "message" => "API key tidak valid");
        }
    } else {
        $result = array("status" => "failed", "message" => "Koneksi ke database gagal");
    }
} else {
    $result = array("status" => "failed", "message" => "API key dan gambar diperlukan");
}

// Output hasil sebagai JSON
echo json_encode($result, JSON_PRETTY_PRINT);
?>
