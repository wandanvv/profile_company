<?php
session_start();
include '../config/koneksi.php';
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'];
$q  = mysqli_query($koneksi, "SELECT * FROM data_instruktur WHERE id_instruktur='$id'");
$data = mysqli_fetch_assoc($q);

if (!$data) {
    die("Data tidak ditemukan!");
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $nama      = $_POST['nama'];
    $bidang    = $_POST['bidang'];
    $deskripsi = $_POST['deskripsi'];

    $foto = $data['foto']; // default lama
    if (!empty($_FILES['foto']['name'])) {
        $fotoBaru = time() . "_" . basename($_FILES['foto']['name']);
        move_uploaded_file($_FILES['foto']['tmp_name'], "../assets/uploads/" . $fotoBaru);
        $foto = $fotoBaru;
    }

    $sql = "UPDATE data_instruktur SET nama='$nama', bidang='$bidang', deskripsi='$deskripsi', foto='$foto' WHERE id_instruktur='$id'";
    mysqli_query($koneksi, $sql);

    header("Location: instruktur.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Instruktur</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="content">
    <h1>Edit Instruktur</h1>
    <form method="post" enctype="multipart/form-data">
        <label>Nama:</label><br>
        <input type="text" name="nama" value="<?= $data['nama'] ?>" required><br><br>

        <label>Bidang:</label><br>
        <input type="text" name="bidang" value="<?= $data['bidang'] ?>" required><br><br>

        <label>Deskripsi:</label><br>
        <textarea name="deskripsi" rows="5"><?= $data['deskripsi'] ?></textarea><br><br>

        <label>Foto:</label><br>
        <input type="file" name="foto"><br>
        <?php if($data['foto']): ?>
            <img src="../assets/uploads/<?= $data['foto'] ?>" width="120"><br><br>
        <?php endif; ?>

        <button type="submit">Update</button>
        <a href="instruktur.php">Kembali</a>
    </form>
</div>
</body>
</html>