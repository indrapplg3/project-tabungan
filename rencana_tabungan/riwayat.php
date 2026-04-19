<?php
include "config/koneksi.php";
include "layout/header.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$total_riwayat = mysqli_fetch_assoc(mysqli_query($conn, "
SELECT SUM(target_nominal) as total 
FROM tabungan 
WHERE user_id='$user_id' AND status='selesai'
"));

$query = mysqli_query($conn, "
SELECT * FROM tabungan 
WHERE user_id='$user_id' AND status='selesai'
ORDER BY updated_at DESC
");
?>

<div class="container">

<h2> Riwayat Tabungan</h2>

<div class="card highlight">
    <h3>Total Uang Terkumpul</h3>
    <p class="total-uang">
        Rp <?= number_format($total_riwayat['total'] ?? 0,0,',','.') ?>
    </p>
</div>

<?php if (mysqli_num_rows($query) == 0) { ?>
    <p>Belum ada tabungan selesai</p>
<?php } ?>

<div class="riwayat-list">

<?php while ($row = mysqli_fetch_assoc($query)) { ?>

<?php
$tanggal = $row['updated_at'] 
    ? date("d M Y", strtotime($row['updated_at'])) 
    : "-";
?>

<div class="riwayat-card fade-in">

    <img src="upload/<?= $row['foto'] ?>" 
         class="riwayat-img"
         onclick="zoomGambar(this.src)">

    <div class="riwayat-info">
        <h3><?= $row['judul'] ?></h3>

        <p>Target: Rp <?= number_format($row['target_nominal'],0,',','.') ?></p>

        <p class="tanggal">
             Selesai: <?= $tanggal ?>
        </p>
    </div>

</div>

<?php } ?>

</div>

</div>

<div id="imgModal" class="img-modal">
    <span onclick="tutupZoom()">✖</span>
    <img id="imgPreview">
</div>

<script>
function zoomGambar(src) {
    document.getElementById("imgModal").style.display = "flex";
    document.getElementById("imgPreview").src = src;
}

function tutupZoom() {
    document.getElementById("imgModal").style.display = "none";
}
</script>

<?php include "layout/footer.php"; ?>