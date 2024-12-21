<?php
if (!empty($_POST['email']) && !empty($_POST['apikey'])) {
    $email = $_POST['email'];
    $apikey = $_POST['apikey'];

    // Koneksi ke database
    $con = mysqli_connect("wstif23.myhost.id", "wstifmy1_kelas_int", "@Polije164Int", "wstifmy1_int_team3");
    if ($con) {
        // Memeriksa apakah email dan apikey cocok
        $sql = "SELECT * FROM pengguna WHERE email = '".$email."' AND apikey = '".$apikey."'";
        $res = mysqli_query($con, $sql);

        if (mysqli_num_rows($res) != 0) {
            // Jika cocok, set apikey menjadi kosong untuk logout
            $sqlUpdate = "UPDATE pengguna SET apikey = '' WHERE email = '".$email."'";
            if (mysqli_query($con, $sqlUpdate)) {
                echo "success";
            } else {
                echo "Logout failed";
            }
        } else {
            echo "Unauthorized to access";
        }
    } else {
        echo "Database connection failed";
    }
} else {
    echo "All fields are required";
}
?>
