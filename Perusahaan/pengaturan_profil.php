<?php
session_start();
include 'db_connect.php'; // Include your database connection file

// Check if the user is logged in
if (!isset($_SESSION['pengguna_id'])) {
    header('Location: ../login/login.php'); // Redirect if the user is not logged in
    exit();
}

// Get the user's company profile information
$id_pengguna = $_SESSION['pengguna_id']; // Use the correct session key
$query = "SELECT * FROM perusahaan WHERE id_pengguna = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_pengguna);
$stmt->execute();
$result = $stmt->get_result();
$company = $result->fetch_assoc();
$stmt->close();

// Handle form submission for updating the profile
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the new data from the form
    $nama_perusahaan = $_POST['nama'];
    $lokasi_perusahaan = $_POST['lokasi'];
    $deskripsi_perusahaan = $_POST['deskripsi'];
    $password = $_POST['password'];
    $new_photo = $_FILES['foto_profil']['name'];
    
    // Check if the entered password matches the stored password
    $query_password = "SELECT kata_sandi FROM pengguna WHERE id_pengguna = ?";
    $stmt = $conn->prepare($query_password);
    $stmt->bind_param("i", $id_pengguna);
    $stmt->execute();
    $result_password = $stmt->get_result();
    $user = $result_password->fetch_assoc();
    
    if (password_verify($password, $user['kata_sandi'])) {
        // Password is correct, proceed with updating the profile
        
        // Handle photo upload (if provided)
        if (!empty($new_photo)) {
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($new_photo);
            if (move_uploaded_file($_FILES['foto_profil']['tmp_name'], $target_file)) {
                // Successfully uploaded the new photo, update the database with the new photo file name
                $photo_path = $new_photo;
            } else {
                // Handle upload error if necessary
                $photo_path = $company['foto_profil']; // Keep the old photo if upload fails
            }
        } else {
            // No new photo uploaded, keep the old one
            $photo_path = $company['foto_profil'];
        }

        // Update the company profile in the database
        $update_query = "UPDATE perusahaan SET nama_perusahaan = ?, lokasi_perusahaan = ?, deskripsi_perusahaan = ? WHERE id_pengguna = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("sssi", $nama_perusahaan, $lokasi_perusahaan, $deskripsi_perusahaan, $id_pengguna);

        if ($stmt->execute()) {
            // If the update was successful, also update the user's photo in the 'pengguna' table
            if ($photo_path != $company['foto_profil']) {
                $update_user_query = "UPDATE pengguna SET foto_profil = ? WHERE id_pengguna = ?";
                $stmt_user = $conn->prepare($update_user_query);
                $stmt_user->bind_param("si", $photo_path, $id_pengguna);
                $stmt_user->execute();
                $stmt_user->close();
            }
            // Redirect to the profile page with success message
            header('Location: pengaturan_profil.php?status=success');
            exit();
        } else {
            // Handle database update error
            echo "Error: Could not update the profile.";
        }
        $stmt->close();
    } else {
        // If the password is incorrect
        echo "Error: Password is incorrect.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Perusahaan_LookWork</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="img/favicon.ico" rel="icon">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <style>
        .form-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="form-container">
            <h2>Pengaturan Profil Perusahaan</h2>

            <!-- Form untuk memperbarui profil perusahaan -->
            <form action="" method="POST" enctype="multipart/form-data">
                <label for="nama">Nama Perusahaan:</label><br>
                <input type="text" id="nama" name="nama" value="<?= htmlspecialchars($company['nama_perusahaan']) ?>" required><br><br>

                <label for="lokasi">Lokasi Perusahaan:</label><br>
                <input type="text" id="lokasi" name="lokasi" value="<?= htmlspecialchars($company['lokasi_perusahaan']) ?>" required><br><br>

                <label for="deskripsi">Deskripsi Perusahaan:</label><br>
                <textarea id="deskripsi" name="deskripsi" rows="5" required><?= htmlspecialchars($company['deskripsi_perusahaan']) ?></textarea><br><br>

                <label for="password">Konfirmasi Password:</label><br>
                <input type="password" id="password" name="password" required><br><br>

                <label for="foto_profil">Foto Profil:</label><br>
                <input type="file" id="foto_profil" name="foto_profil"><br>
                <?php if (!empty($company['foto_profil'])) { ?>
                    <img src="uploads/<?= htmlspecialchars($company['foto_profil']) ?>" alt="Foto Profil" width="100"><br>
                <?php } ?><br>

                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </form>
        </div>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>
