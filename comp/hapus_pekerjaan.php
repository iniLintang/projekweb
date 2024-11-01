<?php
include 'db_connect.php';

if (isset($_GET['id_pekerjaan'])) {
    $id_pekerjaan = $_GET['id_pekerjaan'];

    $query = "DELETE FROM pekerjaan WHERE id_pekerjaan = $id_pekerjaan";
    
    if (mysqli_query($conn, $query)) {
        header('Location: index.php');
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
