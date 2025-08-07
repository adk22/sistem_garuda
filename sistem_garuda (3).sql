-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 07, 2025 at 06:59 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sistem_garuda`
--

-- --------------------------------------------------------

--
-- Table structure for table `berita`
--

CREATE TABLE `berita` (
  `id` int(11) NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `tanggal_upload` date DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `berita`
--

INSERT INTO `berita` (`id`, `gambar`, `tanggal_upload`) VALUES
(10, 'Periode Libur Hari Raya (27 Juni 2025) Tahun Baru Islam 1447 Hijriah_A4 2.png', '2025-07-14'),
(11, 'idul adha.png', '2025-07-14'),
(12, 'KV HARGA GOTF - WA BLAST.jpg', '2025-07-14'),
(13, 'KV HLP(bali)_WA BLAST.jpg', '2025-07-15');

-- --------------------------------------------------------

--
-- Table structure for table `destinasi`
--

CREATE TABLE `destinasi` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `deskripsi` text NOT NULL,
  `gambar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `destinasi`
--

INSERT INTO `destinasi` (`id`, `nama`, `deskripsi`, `gambar`) VALUES
(2, 'sanur', 'pantai di bagian timur denpasar', 'sanur.jpg'),
(3, 'lapangan puputan badung', 'lapangan yang terletak di jl sugianyar', 'lapangan puputan badung.webp'),
(4, 'pura jagatnatha ', 'pura yang terletak berdekatan dengan lapangan puputan badung dan mesum bali', 'pura jagatnatha dps.webp'),
(5, 'museum bali', 'museum yang terletak berdekatan dengan lapangan puputan badung', 'museum bali.webp'),
(6, 'pasar badung', 'pasar dengan tempat yang luas untuk berbelanja', 'pasar badung.webp'),
(11, 'Monumen bajrashandi', 'menumen yang terdapat di lapangan renon denpasar', 'bajra sandhi.webp');

-- --------------------------------------------------------

--
-- Table structure for table `hotel_control`
--

CREATE TABLE `hotel_control` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `deskripsi` text NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `rating` decimal(2,1) NOT NULL,
  `harga` int(11) NOT NULL,
  `link_kamar` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `hotel_control`
--

INSERT INTO `hotel_control` (`id`, `nama`, `deskripsi`, `gambar`, `rating`, `harga`, `link_kamar`) VALUES
(2, 'Prama Sanur', 'hotel prama terletak di bagian timur di area sanur dan berdekatan dengan pantai mertasari', 'prama hotel sanur.jpeg', 4.8, 1200000, 'pramakamar.php'),
(3, 'Meru Sanur', 'Hotel meru sanur terletak di simpang empat di arah menuju ke pantai sanur', 'meru sanur.webp', 4.9, 1300000, 'merukamar.php');

-- --------------------------------------------------------

--
-- Table structure for table `isi_nama`
--

CREATE TABLE `isi_nama` (
  `id` int(11) NOT NULL,
  `kode_tiket` varchar(50) NOT NULL,
  `id_tiket` int(11) NOT NULL,
  `asal` varchar(100) DEFAULT NULL,
  `tujuan` varchar(100) DEFAULT NULL,
  `jam` varchar(50) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `jenis_kelamin` varchar(20) NOT NULL,
  `negara` varchar(50) NOT NULL,
  `alamat` text NOT NULL,
  `tanggal_berangkat` date NOT NULL,
  `tanggal_pulang` date DEFAULT NULL,
  `kursi` varchar(20) DEFAULT NULL,
  `kelas` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `isi_nama`
--

INSERT INTO `isi_nama` (`id`, `kode_tiket`, `id_tiket`, `asal`, `tujuan`, `jam`, `harga`, `nama_lengkap`, `jenis_kelamin`, `negara`, `alamat`, `tanggal_berangkat`, `tanggal_pulang`, `kursi`, `kelas`, `created_at`) VALUES
(1, 'GA134244', 3, NULL, NULL, NULL, NULL, 'agung rai', 'Laki-laki', 'indonesia', 'gatsu', '2025-08-01', '2025-08-02', '1', 'Ekonomi', '2025-08-01 07:49:00'),
(2, 'GA134244', 3, NULL, NULL, NULL, NULL, 'agung rai', 'Laki-laki', 'indonesia', 'gatsu', '2025-08-01', '2025-08-02', '1', 'Ekonomi', '2025-08-01 07:50:55'),
(3, 'GA134244', 3, NULL, NULL, NULL, NULL, 'agung rai', 'Laki-laki', 'indonesia', 'gatsu', '2025-08-01', '2025-08-02', '10', 'Ekonomi', '2025-08-01 07:51:17'),
(4, 'GA134244', 3, NULL, NULL, NULL, NULL, 'agung rai', 'Laki-laki', 'indonesia', 'gatsu', '2025-08-01', '2025-08-02', '1', 'Ekonomi', '2025-08-01 08:01:52'),
(5, 'GA134244', 3, NULL, NULL, NULL, NULL, 'agung rai', 'Laki-laki', 'indonesia', 'gatsu', '2025-08-01', '2025-08-02', '1', 'Ekonomi', '2025-08-01 08:13:01'),
(6, 'GA134244', 3, NULL, NULL, NULL, NULL, 'agung rai', 'Laki-laki', 'indonesia', 'gatsu', '2025-08-01', '2025-08-02', '1', 'Ekonomi', '2025-08-01 08:13:30'),
(7, 'GA134244', 3, NULL, NULL, NULL, NULL, 'agung rai', 'Laki-laki', 'indonesia', 'gatsu ', '2025-08-01', '2025-08-02', '1', 'Ekonomi', '2025-08-01 08:49:17'),
(8, 'GA134244', 3, NULL, NULL, NULL, NULL, 'agung rai', 'Laki-laki', 'indonesia', 'gatsu ', '2025-08-01', '2025-08-02', '1', 'Ekonomi', '2025-08-01 08:55:35'),
(9, 'GA134244', 3, NULL, NULL, NULL, NULL, 'agung rai', 'Laki-laki', 'indonesia', 'gatsu', '2025-08-01', '2025-08-02', '1,2,5', 'Ekonomi', '2025-08-01 08:56:58'),
(10, 'GA134244', 3, NULL, NULL, NULL, NULL, 'joko', 'Laki-laki', 'indonesia', 'gatsu', '2025-08-01', '2025-08-02', '1,2,5', 'Ekonomi', '2025-08-01 08:56:58'),
(11, 'GA134244', 3, NULL, NULL, NULL, NULL, 'andada', 'Laki-laki', 'indonesia', 'gatsu', '2025-08-01', '2025-08-02', '1,2,5', 'Ekonomi', '2025-08-01 08:56:58'),
(12, 'GA224433', 2, NULL, NULL, NULL, NULL, 'agung rai', 'Laki-laki', 'indonesia', 'gatsu', '2025-08-01', '2025-08-02', '1', 'Ekonomi', '2025-08-01 15:31:16'),
(13, 'GA415627', 1, 'Bandara Ngurah Rai, DPS', 'Bandara Soekarno-Hatta', ' - ', 2300000, 'agung rai', 'Laki-laki', 'indonesia', 'fadfad', '2025-08-02', '2025-08-03', '1', 'Ekonomi', '2025-08-01 16:08:47'),
(14, 'GA415627', 1, 'Bandara Ngurah Rai, DPS', 'Bandara Soekarno-Hatta', ' - ', 2300000, 'agung rai', 'Laki-laki', 'indonesia', 'fafdfadf', '2025-08-02', '2025-08-03', '2', 'Ekonomi', '2025-08-01 16:08:47'),
(15, 'GA415627', 1, 'Bandara Ngurah Rai, DPS', 'Bandara Soekarno-Hatta', 'undefined', 2300000, 'agung rai', 'Laki-laki', 'indonesia', 'fadfad', '2025-08-02', '2025-08-03', '1', 'Ekonomi', '2025-08-01 16:12:01'),
(16, 'GA415627', 1, 'Bandara Ngurah Rai, DPS', 'Bandara Soekarno-Hatta', 'undefined', 2300000, 'agung rai', 'Laki-laki', 'indonesia', 'fafdfadf', '2025-08-02', '2025-08-03', '2', 'Ekonomi', '2025-08-01 16:12:01'),
(17, 'GA415627', 1, 'Bandara Ngurah Rai, DPS', 'Bandara Soekarno-Hatta', 'undefined', 2300000, 'agung rai', 'Laki-laki', 'indonesia', 'vcbv', '2025-08-02', '2025-08-03', '1,2', 'Ekonomi', '2025-08-01 16:16:43'),
(18, 'GA415627', 1, 'Bandara Ngurah Rai, DPS', 'Bandara Soekarno-Hatta', 'undefined', 2300000, 'agung rai', 'Laki-laki', 'indonesia', 'bcbvb', '2025-08-02', '2025-08-03', '1,2', 'Ekonomi', '2025-08-01 16:16:43'),
(19, 'GA415627', 1, 'Bandara Ngurah Rai, DPS', 'Bandara Soekarno-Hatta', 'undefined', 2300000, 'agung rai', 'Laki-laki', 'indonesia', 'vcbv', '2025-08-02', '2025-08-03', '1,2', 'Ekonomi', '2025-08-01 16:36:03'),
(20, 'GA415627', 1, 'Bandara Ngurah Rai, DPS', 'Bandara Soekarno-Hatta', 'undefined', 2300000, 'agung rai', 'Laki-laki', 'indonesia', 'bcbvb', '2025-08-02', '2025-08-03', '1,2', 'Ekonomi', '2025-08-01 16:36:03');

-- --------------------------------------------------------

--
-- Table structure for table `kamar_meru`
--

CREATE TABLE `kamar_meru` (
  `id` int(11) NOT NULL,
  `tipe` varchar(100) NOT NULL,
  `nama_kamar` varchar(100) NOT NULL,
  `deskripsi` text NOT NULL,
  `fasilitas` text NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `harga_asli` int(11) DEFAULT NULL,
  `harga_diskon` int(11) NOT NULL,
  `jumlah_tamu` int(11) NOT NULL,
  `sisa_kamar` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `kamar_meru`
--

INSERT INTO `kamar_meru` (`id`, `tipe`, `nama_kamar`, `deskripsi`, `fasilitas`, `gambar`, `harga_asli`, `harga_diskon`, `jumlah_tamu`, `sisa_kamar`) VALUES
(2, 'Garden suite', 'Garden Suite', 'kamar dekat dengan pemandangan taman yang indah', 'shower, TV, balkoni, garden view', 'garden suite meru.jpg', 1200000, 0, 2, 4),
(3, 'Tropical Suite', 'Tropical suite', 'kamar dengan kenyaman yang luar biasa dengan pemandangan yang indah dan tropis', 'shower, TV, balkoni, tropical view', 'tropical suite meru.webp', 1200000, 0, 2, 4);

-- --------------------------------------------------------

--
-- Table structure for table `list_tiket`
--

CREATE TABLE `list_tiket` (
  `id` int(11) NOT NULL,
  `kode` varchar(20) DEFAULT NULL,
  `asal` varchar(100) DEFAULT NULL,
  `tujuan` varchar(100) DEFAULT NULL,
  `jam_berangkat` time DEFAULT NULL,
  `jam_tiba` time DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `keterangan_waktu` varchar(50) DEFAULT NULL,
  `kelas` varchar(50) DEFAULT NULL,
  `kode_promo` varchar(100) DEFAULT NULL,
  `jumlah_kursi` int(11) DEFAULT 20
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `list_tiket`
--

INSERT INTO `list_tiket` (`id`, `kode`, `asal`, `tujuan`, `jam_berangkat`, `jam_tiba`, `harga`, `keterangan_waktu`, `kelas`, `kode_promo`, `jumlah_kursi`) VALUES
(1, 'GA415627', 'Bandara Ngurah Rai, DPS', 'Bandara Soekarno-Hatta', '23:00:00', '12:00:00', 2300000, 'Siang', 'Ekonomi', NULL, 20),
(2, 'GA224433', 'Bandara Soekarno-Hatta, JKT', 'Bandara Ngurah Rai, DPS', '08:00:00', '09:00:00', 2200000, 'Pagi', 'Ekonomi', 'GOTF', 20),
(3, 'GA134244', 'Bandara Internasional Komodo, LBJ', 'Bandara Ngurah Rai, DPS', '10:35:00', '11:45:00', 2100000, 'Pagi', 'Ekonomi', '', 40);

-- --------------------------------------------------------

--
-- Table structure for table `pemesanan`
--

CREATE TABLE `pemesanan` (
  `id` int(11) NOT NULL,
  `kode_tiket` varchar(100) NOT NULL,
  `kode_hotel` varchar(100) DEFAULT NULL,
  `id_tiket` int(11) NOT NULL,
  `asal` varchar(100) DEFAULT NULL,
  `tujuan` varchar(100) DEFAULT NULL,
  `tanggal_berangkat` date DEFAULT NULL,
  `tanggal_pulang` date DEFAULT NULL,
  `kelas` varchar(50) DEFAULT NULL,
  `kursi` varchar(100) DEFAULT NULL,
  `jumlah_penumpang` int(11) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `nama_hotel` varchar(100) DEFAULT NULL,
  `nama_kamar` varchar(100) DEFAULT NULL,
  `jumlah_tamu` int(11) DEFAULT NULL,
  `harga_hotel` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `jam_keberangkatan` varchar(20) DEFAULT NULL,
  `jam_tiba` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `pemesanan`
--

INSERT INTO `pemesanan` (`id`, `kode_tiket`, `kode_hotel`, `id_tiket`, `asal`, `tujuan`, `tanggal_berangkat`, `tanggal_pulang`, `kelas`, `kursi`, `jumlah_penumpang`, `harga`, `nama_hotel`, `nama_kamar`, `jumlah_tamu`, `harga_hotel`, `created_at`, `jam_keberangkatan`, `jam_tiba`) VALUES
(1, 'GA415627', NULL, 1, 'Bandara Ngurah Rai, DPS', 'Bandara Soekarno-Hatta', '2025-08-02', '2025-08-03', 'Ekonomi', '1', 0, 0, 'Prama', 'Delux twin', 2, 900000, '2025-08-01 18:18:34', NULL, NULL),
(17, 'GA134244', NULL, 3, 'Bandara Internasional Komodo, LBJ', 'Bandara Ngurah Rai, DPS', '2025-08-02', '2025-08-03', 'Ekonomi', '1,2', 0, 0, 'Prama', 'Delux twin', 2, 900000, '2025-08-02 07:50:24', NULL, NULL),
(47, 'GA224433', NULL, 2, 'Bandara Soekarno-Hatta, JKT', 'Bandara Ngurah Rai, DPS', '2025-08-02', '2025-08-03', 'Ekonomi', '5', 1, 1980000, NULL, NULL, NULL, NULL, '2025-08-02 10:48:14', NULL, NULL),
(52, 'HOTEL1754412320400', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Prama', 'Delux twin', 2, 900000, '2025-08-05 16:45:20', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pemesanan_tiket`
--

CREATE TABLE `pemesanan_tiket` (
  `id` int(11) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `dari` varchar(100) NOT NULL,
  `ke` varchar(100) NOT NULL,
  `waktu_berangkat` time NOT NULL,
  `waktu_tiba` time NOT NULL,
  `tanggal_berangkat` date NOT NULL,
  `tanggal_pulang` date DEFAULT NULL,
  `jumlah_penumpang` int(11) NOT NULL,
  `dewasa` int(11) NOT NULL,
  `anak` int(11) NOT NULL,
  `bayi` int(11) NOT NULL,
  `kelas` varchar(50) DEFAULT 'Ekonomi',
  `kode_promo` varchar(50) DEFAULT NULL,
  `tanggal_pesan` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `penumpang`
--

CREATE TABLE `penumpang` (
  `id` int(11) NOT NULL,
  `kode_tiket` varchar(100) DEFAULT NULL,
  `nama_lengkap` varchar(100) DEFAULT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') DEFAULT NULL,
  `negara` varchar(100) DEFAULT NULL,
  `alamat` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `penumpang`
--

INSERT INTO `penumpang` (`id`, `kode_tiket`, `nama_lengkap`, `jenis_kelamin`, `negara`, `alamat`) VALUES
(1, 'GA415627', 'agung rai', 'Laki-laki', 'indonesia', 'fsfsdfsdfsdfs'),
(2, 'GA134244', 'agung rai', 'Laki-laki', 'indonesia', 'dadasd'),
(3, 'GA134244', 'agung rai', 'Laki-laki', 'indonesia', 'sdasdasdsa');

-- --------------------------------------------------------

--
-- Table structure for table `prama_kamar`
--

CREATE TABLE `prama_kamar` (
  `id` int(11) NOT NULL,
  `tipe` varchar(100) NOT NULL,
  `nama_kamar` varchar(100) NOT NULL,
  `deskripsi` text NOT NULL,
  `fasilitas` text NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `harga_asli` int(11) DEFAULT NULL,
  `harga_diskon` int(11) NOT NULL,
  `jumlah_tamu` int(11) NOT NULL,
  `sisa_kamar` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `prama_kamar`
--

INSERT INTO `prama_kamar` (`id`, `tipe`, `nama_kamar`, `deskripsi`, `fasilitas`, `gambar`, `harga_asli`, `harga_diskon`, `jumlah_tamu`, `sisa_kamar`) VALUES
(1, 'Delux Twin', 'Delux twin', 'kamar yang nyaman dengan double bed dan fasilitas yang bagus lainnya', 'shower, balkon, tv', 'delux twin prama.jpeg', 900000, 0, 2, 1),
(2, 'Garden View', 'Garden View', 'kamar besar dengan pemandangan taman yang indah dengan banyak fasilitas', 'shower, balkon, tv, ac', 'garden view prama.jpeg', 1000000, 900000, 2, 5);

-- --------------------------------------------------------

--
-- Table structure for table `promo`
--

CREATE TABLE `promo` (
  `id` int(11) NOT NULL,
  `kode` varchar(100) NOT NULL,
  `diskon_persen` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `promo`
--

INSERT INTO `promo` (`id`, `kode`, `diskon_persen`) VALUES
(7, 'GOTF', 10),
(8, 'GATF', 15);

-- --------------------------------------------------------

--
-- Table structure for table `tentang_kami`
--

CREATE TABLE `tentang_kami` (
  `id` int(11) NOT NULL,
  `isi` text NOT NULL,
  `tanggal_update` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tentang_kami`
--

INSERT INTO `tentang_kami` (`id`, `isi`, `tanggal_update`) VALUES
(1, 'Garuda Indonesia saat ini melayani lebih dari 60 destinasi di seluruh dunia dan berbagai lokasi eksotis di Indonesia. Sebagai maskapai pembawa bendera bangsa dan demi mempersembahkan layanan penerbangan full service terbaik, Garuda Indonesia memberikan pelayanan terbaik melalui konsep layanan â€œGaruda Indonesia Experienceâ€ ', '2025-07-13 16:04:28');

-- --------------------------------------------------------

--
-- Table structure for table `tiket`
--

CREATE TABLE `tiket` (
  `id` int(11) NOT NULL,
  `dari` varchar(100) NOT NULL,
  `ke` varchar(100) NOT NULL,
  `waktu_berangkat` time NOT NULL,
  `waktu_tiba` time NOT NULL,
  `tanggal_berangkat` date NOT NULL,
  `tanggal_pulang` date DEFAULT NULL,
  `harga` int(11) NOT NULL,
  `batas_penumpang` int(11) DEFAULT 20,
  `kode_promo` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tiket`
--

INSERT INTO `tiket` (`id`, `dari`, `ke`, `waktu_berangkat`, `waktu_tiba`, `tanggal_berangkat`, `tanggal_pulang`, `harga`, `batas_penumpang`, `kode_promo`) VALUES
(1, 'ngurah rai', 'sukarno hatta', '15:51:00', '20:55:00', '0000-00-00', '0000-00-00', 2000000, 20, ''),
(2, 'ngurah rai', 'sukarno hatta', '15:51:00', '20:55:00', '0000-00-00', '0000-00-00', 2000000, 20, ''),
(3, 'ngurah rai', 'sukarno hatta', '18:04:00', '22:02:00', '0000-00-00', '2025-07-16', 2000000, 20, '');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('user','admin','superadmin') DEFAULT 'user',
  `nama_depan` varchar(50) DEFAULT NULL,
  `nama_belakang` varchar(50) DEFAULT NULL,
  `jabatan` varchar(50) DEFAULT NULL,
  `kewarganegaraan` varchar(50) DEFAULT NULL,
  `negara` varchar(50) DEFAULT NULL,
  `provinsi` varchar(50) DEFAULT NULL,
  `kota` varchar(50) DEFAULT NULL,
  `alamat` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `nama`, `email`, `username`, `password`, `role`, `nama_depan`, `nama_belakang`, `jabatan`, `kewarganegaraan`, `negara`, `provinsi`, `kota`, `alamat`) VALUES
(1, 'adi korsa', 'adda@gmail.com', 'adi111', '$2y$10$QJiNY1OcTD3moXNWYatYwO1fypkPTgUHPTi/Q2cxHMV8j/GBim4bC', 'user', 'adi', 'korsa', NULL, 'Indonesia', 'indonesia', NULL, NULL, 'jl renon'),
(3, 'iyaaa adi', 'abeee@gmail.com', 'adi145', '$2y$10$ylqVJVczrH2PRleQm.I2P.R0nHNJW78zbMQvKLtEtjpL3egmxQCtO', 'user', 'iyaaa', 'adi', NULL, 'Indonesia', 'indonesia', NULL, NULL, 'jl renon'),
(4, 'nanda kharsa', 'nan@gmail.com', 'nan88ya', '$2y$10$9o/mYThGTMxA9/qTOPBCf.ds.y/bcqRiluCBmd8ieBtSImbW7f6lu', 'user', 'nanda', 'kharsa', NULL, 'Indonesia', 'indonesia', NULL, NULL, 'jl karangasem'),
(5, 'gung jaya', 'gung12@gmail.com', 'gungjaya23', '$2y$10$pgVp1.wct4joj999eXWw2uHzMQB19y0v0J2rnZzNe8wsec0u68HCW', 'user', 'gung', 'jaya', NULL, 'Indonesia', 'indonesia', NULL, NULL, 'jln gatsu '),
(6, 'ade', 'adenur@gmail.com', 'nurade', 'GAade123', 'admin', 'ade', 'nur', 'bos', 'WNI', 'indonesia', NULL, NULL, NULL),
(8, 'superadmin', 'superadmin@gmail.com', 'superadmin01', 'SGAsuperadmin01', 'superadmin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 'put ardi', 'put@gmail.com', 'putu123', '$2y$10$cvAc64fIhXWafome28ILLuBT.kOk0AmzmtSDzQ6skjQgCs4/nhAVa', 'user', 'put', 'ardi', NULL, 'Indonesia', 'indonesia', NULL, NULL, 'jl.penatih '),
(11, 'kusuma jaya', 'kusuma@gmail.com', 'kusumajaya', '$2y$10$EIBcflfjKOprb9wR.RfEMu7mBSxWp./rmBjO/3VPIbFfVlkTjgE9q', 'user', 'kusuma', 'jaya', NULL, 'Asing', 'malaysia', NULL, NULL, 'jl johor'),
(13, 'wira jaya', 'wirajaya@gmail.com', 'wira123', 'GAjaya123', 'admin', 'wira', 'jaya', 'sekretaris ', 'WNI', 'indonesia', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `berita`
--
ALTER TABLE `berita`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `destinasi`
--
ALTER TABLE `destinasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hotel_control`
--
ALTER TABLE `hotel_control`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `isi_nama`
--
ALTER TABLE `isi_nama`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kamar_meru`
--
ALTER TABLE `kamar_meru`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `list_tiket`
--
ALTER TABLE `list_tiket`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_tiket` (`kode_tiket`);

--
-- Indexes for table `pemesanan_tiket`
--
ALTER TABLE `pemesanan_tiket`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `penumpang`
--
ALTER TABLE `penumpang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kode_tiket` (`kode_tiket`);

--
-- Indexes for table `prama_kamar`
--
ALTER TABLE `prama_kamar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `promo`
--
ALTER TABLE `promo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tentang_kami`
--
ALTER TABLE `tentang_kami`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tiket`
--
ALTER TABLE `tiket`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `berita`
--
ALTER TABLE `berita`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `destinasi`
--
ALTER TABLE `destinasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `hotel_control`
--
ALTER TABLE `hotel_control`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `isi_nama`
--
ALTER TABLE `isi_nama`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `kamar_meru`
--
ALTER TABLE `kamar_meru`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `list_tiket`
--
ALTER TABLE `list_tiket`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pemesanan`
--
ALTER TABLE `pemesanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `pemesanan_tiket`
--
ALTER TABLE `pemesanan_tiket`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `penumpang`
--
ALTER TABLE `penumpang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `prama_kamar`
--
ALTER TABLE `prama_kamar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `promo`
--
ALTER TABLE `promo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tentang_kami`
--
ALTER TABLE `tentang_kami`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tiket`
--
ALTER TABLE `tiket`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `penumpang`
--
ALTER TABLE `penumpang`
  ADD CONSTRAINT `penumpang_ibfk_1` FOREIGN KEY (`kode_tiket`) REFERENCES `pemesanan` (`kode_tiket`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
