<?php
session_start();
include 'koneksi2.php'; // Include your database connection file

// Pastikan pengguna sudah login
if (!isset($_SESSION['pengguna_id'])) {
    header('Location: login.php'); // Redirect jika user belum login
    exit();
}

// Ambil data pengguna berdasarkan pengguna_id dari session
$pengguna_id = $_SESSION['pengguna_id'];
$sql = "SELECT p.*, pj.cv_url, pj.keterampilan 
        FROM pengguna p 
        LEFT JOIN pencari_kerja pj ON p.id_pengguna = pj.id_pengguna 
        WHERE p.id_pengguna = ?";
$stmt = $db->prepare($sql);
$stmt->bind_param('i', $pengguna_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Check if user data was retrieved
if (!$user) {
    echo "User not found!";
    exit();
}
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

    <main>

    <main class="container mt-5">
        <div class="profile-header text-center">
            <img src="<?php echo htmlspecialchars($user['foto_profil'] ?: 'default.jpg'); ?>" alt="Profile Picture" class="rounded-circle" width="150">
            <h2><?php echo htmlspecialchars($user['nama']); ?></h2>
            <p><?php echo htmlspecialchars($user['peran']); ?></p>
            <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
        </div>

        <div class="profile-body mt-4">
            <h3>About Me</h3>
            <p>Hi, I'm <?php echo htmlspecialchars($user['nama']); ?>. I'm currently looking for opportunities in web development.</p>

            <h3>Keterampilan</h3>
            <p><?php echo htmlspecialchars($user['keterampilan'] ?: 'Tidak ada keterampilan yang ditentukan.'); ?></p>

            <h3>CV</h3>
            <?php if ($user['cv_url']): ?>
                <a href="<?php echo htmlspecialchars($user['cv_url']); ?>" target="_blank" class="btn btn-primary">Download CV</a>
            <?php else: ?>
                <p>CV belum diunggah.</p>
            <?php endif; ?>
        </div>
    </main>

 
    <footer >
        <p>&copy; 2024 LookWork.co &middot; <a href="#">Privacy</a> &middot; <a href="#">Terms</a></p>
      </footer>
    <script src="../projekweb/assets/dist/js/bootstrap.bundle.min.js"></script>

        </body>
    </html>
