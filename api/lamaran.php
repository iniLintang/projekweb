<?php
// upload_lamaran.php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $targetDir = "uploads/";
    $response = array();

    // Memeriksa apakah file dan data lainnya ada
    if (isset($_FILES['cv']) && isset($_FILES['surat_lamaran'])) {
        $cvFileName = basename($_FILES['cv']['name']);
        $cvFilePath = $targetDir . $cvFileName;
        $suratLamaranFileName = basename($_FILES['surat_lamaran']['name']);
        $suratLamaranFilePath = $targetDir . $suratLamaranFileName;

        // Memindahkan file ke folder tujuan
        if (move_uploaded_file($_FILES['cv']['tmp_name'], $cvFilePath) && move_uploaded_file($_FILES['surat_lamaran']['tmp_name'], $suratLamaranFilePath)) {
            // Koneksi database
            $server = "wstif23.myhost.id";
            $user = "wstifmy1_kelas_int";
            $password = "@Polije164Int";
            $nama_database = "wstifmy1_int_team3";
            
            
            // Buat koneksi
            $db = new mysqli($server, $user, $password, $nama_database);

            // Memeriksa koneksi database
            if ($db->connect_error) {
                $response['error'] = "Connection failed: " . $db->connect_error;
            } else {
                // Menyimpan nama file ke database
                $pekerjaan = $_POST['pekerjaan'];
                $fullname = $_POST['fullname'];
                $sql = "INSERT INTO lamaran (pekerjaan, fullname, cv, surat_lamaran) 
                        VALUES ('$pekerjaan', '$fullname', '$cvFileName', '$suratLamaranFileName')";

                if ($db->query($sql) === TRUE) {
                    $response['success'] = "File uploaded and saved successfully.";
                } else {
                    $response['error'] = "Database error: " . $db->error;
                }
            }

            // Menutup koneksi database
            $db->close();
        } else {
            $response['error'] = "Failed to upload files.";
        }
    } else {
        $response['error'] = "Files are missing.";
    }

    echo json_encode($response);
}
?>
