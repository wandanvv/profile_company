<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $result = mysqli_query($koneksi, "SELECT foto FROM data_instruktur WHERE id_instruktur=$id");
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        $foto = $row['foto'];
        $delete = mysqli_query($koneksi, "DELETE FROM data_instruktur WHERE id_instruktur=$id");

        if ($delete) {
            if (!empty($foto) && file_exists("../assets/uploads/" . $foto)) {
                unlink("../assets/uploads/" . $foto);
            }
            header("Location: instruktur.php?msg=deleted");
            exit;
        } else {
            echo "Gagal menghapus data: " . mysqli_error($koneksi);
        }
    } else {
        echo "Data tidak ditemukan!";
    }
} else {
    echo "ID tidak valid!";
}
?>
