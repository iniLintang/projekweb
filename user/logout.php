<?php

session_start();
session_destroy(); // Hapus semua session
header("Location: ../user/indexx.php"); // Redirect ke halaman login setelah logout
exit();

?>
