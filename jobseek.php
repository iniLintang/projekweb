<?php
session_start();
?>
<!doctype html>
    <html lang="en" data-bs-theme="auto">
      <head><script src="../assets/js/color-modes.js"></script>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
        <meta name="generator" content="Hugo 0.122.0">
        <title>LookWork.co</title>

        <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/carousel/">

        

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">

    <link href="../projekweb/assets/dist/css/bootstrap.min.css" rel="stylesheet">


        <style>

          .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
          }

          @media (min-width: 768px) {
            .bd-placeholder-img-lg {
              font-size: 3.5rem;
            }
          }

          .b-example-divider {
            width: 100%;
            height: 3rem;
            background-color: rgba(0, 0, 0, .1);
            border: solid rgba(0, 0, 0, .15);
            border-width: 1px 0;
            box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
          }

          .b-example-vr {
            flex-shrink: 0;
            width: 1.5rem;
            height: 100vh;
          }

          .bi {
            vertical-align: -.125em;
            fill: currentColor;
          }

          .nav-scroller {
            position: relative;
            z-index: 2;
            height: 2.75rem;
            overflow-y: hidden;
          }

          .nav-scroller .nav {
            display: flex;
            flex-wrap: nowrap;
            padding-bottom: 1rem;
            margin-top: -1px;
            overflow-x: auto;
            text-align: center;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
          }

          .btn-bd-primary {
            --bd-violet-bg: #712cf9;
            --bd-violet-rgb: 112.520718, 44.062154, 249.437846;

            --bs-btn-font-weight: 600;
            --bs-btn-color: var(--bs-white);
            --bs-btn-bg: var(--bd-violet-bg);
            --bs-btn-border-color: var(--bd-violet-bg);
            --bs-btn-hover-color: var(--bs-white);
            --bs-btn-hover-bg: #6528e0;
            --bs-btn-hover-border-color: #6528e0;
            --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
            --bs-btn-active-color: var(--bs-btn-hover-color);
            --bs-btn-active-bg: #5a23c8;
            --bs-btn-active-border-color: #5a23c8;
          }

          .bd-mode-toggle {
            z-index: 1500;
          }

          .bd-mode-toggle .dropdown-menu .active .bi {
            display: block !important;
          }

          form {
    display: flex;
    flex-wrap: wrap; /* Agar elemen otomatis turun ke baris baru jika ruang tidak cukup */
    gap: 10px;
    max-width: 800px; /* Lebar maksimum form */
    margin: auto;
    justify-content: space-between; /* Mengatur jarak antar elemen */
    align-items: center; /* Menjaga elemen agar sejajar secara vertikal */
}

input[type="text"],
select {
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 4px;
    flex: 1; /* Membuat input dan select menyesuaikan lebar */
    min-width: 200px; /* Lebar minimum agar tidak terlalu kecil */
}


button[type="submit"]:hover {
    background-color: #45a049;
}

select, input[type="text"] {
    background-color: #fff;
}

        </style>

        
        <!-- Custom styles for this template -->
        <link href="carousel.css" rel="stylesheet">
      </head>
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
                    <a class="nav-link" href="index.php#kontak">Kontak</a>
                  </li>
                  <?php
                  if (isset($_SESSION['username'])) {
                      echo ' <a class="nav-link" href="index.php#kontak">Notifikasi</a>';
                  } else {
                      echo '<a class="nav-link" href="index.php#kontak"></a>';
                  } 
                  ?>
                </ul>

                <form class="d-flex" role="search">
                  <?php if (isset($_SESSION['username'])): ?>
                    <!-- Jika user sudah login, tampilkan dropdown -->
                    <div class="dropdown">
                      <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        <?php echo $_SESSION['username']; ?> <!-- Menampilkan username -->
                      </button>
                      <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <li><a class="dropdown-item" href="profile.php">Profile</a></li>
                        <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                      </ul>
                    </div>
                  <?php else: ?>
                    <!-- Jika user belum login, tampilkan link Login -->
                    <a class="nav-link" href="login.php">Login</a>
                  <?php endif; ?>
                </form>
              </div>
            </div>
          </nav>

        </div>
      </nav>
    </header>

   
      <!-- Marketing messaging and featurettes
      ================================================== -->
      <!-- Wrap the rest of the page in another container to center all the content. -->

      <hr class="featurette-divider">

      <div class="container fluid">


        <!-- START THE FEATURETTES -->

        <div id="tentang" class="row featurette">

        <section id="services" class="services-section">
    <h2><b>LookWork</b></h2>
    <main class="container mt-5">
        <form method="GET" action="">
            <!-- Input Pencarian -->
            <input type="text" name="search" placeholder="Cari pekerjaan atau perusahaan" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">

            <!-- Combo Box untuk Rentang Gaji -->
            <select name="salary_range">
                <option value="">Pilih Rentang Gaji</option>
                <?php
                include 'koneksi.php';

                // Query untuk mengambil rentang gaji unik dari tabel pekerjaan
                $sql_salary = "SELECT DISTINCT salary_range FROM jobs";
                $result_salary = $db->query($sql_salary);

                if ($result_salary->num_rows > 0) {
                    while ($row_salary = $result_salary->fetch_assoc()) {
                        $salary_range = $row_salary['salary_range'];
                        echo "<option value='$salary_range'>" . format_salary_range($salary_range) . "</option>";
                    }
                }

                function format_salary_range($salary_range) {
                    // Fungsi untuk memformat rentang gaji dari database ke dalam format Rupiah
                    $gaji_parts = explode('-', $salary_range);
                    $gaji_min = isset($gaji_parts[0]) ? floatval(preg_replace("/[^0-9]/", "", $gaji_parts[0])) : 0;
                    $gaji_max = isset($gaji_parts[1]) ? floatval(preg_replace("/[^0-9]/", "", $gaji_parts[1])) : 0;
                    $gaji_min_formatted = "Rp " . number_format($gaji_min, 0, ',', '.');
                    $gaji_max_formatted = "Rp " . number_format($gaji_max, 0, ',', '.');
                    return $gaji_min_formatted . ' - ' . $gaji_max_formatted;
                }
                ?>
            </select>

            <!-- Combo Box untuk Kota -->
            <select name="location">
                <option value="">Pilih Kota</option>
                <?php
                // Query untuk mengambil daftar kota unik dari tabel pekerjaan
                $sql_location = "SELECT DISTINCT location FROM jobs";
                $result_location = $db->query($sql_location);

                if ($result_location->num_rows > 0) {
                    while ($row_location = $result_location->fetch_assoc()) {
                        $location = $row_location['location'];
                        echo "<option value='$location'>$location</option>";
                    }
                }
                ?>
            </select>

            <button type="submit"   class='btn btn-apply' >Cari</button>
        </form>

        <div class="grid-container">
        <?php
// Ambil parameter pencarian
$search = isset($_GET['search']) ? $_GET['search'] : '';
$salary_range = isset($_GET['salary_range']) ? $_GET['salary_range'] : '';
$location = isset($_GET['location']) ? $_GET['location'] : '';

// Query dasar untuk mengambil data pekerjaan
$sql = "SELECT jobs.*, companies.company_name, companies.contact_email 
        FROM jobs 
        LEFT JOIN companies ON jobs.company_id = companies.company_id WHERE 1=1";

// Tambahkan klausa WHERE untuk pencarian kata kunci
if ($search) {
    $sql .= " AND (jobs.job_title LIKE '%$search%' OR companies.company_name LIKE '%$search%')";
}

// Tambahkan filter berdasarkan rentang gaji
if ($salary_range) {
    $gaji_parts = explode('-', $salary_range);
    $gaji_min = floatval($gaji_parts[0]);
    $gaji_max = floatval($gaji_parts[1]);
    
    // Ubah rentang gaji dari database ke angka tanpa simbol dan tambahkan ke query
    $sql .= " AND (
        CAST(REPLACE(SUBSTRING_INDEX(jobs.salary_range, '-', 1), '.', '') AS UNSIGNED) >= $gaji_min
        AND CAST(REPLACE(SUBSTRING_INDEX(jobs.salary_range, '-', -1), '.', '') AS UNSIGNED) <= $gaji_max
    )";
}

// Tambahkan filter berdasarkan kota
if ($location) {
    $sql .= " AND jobs.location = '$location'";
}

$result = $db->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $judul = isset($row['job_title']) ? $row['job_title'] : 'Tidak ada judul';
        $comp = isset($row['company_name']) ? $row['company_name'] : 'Tidak ada perusahaan';
        $deskripsi = isset($row['job_description']) ? $row['job_description'] : 'Tidak ada deskripsi';
        $lokasi = isset($row['location']) ? $row['location'] : 'Tidak ada lokasi';

        // Proses gaji
        $gaji_raw = isset($row['salary_range']) ? $row['salary_range'] : '0-0';
        $gaji_parts = explode('-', $gaji_raw);
        $gaji_min = isset($gaji_parts[0]) ? floatval(preg_replace("/[^0-9]/", "", $gaji_parts[0])) : 0;
        $gaji_max = isset($gaji_parts[1]) ? floatval(preg_replace("/[^0-9]/", "", $gaji_parts[1])) : 0;
        $gaji_min_formatted = "Rp " . number_format($gaji_min, 0, ',', '.');
        $gaji_max_formatted = "Rp " . number_format($gaji_max, 0, ',', '.');
        $gaji = $gaji_min_formatted . ' - ' . $gaji_max_formatted;

        $persyaratan = isset($row['job_type']) ? $row['job_type'] : 'Tidak ada tipe';
        $employer_email = isset($row['contact_email']) ? $row['contact_email'] : 'Tidak ada email';

        // Tampilkan data pekerjaan
        echo "<div class='grid-item'>";
        echo "<h5>" . $judul . "</h5>";
        echo "<p><strong>Perusahaan:</strong> " . $comp . "</p>";
        echo "<p><strong>Lokasi:</strong> " . $lokasi . "</p>";
        echo "<p><strong>Gaji:</strong> " . $gaji . "</p>";
        echo "<p><strong>Deskripsi:</strong> " . $deskripsi . "</p>";
        echo "<p><strong>Persyaratan:</strong> " . $persyaratan . "</p>";

        $mailto_link = "mailto:" . $employer_email . "?subject=Job%20Application%20for%20" . urlencode($judul) .
        "&body=Dear%20Employer,%0A%0AI%20am%20interested%20in%20applying%20for%20the%20position%20of%20" .
        urlencode($judul) . "%20located%20in%20" . urlencode($lokasi) . ".%0A%0AThank%20you.";
        echo "<a href='" . $mailto_link . "' class='btn-apply'>Apply for Job</a>";
        echo "</div>";
    }
} else {
    echo "<p>Tidak ada data yang ditemukan</p>";
}

$db->close();
?>

        </div>
    </main>
</section>
        <!-- /END THE FEATURETTES -->

      </div><!-- /.container -->


      <!-- FOOTER -->
      <footer >
        <p>&copy; 2024 LookWork.co &middot; <a href="#">Privacy</a> &middot; <a href="#">Terms</a></p>
      </footer>
    </main>
    <script src="../projekweb/assets/dist/js/bootstrap.bundle.min.js"></script>

        </body>
    </html>
