<?php
include "../config/koneksi.php";

$notif = "";

if (isset($_POST['register'])) {

    $username = $_POST['username'];
    $email    = $_POST['email'];
    $password = md5($_POST['password']);

    $cek = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");

    if (mysqli_num_rows($cek) > 0) {
        $notif = "<div class='notif error'>Email sudah digunakan!</div>";
    } else {

        $simpan = mysqli_query($conn, "
        INSERT INTO users (username, email, password)
        VALUES ('$username','$email','$password')
        ");

        if ($simpan) {
            $notif = "<div class='notif success'>Registrasi berhasil! Silakan login</div>";
        } else {
            $notif = "<div class='notif error'>Registrasi gagal!</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <?= $notif ?>

    <!-- FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Didact+Gothic&display=swap" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="/rencana_tabungan/assets/style.css">
</head>
<body>

<div class="auth-container">
    <div class="auth-card">

        <h2>Register</h2>

        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>

            <input type="email" name="email" placeholder="Email" required>

            <input type="password" name="password" placeholder="Password" required>

            <button name="register">Daftar</button>
        </form>

        <p style="margin-top:10px;">
            Sudah punya akun? 
            <a href="../index.php">Login</a>
        </p>

    </div>
</div>

</body>
</html>