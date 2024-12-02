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
        $this->Cell(0, 10, 'Laporan Pekerjaan Per Perusahaan ', 0, 1, 'C', true); // 'true' untuk mengisi warna latar belakang
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
$pdf->Cell(60, 10, 'Nama Perusahaan', 1, 0, 'C', true);
$pdf->Cell(40, 10, 'Lokasi Perusahaan', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Total Lowongan', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Full-time', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Part-time', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Contract', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Internship', 1, 1, 'C', true);

// Set warna teks normal (hitam)
$pdf->SetTextColor(0, 0, 0);

// Ambil data dari database
$sql = "SELECT 
            perusahaan.nama_perusahaan, 
            perusahaan.lokasi_perusahaan,
            COUNT(pekerjaan.id_pekerjaan) AS total_lowongan,
            SUM(CASE WHEN pekerjaan.jenis_pekerjaan = 'Full-time' THEN 1 ELSE 0 END) AS full_time,
            SUM(CASE WHEN pekerjaan.jenis_pekerjaan = 'Part-time' THEN 1 ELSE 0 END) AS part_time,
            SUM(CASE WHEN pekerjaan.jenis_pekerjaan = 'Contract' THEN 1 ELSE 0 END) AS contract,
            SUM(CASE WHEN pekerjaan.jenis_pekerjaan = 'Internship' THEN 1 ELSE 0 END) AS internship
        FROM perusahaan
        LEFT JOIN pekerjaan ON perusahaan.id_perusahaan = pekerjaan.id_perusahaan
        GROUP BY perusahaan.id_perusahaan";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Set warna latar belakang tabel baris
        $pdf->SetFillColor(144, 238, 144); // Warna hijau muda untuk baris
        $pdf->Cell(60, 10, $row['nama_perusahaan'], 1, 0, 'C', true);
        $pdf->Cell(40, 10, $row['lokasi_perusahaan'], 1, 0, 'C', true);
        $pdf->Cell(30, 10, $row['total_lowongan'], 1, 0, 'C', true);
        $pdf->Cell(30, 10, $row['full_time'], 1, 0, 'C', true);
        $pdf->Cell(30, 10, $row['part_time'], 1, 0, 'C', true);
        $pdf->Cell(30, 10, $row['contract'], 1, 0, 'C', true);
        $pdf->Cell(30, 10, $row['internship'], 1, 1, 'C', true);
    }
} else {
    // Jika tidak ada data
    $pdf->Cell(190, 10, 'Tidak ada data ditemukan', 1, 1, 'C');
}

// Output PDF ke browser
$pdf->Output('D', 'laporan_perusahaan.pdf'); // 'D' untuk download langsung
?>
