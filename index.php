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
                <a class="nav-link active" aria-current="page" href="#">Beranda</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#tentang">Tentang</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#services">LookWork</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#comp">Profile Perusahaan</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#kontak">Kontak</a>
              </li>

            </ul>
            <form class="d-flex" role="search">
            <a class="nav-link" href="login.php">Login</a>
            </form>
          </div>
        </div>
      </nav>
    </header>

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


        <!-- START THE FEATURETTES -->

        <div id="tentang" class="row featurette">
          <div class="col-md-7">
            <h2 class="featurette-heading fw-normal lh-1"><b>Tentang Web</b> </h2>
            <p class="lead">LookWork adalah platform terpercaya yang mempermudah Anda menemukan pekerjaan impian atau 
            membuka peluang karir bagi orang lain. Dengan kemudahan navigasi dan fitur unggulan, 
            LookWork menghubungkan pencari kerja dengan perusahaan yang tepat, memastikan proses rekrutmen yang efisien dan tepat sasaran. 
            Tingkatkan kesempatan Anda untuk sukses dengan LookWork, tempat di mana karir dimulai dan talenta terbaik ditemukan.</p>
          </div>
          <div class="col-md-5">
            <svg class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" width="500" height="500" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 500x500" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="var(--bs-secondary-bg)"/><text x="50%" y="50%" fill="var(--bs-secondary-color)" dy=".3em">500x500</text></svg>
          </div>
        </div>

        <hr class="featurette-divider">

        <section id="services" class="services-section">
            <h2><b>LookWork</b></h2>
            <main class="container mt-5">
        <div class="grid-container">
        <?php
include 'koneksi.php';

// Query dengan LIMIT 3 untuk menampilkan maksimal 3 lowongan saja
$sql = "SELECT jobs.*, companies.company_name FROM jobs 
        LEFT JOIN companies ON jobs.company_id = companies.company_id
        LIMIT 4";  // Batasi hasil yang diambil hanya 3

$result = $db->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Mengisi variabel dengan validasi jika data ada
        $judul = isset($row['job_title']) ? $row['job_title'] : 'Tidak ada judul';
        $comp = isset($row['company_name']) ? $row['company_name'] : 'Tidak ada perusahaan';  // Nama perusahaan
        $deskripsi = isset($row['job_description']) ? $row['job_description'] : 'Tidak ada deskripsi';
        $lokasi = isset($row['location']) ? $row['location'] : 'Tidak ada lokasi';

        // Hapus simbol non-numerik dari gaji dan ubah format ke Rupiah
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

        $persyaratan = isset($row['job_type']) ? $row['job_type'] : 'Tidak ada tipe pekerjaan';

        // Menampilkan data pekerjaan
        echo "<div class='grid-item'>";
        echo "<h5>" . $judul . "</h5>";  // Menampilkan judul pekerjaan
        echo "<p><strong>Perusahaan:</strong> " . $comp . "</p>";  // Menampilkan nama perusahaan
        echo "<p><strong>Lokasi:</strong> " . $lokasi . "</p>";  // Menampilkan lokasi pekerjaan
        echo "<p><strong>Gaji:</strong> " . $gaji . "</p>";  // Menampilkan gaji dengan format Rupiah
        echo "<p><strong>Deskripsi:</strong> " . $deskripsi . "</p>";  // Menampilkan deskripsi pekerjaan
        echo "<p><strong>Persyaratan:</strong> " . $persyaratan . "</p>";  // Menampilkan persyaratan pekerjaan
        echo "</div>";
    }
    echo '<button class="btn btn-lg btn-primary" onclick="window.location.href=\'jobseek.php\'">Cari Pekerjaan</button>';
    // Tombol pencarian kerja
    if (isset($_SESSION['user_id'])) {
        echo '<button class="btn btn-lg btn-primary" onclick="window.location.href=\'jobseek.php\'">Cari Pekerjaan</button>';
    } else {
        echo '<button class="btn btn-lg btn-primary" onclick="window.location.href=\'login.php\'">Login Terlebih Dahulu</button>';
    }
} else {
    echo "<p>No records found</p>";
}

$db->close();
?>

        </div>
        </main> 
        </section>

        <hr id="comp"class="featurette-divider">
    <h2><b>Profile Perusahaan</b></h2>
    <div class="grid-container">
    <?php
include 'koneksi.php';

// Query dengan JOIN ke tabel perusahaan untuk mengambil nama, deskripsi, dan email perusahaan
$sql = "SELECT jobs.*, companies.company_name, companies.company_description, companies.contact_email, companies.company_id 
        FROM jobs 
        LEFT JOIN companies ON jobs.company_id = companies.company_id  LIMIT 4";

$result = $db->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Mengisi variabel dengan validasi jika data ada
        $company_id = isset($row['company_id']) ? $row['company_id'] : 0;
        $comp = isset($row['company_name']) ? $row['company_name'] : 'Tidak ada perusahaan';  // Nama perusahaan
        $comp_desc = isset($row['company_description']) ? $row['company_description'] : 'Tidak ada deskripsi perusahaan';  // Deskripsi perusahaan
        $lokasi = isset($row['location']) ? $row['location'] : 'Tidak ada lokasi';

        // Menampilkan data perusahaan
        echo "<div class='grid-item'>";
        echo "<h5>" . $comp . "</h5>";  // Menampilkan nama perusahaan
        echo "<p><strong>Deskripsi Perusahaan:</strong> " . $comp_desc . "</p>";  // Menampilkan deskripsi perusahaan
        echo "<p><strong>Lokasi:</strong> " . $lokasi . "</p>";  // Menampilkan lokasi perusahaan
        echo "</div>";
    }
    echo "<a href='comp.php' class='btn btn-lg btn-primary'>Profil Perusahaan</a>";
    // Tombol Profil Perusahaan
    if (isset($_SESSION['user_id'])) {
        echo "<a href='comp.php' class='btn btn-lg btn-primary'>Profil Perusahaan</a>";
    } else {
        echo '<button class="btn btn-lg btn-primary" onclick="window.location.href=\'login.php\'">Login Terlebih Dahulu</button>';
    }
} else {
    echo "<p>No records found</p>";
}

$db->close();
?>



    </div>
    <hr id="kontak"class="featurette-divider">

    <h2><b>Komentar mereka :</b></h2>
    <div class="grid-container">
    <?php
    $no_wa = 6282266479716;
    ?>

    <!-- Link WhatsApp dengan gambar ikon -->
    <a href="https://wa.me/<?php echo $no_wa ?>?text=halo saya ingin bertanya" target="_blank">
        <img src="pic/wa.png" alt="WhatsApp" style="width: 50px; height: 50px; vertical-align:middle;"> 
    </a>
    
    <br>
    <?php
    $judul = "Nama Pekerjaan";
    $lokasi = "Jakarta";
    $mailto_link = "mailto:" . "lookwork@lkwrk.co" . "?subject=Job%20Application%20for%20" . urlencode($judul) .
        "&body=Dear%20Employer,%0A%0AI%20am%20interested%20in%20applying%20for%20the%20position%20of%20" .
        urlencode($judul) . "%20located%20in%20" . urlencode($lokasi) . ".%0A%0AThank%20you.";
    ?>

    <!-- Link mailto dengan gambar ikon email -->
    <a href="<?php echo $mailto_link ?>" class="btn-apply">
        <img src="pic/email.jpg" alt="Email" style="width: 50px; height: 50px; vertical-align:middle;">
    </a>

    <br>
    <!-- Link Instagram dengan gambar ikon Instagram -->
    <a href="https://www.instagram.com/lookwork__/" target="_blank">
        <img src="pic/ig.png" alt="Instagram" style="width: 50px; height: 50px; vertical-align:middle;">
    </a>
</div>

    <hr id="kontak"class="featurette-divider">
    <h2><b>Kontak Kami</b></h2>
    <div class="grid-container">
    <?php
    $no_wa = 6282266479716;
    ?>

    <!-- Link WhatsApp dengan gambar ikon -->
    <a href="https://wa.me/<?php echo $no_wa ?>?text=halo saya ingin bertanya" target="_blank">
        <img src="pic/wa.png" alt="WhatsApp" style="width: 50px; height: 50px; vertical-align:middle;"> 
    </a>
    
    <br>
    <?php
    $judul = "Nama Pekerjaan";
    $lokasi = "Jakarta";
    $mailto_link = "mailto:" . "lookwork@lkwrk.co" . "?subject=Job%20Application%20for%20" . urlencode($judul) .
        "&body=Dear%20Employer,%0A%0AI%20am%20interested%20in%20applying%20for%20the%20position%20of%20" .
        urlencode($judul) . "%20located%20in%20" . urlencode($lokasi) . ".%0A%0AThank%20you.";
    ?>

    <!-- Link mailto dengan gambar ikon email -->
    <a href="<?php echo $mailto_link ?>" class="btn-apply">
        <img src="pic/email.jpg" alt="Email" style="width: 50px; height: 50px; vertical-align:middle;">
    </a>

    <br>
    <!-- Link Instagram dengan gambar ikon Instagram -->
    <a href="https://www.instagram.com/lookwork__/" target="_blank">
        <img src="pic/ig.png" alt="Instagram" style="width: 50px; height: 50px; vertical-align:middle;">
    </a>
</div>
  
        </div><!-- /.row -->


        <hr class="featurette-divider">



        <!-- /END THE FEATURETTES -->

      </div><!-- /.container -->


      <!-- FOOTER -->
      <footer >
      <p>&copy; 2024 LookWork. All Rights Reserved.</p>
      </footer>
    </main>
    <script src="../projekweb/assets/dist/js/bootstrap.bundle.min.js"></script>

        </body>
    </html>
