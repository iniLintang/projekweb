<?php
// Memeriksa apakah semua field pada form telah diisi
if (!empty($_POST['id_pencari_kerja']) && !empty($_POST['nama_institusi']) && !empty($_POST['jenis_pengalaman']) && !empty($_POST['tanggal_mulai']) && !empty($_POST['tanggal_selesai'])) {
    $id_pencari_kerja = $_POST['id_pencari_kerja'];
    $nama_institusi = $_POST['nama_institusi'];
    $jenis_pengalaman = $_POST['jenis_pengalaman'];
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $tanggal_selesai = $_POST['tanggal_selesai'];

    $result = array();

    // Koneksi ke database
    $con = mysqli_connect("wstif23.myhost.id", "wstifmy1_kelas_int", "@Polije164Int", "wstifmy1_int_team3");
    if ($con) {
        // Cek apakah `id_pencari_kerja` valid di tabel `pencari_kerja`
        $sqlCheckPencariKerja = "
            SELECT id_pencari_kerja
            FROM pencari_kerja
            WHERE id_pencari_kerja = '".$id_pencari_kerja."'
        ";
        $checkRes = mysqli_query($con, $sqlCheckPencariKerja);

        if (mysqli_num_rows($checkRes) != 0) {
            // Tambahkan pengalaman baru ke tabel pengalaman
            $sqlInsert = "
                INSERT INTO pengalaman (id_pencari_kerja, nama_institusi, jenis_pengalaman, tanggal_mulai, tanggal_selesai)
                VALUES ('".$id_pencari_kerja."', '".$nama_institusi."', '".$jenis_pengalaman."', '".$tanggal_mulai."', '".$tanggal_selesai."')
            ";
            if (mysqli_query($con, $sqlInsert)) {
                $result = array(
                    "status" => "success",
                    "message" => "Experience data added successfully",
                    "id_pencari_kerja" => $id_pencari_kerja,
                    "nama_institusi" => $nama_institusi,
                    "jenis_pengalaman" => $jenis_pengalaman,
                    "tanggal_mulai" => $tanggal_mulai,
                    "tanggal_selesai" => $tanggal_selesai
                );
            } else {
                $result = array("status" => "failed", "message" => "Failed to add new experience data");
            }
        } else {
            $result = array("status" => "failed", "message" => "ID pencari kerja not found in pencari_kerja table");
        }
    } else {
        $result = array("status" => "failed", "message" => "Database connection failed");
    }

    // Menutup koneksi database
    mysqli_close($con);
} else {
    $result = array("status" => "failed", "message" => "All fields are required");
}

// Mengeluarkan hasil dalam bentuk JSON
echo json_encode($result, JSON_PRETTY_PRINT);
?>
