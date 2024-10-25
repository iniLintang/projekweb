<?php
session_start();

// Koneksi ke database
$host = "localhost";
$username = "root"; // Sesuaikan dengan konfigurasi database kamu
$password = "";     // Sesuaikan dengan konfigurasi database kamu
$database = "lookwork"; // Nama database kamu

$conn = new mysqli($host, $username, $password, $database);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$avg_sql = "SELECT AVG(rating) AS avg_rating FROM review";
$avg_result = $conn->query($avg_sql);

if ($avg_result->num_rows > 0) {
    $row = $avg_result->fetch_assoc();
    $avg_rating = round($row['avg_rating'], 1); // Membulatkan hasil ke 1 angka desimal
} else {
    $avg_rating = 0; // Jika tidak ada review
}

// Query untuk mendapatkan data review dari database
$sql = "SELECT user_id, rating, deskripsi, date FROM review ORDER BY date DESC";
$result = $conn->query($sql);


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $user_id = mysqli_real_escape_string($conn, $_POST['userName']);
    $rating = mysqli_real_escape_string($conn, $_POST['userRating']);
    $title = "User Review"; // Judul bisa disesuaikan jika perlu
    $deskripsi = mysqli_real_escape_string($conn, $_POST['userReview']);
    $date = date('Y-m-d');

    // Query untuk memasukkan data ke dalam tabel 'review'
    $sql = "INSERT INTO review (user_id, rating, title, deskripsi, date) 
            VALUES ('$user_id', '$rating', '$title', '$deskripsi', '$date')";

    if ($conn->query($sql) === TRUE) {
        echo "Review berhasil dikirim!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}



$conn->close();
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

          .comment-form form {
            background-color: #f4f4f4;
            padding: 20px;
            border-radius: 8px;
        }
        .comment-form label {
            display: block;
            margin-top: 10px;
        }
        .comment-form input, .comment-form textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .comment-form button {
            margin-top: 15px;
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .comment-form button:hover {
            background-color: #0056b3;
        }

        .sosial-media {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .sosial-media-link {
        margin: 10px;
    }


        .star-filled {
            color: gold; /* Warna emas untuk bintang penuh */
        }

        .star-empty {
            color: #ccc; /* Warna abu-abu untuk bintang kosong */
        }

        .rating-percentage {
            font-size: 1.2rem;
            font-weight: bold;
        }

    
        
        </style>

        
        <!-- Custom styles for this template -->
        <link href="carousel.css" rel="stylesheet">
      </head>
      <main>

        
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


    <body>
      <main>
        <br><br><br><br>
        <div id="average-rating" class="container">
    <h3 class="text-center"><b>Rating untuk penggunaan LookWork</b></h3>

    <!-- Tampilkan Rata-rata Rating dan Simbol Bintang -->
    <?php
    // Konversi rata-rata rating ke simbol bintang
    $stars_avg = str_repeat("<span class='star-filled'>★</span>", floor($avg_rating)) .
                 str_repeat("<span class='star-empty'>☆</span>", 5 - floor($avg_rating));

    echo "<div class='text-center'>";
    echo "<div class='rating-stars' style='font-size: 1.5rem;'>$stars_avg</div>";
    echo "<p class='rating-percentage'>Rata-rata: $avg_rating / 5</p>";
    echo "</div>";
    ?>
</div>
        <div id="reviews" class="container mt-5">

    <div class="row">
        <div class="col-md-12">
            <!-- Review Form -->
            <div class="mb-4">
                <h4>Tulis Review Anda</h4>
                <form id="reviewForm" method="POST" action="">
                    <div class="form-group">
                        <label for="userName">Nama Anda:</label>
                        <input type="text" class="form-control" id="userName" name="userName" required>
                    </div>
                    <div class="form-group">
                        <label for="userRating">Rating:</label>
                        <select class="form-control" id="userRating" name="userRating" required>
                            <option value="">Pilih Rating</option>
                            <option value="1">1 Star</option>
                            <option value="2">2 Stars</option>
                            <option value="3">3 Stars</option>
                            <option value="4">4 Stars</option>
                            <option value="5">5 Stars</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="userReview">Review Anda:</label>
                        <textarea class="form-control" id="userReview" name="userReview" rows="3" required></textarea>
                    </div>
                    <?php if (isset($_SESSION['username'])): ?>
            <!-- Jika pengguna sudah login, tampilkan tombol kirim -->
                <button type="submit" class="btn btn-primary mt-2">Kirim Review</button>
                  <?php else: ?>
                      <!-- Jika pengguna belum login, tampilkan pesan atau tombol login -->
                      <a href="login.php" class="btn btn-secondary mt-2">Login untuk mengirim review</a>
                  <?php endif; ?>
                </form>
            </div>

            <!-- Review List -->
            <h4>User Review</h4>
            <form id="filterForm" method="GET" action="">
            <div class="form-group">
                <label for="filterRating">Urutkan Berdasarkan:</label>
                <select class="form-control" id="filterRating" name="filterRating" onchange="this.form.submit()">
                    <option value="desc" <?php if(isset($_GET['filterRating']) && $_GET['filterRating'] == 'desc') echo 'selected'; ?>>Rating Tertinggi</option>
                    <option value="asc" <?php if(isset($_GET['filterRating']) && $_GET['filterRating'] == 'asc') echo 'selected'; ?>>Rating Terendah</option>
                </select>
            </div>
        </form>

            <div id="reviewList" class="mt-3">
                <?php include 'view/display_reviews.php'; ?>
            </div>
        </div>
    </div>
</div>



 
<footer >
        
        
      <p>&copy; 2024 LookWork. All Rights Reserved. </p>
      </footer>
</main>
</body>