<?php
include "config/koneksi.php";
include "layout/header.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$user = mysqli_fetch_assoc(mysqli_query($conn, "
SELECT * FROM users WHERE id='$user_id'
"));


$total_uang = mysqli_fetch_assoc(mysqli_query($conn, "
SELECT SUM(nominal) as total FROM menabung
JOIN tabungan ON menabung.tabungan_id = tabungan.id
WHERE tabungan.user_id='$user_id'
"));

$total_tabungan = mysqli_fetch_assoc(mysqli_query($conn, "
SELECT COUNT(*) as jumlah FROM tabungan WHERE user_id='$user_id'
"));

$total_selesai = mysqli_fetch_assoc(mysqli_query($conn, "
SELECT COUNT(*) as jumlah FROM tabungan 
WHERE user_id='$user_id' AND status='selesai'
"));

$data_chart = mysqli_query($conn, "
SELECT judul, target_nominal FROM tabungan 
WHERE user_id='$user_id'
");

$judul = [];
$nominal = [];

while ($row = mysqli_fetch_assoc($data_chart)) {
    $judul[] = $row['judul'];
    $nominal[] = $row['target_nominal'];
}
?>

<div class="container">

<h2> PROFILE</h2>

<div class="profile-card">
    <div class="profile-avatar">
        
    </div>

    <div class="profile-info">
        <h3><?= $user['username'] ?></h3>
        <p><?= $user['email'] ?></p>
    </div>
</div>

<div class="stats">
    <div class="stat-box">
        <h3><?= $total_tabungan['jumlah'] ?></h3>
        <p>Total Tabungan</p>
    </div>

    <div class="stat-box">
        <h3><?= $total_selesai['jumlah'] ?></h3>
        <p>Selesai</p>
    </div>

    <div class="stat-box">
        <h3>Rp <?= number_format($total_uang['total'] ?? 0,0,',','.') ?></h3>
        <p>Total Uang</p>
    </div>
</div>


<div class="card">
    <h3> Grafik Tabungan</h3>
    <canvas id="chartTabungan"></canvas>
</div>

</div>

<script>
const ctx = document.getElementById('chartTabungan');

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?= json_encode($judul) ?>,
        datasets: [{
            label: 'Target Tabungan',
            data: <?= json_encode($nominal) ?>,
        }]
    }
});
</script>

<?php include "layout/footer.php"; ?>