<?php
require('../fpdf/fpdf.php'); // Pastikan FPDF sudah diinstal
include('db.php'); // Koneksi ke database

class PDF extends FPDF
{
    // Header untuk laporan
    function Header()
    {
        // Set background color hijau muda untuk header
        $this->SetFillColor(70, 130, 70); // Warna hijau
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 10, 'Laporan Pengguna Berdasarkan Peran', 0, 1, 'C', true); // Mengubah judul sesuai dengan data yang ditampilkan
        $this->Ln(5);
    }

    // Footer untuk laporan
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->SetTextColor(0, 128, 0); // Warna teks hijau
        $this->Cell(0, 10, 'Halaman ' . $this->PageNo(), 0, 0, 'C');
    }
}

// Buat instance FPDF
$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 12);

// Set warna untuk tabel header (Hijau Tua)
$pdf->SetFillColor(34, 139, 34); // Warna hijau tua
$pdf->SetTextColor(255, 255, 255); // Teks putih untuk header tabel

// Tambahkan header tabel dengan warna hijau
$pdf->Cell(90, 10, 'Peran Pengguna', 1, 0, 'C', true); // Menyesuaikan dengan peran pengguna
$pdf->Cell(50, 10, 'Jumlah Pengguna', 1, 1, 'C', true); // Menyesuaikan dengan jumlah pengguna

// Set warna teks normal (hitam)
$pdf->SetTextColor(0, 0, 0); 

// Ambil data dari database
$sql = "SELECT peran, COUNT(id_pengguna) AS jumlah_pengguna 
        FROM pengguna 
        GROUP BY peran";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Set warna latar belakang tabel baris
        $pdf->SetFillColor(144, 238, 144); // Warna hijau muda untuk baris
        $pdf->Cell(90, 10, $row['peran'], 1, 0, 'C', true); // Menampilkan peran pengguna
        $pdf->Cell(50, 10, $row['jumlah_pengguna'], 1, 1, 'C', true); // Menampilkan jumlah pengguna
    }
} else {
    // Jika tidak ada data
    $pdf->Cell(190, 10, 'Tidak ada data ditemukan', 1, 1, 'C');
}

// Output PDF ke browser
$pdf->Output('D', 'laporan_pengguna_peran.pdf'); // 'D' untuk download langsung
?>
