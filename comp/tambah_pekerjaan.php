<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Tambah Pekerjaan</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        h1 {
            color: #2c3e50;
        }
        .container {
            margin-top: 50px;
        }
        .form-control {
            border-radius: 0.25rem;
        }
        .btn-primary {
            background-color: #3498db;
            border: none;
        }
        .btn-primary:hover {
            background-color: #2980b9;
        }
        .btn-secondary {
            background-color: #95a5a6;
            border: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center my-4"><i class="fas fa-plus-circle"></i> Tambah Pekerjaan</h1>

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
                <label for="jenis_pekerjaan">Jenis Pekerjaan</label>
                <input type="text" class="form-control" id="jenis_pekerjaan" name="jenis_pekerjaan" required>
            </div>
            <div class="form-group">
                <label for="tipe_kerja">Tipe Kerja</label>
                <input type="text" class="form-control" id="tipe_kerja" name="tipe_kerja" required>
            </div>
            <div class="form-group">
                <label for="gaji">Gaji</label>
                <input type="number" class="form-control" id="gaji" name="gaji" required>
            </div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Tambah Pekerjaan</button>
            <a href="index.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Batal</a>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
