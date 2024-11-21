<?php
session_start();
require 'db_connect.php';

if (!isset($_SESSION['pengguna_id'])) {
    header("Location: login.php");
    exit();
}

$id_pengguna = $_SESSION['pengguna_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $foto_profil = $_FILES['foto_profil'];

    // Update data pengguna
    if ($foto_profil['name']) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($foto_profil["name"]);
        move_uploaded_file($foto_profil["tmp_name"], $target_file);

        $query = $conn->prepare("
            UPDATE pengguna 
            SET nama = ?, email = ?, username = ?, foto_profil = ? 
            WHERE id_pengguna = ?");
        $query->bind_param("ssssi", $nama, $email, $username, $target_file, $id_pengguna);
    } else {
        $query = $conn->prepare("
            UPDATE pengguna 
            SET nama = ?, email = ?, username = ? 
            WHERE id_pengguna = ?");
        $query->bind_param("sssi", $nama, $email, $username, $id_pengguna);
    }

    if ($query->execute()) {
        header("Location: profil.php");
    } else {
        echo "Gagal memperbarui profil.";
    }
    exit();
}

// Ambil data pengguna
$query = $conn->prepare("
    SELECT nama, email, username 
    FROM pengguna 
    WHERE id_pengguna = ?");
$query->bind_param("i", $id_pengguna);
$query->execute();
$user = $query->get_result()->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil</title>
</head>
<body>
    <h1>Edit Profil</h1>
    <form action="update_profile.php" method="POST" enctype="multipart/form-data">
        <label>Nama:</label>
        <input type="text" name="nama" value="<?= htmlspecialchars($user['nama']); ?>" required><br>
        <label>Email:</label>
        <input type="email" name="email" value="<?= htmlspecialchars($user['email']); ?>" required><br>
        <label>Username:</label>
        <input type="text" name="username" value="<?= htmlspecialchars($user['username']); ?>" required><br>
        <label>Foto Profil:</label>
        <input type="file" name="foto_profil"><br>
        <button type="submit">Simpan</button>
    </form>
</body>
</html>
