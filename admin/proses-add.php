<?php
// Include file koneksi database
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $role = 'admin'; // Peran diatur ke admin

    // Hash password untuk keamanan
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Mulai transaksi untuk memastikan konsistensi data
    $conn->begin_transaction();

    try {
        // Query untuk menambahkan pengguna baru ke tabel pengguna
        $queryPengguna = "INSERT INTO pengguna (nama, email, username, kata_sandi, peran) VALUES (?, ?, ?, ?, ?)";
        $stmtPengguna = $conn->prepare($queryPengguna);
        $stmtPengguna->bind_param('sssss', $nama, $email, $username, $hashedPassword, $role);
        $stmtPengguna->execute();

        // Ambil ID pengguna yang baru saja dimasukkan
        $idPengguna = $conn->insert_id;

        // Query untuk menambahkan data admin ke tabel admin
        $queryAdmin = "INSERT INTO admin (id_pengguna, jabatan) VALUES (?, ?)";
        $stmtAdmin = $conn->prepare($queryAdmin);
        $jabatan = null; // Set jabatan jika diperlukan, null untuk saat ini
        $stmtAdmin->bind_param('is', $idPengguna, $jabatan);
        $stmtAdmin->execute();

        // Commit transaksi jika semua query berhasil
        $conn->commit();

        // Redirect ke halaman admin dengan pesan sukses
        header('Location: data-user.php?status=sukses');
        exit();
    } catch (Exception $e) {
        // Rollback transaksi jika terjadi kesalahan
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    }

    // Tutup koneksi
    $stmtPengguna->close();
    $stmtAdmin->close();
    $conn->close();
} else {
    // Jika bukan metode POST, redirect ke halaman lain
    header('Location: data-user.php');
    exit(); 
}

?>
