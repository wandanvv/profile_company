<?php
session_start();
include '../config/koneksi.php';

// Fungsi clean_input
function clean_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Cek session admin
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

$message = '';
$message_type = '';

// Proses form submit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = clean_input($_POST['nama']);
    $bidang = clean_input($_POST['bidang']);
    $deskripsi = clean_input($_POST['deskripsi']);
    
    $foto_name = '';
    
    // Proses upload foto
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
        $max_size = 5 * 1024 * 1024; // 5MB
        
        if (in_array($_FILES['foto']['type'], $allowed_types)) {
            if ($_FILES['foto']['size'] <= $max_size) {
                $foto_ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
                $foto_name = 'instruktur_' . time() . '_' . rand(1000, 9999) . '.' . $foto_ext;
                
                // Path untuk upload - pastikan folder ada
                $admin_upload_path = '../assets/uploads/';
                $public_upload_path = '../../assets/uploads/';
                
                // Buat folder jika belum ada
                if (!is_dir($admin_upload_path)) {
                    mkdir($admin_upload_path, 0755, true);
                }
                if (!is_dir($public_upload_path)) {
                    mkdir($public_upload_path, 0755, true);
                }
                
                $admin_target = $admin_upload_path . $foto_name;
                $public_target = $public_upload_path . $foto_name;
                
                // Upload ke folder admin
                if (move_uploaded_file($_FILES['foto']['tmp_name'], $admin_target)) {
                    // Copy ke folder public agar bisa diakses dari halaman umum
                    copy($admin_target, $public_target);
                } else {
                    $message = 'Gagal upload foto!';
                    $message_type = 'error';
                }
            } else {
                $message = 'Ukuran file terlalu besar! Maksimal 5MB.';
                $message_type = 'error';
            }
        } else {
            $message = 'Format file tidak didukung! Gunakan JPG, PNG, atau GIF.';
            $message_type = 'error';
        }
    }
    
    // Insert ke database jika tidak ada error
    if (empty($message) || $message_type != 'error') {
        $sql = "INSERT INTO data_instruktur (nama, bidang, deskripsi, foto, created_at) VALUES (?, ?, ?, ?, NOW())";
        $stmt = mysqli_prepare($koneksi, $sql);
        
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ssss", $nama, $bidang, $deskripsi, $foto_name);
            
            if (mysqli_stmt_execute($stmt)) {
                $message = 'Data instruktur berhasil ditambahkan!';
                $message_type = 'success';
                // Reset form
                $nama = $bidang = $deskripsi = '';
            } else {
                $message = 'Gagal menyimpan data: ' . mysqli_error($koneksi);
                $message_type = 'error';
                
                // Hapus foto yang sudah diupload jika gagal insert
                if (!empty($foto_name)) {
                    if (file_exists($admin_target)) unlink($admin_target);
                    if (file_exists($public_target)) unlink($public_target);
                }
            }
            
            mysqli_stmt_close($stmt);
        } else {
            $message = 'Error preparing statement: ' . mysqli_error($koneksi);
            $message_type = 'error';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Instruktur - Admin LPK CTI</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; background: #f5f5f5; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { color: #333; border-bottom: 2px solid #007bff; padding-bottom: 10px; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; color: #555; }
        input[type="text"], input[type="file"], textarea { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px; box-sizing: border-box; }
        textarea { height: 120px; resize: vertical; }
        .btn { display: inline-block; padding: 12px 24px; margin: 10px 5px 0 0; text-decoration: none; border-radius: 5px; font-size: 14px; border: none; cursor: pointer; }
        .btn-primary { background: #007bff; color: white; }
        .btn-secondary { background: #6c757d; color: white; }
        .btn:hover { opacity: 0.8; }
        .alert { padding: 15px; margin: 20px 0; border-radius: 5px; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .form-note { font-size: 12px; color: #666; margin-top: 5px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Tambah Instruktur Baru</h1>
        
        <?php if ($message): ?>
            <div class="alert alert-<?php echo $message_type; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nama">Nama Instruktur *</label>
                <input type="text" id="nama" name="nama" value="<?php echo isset($nama) ? $nama : ''; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="bidang">Bidang Keahlian *</label>
                <input type="text" id="bidang" name="bidang" value="<?php echo isset($bidang) ? $bidang : ''; ?>" required>
                <div class="form-note">Contoh: Web Programming, Database, UI/UX Design</div>
            </div>
            
            <div class="form-group">
                <label for="deskripsi">Deskripsi *</label>
                <textarea id="deskripsi" name="deskripsi" required><?php echo isset($deskripsi) ? $deskripsi : ''; ?></textarea>
                <div class="form-note">Deskripsikan pengalaman dan keahlian instruktur</div>
            </div>
            
            <div class="form-group">
                <label for="foto">Foto Instruktur</label>
                <input type="file" id="foto" name="foto" accept="image/*">
                <div class="form-note">Format: JPG, PNG, GIF. Maksimal 5MB. Disarankan ukuran persegi (contoh: 400x400px)</div>
            </div>
            
            <button type="submit" class="btn btn-primary">Simpan Data</button>
            <a href="instruktur.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
    
    <script>
        // Preview foto sebelum upload
        document.getElementById('foto').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // Remove existing preview
                    const existingPreview = document.getElementById('foto-preview');
                    if (existingPreview) {
                        existingPreview.remove();
                    }
                    
                    // Create new preview
                    const preview = document.createElement('div');
                    preview.id = 'foto-preview';
                    preview.style.marginTop = '10px';
                    preview.innerHTML = '<img src="' + e.target.result + '" style="max-width: 200px; max-height: 200px; border-radius: 10px; border: 2px solid #ddd;">';
                    
                    // Insert after file input
                    e.target.parentNode.appendChild(preview);
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>
</html>