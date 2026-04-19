<?php
include "../config/koneksi.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    exit;
}

$id = $_GET['id'];
$user_id = $_SESSION['user_id'];

$query = mysqli_query($conn, "
UPDATE tabungan 
SET status='selesai', updated_at=NOW()
WHERE id='$id' AND user_id='$user_id'
");

if ($query) {
    echo "success";
} else {
    echo "error";
}
?>