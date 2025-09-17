<?php
session_start();
include '../config/koneksi.php';
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'];
$q  = mysqli_query($koneksi, "SELECT * FROM kegiatan WHERE id_kegiatan='$id'");
$data = mysqli_fetch_assoc($q);

if (!$data) {
    die("Data tidak ditemukan!");
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $judul   = $_POST['judul'];
    $isi     = $_POST['isi'];
    $tanggal = $_POST['tanggal'];

    $gambar = $data['gambar'];
    if (!empty($_FILES['gambar']['name'])) {
        $gambarBaru = time() . "_" . basename($_FILES['gambar']['name']);
        move_uploaded_file($_FILES['gambar']['tmp_name'], "../assets/uploads/" . $gambarBaru);
        $gambar = $gambarBaru;
    }

    $sql = "UPDATE kegiatan SET judul='$judul', isi='$isi', tanggal='$tanggal', gambar='$gambar' WHERE id_kegiatan='$id'";
    mysqli_query($koneksi, $sql);
    header("Location: kegiatan.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Kegiatan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="content">
    <h1>Edit Kegiatan</h1>
    <form method="post" enctype="multipart/form-data">
        <label>Judul:</label><br>
        <input type="text" name="judul" value="<?= $data['judul'] ?>" required><br><br>

        <label>Isi:</label><br>
        <textarea name="isi" rows="5"><?= $data['isi'] ?></textarea><br><br>

        <label>Tanggal:</label><br>
        <input type="date" name="tanggal" value="<?= $data['tanggal'] ?>" required><br><br>

        <label>Gambar:</label><br>
        <input type="file" name="gambar"><br>
        <?php if($data['gambar']): ?>
            <img src="../assets/uploads/<?= $data['gambar'] ?>" width="120"><br><br>
        <?php endif; ?>

        <button type="submit">Update</button>
        <a href="kegiatan.php">Kembali</a>
    </form>
</div>
</body>
</html>