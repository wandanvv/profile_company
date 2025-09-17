-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Waktu pembuatan: 17 Sep 2025 pada 07.25
-- Versi server: 8.0.35
-- Versi PHP: 8.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lpk_cti`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `beranda`
--

CREATE TABLE `beranda` (
  `id_beranda` int NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `isi` text COLLATE utf8mb4_general_ci,
  `gambar` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_instruktur`
--

CREATE TABLE `data_instruktur` (
  `id_instruktur` int NOT NULL,
  `nama` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `bidang` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `deskripsi` text COLLATE utf8mb4_general_ci,
  `foto` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `data_instruktur`
--

INSERT INTO `data_instruktur` (`id_instruktur`, `nama`, `bidang`, `deskripsi`, `foto`, `created_at`, `updated_at`) VALUES
(11, 'Bu Mely', 'Wali Kelas 2', '', '1758009092_profil.png', '2025-09-12 07:51:28', '2025-09-16 07:51:32'),
(13, 'Bu Wanda', 'Wali Kelas 1', '', '1758009067_profil.png', '2025-09-12 12:56:39', '2025-09-16 07:51:07'),
(14, 'Pa Sugih', 'Wali Kelas 3', '', 'instruktur_1758009148_9278.png', '2025-09-16 07:52:28', '2025-09-16 07:52:28'),
(15, 'Pa Tisna', 'Wali Kelas 4', '', 'instruktur_1758009191_8100.png', '2025-09-16 07:53:11', '2025-09-16 07:53:11');

-- --------------------------------------------------------

--
-- Struktur dari tabel `informasi`
--

CREATE TABLE `informasi` (
  `id_info` int NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `isi` text COLLATE utf8mb4_general_ci,
  `gambar` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `informasi`
--

INSERT INTO `informasi` (`id_info`, `judul`, `isi`, `gambar`, `tanggal`, `created_at`, `updated_at`) VALUES
(1, 'hiydhguiegiteh7yjerhiuyf', 'wedfghjukilooiuytr34567890-=', '1756125996_WIN_20250709_15_48_35_Pro.jpg', '2025-08-25', '2025-08-25 12:46:36', '2025-08-25 12:46:36');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kegiatan`
--

CREATE TABLE `kegiatan` (
  `id_kegiatan` int NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `isi` text COLLATE utf8mb4_general_ci,
  `tanggal` date DEFAULT NULL,
  `gambar` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kegiatan`
--

INSERT INTO `kegiatan` (`id_kegiatan`, `judul`, `isi`, `tanggal`, `gambar`, `created_at`, `updated_at`) VALUES
(1, 'hiuywiuw', 'jehjwerkjwheoiuwejqjwoqjyfytmdofo', '2025-08-23', '1756125865_Screenshot (59).png', '2025-08-25 12:44:25', '2025-08-25 12:44:25'),
(2, 'Outbound Character Building', 'Pembentukan karakter untuk peserta pelatihan siap kerja 3 bulan', '2025-08-30', 'kegiatan_1757727877_5352.jpeg', '2025-09-13 01:44:37', '2025-09-13 01:44:37'),
(3, 'pengabdian masyarakat', 'aaaa', '2025-09-17', 'kegiatan_1758075165_9448.png', '2025-09-17 02:12:45', '2025-09-17 02:12:45');

-- --------------------------------------------------------

--
-- Struktur dari tabel `profil_perusahaan`
--

CREATE TABLE `profil_perusahaan` (
  `id_profil` int NOT NULL,
  `tipe` enum('tentang','struktur') COLLATE utf8mb4_general_ci NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `isi` text COLLATE utf8mb4_general_ci,
  `gambar` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id_user` int NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `nama_lengkap` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id_user`, `username`, `password_hash`, `nama_lengkap`, `email`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$10$6nvktBNE0tuf0ldYwbl9ROLB27JhRWLOO4a9WpA5Eg2WbogGCTeLm', 'eka lukita candra', 'ekalukita@gmail.com', '2025-08-23 14:09:06', '2025-08-25 06:18:35');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `beranda`
--
ALTER TABLE `beranda`
  ADD PRIMARY KEY (`id_beranda`);

--
-- Indeks untuk tabel `data_instruktur`
--
ALTER TABLE `data_instruktur`
  ADD PRIMARY KEY (`id_instruktur`);

--
-- Indeks untuk tabel `informasi`
--
ALTER TABLE `informasi`
  ADD PRIMARY KEY (`id_info`);

--
-- Indeks untuk tabel `kegiatan`
--
ALTER TABLE `kegiatan`
  ADD PRIMARY KEY (`id_kegiatan`);

--
-- Indeks untuk tabel `profil_perusahaan`
--
ALTER TABLE `profil_perusahaan`
  ADD PRIMARY KEY (`id_profil`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `beranda`
--
ALTER TABLE `beranda`
  MODIFY `id_beranda` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `data_instruktur`
--
ALTER TABLE `data_instruktur`
  MODIFY `id_instruktur` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `informasi`
--
ALTER TABLE `informasi`
  MODIFY `id_info` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `kegiatan`
--
ALTER TABLE `kegiatan`
  MODIFY `id_kegiatan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `profil_perusahaan`
--
ALTER TABLE `profil_perusahaan`
  MODIFY `id_profil` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
