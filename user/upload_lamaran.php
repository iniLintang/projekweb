<?php
require 'db_connect.php'; // Pastikan file koneksi database sesuai

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $judul_pekerjaan = $_POST['judul_pekerjaan'] ?? '';
    $nama_pencari_kerja = $_POST['nama'] ?? '';

    // Validasi input
    if (empty($judul_pekerjaan) || empty($nama_pencari_kerja)) {
        die("Judul pekerjaan atau nama pencari kerja tidak boleh kosong.");
    }

    // Proses file upload
    $upload_dir = '../uploads/';

    // Pastikan folder upload ada
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true); // Membuat folder jika belum ada
    }

    // Cek apakah file surat lamaran di-upload
    $surat_lamaran = $_FILES['surat_lamaran']['name'] ?? null;
    $cv = $_FILES['cv']['name'] ?? null;

    if ($surat_lamaran && $cv) {
        $surat_lamaran_path = $upload_dir . basename($surat_lamaran);
        $cv_path = $upload_dir . basename($cv);

        // Cek apakah file surat lamaran dan CV valid (contoh: hanya PDF)
        $valid_ext = ['pdf'];  // Daftar ekstensi file yang valid

        $surat_lamaran_ext = strtolower(pathinfo($surat_lamaran, PATHINFO_EXTENSION));
        $cv_ext = strtolower(pathinfo($cv, PATHINFO_EXTENSION));

        if (!in_array($surat_lamaran_ext, $valid_ext) || !in_array($cv_ext, $valid_ext)) {
            die("Hanya file PDF yang diizinkan untuk diunggah.");
        }

        // Pindahkan file yang diunggah ke folder yang sesuai
        if (move_uploaded_file($_FILES['surat_lamaran']['tmp_name'], $surat_lamaran_path) &&
            move_uploaded_file($_FILES['cv']['tmp_name'], $cv_path)) {

            // Ambil ID pengguna berdasarkan nama
            $query_pengguna = "SELECT id_pengguna FROM pengguna WHERE nama = ?";
            $stmt_pengguna = $conn->prepare($query_pengguna);
            $stmt_pengguna->bind_param("s", $nama_pencari_kerja);
            $stmt_pengguna->execute();
            $result_pengguna = $stmt_pengguna->get_result();

            if ($result_pengguna->num_rows > 0) {
                $row_pengguna = $result_pengguna->fetch_assoc();
                $id_pengguna = $row_pengguna['id_pengguna'];

                // Ambil ID pekerjaan berdasarkan judul
                $query_pekerjaan = "SELECT id_pekerjaan FROM pekerjaan WHERE judul_pekerjaan = ?";
                $stmt_pekerjaan = $conn->prepare($query_pekerjaan);
                $stmt_pekerjaan->bind_param("s", $judul_pekerjaan);
                $stmt_pekerjaan->execute();
                $result_pekerjaan = $stmt_pekerjaan->get_result();

                if ($result_pekerjaan->num_rows > 0) {
                    $row_pekerjaan = $result_pekerjaan->fetch_assoc();
                    $id_pekerjaan = $row_pekerjaan['id_pekerjaan'];

                    // Simpan data ke dalam tabel lamaran
                    $query_insert = "INSERT INTO lamaran (id_pencari_kerja, id_pekerjaan, surat_lamaran, cv, tanggal_lamaran) 
                                     VALUES (?, ?, ?, ?, NOW())";
                    $stmt_insert = $conn->prepare($query_insert);
                    $stmt_insert->bind_param("iiss", $id_pengguna, $id_pekerjaan, $surat_lamaran_path, $cv_path);

                    if ($stmt_insert->execute()) {
                        echo '<!DOCTYPE html>
                        <html lang="id">
                        <head>
                            <meta charset="UTF-8">
                            <meta name="viewport" content="width=device-width, initial-scale=1.0">
                            <title>Konfirmasi Lamaran</title>
                            <style>
                                body {
                                    font-family: Arial, sans-serif;
                                    background-color: #e9f7e9;
                                    color: #2d472d;
                                    margin: 0;
                                    display: flex;
                                    justify-content: center;
                                    align-items: center;
                                    height: 100vh;
                                }
                                .container {
                                    text-align: center;
                                    background-color: #d4edda;
                                    padding: 20px;
                                    border-radius: 10px;
                                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                                    max-width: 400px;
                                    width: 90%;
                                }
                                h1 {
                                    margin-bottom: 20px;
                                }
                                .button {
                                    display: inline-block;
                                    background-color: #28a745;
                                    color: white;
                                    padding: 10px 20px;
                                    text-decoration: none;
                                    font-size: 16px;
                                    font-weight: bold;
                                    border-radius: 5px;
                                    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                                    transition: background-color 0.3s ease, transform 0.2s ease;
                                }
                                .button:hover {
                                    background-color: #218838;
                                    transform: scale(1.05);
                                }
                                .button:active {
                                    background-color: #1e7e34;
                                }
                            </style>
                        </head>
                        <body>
                            <div class="container">
                                <h1>Lamaran Berhasil Dikirim!</h1>
                                <p>Terima kasih telah melamar pekerjaan ini. Kami akan menghubungi Anda jika ada perkembangan lebih lanjut.</p>
                                <a href="indexx.php" class="button">Kembali</a>
                            </div>
                        </body>
                        </html>';
                    } else {
                        echo "Gagal menyimpan lamaran: " . $stmt_insert->error;
                    }
                } else {
                    echo "Pekerjaan tidak ditemukan!";
                }
            } else {
                echo "Pengguna tidak ditemukan!";
            }
        } else {
            echo "Gagal mengunggah file!";
        }
    } else {
        echo "File surat lamaran atau CV tidak diunggah dengan benar.";
    }
}

$conn->close();
?>
