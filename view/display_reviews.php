<?php
// Koneksi ke database
$host = "localhost";
$username = "root"; // Sesuaikan dengan konfigurasi database kamu
$password = "";     // Sesuaikan dengan konfigurasi database kamu
$database = "lookwork"; // Nama database kamu

$conn = new mysqli($host, $username, $password, $database);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$sort_order = "DESC";

// Jika ada request filter dari dropdown, set berdasarkan pilihan user
if (isset($_GET['filterRating'])) {
    $sort_order = $_GET['filterRating'] == 'asc' ? 'ASC' : 'DESC';
}

// Query untuk mendapatkan data review dari database dengan urutan yang dipilih
$sql = "SELECT user_id, rating, deskripsi, date FROM review ORDER BY rating $sort_order, date DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output setiap review
    while ($row = $result->fetch_assoc()) {
        // Konversi rating ke simbol bintang
        $stars = str_repeat("★", $row['rating']) . str_repeat("☆", 5 - $row['rating']);
        
        echo "<div class='card mb-3'>";
        echo "<div class='card-body'>";
        echo "<h5 class='card-title'>" . $row['user_id'] . " (Rating: " . $stars . ")</h5>"; // Tampilkan bintang
        echo "<p class='card-text'>" . $row['deskripsi'] . "</p>";
        echo "<p class='card-text'><small class='text-muted'>Dikirim pada: " . $row['date'] . "</small></p>";
        echo "</div>";
        echo "</div>";
    }
} else {
    echo "Belum ada review.";
}

$conn->close();
?>
<style>
    .star-filled {
        color: gold; /* Warna emas untuk bintang penuh */
    }

    .star-empty {
        color: #ccc; /* Warna abu-abu untuk bintang kosong */
    }
</style>