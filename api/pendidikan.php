<?php
// Memeriksa apakah semua field pada form telah diisi
if (!empty($_POST['id_pencari_kerja']) && !empty($_POST['institusi']) && !empty($_POST['bidang_studi']) && !empty($_POST['tahun_mulai']) && !empty($_POST['tahun_selesai'])) {
    $id_pencari_kerja = $_POST['id_pencari_kerja'];
    $institusi = $_POST['institusi'];
    $bidang_studi = $_POST['bidang_studi'];
    $tahun_mulai = $_POST['tahun_mulai'];
    $tahun_selesai = $_POST['tahun_selesai'];

    $result = array();

    // Koneksi ke database
    $con = mysqli_connect("wstif23.myhost.id", "wstifmy1_kelas_int", "@Polije164Int", "wstifmy1_int_team3");
    if ($con) {
        // Memeriksa apakah id_pencari_kerja valid dengan mencocokkan di tabel pencari_kerja dan pendidikan
        $sql = "
            SELECT p.id_pencari_kerja
            FROM pendidikan p
            INNER JOIN pencari_kerja pk
            ON p.id_pencari_kerja = pk.id_pencari_kerja
            WHERE p.id_pencari_kerja = '".$id_pencari_kerja."'
        ";
        $res = mysqli_query($con, $sql);

        // Jika id_pencari_kerja ditemukan di tabel pendidikan
        if (mysqli_num_rows($res) != 0) {
            // Mengupdate informasi pendidikan di database
            $sqlUpdate = "
                UPDATE pendidikan SET 
                    institusi = '".$institusi."', 
                    bidang_studi = '".$bidang_studi."', 
                    tahun_mulai = '".$tahun_mulai."', 
                    tahun_selesai = '".$tahun_selesai."' 
                WHERE id_pencari_kerja = '".$id_pencari_kerja."'
            ";
            if (mysqli_query($con, $sqlUpdate)) {
                $result = array(
                    "status" => "success",
                    "message" => "User information updated successfully",
                    "institusi" => $institusi,
                    "bidang_studi" => $bidang_studi,
                    "tahun_mulai" => $tahun_mulai,
                    "tahun_selesai" => $tahun_selesai
                );
            } else {
                $result = array("status" => "failed", "message" => "Failed to update user information, please try again");
            }
        } else {
            // Cek apakah ID ada di tabel pencari_kerja
            $sqlCheckPencariKerja = "
                SELECT id_pencari_kerja
                FROM pencari_kerja
                WHERE id_pencari_kerja = '".$id_pencari_kerja."'
            ";
            $checkRes = mysqli_query($con, $sqlCheckPencariKerja);

            if (mysqli_num_rows($checkRes) != 0) {
                // Jika ID ditemukan di tabel pencari_kerja, tambahkan data baru ke pendidikan
                $sqlInsert = "
                    INSERT INTO pendidikan (id_pencari_kerja, institusi, bidang_studi, tahun_mulai, tahun_selesai)
                    VALUES ('".$id_pencari_kerja."', '".$institusi."', '".$bidang_studi."', '".$tahun_mulai."', '".$tahun_selesai."')
                ";
                if (mysqli_query($con, $sqlInsert)) {
                    $result = array(
                        "status" => "success",
                        "message" => "New experience data added successfully",
                        "institusi" => $institusi,
                        "bidang_studi" => $bidang_studi,
                        "tahun_mulai" => $tahun_mulai,
                        "tahun_selesai" => $tahun_selesai
                    );
                } else {
                    $result = array("status" => "failed", "message" => "Failed to add new experience data");
                }
            } else {
                $result = array("status" => "failed", "message" => "ID pencari kerja not found in pencari_kerja table");
            }
        }
    } else {
        $result = array("status" => "failed", "message" => "Database connection failed");
    }
} else {
    $result = array("status" => "failed", "message" => "All fields are required");
}

// Mengeluarkan hasil dalam bentuk JSON
echo json_encode($result, JSON_PRETTY_PRINT);
?>
