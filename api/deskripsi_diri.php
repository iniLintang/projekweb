<?php
// Cek apakah data yang dibutuhkan ada dalam POST request
if (!empty($_POST['id_pengguna']) && !empty($_POST['keterangan'])) {
    $id_pengguna = $_POST['id_pengguna'];
    $keterangan = $_POST['keterangan'];

    // Koneksi ke database
    $con = mysqli_connect("wstif23.myhost.id", "wstifmy1_kelas_int", "@Polije164Int", "wstifmy1_int_team3");
    if (!$con) {
        // Jika koneksi gagal, beri pesan error yang lebih aman
        die(json_encode(array("status" => "failed", "message" => "Koneksi database gagal")));
    }

    // Pastikan id_pengguna dan keterangan valid sebelum melanjutkan
    $id_pengguna = mysqli_real_escape_string($con, $id_pengguna);
    $keterangan = mysqli_real_escape_string($con, $keterangan);

    // Menggunakan prepared statement untuk menghindari SQL Injection
    $stmt = $con->prepare("UPDATE pencari_kerja SET keterangan = ? WHERE id_pengguna = ?");
    if ($stmt) {
        // Bind parameters dan eksekusi query
        $stmt->bind_param("ss", $keterangan, $id_pengguna);
        
        // Mengeksekusi query
        $stmt->execute();

        // Mengecek apakah data berhasil diperbarui
        if ($stmt->affected_rows > 0) {
            $result = array(
                "status" => "success",
                "message" => "Keterangan berhasil ditambahkan",
                "keterangan" => $keterangan
            );
        } else {
            // Jika tidak ada baris yang terpengaruh, kemungkinan ID pengguna tidak ditemukan
            $result = array(
                "status" => "failed",
                "message" => "Keterangan tidak berubah, periksa kembali ID pengguna atau keterangan"
            );
        }

        // Menutup statement
        $stmt->close();
    } else {
        // Jika gagal menyiapkan query
        $result = array(
            "status" => "failed",
            "message" => "Gagal menyiapkan query update"
        );
    }

    // Menutup koneksi database
    mysqli_close($con);
} else {
    // Jika ada parameter yang kosong
    $result = array(
        "status" => "failed",
        "message" => "Semua field harus diisi"
    );
}

// Mengembalikan response dalam format JSON
echo json_encode($result);
?>
