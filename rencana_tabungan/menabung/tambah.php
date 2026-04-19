<?php
include "../config/koneksi.php";
include "../layout/header.php";

if (!isset($_SESSION['user_id'])) {
    die("Harus login!");
}

$pesan = "";
$tabungan_id = $_GET['id'];

// PROSES SIMPAN
if (isset($_POST['nabung'])) {
    $nominal = $_POST['nominal'];

    // VALIDASI
    if ($nominal == "" || $nominal <= 0) {
        $pesan = " Nominal harus lebih dari 0!";
    } else {


        $cek = mysqli_query($conn, "
        SELECT target_nominal, 
        IFNULL(SUM(m.nominal),0) as total 
        FROM tabungan t
        LEFT JOIN menabung m ON t.id = m.tabungan_id
        WHERE t.id='$tabungan_id'
        ");

        $data = mysqli_fetch_assoc($cek);

        $total_baru = $data['total'] + $nominal;

  
        if ($total_baru > $data['target_nominal']) {
            $pesan = " Anda melebihi target tabungan!";
        } else {

            mysqli_query($conn, "
            INSERT INTO menabung (tabungan_id, nominal) 
            VALUES ('$tabungan_id','$nominal')
            ");

            $pesan = " Berhasil menabung!";
        }
    }
}
?>

<div class="container">

<div class="card">

<h2> Menabung</h2>

<!-- PESAN -->
<?php if ($pesan != "") { ?>
    <p style="color: <?= strpos($pesan, 'Berhasil') !== false ? 'green' : 'red' ?>;">
        <?= $pesan ?>
    </p>
<?php } ?>

<form method="POST">

    <input type="text" id="rupiah2" placeholder="Masukkan nominal" required>
    <input type="hidden" name="nominal" id="nominal_asli2">

    <button name="nabung">Simpan</button>

</form>

<br>
<a href="../home.php" class="btn btn-danger">⬅ Kembali</a>

<hr>

<h3> Riwayat Menabung</h3>

<?php
$riwayat = mysqli_query($conn, "
SELECT * FROM menabung 
WHERE tabungan_id='$tabungan_id'
ORDER BY id DESC
");

while ($r = mysqli_fetch_assoc($riwayat)) {
?>

<div style="margin-bottom:10px;">
    Rp <?= number_format($r['nominal'],0,',','.') ?>
</div>

<?php } ?>

</div>
</div>


<script>
const input = document.getElementById("rupiah2");
const asli = document.getElementById("nominal_asli2");

input.addEventListener("input", function () {
    let angka = this.value.replace(/[^0-9]/g, ""); // hanya angka

    asli.value = angka;

    let format = new Intl.NumberFormat("id-ID").format(angka);
    this.value = angka ? "Rp " + format : "";
});
</script>

<?php include "../layout/footer.php"; ?>