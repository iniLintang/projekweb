<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    include 'DatabaseConfig.php';
    $conn = mysqli_connect($HostName, $HostUser, $HostPass, $DatabaseName);

    // Ambil nilai email dan password dari request GET
    $email = $_GET['email'];
    $password = $_GET['kata_sandi'];

    // Query untuk mengecek apakah email ada dalam tabel `pengguna`
    $query_check = "SELECT * FROM pengguna WHERE email = '$email'";
    $check = mysqli_fetch_array(mysqli_query($conn, $query_check)); 
    $json_array = array();
    $response = "";
    
    if (isset($check)) {
        // Jika email ditemukan, lanjutkan untuk memeriksa kata sandi
        $query_check_pass = "SELECT * FROM pengguna WHERE email = '$email' AND kata_sandi = '$password'";
        $query_pass_result = mysqli_query($conn, $query_check_pass);
        $check_password = mysqli_fetch_array($query_pass_result);
        
        if (isset($check_password)) {
            // Jika kata sandi benar, kirim data pengguna sebagai respons
            while ($row = mysqli_fetch_assoc($query_pass_result)) {
                $json_array[] = $row;
            }                
            $response = array(
                'code' => 200,
                'status' => 'Sukses',
                'user_list' => $json_array
            );
        } else {
            // Jika kata sandi salah
            $response = array(
                'code' => 401,
                'status' => 'Password salah, periksa kembali!',
                'user_list' => $json_array
            );    
        }
    } else {
        // Jika email tidak ditemukan
        $response = array(
            'code' => 404,
            'status' => 'Data tidak ditemukan, lanjutkan registrasi?',
            'user_list' => $json_array
        );
    }
    // Mengirimkan respons dalam format JSON
    print(json_encode($response));
    mysqli_close($conn);
}
?>
