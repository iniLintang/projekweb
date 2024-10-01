<?php
session_start();
include 'koneksi.php'; // Connect to the database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the user is an admin
    $admin_query = "SELECT * FROM admin WHERE username = ?";
    $stmt = $db->prepare($admin_query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Admin found, now verify password (without hashing for now)
        $admin = $result->fetch_assoc();
        if ($password == $admin['password']) { // Plain text comparison
            $_SESSION['admin_id'] = $admin['admin_id'];
            header('Location: html/index.php');
            eAxit();
        } else {
            $error = "Invalid password for admin.";
        }
    } else {
        // Close previous statement
        $stmt->close();

        // Check if the user is a regular user
        $user_query = "SELECT * FROM users WHERE username = ?";
        $stmt = $db->prepare($user_query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if ($password == $user['password']) { // Plain text comparison
                $_SESSION['user_id'] = $user['user_id'];
                header('Location: index.php');
                exit();
            } else {
                $error = "Invalid password for user.";
            }
        } else {
            $error = "User not found.";
        }
    }
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - LookWork</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
    <div class="container mt-5">
      <h2 class="text-center">Login to LookWork</h2>
      
      <?php if (isset($error)): ?>
          <div class="alert alert-danger" role="alert">
              <?php echo $error; ?>
          </div>
      <?php endif; ?>
      
      <form method="POST" action="login.php">
        <div class="form-floating mb-3">
          <input type="text" name="username" class="form-control" id="username" placeholder="Username" required>
          <label for="username">Username</label>
        </div>
        <div class="form-floating mb-3">
          <input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
          <label for="password">Password</label>
        </div>
        <button class="btn btn-primary w-100 py-2" type="submit">Login</button>
      </form>
      <button href="on-click register.php">register</button>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
