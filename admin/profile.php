<?php
include('db.php');
session_start();
// Ambil ID perusahaan dari URL
$company_id = $_GET['id'] ?? null;

if ($company_id) {
    // Query untuk mendapatkan data perusahaan
    $sql = "SELECT * FROM companies WHERE company_id = $company_id";
    $company_result = $conn->query($sql);
    $company = $company_result->fetch_assoc();

    // Query untuk mendapatkan lowongan pekerjaan dari perusahaan tersebut
    $sql_jobs = "SELECT * FROM jobs WHERE company_id = $company_id";
    $jobs_result = $conn->query($sql_jobs);
}

// Logic untuk mengupdate data perusahaan
if (isset($_POST['update_company'])) {
    $company_name = $_POST['company_name'];
    $company_description = $_POST['company_description'];
    $contact_email = $_POST['contact_email'];

    $sql = "UPDATE companies SET company_name='$company_name', company_description='$company_description', contact_email='$contact_email' WHERE company_id=$company_id";

    if ($conn->query($sql) === TRUE) {
        header("Location: data-perusahaan.php?id=$company_id");
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <title>Company Profile</title>
</head>
<body>
    <div class="container mt-4">
        <h2>Profil Perusahaan</h2>

        <!-- Detail Perusahaan -->
        <?php if ($company): ?>
            <form method="POST" action="">
                <div class="form-group mb-3">
                    <label>Nama Perusahaan</label>
                    <input type="text" name="company_name" class="form-control" value="<?php echo htmlspecialchars($company['company_name']); ?>" required>
                </div>
                <div class="form-group mb-3">
                    <label>Deskripsi Perusahaan</label>
                    <textarea name="company_description" class="form-control" required><?php echo htmlspecialchars($company['company_description']); ?></textarea>
                </div>
                <div class="form-group mb-3">
                    <label>Email Kontak</label>
                    <input type="email" name="contact_email" class="form-control" value="<?php echo htmlspecialchars($company['contact_email']); ?>" required>
                </div>
                <button type="submit" name="update_company" class="btn btn-primary">Update Perusahaan</button>
            </form>
        <?php else: ?>
            <p>Perusahaan tidak ditemukan.</p>
        <?php endif; ?>

        <hr>

        <!-- Daftar Lowongan Pekerjaan -->
        <h3>Lowongan Pekerjaan</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Job Title</th>
                    <th>Location</th>
                    <th>Salary Range</th>
                    <th>Job Type</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($jobs_result->num_rows > 0): ?>
                    <?php while ($job = $jobs_result->fetch_assoc()): ?>
                        <tr>
                            <form method="POST" action="">
                                <input type="hidden" name="job_id" value="<?php echo $job['job_id']; ?>">
                                <td><input type="text" name="job_title" class="form-control" value="<?php echo htmlspecialchars($job['job_title']); ?>" required></td>
                                <td><input type="text" name="location" class="form-control" value="<?php echo htmlspecialchars($job['location']); ?>" required></td>
                                <td><input type="text" name="salary_range" class="form-control" value="<?php echo htmlspecialchars($job['salary_range']); ?>" required></td>
                                <td><input type="text" name="job_type" class="form-control" value="<?php echo htmlspecialchars($job['job_type']); ?>" required></td>
                                </td>
                            </form>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="5">Tidak ada lowongan pekerjaan.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
<!-- Button Back -->
<a href="data-perusahaan.php?id=<?php echo $company_id; ?>" class="btn btn-secondary mt-3">Back to Profile</a>
                </div>

    <script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
