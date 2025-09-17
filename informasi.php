<?php
include 'config/koneksi.php'; 
include 'header.php';
?>

<section id="informasi" class="content">
    <h2>Informasi Terbaru</h2>
    <p class="section-description">Lihat semua pengumuman dan informasi penting dari LPK CTI.</p>

    <div style="display: flex; flex-direction: column; gap: 30px; max-width: 800px; margin: 0 auto;">
        <?php
        // Query untuk mengambil semua data informasi
        $query = "SELECT * FROM informasi ORDER BY tanggal DESC";
        $result = mysqli_query($koneksi, $query);

        if (!$result) {
            echo "<div class='no-data'>";
            echo "<h3>Error Database</h3>";
            echo "<p>Terjadi kesalahan: " . mysqli_error($koneksi) . "</p>";
            echo "</div>";
        } elseif (mysqli_num_rows($result) == 0) {
            echo "<div class='no-data'>";
            echo "<h3>Belum Ada Informasi Terbaru</h3>";
            echo "<p>Informasi sedang dalam proses pembaruan. Silakan kembali lagi nanti.</p>";
            echo "</div>";
        } else {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div style='background: white; padding: 30px; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.05);'>";
                echo "<h3 style='color: #007bff; margin-bottom: 15px; font-size: 1.5rem;'>" . htmlspecialchars($row['judul']) . "</h3>";
                echo "<p style='color: #666; font-size: 0.9rem; margin-bottom: 15px;'>" . htmlspecialchars(date('d F Y', strtotime($row['tanggal']))) . "</p>";
                echo "<p style='font-size: 1.1rem; line-height: 1.6;'>" . nl2br(htmlspecialchars($row['isi'])) . "</p>";
                echo "</div>";
            }
        }
        ?>
    </div>
</section>

<?php
include 'footer.php';
?>