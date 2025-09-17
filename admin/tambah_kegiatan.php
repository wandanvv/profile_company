<?php
// admin/tambah_kegiatan.php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

$error_message = "";
$success_message = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $judul = mysqli_real_escape_string($koneksi, trim($_POST['judul']));
    $isi = mysqli_real_escape_string($koneksi, trim($_POST['isi']));
    $tanggal = mysqli_real_escape_string($koneksi, $_POST['tanggal']);

    // Validasi input
    if (empty($judul)) {
        $error_message = "Judul kegiatan wajib diisi!";
    } elseif (empty($tanggal)) {
        $error_message = "Tanggal kegiatan wajib diisi!";
    } else {
        $gambar = "";
        
        // Handle upload gambar
        if (!empty($_FILES['gambar']['name'])) {
            $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
            $max_size = 5 * 1024 * 1024; // 2MB
            
            if (!in_array($_FILES['gambar']['type'], $allowed_types)) {
                $error_message = "Format file tidak didukung! Gunakan JPG,JPEG PNG, atau GIF.";
            } elseif ($_FILES['gambar']['size'] > $max_size) {
                $error_message = "Ukuran file terlalu besar! Maksimal 5MB.";
            } else {
                $file_extension = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
                $gambar = "kegiatan_" . time() . "_" . rand(1000, 9999) . "." . $file_extension;
                
                // Buat folder jika belum ada
                $upload_dir = "../assets/uploads/";
                if (!file_exists($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }
                
                if (!move_uploaded_file($_FILES['gambar']['tmp_name'], $upload_dir . $gambar)) {
                    $error_message = "Gagal mengupload gambar!";
                    $gambar = "";
                }
            }
        }
        
        if (empty($error_message)) {
            $sql = "INSERT INTO kegiatan (judul, isi, tanggal, gambar, created_at) VALUES ('$judul', '$isi', '$tanggal', '$gambar', NOW())";
            
            if (mysqli_query($koneksi, $sql)) {
                header("Location: kegiatan.php?success=1");
                exit;
            } else {
                $error_message = "Error: " . mysqli_error($koneksi);
                
                // Hapus file yang sudah diupload jika query gagal
                if (!empty($gambar) && file_exists($upload_dir . $gambar)) {
                    unlink($upload_dir . $gambar);
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tambah Kegiatan</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .form-container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            color: #333;
        }
        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            box-sizing: border-box;
        }
        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }
        .form-group input[type="file"] {
            padding: 8px;
        }
        .btn {
            display: inline-block;
            padding: 12px 20px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 10px;
        }
        .btn:hover {
            background: #0056b3;
        }
        .btn-secondary {
            background: #6c757d;
        }
        .btn-secondary:hover {
            background: #545b62;
        }
        .error-message {
            background: #f8d7da;
            color: #721c24;
            padding: 12px;
            border-radius: 4px;
            margin-bottom: 20px;
            border: 1px solid #f5c6cb;
        }
        .file-info {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
        }
        .required {
            color: #dc3545;
        }
    </style>
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
    <h1>Tambah Kegiatan Baru</h1>
    
    <div class="form-container">
        <?php if (!empty($error_message)): ?>
        <div class="error-message">
            <?= $error_message ?>
        </div>
        <?php endif; ?>
        
        <form method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="judul">Judul Kegiatan: <span class="required">*</span></label>
                <input type="text" 
                       id="judul" 
                       name="judul" 
                       value="<?= isset($_POST['judul']) ? htmlspecialchars($_POST['judul']) : '' ?>" 
                       placeholder="Masukkan judul kegiatan" 
                       required>
            </div>

            <div class="form-group">
                <label for="isi">Deskripsi/Isi Kegiatan:</label>
                <textarea id="isi" 
                          name="isi" 
                          placeholder="Masukkan deskripsi kegiatan"><?= isset($_POST['isi']) ? htmlspecialchars($_POST['isi']) : '' ?></textarea>
            </div>

            <div class="form-group">
                <label for="tanggal">Tanggal Kegiatan: <span class="required">*</span></label>
                <input type="date" 
                       id="tanggal" 
                       name="tanggal" 
                       value="<?= isset($_POST['tanggal']) ? $_POST['tanggal'] : '' ?>" 
                       required>
            </div>

            <div class="form-group">
                <label for="gambar">Gambar Kegiatan:</label>
                <input type="file" 
                       id="gambar" 
                       name="gambar" 
                       accept="image/*">
                <div class="file-info">
                    Format yang didukung: JPG, PNG, GIF. Maksimal 2MB.
                </div>
            </div>

            <div class="form-group">
                <button type="submit" class="btn">Simpan Kegiatan</button>
                <a href="kegiatan.php" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </div>
</div>

<script>
// Preview gambar sebelum upload
document.getElementById('gambar').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        // Hapus preview yang ada
        const existingPreview = document.getElementById('image-preview');
        if (existingPreview) {
            existingPreview.remove();
        }
        
        // Buat preview baru
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.createElement('div');
            preview.id = 'image-preview';
            preview.innerHTML = '<img src="' + e.target.result + '" style="max-width: 200px; max-height: 150px; object-fit: cover; border-radius: 4px; margin-top: 10px;">';
            document.getElementById('gambar').parentNode.appendChild(preview);
        };
        reader.readAsDataURL(file);
    }
});

// Validasi form sebelum submit
document.querySelector('form').addEventListener('submit', function(e) {
    const judul = document.getElementById('judul').value.trim();
    const tanggal = document.getElementById('tanggal').value;
    
    if (!judul) {
        alert('Judul kegiatan wajib diisi!');
        e.preventDefault();
        return false;
    }
    
    if (!tanggal) {
        alert('Tanggal kegiatan wajib diisi!');
        e.preventDefault();
        return false;
    }
    
    return true;
});
</script>
</body>
</html>