<?php
include "config/koneksi.php";
include "layout/header.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// STATISTIK
$total_uang = mysqli_query($conn, "
SELECT SUM(nominal) as total FROM menabung 
JOIN tabungan ON menabung.tabungan_id = tabungan.id 
WHERE tabungan.user_id='$user_id'
");
$tu = mysqli_fetch_assoc($total_uang);

$total_tabungan = mysqli_query($conn, "
SELECT COUNT(*) as jumlah 
FROM tabungan 
WHERE user_id='$user_id' AND status!='selesai'
");
$tt = mysqli_fetch_assoc($total_tabungan);

// DATA TABUNGAN
$query = mysqli_query($conn, "
SELECT t.*, IFNULL(SUM(m.nominal),0) as total
FROM tabungan t
LEFT JOIN menabung m ON t.id = m.tabungan_id
WHERE t.user_id='$user_id' AND t.status!='selesai'
GROUP BY t.id
");
?>

<div class="container">

<h2>Dashboard</h2>

<!-- STATISTIK -->
<div class="stats">
    <div class="stat-box">
        <h3><?= $tt['jumlah'] ?></h3>
        <p>Total Tabungan</p>
    </div>

    <div class="stat-box">
        <h3>Rp <?= number_format($tu['total'] ?? 0,0,',','.') ?></h3>
        <p>Total Uang</p>
    </div>
</div>

<!-- GRID -->
<div class="grid-tabungan">

<?php while ($row = mysqli_fetch_assoc($query)) { ?>

<?php
$target = $row['target_nominal'];
$total = $row['total'];

$persen = ($target > 0) ? ($total / $target) * 100 : 0;
if ($persen > 100) $persen = 100;

// RATA-RATA
$tanggal_mulai = strtotime($row['tanggal_mulai']);
$hari_ini = time();
$selisih_hari = max(1, floor(($hari_ini - $tanggal_mulai) / 86400));
$rata_harian = $total / $selisih_hari;
?>

<div class="tabungan-card" id="card-<?= $row['id'] ?>">

    <img src="upload/<?= $row['foto'] ?>" class="img-tabungan">

    <h3><?= $row['judul'] ?></h3>

    <p class="uang">
        Rp <?= number_format($total,0,',','.') ?> / 
        <?= number_format($target,0,',','.') ?>
    </p>

    <!-- PROGRESS -->
    <div class="progress">
        <div class="progress-bar" style="width: <?= $persen ?>%">
            <?= round($persen) ?>%
        </div>
    </div>

    <!-- RATA -->
    <p class="rata">
        Rata-rata: Rp <?= number_format($rata_harian,0,',','.') ?>/hari
    </p>

    <!-- BUTTON -->
    <div class="btn-group">

        <?php if ($persen >= 100) { ?>
            <button class="btn btn-success" onclick="konfirmasiSelesai(<?= $row['id'] ?>)">
                Selesai
            </button>
        <?php } else { ?>
            <a href="menabung/tambah.php?id=<?= $row['id'] ?>" class="btn btn-primary">
                Menabung
            </a>
        <?php } ?>

        <a href="tabungan/edit.php?id=<?= $row['id'] ?>" class="btn btn-warning">Edit</a>

        <a href="tabungan/hapus.php?id=<?= $row['id'] ?>" 
           class="btn btn-danger"
           onclick="return confirm('Yakin hapus?')">
           Hapus
        </a>

    </div>

</div>

<?php } ?>

</div>

</div>

<!-- FLOAT -->
<a href="tabungan/tambah.php" class="floating-btn">+</a>

<!-- MODAL -->
<div id="modalSelesai" class="modal">
    <div class="modal-content">
        <h3>🎉 Tabungan Selesai!</h3>
        <p>Yakin mau menyelesaikan tabungan ini?</p>

        <button onclick="lanjutSelesai()">OK</button>
        <button onclick="tutupModal()">Batal</button>
    </div>
</div>

<!-- SCRIPT -->
<script>
let idSelesai = null;

function konfirmasiSelesai(id) {
    idSelesai = id;
    document.getElementById("modalSelesai").style.display = "flex";
}

function lanjutSelesai() {
    if (!idSelesai) return;

    fetch("tabungan/selesai.php?id=" + idSelesai)
    .then(res => res.text())
    .then(data => {
        if (data.trim() === "success") {

            document.getElementById("modalSelesai").style.display = "none";

            let card = document.getElementById("card-" + idSelesai);
            if (card) card.remove();

        } else {
            alert("Gagal menyelesaikan tabungan!");
        }
    });
}

function tutupModal() {
    document.getElementById("modalSelesai").style.display = "none";
}
</script>

<?php include "layout/footer.php"; ?>