<!doctype html>
<html lang="en" data-bs-theme="auto">
  <head>
    <script src="../projekweb/assets/js/color-modes.js"></script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.122.0">
    <title>Register · Bootstrap v5.3</title>

    <link href="../projekweb/assets/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
      body {
        background: linear-gradient(140deg, #6A9C89, #C4DAD2, #E9EFEC);
        height: 100vh;
        margin: 0;
        display: flex;
        align-items: center;
        justify-content: center;
      }
      .form-signin {
        padding: 10px;
        border-radius: 8px;
        box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
      }
    </style>
  </head>
  
  <body class="d-flex align-items-center py-4 bg-body-tertiary">
    <main class="form-signin w-100 m-auto">
      <form class="text-center">
        <div class="d-flex justify-content-center">
          <img class="mb-3" src="pic/lwork.png" alt="Logo" width="250" height="250">
        </div>


        <div class="form-floating mb-3">
          <input type="text" class="form-control" id="floatingName" placeholder="Full Name">
          <label for="floatingName">Full Name</label>
        </div>

        <div class="form-floating mb-3">
          <input type="email" class="form-control" id="floatingEmail" placeholder="name@example.com">
          <label for="floatingEmail">Email address</label>
        </div>

        <div class="form-floating mb-3">
          <input type="text" class="form-control" id="floatingUsername" placeholder="Username">
          <label for="floatingUsername">Username</label>
        </div>

        <div class="form-floating mb-3">
          <input type="password" class="form-control" id="floatingPassword" placeholder="Password">
          <label for="floatingPassword">Password</label>
        </div>

        <button class="btn btn-primary w-100 py-2" type="submit">Register</button>

        <a class="mt-3 mb-2 nav-link" href="login.php">Sudah punya akun? Login</a> 
      </form>
    </main>

    <script src="../projekweb/assets/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
