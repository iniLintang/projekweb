<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LookWork</title>
    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/carousel/">

        

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">

<link href="../projekweb/assets/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
  /* General Styles */

.details-table, .jobs-table {
        width: 100%;
        margin-bottom: 20px;
    }

    .details-table th, .jobs-table th {
        width: 20%;
        background-color: #C4DAD2 ;
    }

    .details-table td, .jobs-table td {
        vertical-align: top;
    }

    h2 {
        margin-bottom: 20px;
    }

    h3 {
        margin-top: 40px;
        margin-bottom: 20px;
    }

    .container {
        max-width: 900px;
        margin: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    th, td {
        padding: 10px;
        text-align: left;
        border: 1px solid #ddd;
    }

</style>
<link href="carousel.css" rel="stylesheet">
<body>
<header data-bs-theme="dark">
          <nav class="navbar navbar-expand-md fixed-top">
            <div class="container-fluid">
              <a class="navbar-brand" href="#">LookWork</a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav me-auto mb-2 mb-md-0">
                  <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="index.php#">Beranda</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="index.php#tentang">Tentang</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="index.php#services">LookWork</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="index.php#comp">Profile Perusahaan</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="index.php#komentar">Kata Mereka</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="index.php#kontak">Kontak</a>
                  </li>
                  <?php
                  if (isset($_SESSION['username'])) {
                      echo ' <a class="nav-link" href="user/notif.php">Notifikasi</a>';
                  } else {
                      echo '<a class="nav-link" href=""></a>';
                  } 
                  ?>
                </ul>

                <form class="d-flex ml-auto" role="search" method="get" action="search.php"> <!-- Specify action and method -->
            <?php if (isset($_SESSION['username'])): ?>
                <!-- Jika user sudah login, tampilkan dropdown -->
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        <?php echo htmlspecialchars($_SESSION['username']); ?> <!-- Menampilkan username -->
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <li><a class="dropdown-item" href="profile.php">Profile</a></li>
                        <li><a class="dropdown-item" href="login/logout.php">Logout</a></li>
                    </ul>
                </div>
            <?php else: ?>
                <!-- Jika user belum login, tampilkan link Login -->
                <a class="nav-link" href="login/login.php">Login</a>
            <?php endif; ?>
        </form>
              </div>
            </div>
          </nav>

        </div>
      </nav>
    </header>
    <main class="container mt-5"> <br><br>
    <?php
    include 'koneksi.php';  // Pastikan file koneksi ke database sudah ada

    // Ambil ID perusahaan dari URL
    $company_id = isset($_GET['company_id']) ? intval($_GET['company_id']) : 0;

    if ($company_id > 0) {
        // Query untuk mengambil detail perusahaan
        $company_sql = "SELECT company_id, company_name, company_description, contact_email 
                        FROM companies 
                        WHERE company_id = $company_id";
        $company_result = $db->query($company_sql);

        if ($company_result->num_rows > 0) {
            $company = $company_result->fetch_assoc();
            
            // Menampilkan informasi perusahaan
            echo "<h2>Detail Perusahaan</h2>";
            echo "<table class='table table-striped table-bordered details-table'>";
            echo "<tr><th>Nama Perusahaan</th><td>" . $company['company_name'] . "</td></tr>";
            echo "<tr><th>Deskripsi</th><td>" . nl2br($company['company_description']) . "</td></tr>";
            echo "<tr><th>Email Kontak</th><td>" . $company['contact_email'] . "</td></tr>";
            echo "</table>";
            
            // Query untuk mengambil lowongan pekerjaan terkait
            $jobs_sql = "SELECT job_title, job_description, location, salary_range 
                        FROM jobs 
                        WHERE company_id = $company_id";
            $jobs_result = $db->query($jobs_sql);

            if ($jobs_result->num_rows > 0) {
                echo "<h3>Lowongan Kerja di " . $company['company_name'] . "</h3>";
                echo "<table class='table table-striped table-bordered jobs-table'>";
                echo "<tr><th>Judul Pekerjaan</th><th>Deskripsi</th><th>Lokasi</th><th>Gaji</th><th>Lamar</th></tr>";

                // Menampilkan setiap lowongan pekerjaan
                while ($job = $jobs_result->fetch_assoc()) {
                    $gaji_raw = isset($job['salary_range']) ? $job['salary_range'] : '0-0';  // Rentang gaji
                    $gaji_parts = explode('-', $gaji_raw);  // Pisahkan gaji minimal dan maksimal
                    $gaji_min = isset($gaji_parts[0]) ? floatval(preg_replace("/[^0-9]/", "", $gaji_parts[0])) : 0;
                    $gaji_max = isset($gaji_parts[1]) ? floatval(preg_replace("/[^0-9]/", "", $gaji_parts[1])) : 0;
                    $gaji_min_formatted = "Rp " . number_format($gaji_min, 0, ',', '.');
                    $gaji_max_formatted = "Rp " . number_format($gaji_max, 0, ',', '.');
                    $gaji = $gaji_min_formatted . ' - ' . $gaji_max_formatted;

                    // Variabel untuk email dan judul pekerjaan
                    $employer_email = $company['contact_email'];
                    $judul = $job['job_title'];
                    $lokasi = $job['location'];

                    $mailto_link = "mailto:" . $employer_email . "?subject=Job%20Application%20for%20" . urlencode($judul) .
                    "&body=Dear%20Employer,%0A%0AI%20am%20interested%20in%20applying%20for%20the%20position%20of%20" .
                    urlencode($judul) . "%20located%20in%20" . urlencode($lokasi) . ".%0A%0AThank%20you.";

                    echo "<tr>";
                    echo "<td>" . $job['job_title'] . "</td>";
                    echo "<td>" . nl2br($job['job_description']) . "</td>";
                    echo "<td>" . $job['location'] . "</td>";
                    echo "<td>" . $gaji . "</td>";
                    echo "<td><a href='" . $mailto_link . "' class='btn-apply'>Apply for Job</a></td>";
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
</main>


    <footer>
        <p>&copy; 2024 LookWork. All Rights Reserved.</p>
    </footer>
</body>
</html>