<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LookWork</title>
    <link rel="stylesheet" href="aset/css/index.css">
</head>
<style>
  /* General Styles */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f4;
    color: #333;
}

header {
    background-color: #16423C;
    padding: 20px;
    text-align: center;
    color: #fff;
    font-size: 1.5rem;
}

.container {
    width: 90%;
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
    background-color: #fff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

/* Title and Tables */
h2, h3 {
    color: #16423C;
    border-bottom: 2px solid #6A9C89;
    padding-bottom: 10px;
    margin-bottom: 20px;
    font-size: 1.8rem;
}

.details-table, .jobs-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 30px;
}

.details-table th, .jobs-table th {
    background-color: #6A9C89;
    color: #fff;
    padding: 10px;
    text-align: left;
}

.details-table td, .jobs-table td {
    padding: 10px;
    border: 1px solid #ddd;
}

.details-table tr:nth-child(even), .jobs-table tr:nth-child(even) {
    background-color: #f9f9f9;
}

/* Responsive Design */
@media (max-width: 768px) {
    body {
        font-size: 14px;
    }

    .container {
        width: 100%;
        padding: 10px;
    }

    h2, h3 {
        font-size: 1.5rem;
    }

    th, td {
        padding: 8px;
    }
}

footer {
    background-color: #16423C;
    color: white;
    text-align: center;
    padding: 15px 0;
    position: fixed;
    width: 100%;
    bottom: 0;
    font-size: 0.9rem;
}

</style>
<body>
<header>
    </header>
    <main class="container mt-5">
    <div class="grid-container">
    <?php
include 'koneksi.php';  // Pastikan file koneksi ke database sudah ada

// Ambil ID perusahaan dari URL, misalnya: detail_perusahaan.php?company_id=1
$company_id = isset($_GET['company_id']) ? intval($_GET['company_id']) : 0;

if ($company_id > 0) {
    // Query untuk mengambil detail perusahaan berdasarkan company_id
    $company_sql = "SELECT company_id, company_name, company_description, contact_email 
                    FROM companies 
                    WHERE company_id = $company_id";

    $company_result = $db->query($company_sql);

    if ($company_result->num_rows > 0) {
        $company = $company_result->fetch_assoc();
        
        // Menampilkan informasi perusahaan
        echo "<h2>Detail Perusahaan</h2>";
        echo "<table class='details-table'>";
        echo "<tr><th>Nama Perusahaan</th><td>" . $company['company_name'] . "</td></tr>";
        echo "<tr><th>Deskripsi</th><td>" . $company['company_description'] . "</td></tr>";
        echo "<tr><th>Email Kontak</th><td>" . $company['contact_email'] . "</td></tr>";
        echo "</table>";
        
        // Query untuk mengambil lowongan pekerjaan yang terkait dengan perusahaan ini
        $jobs_sql = "SELECT job_title, job_description, location, salary_range 
                     FROM jobs 
                     WHERE company_id = $company_id";
                     
        $jobs_result = $db->query($jobs_sql);

        if ($jobs_result->num_rows > 0) {
            echo "<h3>Lowongan Kerja di " . $company['company_name'] . "</h3>";
            echo "<table class='jobs-table'>";
            echo "<tr><th>Judul Pekerjaan</th><th>Deskripsi</th><th>Lokasi</th><th>Gaji</th></tr>";

            // Menampilkan setiap lowongan pekerjaan
            while ($job = $jobs_result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $job['job_title'] . "</td>";
                echo "<td>" . $job['job_description'] . "</td>";
                echo "<td>" . $job['location'] . "</td>";

                $gaji_raw = isset($row['salary_range']) ? $row['salary_range'] : '0-0';  // Rentang gaji, misalnya: 8000000-12000000
                $gaji_parts = explode('-', $gaji_raw);  // Pisahkan gaji minimal dan maksimal
        
                // Memastikan ada minimal dan maksimal gaji, jika tidak ada, set default 0
                $gaji_min = isset($gaji_parts[0]) ? floatval(preg_replace("/[^0-9]/", "", $gaji_parts[0])) : 0;
                $gaji_max = isset($gaji_parts[1]) ? floatval(preg_replace("/[^0-9]/", "", $gaji_parts[1])) : 0;
        
                // Format gaji menjadi Rupiah
                $gaji_min_formatted = "Rp " . number_format($gaji_min, 0, ',', '.');
                $gaji_max_formatted = "Rp " . number_format($gaji_max, 0, ',', '.');
        
                // Gabungkan gaji minimum dan maksimum dalam satu string
                $gaji = $gaji_min_formatted . '-' . $gaji_max_formatted;
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>Tidak ada lowongan pekerjaan di perusahaan ini.</p>";
        }
    } else {
        echo "<p>Perusahaan tidak ditemukan.</p>";
    }
} else {
    echo "<p>ID perusahaan tidak valid.</p>";
}

$db->close();
?>


    </div>
    </main>

    <footer>
        <p>&copy; 2024 LookWork. All Rights Reserved.</p>
    </footer>
</body>
</html>