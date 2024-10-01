
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
        <!-- START THE FEATURETTES -->
        <section id="services" class="services-section">
            <main class="container mt-5">
            <div class="container marketing">
            <h2><b>Profile Perusahaan</b></h2>
    <form class="d-flex mb-4" role="search" action="comp.php" method="GET">
        <!-- Input kata kunci pencarian -->
        <input class="form-control me-2" type="search" name="search" placeholder="Cari perusahaan..." aria-label="Search" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">

        <!-- Combo box untuk lokasi -->
        <select class="form-select me-2" name="location">
            <option value="">Pilih Lokasi</option>
            <?php
            include 'koneksi.php';
            // Query untuk mengambil daftar lokasi yang tersedia
            $sql_location = "SELECT DISTINCT location FROM jobs";
            $result_location = $db->query($sql_location);

            if ($result_location->num_rows > 0) {
                while ($row = $result_location->fetch_assoc()) {
                    $selected = (isset($_GET['location']) && $_GET['location'] == $row['location']) ? 'selected' : '';
                    echo "<option value='" . htmlspecialchars($row['location']) . "' $selected>" . htmlspecialchars($row['location']) . "</option>";
                }
            }
            ?>
        </select>

        <!-- Tombol submit -->
        <button class="btn btn-outline-success" type="submit">Search</button>
    </form>

    <div class="grid-container">
        <?php
        include 'koneksi.php';

        // Ambil nilai dari GET jika ada (untuk pencarian dan filter lokasi)
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        $location_filter = isset($_GET['location']) ? trim($_GET['location']) : '';

        // Query dengan JOIN ke tabel perusahaan dan filter pencarian
        $sql = "SELECT jobs.*, companies.company_name, companies.company_description, companies.contact_email, companies.company_id 
                FROM jobs 
                LEFT JOIN companies ON jobs.company_id = companies.company_id
                WHERE 1=1"; // 1=1 untuk menambahkan kondisi WHERE dinamis

        // Filter berdasarkan kata kunci pencarian
        if ($search) {
            $sql .= " AND companies.company_name LIKE ? OR companies.company_description LIKE ?";
        }

        // Filter berdasarkan lokasi
        if ($location_filter) {
            $sql .= " AND jobs.location = ?";
        }

        // Siapkan statement dan bind parameters
        if ($stmt = $db->prepare($sql)) {
            if ($search && $location_filter) {
                $param_search = "%" . $search . "%";
                $stmt->bind_param('sss', $param_search, $param_search, $location_filter);
            } elseif ($search) {
                $param_search = "%" . $search . "%";
                $stmt->bind_param('ss', $param_search, $param_search);
            } elseif ($location_filter) {
                $stmt->bind_param('s', $location_filter);
            }

            // Eksekusi query
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $company_id = isset($row['company_id']) ? $row['company_id'] : 0;
                    $comp = isset($row['company_name']) ? $row['company_name'] : 'Tidak ada perusahaan';
                    $comp_desc = isset($row['company_description']) ? $row['company_description'] : 'Tidak ada deskripsi perusahaan';
                    $lokasi = isset($row['location']) ? $row['location'] : 'Tidak ada lokasi';

                    // Menampilkan data perusahaan
                    echo "<div class='grid-item'>";
                    echo "<h5>" . htmlspecialchars($comp) . "</h5>";
                    echo "<p><strong>Deskripsi Perusahaan:</strong> " . htmlspecialchars($comp_desc) . "</p>";
                    echo "<p><strong>Lokasi:</strong> " . htmlspecialchars($lokasi) . "</p>";
                    echo "<a href='compdetail.php?company_id=" . $company_id . "' class='btn-apply'>Profil Perusahaan</a>";
                    echo "</div>";
                }
            } else {
                echo "<p>No records found</p>";
            }

            $stmt->close();
        } else {
            echo "<p>Query gagal dijalankan.</p>";
        }

        $db->close();
        ?>
    </div>
</div>

        </div><!-- /.row -->

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
