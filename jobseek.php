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
        </style>

        
        <!-- Custom styles for this template -->
        <link href="carousel.css" rel="stylesheet">
      </head>
      <body>

        
    <header data-bs-theme="dark">
    <nav class="navbar navbar-expand-md fixed-top">
        <div class="container-fluid">
          <a class="navbar-brand" href="#"><B>LookWork</B></a>
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

            </ul>
            <form class="d-flex" role="search">
            <a class="nav-link" href="login.php">Login</a>
            </form>
          </div>
        </div>
      </nav>

    <main>
    <div id="myCarousel" class="carousel slide mb-6" data-bs-ride="carousel">
      <div class="carousel-item active">
      <img src="pic/BANNER1.png" class="d-block w-100" alt="First Slide">
      <div class="container">
        <div class="carousel-caption text-start">
          <h1>Headline 1</h1>
          <p>Deskripsi untuk slide pertama</p>
          <p><a class="btn btn-lg btn-primary" href="#">Sign up today</a></p>
        </div>
      </div>
    </div>
    <div class="carousel-item">
      <img src="pic/LOOKWORK.jpg" class="d-block w-100" alt="Second Slide">
      <div class="container">
        <div class="carousel-caption">
          <h1>Headline 2</h1>
          <p>Deskripsi untuk slide kedua</p>
          <p><a class="btn btn-lg btn-primary" href="#">Learn more</a></p>
        </div>
      </div>
    </div>
    <div class="carousel-item">
      <img src="pic/BANNER3.png" class="d-block w-100" alt="Third Slide">
      <div class="container">
        <div class="carousel-caption">
          <h1>Headline 3</h1>
          <p>Deskripsi untuk slide ketiga</p>
          <p><a class="btn btn-lg btn-primary" href="#">Learn more</a></p>
        </div>
      </div>
    </div>
      </div>
      <!-- Marketing messaging and featurettes
      ================================================== -->
      <!-- Wrap the rest of the page in another container to center all the content. -->

      <hr class="featurette-divider">

      <div class="container marketing">
      <form class="d-flex mb-4" role="search" action="jobseek.php" method="GET">
     <input class="form-control me-2" type="search" name="search" placeholder="Cari pekerjaan atau perusahaan..." aria-label="Search" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
     <button class="btn btn-outline-success" type="submit">Search</button>
     </form>


        <!-- START THE FEATURETTES -->

        <div id="tentang" class="row featurette">

        <section id="services" class="services-section">
            <h2><b>LookWork</b></h2>
            <main class="container mt-5">
        <div class="grid-container">
        <?php
include 'koneksi.php';

// Ambil kata kunci dari parameter GET jika ada
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Modifikasi query untuk pencarian pekerjaan berdasarkan job title atau nama perusahaan
$sql = "SELECT jobs.*, companies.company_name, companies.contact_email 
        FROM jobs 
        LEFT JOIN companies ON jobs.company_id = companies.company_id";

// Tambahkan klausa WHERE jika ada pencarian
if ($search) {
    $sql .= " WHERE jobs.job_title LIKE '%$search%' OR companies.company_name LIKE '%$search%'";
}

$result = $db->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Mengisi variabel dengan validasi jika data ada
        $judul = isset($row['job_title']) ? $row['job_title'] : 'Tidak ada judul';
        $comp = isset($row['company_name']) ? $row['company_name'] : 'Tidak ada perusahaan';  // Nama perusahaan
        $deskripsi = isset($row['job_description']) ? $row['job_description'] : 'Tidak ada deskripsi';
        $lokasi = isset($row['location']) ? $row['location'] : 'Tidak ada lokasi';

        // Hapus simbol non-numerik dari gaji dan ubah format ke Rupiah
        $gaji_raw = isset($row['salary_range']) ? $row['salary_range'] : '0-0';  // Rentang gaji
        $gaji_parts = explode('-', $gaji_raw);  // Pisahkan gaji minimal dan maksimal

        // Memastikan ada minimal dan maksimal gaji
        $gaji_min = isset($gaji_parts[0]) ? floatval(preg_replace("/[^0-9]/", "", $gaji_parts[0])) : 0;
        $gaji_max = isset($gaji_parts[1]) ? floatval(preg_replace("/[^0-9]/", "", $gaji_parts[1])) : 0;

        // Format gaji menjadi Rupiah
        $gaji_min_formatted = "Rp " . number_format($gaji_min, 0, ',', '.');
        $gaji_max_formatted = "Rp " . number_format($gaji_max, 0, ',', '.');

        // Gabungkan gaji minimum dan maksimum dalam satu string
        $gaji = $gaji_min_formatted . ' - ' . $gaji_max_formatted;

        $persyaratan = isset($row['job_type']) ? $row['job_type'] : 'Tidak ada tipe';
        $employer_email = isset($row['contact_email']) ? $row['contact_email'] : 'Tidak ada email';  // Email perusahaan

        // Menampilkan data pekerjaan
        echo "<div class='grid-item'>";
        echo "<h5>" . $judul . "</h5>";  // Judul pekerjaan
        echo "<p><strong>Perusahaan:</strong> " . $comp . "</p>";  // Nama perusahaan
        echo "<p><strong>Lokasi:</strong> " . $lokasi . "</p>";  // Lokasi pekerjaan
        echo "<p><strong>Gaji:</strong> " . $gaji . "</p>";  // Gaji dengan format Rupiah
        echo "<p><strong>Deskripsi:</strong> " . $deskripsi . "</p>";  // Deskripsi pekerjaan
        echo "<p><strong>Persyaratan:</strong> " . $persyaratan . "</p>";  // Persyaratan pekerjaan

        // Membuat mailto link dinamis untuk apply job
        $mailto_link = "mailto:" . $employer_email . "?subject=Job%20Application%20for%20" . urlencode($judul) .
        "&body=Dear%20Employer,%0A%0AI%20am%20interested%20in%20applying%20for%20the%20position%20of%20" .
        urlencode($judul) . "%20located%20in%20" . urlencode($lokasi) . ".%0A%0AThank%20you.";

        // Menampilkan tombol Apply yang membuka mailto
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
