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
        $this->Cell(0, 10, 'Laporan Perusahaan Paling Aktif', 0, 1, 'C', true); // 'true' untuk mengisi warna latar belakang
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
$pdf->Cell(90, 10, 'Nama Perusahaan', 1, 0, 'C', true);
$pdf->Cell(50, 10, 'Jumlah Lowongan', 1, 0, 'C', true);
$pdf->Cell(50, 10, 'Tanggal Terakhir Posting', 1, 1, 'C', true);

// Set warna teks normal (hitam)
$pdf->SetTextColor(0, 0, 0); 

// Ambil data dari database
$sql = "SELECT perusahaan.nama_perusahaan, 
               COUNT(pekerjaan.id_pekerjaan) AS job_count, 
               MAX(pekerjaan.tanggal_posting) AS last_posted
        FROM perusahaan
        LEFT JOIN pekerjaan ON perusahaan.id_perusahaan = pekerjaan.id_perusahaan
        GROUP BY perusahaan.id_perusahaan
        ORDER BY job_count DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Set warna latar belakang tabel baris
        $pdf->SetFillColor(144, 238, 144); // Warna hijau muda untuk baris
        $pdf->Cell(90, 10, $row['nama_perusahaan'], 1, 0, 'C', true);
        $pdf->Cell(50, 10, $row['job_count'], 1, 0, 'C', true);
        $pdf->Cell(50, 10, $row['last_posted'], 1, 1, 'C', true);
    }
} else {
    // Jika tidak ada data
    $pdf->Cell(190, 10, 'Tidak ada data ditemukan', 1, 1, 'C');
}

// Output PDF ke browser
$pdf->Output('D', 'laporan_perusahaan.pdf'); // 'D' untuk download langsung
?>
