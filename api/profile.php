<?php
if (!empty($_POST['email']) && !empty($_POST['apikey'])) {
    $email = $_POST['email'];
    $apikey = $_POST['apikey'];
    $result = array();

    // Koneksi ke database
    $con = mysqli_connect("wstif23.myhost.id", "wstifmy1_kelas_int", "@Polije164Int", "wstifmy1_int_team3");
    if ($con) {
        // Menggunakan prepared statement untuk mencegah SQL Injection
        $stmt = mysqli_prepare($con, "SELECT * FROM pengguna WHERE email = ? AND apikey = ?");
        mysqli_stmt_bind_param($stmt, "ss", $email, $apikey);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);

        // Mengecek apakah email dan apikey cocok
        if (mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_assoc($res);
            $result = array(
                "status" => "success", 
                "message" => "Data fetched successfully",
                "nama" => $row['nama'], 
                "email" => $row['email'], 
                "apikey" => $row['apikey']
            );
        } else {
            // Jika tidak ada hasil, kirim pesan Unauthorized access
            $result = array("status" => "failed", "message" => "Unauthorized access: email atau apikey tidak cocok.");
        }

        // Menutup prepared statement
        mysqli_stmt_close($stmt);
    } else {
        // Jika koneksi database gagal
        $result = array("status" => "failed", "message" => "Database connection failed: " . mysqli_connect_error());
    }

    // Menutup koneksi database
    mysqli_close($con);
} else {
    // Jika email atau apikey tidak diisi
    $result = array("status" => "failed", "message" => "All fields are required: email dan apikey harus diisi.");
}

// Output hasil sebagai JSON
echo json_encode($result, JSON_PRETTY_PRINT);
?>
