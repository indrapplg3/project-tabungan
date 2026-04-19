<?php
$conn = mysqli_connect("localhost", "root", "", "tabungan_db");

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// cegah double session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>