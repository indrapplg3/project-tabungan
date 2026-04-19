<?php
include "../config/koneksi.php";
include "../layout/header.php";

if (!isset($_SESSION['user_id'])) {
    die("Harus login!");
}

$pesan = "";

if (isset($_POST['simpan'])) {
    $user_id = $_SESSION['user_id'];
    $judul = $_POST['judul'];
    $target = $_POST['target_nominal'];
    $tanggal_target = $_POST['target_tanggal'];
    $tanggal_mulai = $_POST['tanggal_mulai'];

    // VALIDASI WAJIB
    if ($judul == "" || $target == "" || $tanggal_target == "" || $tanggal_mulai == "") {
        $pesan = "⚠️ Semua field wajib diisi!";
    } elseif ($_FILES['foto']['name'] == "") {
        $pesan = "⚠️ Foto wajib diupload!";
    } else {

        $today = date("Y-m-d");

        // VALIDASI TANGGAL
        if ($tanggal_target < $today) {
            $pesan = "⚠️ Tanggal target tidak boleh di masa lalu!";
        } elseif ($tanggal_mulai < $today) {
            $pesan = "⚠️ Tanggal mulai tidak boleh di masa lalu!";
        } elseif ($tanggal_mulai > $tanggal_target) {
            $pesan = "⚠️ Tanggal mulai tidak boleh melebihi target!";
        } else {

            // UPLOAD FOTO
            $nama_file = time() . "_" . $_FILES['foto']['name'];
            $tmp = $_FILES['foto']['tmp_name'];
            $folder = "../upload/";

            if (!is_dir($folder)) {
                mkdir($folder);
            }

            move_uploaded_file($tmp, $folder . $nama_file);

            // HITUNG RATA-RATA
            $start = new DateTime($tanggal_mulai);
            $end = new DateTime($tanggal_target);
            $selisih = $start->diff($end)->days;

            $rata = ($selisih > 0) ? $target / $selisih : $target;

            // INSERT
            $query = mysqli_query($conn, "
            INSERT INTO tabungan 
            (user_id, judul, foto, target_nominal, target_tanggal, tanggal_mulai, status) 
            VALUES 
            ('$user_id','$judul','$nama_file','$target','$tanggal_target','$tanggal_mulai','belum')
            ");

            if ($query) {
                $pesan = "✅ Tabungan berhasil ditambahkan! Rata-rata/hari: Rp " . number_format($rata,0,',','.');
            } else {
                $pesan = "Error: " . mysqli_error($conn);
            }
        }
    }
}
?>

<div class="container">

<div class="card">

<h2>✨ Buat Tabungan Baru</h2>

<!-- PESAN -->
<?php if ($pesan != "") { ?>
    <p style="color: <?= strpos($pesan, 'berhasil') !== false ? 'green' : 'red' ?>;">
        <?= $pesan ?>
    </p>
<?php } ?>

<form method="POST" enctype="multipart/form-data">

    <input type="text" name="judul" placeholder="Nama Tabungan" required>

    <!-- INPUT RUPIAH -->
    <input type="text" id="rupiah" placeholder="Target Uang" required>
    <input type="hidden" name="target_nominal" id="nominal_asli">

    <label>📅 Tanggal Mulai</label>
    <input type="date" name="tanggal_mulai" min="<?= date('Y-m-d') ?>" required>

    <label>🎯 Target Tanggal</label>
    <input type="date" name="target_tanggal" min="<?= date('Y-m-d') ?>" required>

    <!-- WAJIB FOTO -->
    <input type="file" name="foto" accept="image/*" required>

    <button name="simpan">🚀 Simpan Tabungan</button>

</form>

<br>
<a href="../home.php" class="btn btn-danger">⬅ Kembali</a>

</div>
</div>


<script>
const inputRupiah = document.getElementById("rupiah");
const inputAsli = document.getElementById("nominal_asli");

inputRupiah.addEventListener("input", function () {
    let angka = this.value.replace(/[^0-9]/g, "");
    inputAsli.value = angka;

    let format = new Intl.NumberFormat("id-ID").format(angka);
    this.value = angka ? "Rp " + format : "";
});
</script>

<?php include "../layout/footer.php"; ?>