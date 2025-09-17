<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="sidebar">
    <h3>Dashboard Admin </h3>
    <a href="instruktur.php">Kelola Instruktur</a>
    <a href="kegiatan.php">Kelola Kegiatan</a>
    <a href="informasi.php">Kelola Informasi</a>
    <a href="logout.php">Logout</a>
</div>
<div class="content">
    <h1>Selamat datang, <?php echo $_SESSION['admin']; ?></h1>
    <p>Pilih menu di sidebar untuk mengelola data.</p>
</div>
</body>
</html>