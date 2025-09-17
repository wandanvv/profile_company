<?php

include 'config/koneksi.php'; 


include 'header.php';
?>

<section id="kegiatan" class="content">
    <h2>Kegiatan & Program</h2>
    <p class="section-description">Lihat semua kegiatan dan program terbaru yang kami selenggarakan.</p>
    
    <div class="kegiatan-grid">
        <?php
        // Query untuk mengambil semua data kegiatan
        $query = "SELECT * FROM kegiatan ORDER BY tanggal DESC";
        $result = mysqli_query($koneksi, $query);

        // Cek apakah query berhasil
        if (!$result) {
            echo "<div class='no-data'>";
            echo "<h3>Error Database</h3>";
            echo "<p>Terjadi kesalahan: " . mysqli_error($koneksi) . "</p>";
            echo "</div>";
        } elseif (mysqli_num_rows($result) == 0) {
            echo "<div class='no-data'>";
            echo "<h3>Belum Ada Data Kegiatan</h3>";
            echo "<p>Saat ini belum ada data kegiatan yang tersedia. Silakan cek kembali nanti.</p>";
            echo "</div>";
        } else {
            // Tampilkan semua data kegiatan
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class='kegiatan-card'>";
                
                // Menampilkan gambar dari database, sesuaikan path-nya
                if (!empty($row['gambar'])) {
                    // Perbaikan pada baris ini
                    echo "<img src='assets/uploads/" . htmlspecialchars($row['gambar']) . "' alt='" . htmlspecialchars($row['judul']) . "'>";
                }

                echo "<h3>" . htmlspecialchars($row['judul']) . "</h3>";
                echo "<p class='tanggal'>" . htmlspecialchars(date('d F Y', strtotime($row['tanggal']))) . "</p>";
                
                // Membatasi deskripsi agar tidak terlalu panjang
                $deskripsi_lengkap = $row['isi'];
                $deskripsi_singkat = substr($deskripsi_lengkap, 0, 150);
                if (strlen($deskripsi_lengkap) > 150) {
                    $deskripsi_singkat .= "...";
                }
                echo "<p class='deskripsi'>" . nl2br(htmlspecialchars($deskripsi_singkat)) . "</p>";
                

                echo "</div>";
            }
        }
        ?>
    </div>
</section>

<?php
// Panggil file footer untuk menyertakan footer dan script
include 'footer.php';
?>