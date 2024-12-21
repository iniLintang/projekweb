<?php
// Konfigurasi koneksi database
$host = "wstif23.myhost.id";
$user = "wstifmy1_kelas_int";
$password = "@Polije164Int";
$database = "wstifmy1_int_team3";

$response = array();

// Ambil parameter nama perusahaan jika ada
$nama_perusahaan = isset($_GET['nama_perusahaan']) ? $_GET['nama_perusahaan'] : '';

// Koneksi ke database
$conn = new mysqli($host, $user, $password, $database);

// Mengecek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query untuk mengambil data perusahaan berdasarkan nama perusahaan
$sql = "
    SELECT 
        nama_perusahaan, 
        lokasi_perusahaan, 
        industri, 
        deskripsi_perusahaan
    FROM perusahaan
";
if (!empty($nama_perusahaan)) {
    $sql .= " WHERE nama_perusahaan LIKE '%" . $conn->real_escape_string($nama_perusahaan) . "%'";
}

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Mengambil data dari database
    while ($row = $result->fetch_assoc()) {
        $response[] = array(
            "nama_perusahaan" => $row['nama_perusahaan'],
            "lokasi_perusahaan" => $row['lokasi_perusahaan'],
            "industri" => $row['industri'],
            "deskripsi_perusahaan" => $row['deskripsi_perusahaan']
        );
    }

    // Response berhasil
    $output = array(
        "status" => "success",
        "message" => "Data fetched successfully",
        "data" => $response
    );
} else {
    // Response jika data tidak ditemukan
    $output = array(
        "status" => "failed",
        "message" => "No data found"
    );
}

$conn->close(); // Tutup koneksi

// Mengirimkan response dalam format JSON
header('Content-Type: application/json');
echo json_encode($output, JSON_PRETTY_PRINT);
?>
