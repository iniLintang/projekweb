<?php
  session_start();
  ?>
      <!doctype html>
      <html lang="en" data-bs-theme="auto">
        <head><script src="../assets/js/color-modes.js"></script>

        <script src="../assets/js/color-modes.js"></script>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="description" content="">
      <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
      <meta name="generator" content="Hugo 0.122.0">
      <title>LookWork.co</title>

      <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/carousel/">
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">
      <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
      <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">
      <link rel="stylesheet" href="../aset/notif.css">
        

          <style>
          /* Global Style */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    display: flex;
}

/* Sidebar Style */
.sidebar {
    width: 270px;
    height: 755px;
    background-color: #F4F7F6;
    opacity: 100%;
    padding: 20px;
    position: fixed;
    top: 0;
    left: 0;
    overflow-y: auto;
}

.sidebar h2 {
    font-size: 24px;
    margin-bottom: 20px;
}

.sidebar ul {
    list-style: none;
    padding: 0;
}

.sidebar ul li {
    text-align: center;
    padding: 15px;
    margin: 10px 0;
    font-size: 18px;
    border-radius: 5px;
    cursor: pointer;
    transition: background 0.3s;
}

.button-group {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-top: 20px;
}

.button-link {
    display: inline-block;
    padding: 10px 20px;
    color: white;
    background-color: #C4DAD2; /* warna tombol Proses */
    border: none;
    border-radius: 5px;
    text-align: center;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s;
    text-decoration: none;
}

/* Hover effect untuk tombol */
.button-link:hover {
    background-color: #E9EFEC;
}

/* Style khusus untuk tiap tombol berdasarkan status */
.button-link.diterima {
    background-color: #6A9C89; /* warna tombol Diterima */
}

.button-link.ditolak {
    background-color: #16423C; /* warna tombol Ditolak */
}

.button-link.diterima:hover {
    background-color: #C4DAD2;
}

.button-link.ditolak:hover {
    background-color:#6A9C89;
}


/* Content Style */
main {
    margin-left: 250px; /* Offset main content to account for sidebar width */
    padding: 20px;
    width: calc(100% - 250px);
    box-sizing: border-box;
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

.featurette-divider {
    margin-top: 20px;
    margin-bottom: 20px;
}

/* Footer Style */
footer {
    margin-top: auto;
    background-color: #f8f9fa;
    text-align: center;
    padding: 10px 0;
    border-top: 1px solid #ddd;
}

footer p {
    margin: 0;
    color: #fff;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .sidebar {
        width: 100%;
        height: auto;
        position: relative;
    }

    main {
        margin-left: 0;
        width: 100%;
    }
}

          
          </style>

          
          <!-- Custom styles for this template -->
          <link href="carousel.css" rel="stylesheet">
          <link href="aset/notif.css" rel="stylesheet">
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
                      <a class="nav-link active" aria-current="page" href="../index.php#">Beranda</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="../index.php#tentang">Tentang</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="../index.php#services">LookWork</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="../index.php#comp">Profile Perusahaan</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="../index.php#komentar">Kata Mereka</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="../index.php#kontak">Kontak</a>
                  </li>
                  <?php
                  if (isset($_SESSION['username'])) {
                      echo ' <a class="nav-link" href="notif.php">Notifikasi</a>';
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

      <main>
  



</ul>

      </div>

          


        <footer >
          
          
        <p>&copy; 2024 LookWork. All Rights Reserved. </p>
        </footer>
      </main>
      <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
      <script>
        AOS.init();
      </script>
      <script src="../projekweb/assets/dist/js/bootstrap.bundle.min.js"></script>

          </body>
      </html>
