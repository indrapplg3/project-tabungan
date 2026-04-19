<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>TabunganKu</title>

  
    <link href="https://fonts.googleapis.com/css2?family=Didact+Gothic&display=swap" rel="stylesheet">

  
    <link rel="stylesheet" href="/rencana_tabungan/assets/style.css">

   
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">


    <script src="/rencana_tabungan/assets/chart.js"></script>
</head>
<body>

<?php if (isset($_SESSION['user_id'])) { ?>


<div class="navbar">
    <div class="logo">💰 TabunganKu</div>
    <div class="menu-icon" onclick="toggleMenu()">
         &#9776;
    </div>
</div>


<div id="sidebar" class="sidebar">
    <div class="sidebar-header">
        <h3>Menu</h3>
        <span onclick="toggleMenu()">✖</span>
    </div>

    <a href="/rencana_tabungan/home.php">Dashboard</a>
    <a href="/rencana_tabungan/riwayat.php">Riwayat</a>
    <a href="/rencana_tabungan/profile.php">Profile</a>
    <a href="/rencana_tabungan/auth/logout.php">Logout</a>
</div>


<div id="overlay" class="overlay" onclick="toggleMenu()"></div>


<script>
function toggleMenu() {
    let sidebar = document.getElementById("sidebar");
    let overlay = document.getElementById("overlay");

    sidebar.classList.toggle("active");
    overlay.classList.toggle("active");
}
</script>

<?php } ?>