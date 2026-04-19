<?php
include "../config/koneksi.php";

$id = $_GET['id'];


$cek = mysqli_query($conn, "SELECT status FROM tabungan WHERE id='$id'");
$data = mysqli_fetch_assoc($cek);

if ($data['status'] == 'selesai') {
    echo "<script>alert('Tabungan selesai tidak boleh dihapus!'); window.location='../home.php';</script>";
    exit;
}


mysqli_query($conn, "DELETE FROM menabung WHERE tabungan_id='$id'");


mysqli_query($conn, "DELETE FROM tabungan WHERE id='$id'");

header("Location: ../home.php");