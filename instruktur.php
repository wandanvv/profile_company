<?php
// Pastikan koneksi.php berada di level yang sama dengan instruktur.php
// Atau sesuaikan path-nya jika berada di direktori yang berbeda.
include 'config/koneksi.php'; 

// Jika Anda ingin menggunakan session, pastikan session_start() ada di header.php
// Jika tidak, Anda bisa letakkan di sini.
// session_start(); 

// Tambahkan path relatif yang benar untuk file header dan footer
include 'header.php';
?>

<section id="instruktur" class="content">
    <h2>Tim Instruktur Kami</h2>
    <p class="section-description">
        Berkenalan dengan para instruktur berpengalaman dan berkualitas di LPK CTI
    </p>

    <div class="instruktur-grid">
        <?php
        // Query untuk mengambil semua data instruktur
        $query = "SELECT * FROM data_instruktur ORDER BY created_at DESC";
        $result = mysqli_query($koneksi, $query);

        // Cek apakah query berhasil
        if (!$result) {
            echo "<div class='no-data'>";
            echo "<h3>Error Database</h3>";
            echo "<p>Terjadi kesalahan: " . mysqli_error($koneksi) . "</p>";
            echo "</div>";
        } elseif (mysqli_num_rows($result) == 0) {
            echo "<div class='no-data'>";
            echo "<h3>Belum Ada Data Instruktur</h3>";
            echo "<p>Data instruktur sedang dalam proses pembaruan. Silakan kembali lagi nanti.</p>";
            echo "</div>";
        } else {
            // Tampilkan semua data instruktur
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class='instruktur-card'>";
                
                if (!empty($row['foto'])) {
                    $foto_path = 'assets/uploads/' . $row['foto'];
                    // Periksa apakah file foto ada
                    if (file_exists($foto_path)) {
                        echo "<img src='" . $foto_path . "' alt='" . htmlspecialchars($row['nama']) . "' class='instruktur-img'>";
                    } else {
                        // Jika tidak ada di folder uploads, cek di folder admin/assets/uploads
                        $alt_foto_path = 'admin/assets/uploads/' . $row['foto'];
                        if (file_exists($alt_foto_path)) {
                            echo "<img src='" . $alt_foto_path . "' alt='" . htmlspecialchars($row['nama']) . "' class='instruktur-img'>";
                        } else {
                            // Tampilkan placeholder jika foto tidak ditemukan di kedua path
                            echo "<div class='placeholder-img'>👤</div>";
                        }
                    }
                } else {
                    // Tampilkan placeholder jika tidak ada nama file foto
                    echo "<div class='placeholder-img'>👤</div>";
                }
                
                echo "<h3>" . htmlspecialchars($row['nama']) . "</h3>";
                echo "<p>" . htmlspecialchars($row['bidang']) . "</p>";
                echo "</div>";
            }
        }
        ?>
    </div>
</section>

<?php
include 'footer.php';
?>