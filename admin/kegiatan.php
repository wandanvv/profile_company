<?php
session_start();
include '../config/koneksi.php';
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

// hapus data
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM kegiatan WHERE id_kegiatan='$id'");
    header("Location: kegiatan.php");
    exit;
}

$result = mysqli_query($koneksi, "SELECT * FROM kegiatan ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Kelola Kegiatan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="sidebar">
    <h2>Dashboard Admin</h2>
    <a href="instruktur.php">Kelola Instruktur</a>
    <a href="kegiatan.php">Kelola Kegiatan</a>
    <a href="informasi.php">Kelola Informasi</a>
    <a href="logout.php">Logout</a>
</div>
<div class="content">
    <h1>Data Kegiatan</h1>
    <a href="tambah_kegiatan.php">+ Tambah Kegiatan</a><br><br>
    <table border="1" cellpadding="8" cellspacing="0">
        <tr><th>No</th><th>Judul</th><th>Tanggal</th><th>Gambar</th><th>Aksi</th></tr>
        <?php $no=1; while($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= $row['judul'] ?></td>
            <td><?= $row['tanggal'] ?></td>
            <td><img src="../assets/uploads/<?= $row['gambar'] ?>" width="100"></td>
            <td>
                <a href="edit_kegiatan.php?id=<?= $row['id_kegiatan'] ?>">Edit</a> |
                <a href="?hapus=<?= $row['id_kegiatan'] ?>" onclick="return confirm('Hapus data?')">Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>
</body>
</html>