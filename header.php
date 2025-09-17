<?php
// koneksi.php sudah di-include di file utama yang memanggil header.php
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LPK CTI - Profile Company</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <style>
    /* Anda bisa memindahkan semua CSS ke file terpisah seperti style.css
       Namun, untuk saat ini, letakkan di sini agar tetap dalam satu file */
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; line-height: 1.6; color: #333; }
    
    header { 
      background: #007bff; 
      color: white; 
      padding: 15px 0; 
      position: sticky; 
      top: 0; 
      z-index: 100;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .header-container {
      max-width: 1200px; 
      margin: 0 auto; 
      display: flex; 
      justify-content: space-between; 
      align-items: center; 
      padding: 0 20px;
    }
    
    .logo { 
      display: flex; 
      align-items: center; 
      gap: 15px; 
    }
    
    .logo img { 
      width: 50px; 
      height: 50px; 
      border-radius: 50%; 
      object-fit: cover;
      border: 2px solid rgba(255,255,255,0.3);
    }
    
    .logo h1 {
      font-size: 1.8rem;
      font-weight: 600;
      letter-spacing: -0.5px;
    }
    
    nav ul { 
      list-style: none; 
      display: flex; 
      gap: 0; 
      background: rgba(255,255,255,0.1);
      border-radius: 25px;
      padding: 5px;
    }
    
    nav a { 
      color: white; 
      text-decoration: none; 
      padding: 12px 20px; 
      font-weight: 500;
      font-size: 0.95rem;
      border-radius: 20px;
      transition: all 0.3s ease;
      position: relative;
    }
    
    nav a:hover { 
      background: rgba(255,255,255,0.2); 
      transform: translateY(-1px);
    }
    
    .hero { 
      background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url('assets/bg.jpeg');
      background-size: cover;
      background-position: center;
      background-attachment: fixed;
      color: white; 
      text-align: center; 
      padding: 120px 20px;
      min-height: 70vh;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
    }
    
    .hero h2 { 
      font-size: 3.5rem; 
      margin-bottom: 1rem; 
      font-weight: 700;
      text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
    }
    
    .hero p {
      font-size: 1.3rem;
      margin-bottom: 30px;
      text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
      max-width: 600px;
    }
    
    .btn { 
      display: inline-block; 
      background: white; 
      color: #333; 
      padding: 15px 35px; 
      text-decoration: none; 
      border-radius: 30px; 
      margin-top: 20px;
      font-weight: 600;
      transition: all 0.3s ease;
      box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }
    
    .btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(0,0,0,0.3);
    }
    
    .content { padding: 80px 20px; max-width: 1200px; margin: 0 auto; }
    .content h2 { 
      text-align: center; 
      margin-bottom: 50px; 
      font-size: 2.8rem; 
      color: #333;
      position: relative;
    }
    
    .content h2:after {
      content: '';
      position: absolute;
      bottom: -10px;
      left: 50%;
      transform: translateX(-50%);
      width: 80px;
      height: 4px;
      background: #007bff;
      border-radius: 2px;
    }
    
    /* Instruktur Grid - 4 kolom */
    .instruktur-grid { 
      display: grid; 
      grid-template-columns: repeat(4, 1fr); 
      gap: 30px; 
      margin-top: 50px; 
    }
    
    .instruktur-card { 
      background: white; 
      border-radius: 20px; 
      padding: 30px 20px; 
      text-align: center; 
      box-shadow: 0 10px 30px rgba(0,0,0,0.1); 
      transition: all 0.3s ease;
      border: 1px solid #f0f0f0;
    }
    
    .instruktur-card:hover { 
      transform: translateY(-8px);
      box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    }
    
    .instruktur-img { 
      width: 100px; 
      height: 100px; 
      border-radius: 50%; 
      object-fit: cover; 
      margin: 0 auto 20px; 
      border: 4px solid #007bff;
      display: block;
    }
    
    .instruktur-card h3 { 
      color: #333; 
      margin-bottom: 8px;
      font-size: 1.2rem;
      font-weight: 600;
    }
    
    .instruktur-card p { 
      color: #007bff; 
      font-weight: 500;
      font-size: 0.95rem;
    }

    @media (max-width: 1024px) {
      .instruktur-grid {
        grid-template-columns: repeat(3, 1fr);
        gap: 25px;
      }
    }
    
    @media (max-width: 768px) {
      .instruktur-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
      }
      
      .hero h2 {
        font-size: 2.5rem;
      }
      
      nav ul {
        flex-wrap: wrap;
      }
    }
    
    @media (max-width: 480px) {
      .instruktur-grid {
        grid-template-columns: 1fr;
        gap: 20px;
      }
    }
    
    .no-data { 
      text-align: center; 
      padding: 60px 40px; 
      color: #666; 
      background: #f8f9fa; 
      border-radius: 15px;
      grid-column: 1 / -1;
    }
    
    .placeholder-img { 
      width: 100px; 
      height: 100px; 
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
      border-radius: 50%; 
      display: flex; 
      align-items: center; 
      justify-content: center; 
      color: white; 
      font-size: 40px; 
      margin: 0 auto 20px;
      border: 4px solid #007bff;
    }

    /* Styling untuk deskripsi section */
    .section-description {
        text-align: center;
        margin-bottom: 40px;
        color: #666;
        font-size: 1.1rem;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }

   /* Gaya untuk penampung grid */
.kegiatan-grid {
    display: grid;
    /* Membuat grid responsif dengan 3 kolom di layar lebar */
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px; /* Jarak antar card */
    padding: 20px;
}

/* Gaya untuk setiap card kegiatan */
.kegiatan-card {
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    overflow: hidden; /* Penting untuk menjaga gambar tetap di dalam card */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    background-color: #fff;
    display: flex;
    flex-direction: column;
    height: 100%; /* Memastikan semua card memiliki tinggi yang sama */
}

/* Gaya untuk gambar di dalam card */
.kegiatan-card img {
    width: 100%;
    height: 200px; /* Tinggi gambar yang seragam */
    object-fit: cover; /* Penting! Menjaga rasio gambar tanpa distorsi */
    border-bottom: 1px solid #e0e0e0;
}

/* Gaya untuk konten teks di dalam card */
.kegiatan-card h3 {
    font-size: 1.25em;
    margin: 15px;
    color: #333;
}

.kegiatan-card .tanggal {
    font-size: 0.9em;
    color: #888;
    margin: 0 15px 10px;
}

.kegiatan-card .deskripsi {
    font-size: 1em;
    color: #555;
    margin: 0 15px 15px;
    flex-grow: 1; /* Membuat deskripsi mengisi ruang yang tersisa */
}
    /* Tombol "Lihat Lebih Banyak" */
    .more-button-container {
        text-align: center;
        margin-top: 50px;
    }

    .btn-more {
        display: inline-block;
        background: #007bff;
        color: white;
        padding: 15px 35px;
        text-decoration: none;
        border-radius: 30px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }

    .btn-more:hover {
        background: #0056b3;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.3);
    }
    /* Container Grid untuk Kontak */
    .contact-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr); /* Atur 4 kolom per baris */
      gap: 20px;
      margin-top: 40px;
      max-width: 1200px;
      margin-left: auto;
      margin-right: auto;
    }

    /* Kartu untuk setiap kontak */
    .contact-card {
      text-align: center;
      padding: 40px 20px;
      background: white;
      border-radius: 15px;
      box-shadow: 0 5px 20px rgba(0,0,0,0.05);
      transition: transform 0.3s, box-shadow 0.3s;
      text-decoration: none;
      color: #333;
    }

    .contact-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    /* Ikon Kontak */
    .icon-container {
      font-size: 2.5rem;
      color: #007bff;
      margin-bottom: 20px;
      transition: color 0.3s;
    }

    .contact-card:hover .icon-container {
      color: #0056b3;
    }

    /* Teks pada Kartu */
    .contact-card h3 {
      font-family: 'Poppins', sans-serif;
      font-size: 1.4rem;
      margin-bottom: 8px;
      color: #003366;
    }

    .contact-card p {
      font-size: 1rem;
      color: #666;
    }

    /* Responsif untuk 2 dan 1 kolom */
    @media (max-width: 1024px) {
      .contact-grid {
        grid-template-columns: repeat(2, 1fr); /* 2 kolom di tablet */
      }
    }

    @media (max-width: 600px) {
      .contact-grid {
        grid-template-columns: 1fr; /* 1 kolom di HP */
      }
    }
    /* Responsif */
    @media (max-width: 768px) {
        .kegiatan-grid {
            grid-template-columns: 1fr; /* 1 kolom di layar kecil */
        }
    }
        
    .grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px; margin-top: 40px; }
    .card { background: white; border-radius: 15px; padding: 30px; text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,0.1); transition: transform 0.3s; }
    .card:hover { transform: translateY(-10px); }
  </style>
</head>
<body>
  <header>
    <div class="header-container">
      <div class="logo">
        <img src="assets/uploads/lpk.jpeg" alt="Logo LPK CTI">
        <h1>LPK CTI</h1>
      </div>
      <nav>
        <ul>
          <li><a href="index.php">Beranda</a></li>
          <li><a href="index.php#profil">Profil</a></li>
          <li><a href="instruktur.php">Instruktur</a></li>
          <li><a href="kegiatan.php">Kegiatan</a></li>
          <li><a href="informasi.php">Informasi</a></li>
          <li><a href="kontak.php">Kontak</a></li>
          <li><a href="admin/login.php" style="background: #e67e22; color: white; padding: 10px 20px; border-radius: 20px;">Login</a></li>
          <li><a href="" style="background: #FFDB58; color: white; padding: 10px 20px; border-radius: 20px;">Daftar</a></li>
        </ul>
      </nav>
    </div>
  </header>