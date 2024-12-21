<?php
require('../fpdf/fpdf.php'); // Pastikan FPDF sudah diinstal
include('db.php'); // Koneksi ke database

class PDF extends FPDF
{
    // Header untuk laporan
    function Header()
    {
        $this->SetFont('Arial', 'B', 14);
        $this->SetTextColor(0, 0, 0); // Warna teks hitam
        $this->Cell(0, 10, 'Laporan Perusahaan Paling Aktif', 0, 1, 'C'); // Header tanpa background
        $this->Ln(5);
    }

    // Footer untuk laporan
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->SetTextColor(0, 0, 0); // Warna teks hitam
        $this->Cell(0, 10, 'Halaman ' . $this->PageNo(), 0, 0, 'C');
    }
}

// Buat instance FPDF
$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 12);

// Tentukan lebar tabel
$tabel_width = 190; // Total lebar tabel (90 + 50 + 50)

// Hitung posisi X untuk menempatkan tabel di tengah halaman
$page_width = $pdf->GetPageWidth();
$x = ($page_width - $tabel_width) / 2;
$pdf->SetX($x);

// Set warna untuk header tabel
$pdf->SetFillColor(200, 200, 200); // Warna abu-abu muda untuk background header tabel
$pdf->SetTextColor(0, 0, 0); // Teks hitam untuk header tabel

// Tambahkan header tabel dengan background abu-abu, rata tengah
$pdf->Cell(90, 10, 'Nama Perusahaan', 1, 0, 'C', true);
$pdf->Cell(50, 10, 'Jumlah Lowongan', 1, 0, 'C', true);
$pdf->Cell(50, 10, 'Tanggal Terakhir Posting', 1, 1, 'C', true); // Akhiri baris

// Set warna teks normal (hitam) untuk isi tabel
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

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Set posisi X untuk isi tabel di tengah
        $pdf->SetX($x);
        // Tambahkan isi tabel
        $pdf->Cell(90, 10, htmlspecialchars($row['nama_perusahaan']), 1, 0, 'C');
        $pdf->Cell(50, 10, htmlspecialchars($row['job_count']), 1, 0, 'C');
        $pdf->Cell(50, 10, htmlspecialchars($row['last_posted']), 1, 1, 'C');
    }
} else {
    // Set posisi X untuk pesan 'Tidak ada data' di tengah
    $pdf->SetX($x);
    // Jika tidak ada data
    $pdf->Cell(190, 10, 'Tidak ada data ditemukan', 1, 1, 'C');
}

// Output PDF ke browser
$pdf->Output('D', 'laporan_perusahaan.pdf'); // 'D' untuk download langsung
?>
