<?php
include('db.php');
session_start();
// Mengambil data berdasarkan ID
if (isset($_GET['id'])) {
    $job_id = $_GET['id'];
    $sql = "SELECT * FROM jobs WHERE job_id = $job_id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
}

// UPDATE Logic (Mengupdate data pekerjaan)
if (isset($_POST['update'])) {
    $company_id = $_POST['company_id'];
    $job_title = $_POST['job_title'];
    $job_description = $_POST['job_description'];
    $location = $_POST['location'];
    $salary_range = $_POST['salary_range'];
    $job_type = $_POST['job_type'];

    $sql = "UPDATE jobs 
            SET company_id='$company_id', job_title='$job_title', job_description='$job_description', location='$location', salary_range='$salary_range', job_type='$job_type' 
            WHERE job_id = $job_id";

    if ($conn->query($sql) === TRUE) {
        header("Location: data-pekerjaan.php");
        exit;
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Lowongan Kerja</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            background: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .form-group label {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center">Edit Data Lowongan Kerja</h2>

        <!-- Form Edit Data -->
        <form method="POST" action="">
            <div class="form-group">
                <label>Company ID</label>
                <input type="number" name="company_id" class="form-control" value="<?php echo $row['company_id']; ?>" required>
            </div>
            <div class="form-group">
                <label>Job Title</label>
                <input type="text" name="job_title" class="form-control" value="<?php echo $row['job_title']; ?>" required>
            </div>
            <div class="form-group">
                <label>Job Description</label>
                <textarea name="job_description" class="form-control" required><?php echo $row['job_description']; ?></textarea>
            </div>
            <div class="form-group">
                <label>Location</label>
                <input type="text" name="location" class="form-control" value="<?php echo $row['location']; ?>" required>
            </div>
            <div class="form-group">
                <label>Salary Range</label>
                <input type="text" name="salary_range" class="form-control" value="<?php echo $row['salary_range']; ?>" required>
            </div>
            <div class="form-group">
                <label>Job Type</label>
                <select name="job_type" class="form-control" required>
                    <option value="Full-Time" <?php if($row['job_type'] == 'Full-Time') echo 'selected'; ?>>Full-Time</option>
                    <option value="Part-Time" <?php if($row['job_type'] == 'Part-Time') echo 'selected'; ?>>Part-Time</option>
                    <option value="Contract" <?php if($row['job_type'] == 'Contract') echo 'selected'; ?>>Contract</option>
                    <option value="Internship" <?php if($row['job_type'] == 'Internship') echo 'selected'; ?>>Internship</option>
                </select>
            </div>
            <button type="submit" name="update" class="btn btn-primary btn-block">Update Pekerjaan</button>
        </form>
    </div>
</body>

</html>
