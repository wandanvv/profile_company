<?php
session_start();
include '../config/koneksi.php';

// Fungsi clean_input jika belum ada
if (!function_exists('clean_input')) {
    function clean_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}

// Cek session admin
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

// Variabel untuk pesan
$message = '';
$message_type = '';

// Proses hapus data
if (isset($_GET['hapus']) && isset($_GET['id'])) {
    $id = clean_input($_GET['id']);
    
    // Ambil data foto untuk dihapus
    $get_foto = mysqli_query($koneksi, "SELECT foto FROM data_instruktur WHERE id_instruktur = '$id'");
    if ($get_foto && mysqli_num_rows($get_foto) > 0) {
        $foto_data = mysqli_fetch_assoc($get_foto);
        
        // Hapus file foto dari kedua lokasi
        if (!empty($foto_data['foto'])) {
            // Path admin
            $admin_foto_path = '../assets/uploads/' . $foto_data['foto'];
            if (file_exists($admin_foto_path)) {
                unlink($admin_foto_path);
            }
            
            // Path public (jika ada duplikat)
            $public_foto_path = '../../assets/uploads/' . $foto_data['foto'];
            if (file_exists($public_foto_path)) {
                unlink($public_foto_path);
            }
        }
    }
    
    // Hapus data dari database
    $delete = mysqli_query($koneksi, "DELETE FROM data_instruktur WHERE id_instruktur = '$id'");
    
    if ($delete) {
        $message = 'Data instruktur berhasil dihapus!';
        $message_type = 'success';
    } else {
        $message = 'Gagal menghapus data: ' . mysqli_error($koneksi);
        $message_type = 'error';
    }
}

// Ambil data instruktur
$q = mysqli_query($koneksi, "SELECT * FROM data_instruktur ORDER BY created_at DESC");
if (!$q) {
    $message = 'Error mengambil data: ' . mysqli_error($koneksi);
    $message_type = 'error';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Instruktur - Admin LPK CTI</title>
    <style>
        /* Basic styling untuk admin */
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; background: #f5f5f5; }
        .container { max-width: 1200px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { color: #333; border-bottom: 2px solid #007bff; padding-bottom: 10px; }
        .alert { padding: 15px; margin: 20px 0; border-radius: 5px; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .btn { display: inline-block; padding: 10px 20px; margin: 5px; text-decoration: none; border-radius: 5px; font-size: 14px; }
        .btn { background: #007bff; color: white; }
        .btn-warning { background: #ffc107; color: #212529; }
        .btn-danger { background: #dc3545; color: white; }
        .btn:hover { opacity: 0.8; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #f8f9fa; font-weight: bold; }
        .foto img { width: 60px; height: 60px; object-fit: cover; border-radius: 50%; }
        .deskripsi { max-width: 200px; }
        .actions { white-space: nowrap; }
        .no-data { text-align: center; padding: 40px; color: #666; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Data Instruktur</h1>
        
        <?php if ($message): ?>
            <div class="alert alert-<?php echo $message_type; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        
        <a href="tambah_instruktur.php" class="btn">+ Tambah Instruktur</a>
        <a href="index.php" class="btn btn-warning">← Kembali ke Dashboard</a>
        
        <?php if ($q && mysqli_num_rows($q) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Foto</th>
                        <th>Nama</th>
                        <th>Bidang</th>
                        <th>Deskripsi</th>
                        <th>Tanggal Dibuat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    while($d = mysqli_fetch_array($q)){
                        echo "<tr>";
                        echo "<td>".$no++."</td>";
                        echo "<td class='foto'>";
                        if(!empty($d['foto'])) {
                            // Cek path admin terlebih dahulu
                            $admin_path = '../assets/uploads/'.$d['foto'];
                            if(file_exists($admin_path)) {
                                echo "<img src='../assets/uploads/".$d['foto']."' alt='".$d['nama']."'>";
                            } else {
                                echo "<span style='color: #dc3545;'>File tidak ditemukan</span>";
                            }
                        } else {
                            echo "<span style='color: #666;'>Tidak ada foto</span>";
                        }
                        echo "</td>";
                        echo "<td>".htmlspecialchars($d['nama'])."</td>";
                        echo "<td>".htmlspecialchars($d['bidang'])."</td>";
                        echo "<td class='deskripsi' title='".htmlspecialchars($d['deskripsi'])."'>";
                        echo htmlspecialchars(substr($d['deskripsi'], 0, 100));
                        if(strlen($d['deskripsi']) > 100) echo "...";
                        echo "</td>";
                        echo "<td>".date('d/m/Y H:i', strtotime($d['created_at']))."</td>";
                        echo "<td class='actions'>
                                <a href='edit_instruktur.php?id=".$d['id_instruktur']."' class='btn btn-warning'>Edit</a>
                                <a href='?hapus=1&id=".$d['id_instruktur']."' class='btn btn-danger' onclick=\"return confirm('Yakin ingin menghapus data ".$d['nama']."?')\">Hapus</a>
                              </td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="no-data">
                <h3>Belum ada data instruktur</h3>
                <p>Klik tombol "Tambah Instruktur" untuk menambah data pertama.</p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>