<?php
session_start();
include "../config/koneksi.php";

$email    = $_POST['email'];
$password = md5($_POST['password']);

// CEK USER
$query = mysqli_query($conn, "
SELECT * FROM users 
WHERE email='$email' 
AND password='$password'
");

$data = mysqli_fetch_assoc($query);

if ($data) {

    $_SESSION['user_id'] = $data['id'];
    $_SESSION['nama']    = $data['username']; // tetap ambil nama

    header("Location: ../home.php");
    exit;

} else {
    header("Location: ../index.php?error=1");
}