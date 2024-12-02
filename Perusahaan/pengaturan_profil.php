<?php
session_start();
include 'db_connect.php'; // Include your database connection file

// Check if the user is logged in
if (!isset($_SESSION['pengguna_id'])) {
    header('Location: ../login/login.php'); // Redirect if the user is not logged in
    exit();
}

// Get the user's company profile and user profile information
$id_pengguna = $_SESSION['pengguna_id'];

// Query untuk mengambil data pengguna
$query_user = "SELECT * FROM pengguna WHERE id_pengguna = ?";
$stmt_user = $conn->prepare($query_user);
$stmt_user->bind_param("i", $id_pengguna);
$stmt_user->execute();
$result_user = $stmt_user->get_result();
$user = $result_user->fetch_assoc();
$stmt_user->close();

// Query untuk mengambil data perusahaan
$query_company = "SELECT * FROM perusahaan WHERE id_pengguna = ?";
$stmt_company = $conn->prepare($query_company);
$stmt_company->bind_param("i", $id_pengguna);
$stmt_company->execute();
$result_company = $stmt_company->get_result();
$company = $result_company->fetch_assoc();
$stmt_company->close();

// Validasi jika data tidak ditemukan
if (!$user) {
    echo "Error: Data pengguna tidak ditemukan.";
    exit();
}
if (!$company) {
    echo "Error: Data perusahaan tidak ditemukan.";
    exit();
}

// Handle form submission for updating the profile
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST["username"];
    $nama = $_POST["nama"];
    $email = $_POST["email"];
    $lokasi_perusahaan = $_POST['lokasi'];
    $industri = $_POST['industri'];
    $deskripsi_perusahaan = $_POST['deskripsi'];
    $password = $_POST['password'];
    $foto_profil = $user['foto_profil']; // Default to current photo

    // Verify the entered password
    if (password_verify($password, $user['kata_sandi'])) {
        // Handle photo upload
        if (isset($_FILES['foto_profil']) && $_FILES['foto_profil']['error'] === UPLOAD_ERR_OK) {
            $file_tmp = $_FILES['foto_profil']['tmp_name'];
            $file_name = basename($_FILES['foto_profil']['name']);
            $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
            $allowed_exts = ['jpg', 'jpeg', 'png', 'gif'];

            if (in_array(strtolower($file_ext), $allowed_exts)) {
                $upload_dir = '../foto/'; // Change this to your desired upload directory
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }

                $new_file_name = 'profile_' . $id_pengguna . '.' . $file_ext;
                $file_path = $upload_dir . $new_file_name;

                if (move_uploaded_file($file_tmp, $file_path)) {
                    $foto_profil = $file_path;
                } else {
                    echo "Error: Could not upload the photo.";
                }
            } else {
                echo "Error: Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.";
            }
        }

        // Update the user photo and company profile in the database
        $update_user_query = "UPDATE pengguna SET username = ?, nama = ?, email = ?, foto_profil = ? WHERE id_pengguna = ?";
        $stmt_user = $conn->prepare($update_user_query);
        $stmt_user->bind_param("ssssi", $username, $nama, $email, $foto_profil, $id_pengguna);
        $stmt_user->execute();

        $update_company_query = "UPDATE perusahaan SET lokasi_perusahaan = ?, industri = ?, deskripsi_perusahaan = ? WHERE id_pengguna = ?";
        $stmt_company = $conn->prepare($update_company_query);
        $stmt_company->bind_param("sssi", $lokasi_perusahaan, $industri, $deskripsi_perusahaan, $id_pengguna);
        $stmt_company->execute();

        if ($stmt_user->affected_rows > 0 || $stmt_company->affected_rows > 0) {
            // Redirect to the profile page with success message
            header('Location: pengaturan_profil.php?status=success');
            exit();
        } else {
            echo "Error: No changes were made.";
        }

        $stmt_user->close();
        $stmt_company->close();
    } else {
        echo "Error: Password is incorrect.";
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Perusahaan_LookWork</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <link href="img/favicon.ico" rel="icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Inter:wght@700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<style>
    body {
            font-family: 'Heebo', sans-serif;
            background-color: #f4f4f9;
    }

        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #393e44;
            margin-bottom: 30px;
              text-align: center;
        }

        label {
            font-weight: bold;
            color: #393e44;
        }

        .form-control, select {
            border-radius: 5px;
            padding: 10px;
            font-size: 14px;
            margin-bottom: 20px;
        }
        .btn {
            font-size: 16px;
            padding: 10px 20px;
            border-radius: 5px;
        }
        .btn-primary {
            background-color: #6A9C89;
            border-color: #28a745;
            font-size: 16px;
            padding: 12px 20px;
        }

        .btn-primary:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }

        textarea {
            border-radius: 5px;
            padding: 10px;
            font-size: 14px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }
        
    </style>
</head>

<body>
    <div class="container-xxl bg-white p-0">
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        </div>

        <nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
       <a href="index.php" class="navbar-brand d-flex align-items-center text-center py-0 px-4 px-lg-5">
       <h1 class="m-0" style="color: #16423C;">LookWork</h1>
       </a>

            <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
               
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                    <a href="index.php" class="nav-item nav-link ">Beranda</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pekerjaan</a>
                        <div class="dropdown-menu rounded-0 m-0">
                            <a href="daftar_loker.php" class="dropdown-item">Daftar Lowongan Pekerjaan</a>
                            <a href="daftar_lamaran.php" class="dropdown-item">Daftar Lamaran Pekerjaan</a>
                        </div>
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link active dropdown-toggle" data-bs-toggle="dropdown">Profil</a>
                        <div class="dropdown-menu rounded-0 m-0">
                            <a href="pengaturan_profil.php" class="dropdown-item">Pengaturan Profil</a>
                            <a href="keluar.php" class="dropdown-item">Keluar</a>
                        </div>
                </div>
                <a href="tambah_pekerjaan.php" class="btn btn-primary rounded-0 py-4 px-lg-5 d-none d-lg-block" style="background-color: #6A9C89; border-color: #6A9C89;">Tambahkan Loker<i class="fa fa-arrow-right ms-3"></i></a>
                </div>
        </nav>
    </div>

    <div class="container mt-5">
    <h1>Pengaturan Profil Perusahaan</h1>

    <!-- Form untuk memperbarui profil perusahaan -->
    <form action="" method="POST" enctype="multipart/form-data">
    
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" class="form-control" 
                value="<?= isset($user['username']) ? htmlspecialchars($user['username']) : '' ?>" required>
        </div>

        <div class="form-group">
            <label for="nama">Nama:</label>
            <input type="text" id="nama" name="nama" class="form-control" 
                value="<?= isset($user['nama']) ? htmlspecialchars($user['nama']) : '' ?>" required>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" class="form-control" 
                value="<?= isset($user['email']) ? htmlspecialchars($user['email']) : '' ?>" required>
        </div>

        <div class="form-group">
            <label for="lokasi">Lokasi Perusahaan:</label>
            <input type="text" id="lokasi" name="lokasi" class="form-control" 
                value="<?= isset($company['lokasi_perusahaan']) ? htmlspecialchars($company['lokasi_perusahaan']) : '' ?>" required>
        </div>

        <div class="form-group">
            <label for="industri">Industri:</label>
            <select id="industri" name="industri" class="form-control" required>
                <option value="">-- Pilih Industri --</option>
                <?php
                $industri_list = [
                    "Industri makanan dan minuman",
                    "Industri tekstil dan garmen",
                    "Industri rokok",
                    "Industri otomotif",
                    "Industri kimia dan dasar",
                    "Industri aneka produk konsumsi",
                    "Industri alat dan mesin berat",
                    "Industri logam",
                    "Industri dengan basis plastik",
                    "Industri farmasi",
                    "Industri teknologi informasi",
                    "Industri pertanian"
                ];
                foreach ($industri_list as $ind) {
                    $selected = (isset($company['industri']) && $company['industri'] == $ind) ? 'selected' : '';
                    echo "<option value='$ind' $selected>$ind</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="deskripsi">Deskripsi Perusahaan:</label>
            <textarea id="deskripsi" name="deskripsi" class="form-control" rows="5" required><?= 
                isset($company['deskripsi_perusahaan']) ? htmlspecialchars($company['deskripsi_perusahaan']) : '' ?></textarea>
        </div>

        <div class="form-group">
            <label for="foto_profil">Foto Profil:</label>
            <input type="file" id="foto_profil" name="foto_profil" accept="image/*">
        </div>

        <?php if (!empty($user['foto_profil'])): ?>
            <div>
                <img src="<?= htmlspecialchars($user['foto_profil']); ?>" alt="Foto Profil" 
                    style="max-width: 100px; max-height: 100px;">
            </div>
        <?php endif; ?>

        <div class="form-group">
            <label for="password">Konfirmasi Password:</label>
            <input type="password" id="password" name="password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </form>
</div>



<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <script src="js/main.js"></script>
    
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>
