<?php
if (!empty($_POST['nama']) && !empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['kata_sandi'])) {
    // Koneksi ke database
    $con = mysqli_connect("wstif23.myhost.id", "wstifmy1_kelas_int", "@Polije164Int", "wstifmy1_int_team3");

    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['kata_sandi'], PASSWORD_DEFAULT);

    if ($con) {
        // Cek apakah email sudah terdaftar
        $sql_check_email = "SELECT * FROM pengguna WHERE email = '$email'";
        $result = mysqli_query($con, $sql_check_email);
        if (mysqli_num_rows($result) > 0) {
            echo "Email is already registered";
        } else {
            // Query untuk menambahkan data user baru
            $sql = "INSERT INTO pengguna (email, username, nama, kata_sandi) VALUES ('$email', '$username', '$nama', '$password')";
            if (mysqli_query($con, $sql)) {
                // Ambil ID dari pengguna yang baru saja ditambahkan
                $user_id = mysqli_insert_id($con);

                // Tambahkan data ke tabel pencari_kerja
                $sql_pencari_kerja = "INSERT INTO pencari_kerja (id_pengguna) VALUES ('$user_id')";
                if (mysqli_query($con, $sql_pencari_kerja)) {
                    echo "success";
                } else {
                    echo "Failed to insert into pencari_kerja";
                }
            } else {
                echo "Registration failed";
            }
        }
    } else {
        echo "Database connection failed";
    }
} else {
    echo "All fields are required";
}
?>
