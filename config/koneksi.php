<?php
$host = "localhost";
$user = "root";
$pass = "root";
$db   = "lpk_cti";


$koneksi = mysqli_connect($host, $user, $pass, $db);

mysqli_set_charset($koneksi, "utf8");


if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

?>