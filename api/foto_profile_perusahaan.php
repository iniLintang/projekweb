<?php
// Menambahkan header untuk CORS dan JSON
header('Access-Control-Allow-Origin: *'); // Mengizinkan akses dari semua origin
header('Content-Type: application/json');


// Membuat koneksi
$con = mysqli_connect("wstif23.myhost.id", "wstifmy1_kelas_int", "@Polije164Int", "wstifmy1_int_team3");

// Cek koneksi
if ($conn->connect_error) {
    http_response_code(500); // Internal Server Error
    echo json_encode([
        "status" => "error",
        "message" => "Connection failed: " . $conn->connect_error
    ]);
    exit();
}

// Validasi metode HTTP
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Ambil parameter nama_perusahaan
    if (isset($_GET['nama_perusahaan'])) {
        $nama_perusahaan = $_GET['nama_perusahaan'];

        // Query menggunakan prepared statement untuk menghindari SQL Injection
        $sql = "SELECT p.foto_profil 
                FROM pengguna p
                INNER JOIN perusahaan c ON p.id_pengguna = c.id_pengguna
                WHERE c.nama_perusahaan = ?
                LIMIT 1";
        
        // Persiapkan statement
        if ($stmt = $conn->prepare($sql)) {
            // Bind parameter
            $stmt->bind_param("s", $nama_perusahaan);

            // Eksekusi query
            $stmt->execute();
            $result = $stmt->get_result();

            // Jika data ditemukan
            if ($result->num_rows > 0) {
                $data = $result->fetch_assoc();
                http_response_code(200); // OK
                echo json_encode([
                    "status" => "success",
                    "foto_profil" => $data['foto_profil']
                ]);
            } else {
                // Jika data tidak ditemukan
                http_response_code(404); // Not Found
                echo json_encode([
                    "status" => "error",
                    "message" => "Foto profil tidak ditemukan untuk nama perusahaan: $nama_perusahaan"
                ]);
            }

            // Menutup statement
            $stmt->close();
        } else {
            // Jika query gagal disiapkan
            http_response_code(500); // Internal Server Error
            echo json_encode([
                "status" => "error",
                "message" => "Query gagal disiapkan"
            ]);
        }
    } else {
        // Jika parameter 'nama_perusahaan' tidak ada
        http_response_code(400); // Bad Request
        echo json_encode([
            "status" => "error",
            "message" => "Parameter 'nama_perusahaan' diperlukan"
        ]);
    }
} else {
    // Jika metode HTTP tidak valid
    http_response_code(405); // Method Not Allowed
    echo json_encode([
        "status" => "error",
        "message" => "Metode HTTP tidak valid. Gunakan GET."
    ]);
}

// Tutup koneksi
$conn->close();
?>
