<?php
if (!empty($_POST['email'])) {
    $email = $_POST['email'];
    $result = array();

 
    // Koneksi ke database
    $con = mysqli_connect("wstif23.myhost.id", "wstifmy1_kelas_int", "@Polije164Int", "wstifmy1_int_team3");

    if ($con) {
        // Cek apakah email valid
        $sql = "SELECT * FROM pengguna WHERE email = '".$email."'";
        $res = mysqli_query($con, $sql);

        if (mysqli_num_rows($res) != 0) {
            // Mendapatkan data pengguna
            $row = mysqli_fetch_assoc($res);

            // Menghapus foto profil di folder server dan update di database
            $current_image = $row['foto_profil'];
            if ($current_image != "") {
                // Menghapus gambar dari folder uploads
                unlink("uploads/" . $current_image);

                // Update database, set foto_profil menjadi NULL
                $sqlUpdate = "UPDATE pengguna SET foto_profil = NULL WHERE email = '".$email."'";
                if (mysqli_query($con, $sqlUpdate)) {
                    $result = array(
                        "status" => "success", 
                        "message" => "Foto profil berhasil dihapus"
                    );
                } else {
                    $result = array("status" => "failed", "message" => "Gagal menghapus foto profil");
                }
            } else {
                $result = array("status" => "failed", "message" => "Tidak ada foto profil untuk dihapus");
            }
        } else {
            $result = array("status" => "failed", "message" => "API key tidak valid");
        }
    } else {
        $result = array("status" => "failed", "message" => "Koneksi ke database gagal");
    }
} else {
    $result = array("status" => "failed", "message" => "API key diperlukan");
}

// Output hasil sebagai JSON
echo json_encode($result, JSON_PRETTY_PRINT);
?>
