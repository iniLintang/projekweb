<?php
require('../fpdf/fpdf.php'); 
include('db.php'); 

class PDF extends FPDF
{

    function Header()
    {
        $this->SetFont('Arial', 'B', 14);
        $this->SetTextColor(0, 0, 0); 
        $this->Cell(0, 10, 'Laporan Pekerjaan Per Lokasi Pekerjaan', 0, 1, 'C');
        $this->Ln(5);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->SetTextColor(0, 0, 0); 
        $this->Cell(0, 10, 'Halaman ' . $this->PageNo(), 0, 0, 'C');
    }
}

$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 12);

$tabel_width = 160; 

$page_width = $pdf->GetPageWidth();
$x = ($page_width - $tabel_width) / 2;
$pdf->SetX($x);

$pdf->SetFillColor(200, 200, 200);
$pdf->SetTextColor(0, 0, 0); 

$pdf->Cell(100, 10, 'Lokasi Pekerjaan', 1, 0, 'C', true);
$pdf->Cell(60, 10, 'Total Lowongan', 1, 1, 'C', true); 

$pdf->SetTextColor(0, 0, 0);

$sql = "SELECT 
            pekerjaan.lokasi AS lokasi,
            COUNT(pekerjaan.id_pekerjaan) AS total_lowongan
        FROM pekerjaan
        GROUP BY pekerjaan.lokasi";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $pdf->SetX($x);
        $pdf->Cell(100, 10, htmlspecialchars($row['lokasi']), 1, 0, 'L');
        $pdf->Cell(60, 10, htmlspecialchars($row['total_lowongan']), 1, 1, 'C');
    }
} else {
    $pdf->SetX($x);
    $pdf->Cell(160, 10, 'Tidak ada data ditemukan', 1, 1, 'C');
}

$pdf->Output('D', 'laporan_pekerjaan.pdf'); 
?>
