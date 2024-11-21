<?php
// Include the database connection
include 'koneksi.php';
session_start();

// Check if the user is logged in as a company
if (!isset($_SESSION['peran']) || $_SESSION['peran'] !== 'perusahaan') {
    echo "Silakan login sebagai perusahaan untuk mengakses halaman ini.";
    exit;
}

$id_pengguna = $_SESSION['pengguna_id'];

// Get the company ID based on id_pengguna
$query_perusahaan = "SELECT id_perusahaan FROM perusahaan WHERE id_pengguna = :id_pengguna";
$stmt_perusahaan = $conn->prepare($query_perusahaan);
$stmt_perusahaan->bindParam(':id_pengguna', $id_pengguna, PDO::PARAM_INT);
$stmt_perusahaan->execute();
$id_perusahaan = $stmt_perusahaan->fetch(PDO::FETCH_ASSOC)['id_perusahaan'];

// Get job categories
$query_kategori_pekerjaan = "SELECT * FROM kategori_pekerjaan";
$stmt_kategori_pekerjaan = $conn->prepare($query_kategori_pekerjaan);
$stmt_kategori_pekerjaan->execute();
$result_kategori_pekerjaan = $stmt_kategori_pekerjaan->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input
    $judul_pekerjaan = htmlspecialchars($_POST['judul_pekerjaan']);
    $deskripsi = htmlspecialchars($_POST['deskripsi']);
    $lokasi = htmlspecialchars($_POST['lokasi']);
    $jenis_pekerjaan = htmlspecialchars($_POST['jenis_pekerjaan']);
    $tipe_kerja = htmlspecialchars($_POST['tipe_kerja']);
    $gaji_dari = isset($_POST['gaji_dari']) ? str_replace(',', '', $_POST['gaji_dari']) : 0;
    $gaji_hingga = isset($_POST['gaji_hingga']) ? str_replace(',', '', $_POST['gaji_hingga']) : 0;

    // Validate salary input
    if ($gaji_dari > $gaji_hingga) {
        echo "Gaji minimum tidak boleh lebih besar dari gaji maksimum.";
        exit;
    }

    if (isset($_POST['kategori'])) {
        foreach ($_POST['kategori'] as $id_kategori) {
            // Ensure $id_kategori is an integer
            $id_kategori = (int)$id_kategori;

            // Insert the job data into the database
            $query = "
                INSERT INTO pekerjaan 
                (id_perusahaan, id_kategori, judul_pekerjaan, deskripsi, lokasi, jenis_pekerjaan, tipe_kerja, gaji_dari, gaji_hingga) 
                VALUES (:id_perusahaan, :id_kategori, :judul_pekerjaan, :deskripsi, :lokasi, :jenis_pekerjaan, :tipe_kerja, :gaji_dari, :gaji_hingga)";
            
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':id_perusahaan', $id_perusahaan, PDO::PARAM_INT);
            $stmt->bindParam(':id_kategori', $id_kategori, PDO::PARAM_INT);
            $stmt->bindParam(':judul_pekerjaan', $judul_pekerjaan, PDO::PARAM_STR);
            $stmt->bindParam(':deskripsi', $deskripsi, PDO::PARAM_STR);
            $stmt->bindParam(':lokasi', $lokasi, PDO::PARAM_STR);
            $stmt->bindParam(':jenis_pekerjaan', $jenis_pekerjaan, PDO::PARAM_STR);
            $stmt->bindParam(':tipe_kerja', $tipe_kerja, PDO::PARAM_STR);
            $stmt->bindParam(':gaji_dari', $gaji_dari, PDO::PARAM_INT);
            $stmt->bindParam(':gaji_hingga', $gaji_hingga, PDO::PARAM_INT);

            if ($stmt->execute()) {
                header("Location: daftar_loker.php?success=true");
                exit;
            } else {
                echo "Error: " . $stmt->errorInfo()[2];
                exit;
            }
        }
    } else {
        echo "Pilih setidaknya satu kategori pekerjaan.";
    }
}
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
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Inter:wght@700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="text-center my-4"><i class="fas fa-plus-circle"></i> Tambahkan Lowongan Kerja Anda!</h1>
        <form action="" method="post">
            <div class="form-group">
                <label for="judul_pekerjaan">Judul Pekerjaan</label>
                <input type="text" class="form-control" id="judul_pekerjaan" name="judul_pekerjaan" required>
            </div>
            <div class="form-group">
                <label for="deskripsi">Deskripsi</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="lokasi">Lokasi</label>
                <input type="text" class="form-control" id="lokasi" name="lokasi" required>
            </div>
            <div class="form-group">
                <label>Jenis Pekerjaan</label>
                <select name="jenis_pekerjaan" class="form-control" required>
                    <option value="" disabled selected>Pilih jenis pekerjaan</option>
                    <option value="full_time">Full Time</option>
                    <option value="part_time">Part Time</option>
                    <option value="freelance">Freelance</option>
                    <option value="internship">Internship</option>
                </select>
            </div>
            <div class="form-group">
                <label>Tipe Kerja</label>
                <select name="tipe_kerja" class="form-control" required>
                    <option value="" disabled selected>Pilih tipe kerja</option>
                    <option value="remote">Remote</option>
                    <option value="wfo">WFO (Work from Office)</option>
                    <option value="hybrid">Hybrid</option>
                </select>
            </div>
            <div class="form-group">
                <label>Range Gaji</label>
                <div class="row">
                    <div class="col-md-6">
                        <label>Dari</label>
                        <input type="text" class="form-control" id="gaji_dari" name="gaji_dari" required>
                    </div>
                    <div class="col-md-6">
                        <label>Hingga</label>
                        <input type="text" class="form-control" id="gaji_hingga" name="gaji_hingga" required>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="kategori_pekerjaan">Kategori Pekerjaan</label><br>
                <?php foreach ($result_kategori_pekerjaan as $row_kategori_pekerjaan): ?>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="kategori[]" value="<?php echo $row_kategori_pekerjaan['id_kategori']; ?>">
                        <label class="form-check-label"><?php echo $row_kategori_pekerjaan['nama_kategori']; ?></label>
                    </div>
                <?php endforeach; ?>
            </div>
            <button type="submit" class="btn btn-primary">Tambah Pekerjaan</button>
            <a href="daftar_loker.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
