<?php
// Mulai session
session_start();

// Hapus semua session
session_unset();

// Hancurkan session
session_destroy();

// Arahkan ke halaman login setelah logout
header("Location: ../user/indexx.php");
exit();
?>