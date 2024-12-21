<?php
// Konfigurasi koneksi database
$host = "wstif23.myhost.id";
$user = "wstifmy1_kelas_int";
$password = "@Polije164Int";
$database = "wstifmy1_int_team3";

$response = array();

try {
    // Koneksi ke database
    $conn = new mysqli($host, $user, $password, $database);

    // Mengecek koneksi
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // Query untuk mengambil data pekerjaan dan industri perusahaan
    $sql = "
        SELECT 
            p.judul_pekerjaan, 
            p.deskripsi, 
            p.lokasi, 
            p.jenis_pekerjaan, 
            p.gaji_dari, 
            p.gaji_hingga, 
            DATE(p.tanggal_posting) AS tanggal_posting, 
            pr.industri 
        FROM pekerjaan p
        LEFT JOIN perusahaan pr ON p.id_perusahaan = pr.id_perusahaan
    ";
    $stmt = $conn->prepare($sql); // Gunakan prepared statements
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Mengambil data dari database
        while ($row = $result->fetch_assoc()) {
            // Memformat gaji dari dan gaji hingga
            $gajiDari = number_format($row['gaji_dari'], 0, ',', '.');
            $gajiHingga = number_format($row['gaji_hingga'], 0, ',', '.');

            $response[] = array(
                "judul_pekerjaan" => $row['judul_pekerjaan'],
                "deskripsi" => $row['deskripsi'],
                "lokasi" => $row['lokasi'],
                "jenis pekerjaan" => $row['jenis_pekerjaan'],
                "gaji dari" => "Rp " . $gajiDari, // Menambahkan format IDR
                "gaji hingga" => "Rp " . $gajiHingga, // Menambahkan format IDR
                "tanggal posting" => $row['tanggal_posting'],
                "industri" => $row['industri'] // Menambahkan kolom industri
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

    $stmt->close(); // Tutup statement
    $conn->close(); // Tutup koneksi
} catch (Exception $e) {
    // Menangani error
    $output = array(
        "status" => "error",
        "message" => $e->getMessage()
    );
}

// Mengirimkan response dalam format JSON
header('Content-Type: application/json');
echo json_encode($output, JSON_PRETTY_PRINT);
?>
