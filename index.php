<?php
include 'config/koneksi.php';
include 'header.php';
?>

  <section id="beranda" class="hero">
    <h2>Selamat Datang di LPK CTI</h2>
    <p>Membentuk generasi siap kerja yang terampil dan profesional dengan teknologi terdepan.</p>
    <a href="#profil" class="btn">Lihat Profil</a>
  </section>

  <section id="profil" class="content">
    <h2>Profil LPK CTI</h2>
    <p style="text-align: justify; font-size: 1.1rem; line-height: 1.8;">
      Nama lengkapnya adalah LPK Cipta Tungga Indonesia (CTI), sebuah Lembaga Pelatihan Kerja (LPK) yang fokus di bidang Teknologi Informasi. Berbasis di Jalan Sukamulya No. 62, Belokan SMAN 1, Kabupaten Ciamis, Jawa Barat.
      <br><br>
      <strong>Bidang Pelatihan:</strong><br>
      LPK CTI menyediakan berbagai pelatihan dan kursus di bidang IT seperti Programming, IT-Networking, Multimedia, Desain Grafis, dan Akuntansi. Mereka merupakan lembaga pelatihan kerja terakreditasi dan juga TUK (Tempat Uji Kompetensi) untuk LSP IT dan Pemasaran.
      <br><br>
      LPK CTI menjalankan program pelatihan intensif selama 3 bulan: dua bulan pertama untuk pengajaran materi, dan bulan ketiga sebagai magang praktik kerja. Penutupannya biasanya berupa kegiatan Character Building Outbound untuk menyiapkan kesiapan kerja peserta.
    </p>
  </section>

  <section id="instruktur" class="content">
    <h2>Tim Instruktur Kami</h2>
    <p style="text-align: center; margin-bottom: 40px; color: #666; font-size: 1.1rem;">
      Berkenalan dengan para instruktur berpengalaman dan berkualitas di LPK CTI
    </p>
    <div class="instruktur-grid">
      <?php
      // Query untuk mengambil 4 data instruktur terbaru
      $query = "SELECT * FROM data_instruktur ORDER BY created_at DESC LIMIT 4";
      $result = mysqli_query($koneksi, $query);
      
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
          while ($row = mysqli_fetch_assoc($result)) {
              echo "<div class='instruktur-card'>";
              if (!empty($row['foto'])) {
                  $foto_path = 'assets/uploads/' . $row['foto'];
                  if (file_exists($foto_path)) {
                      echo "<img src='" . $foto_path . "' alt='" . htmlspecialchars($row['nama']) . "' class='instruktur-img'>";
                  } else {
                      echo "<div class='placeholder-img'>👤</div>";
                  }
              } else {
                  echo "<div class='placeholder-img'>👤</div>";
              }
              echo "<h3>" . htmlspecialchars($row['nama']) . "</h3>";
              echo "<p>" . htmlspecialchars($row['bidang']) . "</p>";
              echo "</div>";
          }
      }
      ?>
    </div>
    <div class="more-button-container">
      <a href="instruktur.php" class="btn btn-more">Lihat Lebih Banyak</a>
    </div>
  </section>

  <section id="kegiatan" class="content">
    <h2>Kegiatan & Program</h2>
    <p class="section-description">Lihat berbagai kegiatan dan program terbaru yang kami selenggarakan.</p>
    <div class="kegiatan-grid">
        <?php
        $query = "SELECT * FROM kegiatan ORDER BY tanggal DESC LIMIT 4";
        $result = mysqli_query($koneksi, $query);

        if (!$result) {
            echo "<div class='no-data'>";
            echo "<h3>Error Database</h3>";
            echo "<p>Terjadi kesalahan: " . mysqli_error($koneksi) . "</p>";
            echo "</div>";
        } elseif (mysqli_num_rows($result) == 0) {
            echo "<div class='no-data'>";
            echo "<h3>Belum Ada Data Kegiatan</h3>";
            echo "<p>Data kegiatan sedang dalam proses pembaruan. Silakan kembali lagi nanti.</p>";
            echo "</div>";
        } else {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class='kegiatan-card'>";
                
                // Menampilkan gambar
                if (!empty($row['gambar'])) {
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
    <div class="more-button-container">
      <a href="kegiatan.php" class="btn btn-more">Lihat Lebih Banyak</a>
    </div>
</section>

  <section id="informasi" class="content">
    <h2>Informasi Terbaru</h2>
    <div style="max-width: 600px; margin: 0 auto; text-align: center;">
      <?php
      $query = "SELECT * FROM informasi ORDER BY tanggal DESC LIMIT 1";
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
          $row = mysqli_fetch_assoc($result);
          echo "<div style='background: white; padding: 40px; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);'>";
          echo "<h3 style='color: #007bff; margin-bottom: 20px;'>" . htmlspecialchars($row['judul']) . "</h3>";
          echo "<p style='font-size: 1.1rem; line-height: 1.6;'>" . nl2br(htmlspecialchars($row['isi'])) . "</p>";
          echo "</div>";
      }
      ?>
    </div>
    <div style="text-align: center; margin-top: 30px;">
      <a href="informasi.php" class="btn">Lihat Lebih Banyak</a>
    </div>
  </section>
  
  <section id="kontak" class="content">
    <h2>Hubungi Kami</h2>
    <div class="contact-grid">
      <a href="mailto:info@lpkcti.com" class="contact-card">
        <div class="icon-container"><i class="fas fa-envelope"></i></div>
        <h3>Email</h3>
        <p>info@lpkcti.com</p>
      </a>
      <a href="https://www.instagram.com/lpkcti" target="_blank" class="contact-card">
        <div class="icon-container"><i class="fab fa-instagram"></i></div>
        <h3>Instagram</h3>
        <p>@lpkcti</p>
      </a>
      <a href="https://wa.me/6281234567890" target="_blank" class="contact-card">
        <div class="icon-container"><i class="fab fa-whatsapp"></i></div>
        <h3>WhatsApp</h3>
        <p>0812-3456-7890</p>
      </a>
      <a href="https://goo.gl/maps/contoh-lokasi-lpk-cti" target="_blank" class="contact-card">
        <div class="icon-container"><i class="fas fa-map-marker-alt"></i></div>
        <h3>Alamat</h3>
        <p>Jl. Sukamulya No. 62<br>Belokan SMAN 1, Ciamis</p>
      </a>
    </div>
  </section>

<?php
include 'footer.php';
?>