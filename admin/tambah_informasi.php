<?php
session_start();
include '../config/koneksi.php';
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $judul   = $_POST['judul'];
    $isi     = $_POST['isi'];
    $tanggal = $_POST['tanggal'];

    $gambar = "";
    if (!empty($_FILES['gambar']['name'])) {
        $gambar = time() . "_" . basename($_FILES['gambar']['name']);
        move_uploaded_file($_FILES['gambar']['tmp_name'], "../assets/uploads/" . $gambar);
    }

    $sql = "INSERT INTO informasi (judul, isi, tanggal, gambar) VALUES ('$judul','$isi','$tanggal','$gambar')";
    mysqli_query($koneksi, $sql);
    header("Location: informasi.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tambah Informasi</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="content">
    <h1>Tambah Informasi</h1>
    <form method="post" enctype="multipart/form-data">
        <label>Judul:</label><br>
        <input type="text" name="judul" required><br><br>

        <label>Isi:</label><br>
        <textarea name="isi" rows="5"></textarea><br><br>

        <label>Tanggal:</label><br>
        <input type="date" name="tanggal" required><br><br>

        <label>Gambar:</label><br>
        <input type="file" name="gambar"><br><br>

        <button type="submit">Simpan</button>
        <a href="informasi.php">Kembali</a>
    </form>
</div>
</body>
</html>