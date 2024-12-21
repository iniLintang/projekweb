<?php
// Konfigurasi database
$host = "wstif23.myhost.id";
$username = "wstifmy1_kelas_int";
$password = "@Polije164Int";
$dbname = "wstifmy1_int_team3";

// Membuat koneksi ke database
$conn = mysqli_connect($host, $username, $password, $dbname);

// Memeriksa apakah koneksi berhasil
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Mengecek apakah parameter 'id_pencari_kerja' tersedia
if (isset($_GET['id_pencari_kerja'])) {
    $id_pencari_kerja = $_GET['id_pencari_kerja'];
    
    // Query dengan JOIN antara tabel lamaran dan pekerjaan
    $query = "
        SELECT lamaran.status, pekerjaan.judul_pekerjaan, pekerjaan.deskripsi
        FROM lamaran
        JOIN pekerjaan ON lamaran.id_pekerjaan = pekerjaan.id_pekerjaan
        WHERE lamaran.id_pencari_kerja = '$id_pencari_kerja'
    ";
    
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) > 0) {
        $lamaran = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $lamaran[] = $row;
        }
        // Return the result with the 'lamaran' key
        echo json_encode(array('lamaran' => $lamaran));
    } else {
        // Return empty 'lamaran' array if no data found
        echo json_encode(array('lamaran' => []));
    }
} else {
    // Return message if 'id_pencari_kerja' is not provided
    echo json_encode(array('message' => 'ID pencari kerja not provided.'));
}

// Menutup koneksi
mysqli_close($conn);
?>
