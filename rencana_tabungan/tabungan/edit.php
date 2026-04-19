<?php
include "../config/koneksi.php";
include "../layout/header.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit;
}

$id = $_GET['id'];
$user_id = $_SESSION['user_id'];

$data = mysqli_query($conn, "
SELECT * FROM tabungan 
WHERE id='$id' AND user_id='$user_id'
");
$d = mysqli_fetch_assoc($data);

$notif = "";

if (isset($_POST['update'])) {

    $judul = $_POST['judul'];
    $target = $_POST['target_nominal'];
    $tanggal = $_POST['target_tanggal'];


    if ($tanggal < date("Y-m-d")) {
        $notif = "<div class='notif error'>Tanggal tidak boleh lewat!</div>";
    } else {

    
        if ($_FILES['foto']['name'] != "") {

            $nama_file = time() . "_" . $_FILES['foto']['name'];
            move_uploaded_file($_FILES['foto']['tmp_name'], "../upload/" . $nama_file);

            $update = mysqli_query($conn, "
            UPDATE tabungan 
            SET judul='$judul',
                target_nominal='$target',
                target_tanggal='$tanggal',
                foto='$nama_file'
            WHERE id='$id' AND user_id='$user_id'
            ");

        } else {

            $update = mysqli_query($conn, "
            UPDATE tabungan 
            SET judul='$judul',
                target_nominal='$target',
                target_tanggal='$tanggal'
            WHERE id='$id' AND user_id='$user_id'
            ");
        }

        if ($update) {
            $notif = "<div class='notif success'>Berhasil diupdate!</div>";
        } else {
            $notif = "<div class='notif error'>Gagal update!</div>";
        }
    }
}
?>

<div class="container">

<div class="form-card">
    <h2>Edit Tabungan</h2>

    <?= $notif ?>

    <form method="POST" enctype="multipart/form-data">

        <input type="text" name="judul" value="<?= $d['judul'] ?>" required>

        <input type="number" name="target_nominal" value="<?= $d['target_nominal'] ?>" required>

        <input type="date" name="target_tanggal" value="<?= $d['target_tanggal'] ?>" required>

        <p>Foto sekarang:</p>
        <img src="../upload/<?= $d['foto'] ?>" width="100" style="border-radius:10px;"><br><br>

        <input type="file" name="foto">

        <button name="update">Update</button>

    </form>
</div>

</div>

<?php include "../layout/footer.php"; ?>