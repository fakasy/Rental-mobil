-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Waktu pembuatan: 03 Des 2024 pada 03.14
-- Versi server: 8.3.0
-- Versi PHP: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rentalmobil`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `bayar`
--

DROP TABLE IF EXISTS `bayar`;
CREATE TABLE IF NOT EXISTS `bayar` (
  `bayarId` int NOT NULL AUTO_INCREMENT,
  `kembaliId` int NOT NULL,
  `tgl_bayar` date NOT NULL,
  `total_bayar` decimal(10,2) NOT NULL,
  `status` enum('lunas','belum') NOT NULL,
  PRIMARY KEY (`bayarId`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `bayar`
--

INSERT INTO `bayar` (`bayarId`, `kembaliId`, `tgl_bayar`, `total_bayar`, `status`) VALUES
(7, 9, '2024-10-23', 148544.00, 'lunas');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kembali`
--

DROP TABLE IF EXISTS `kembali`;
CREATE TABLE IF NOT EXISTS `kembali` (
  `kembaliId` int NOT NULL AUTO_INCREMENT,
  `transaksiId` int NOT NULL,
  `tgl_kembali` date NOT NULL,
  `kondisimobil` text NOT NULL,
  `denda` decimal(10,2) NOT NULL,
  PRIMARY KEY (`kembaliId`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `kembali`
--

INSERT INTO `kembali` (`kembaliId`, `transaksiId`, `tgl_kembali`, `kondisimobil`, `denda`) VALUES
(11, 671668397, '2025-01-01', 'dsff', 17926.00),
(10, 671668396, '2024-11-05', 's fedasc', 13284.00),
(9, 671668395, '2024-11-08', 'rusak', 18668.00);

-- --------------------------------------------------------

--
-- Struktur dari tabel `member`
--

DROP TABLE IF EXISTS `member`;
CREATE TABLE IF NOT EXISTS `member` (
  `nik` int NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jk` enum('L','P') NOT NULL,
  `telp` varchar(15) NOT NULL,
  `alamat` text NOT NULL,
  `user` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`nik`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `member`
--

INSERT INTO `member` (`nik`, `nama`, `jk`, `telp`, `alamat`, `user`, `password`) VALUES
(42353, 'nabil', 'P', '088888000888', 'secangkelan', 'd', '$2y$10$TQ02ns0aayyGtulDcAhlyO7sBTX5QLJGW5PSmvnX6yNlYdepi/DJC'),
(5745745, 'seva', 'P', '3453535', 'adas', 's', '$2y$10$Td1UvBN.5KLQIN/ukCGX1eDsDTWS6Jh/e4OG7dgEWr3SCqWdMksGm'),
(4555566, 'nabil', 'L', '088888000888', 'asdasasd', 'g', '$2y$10$PBIsc7CgjAZmY4v3m9HZRe3JMTLfrHTZdWC4YeENqXiWE3qsEjxmC');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mobil`
--

DROP TABLE IF EXISTS `mobil`;
CREATE TABLE IF NOT EXISTS `mobil` (
  `nopol` varchar(10) NOT NULL,
  `brand` varchar(50) NOT NULL,
  `type` varchar(50) NOT NULL,
  `tahun` date NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `foto` varchar(50) NOT NULL,
  `status` enum('tersedia','tidak') NOT NULL,
  PRIMARY KEY (`nopol`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `mobil`
--

INSERT INTO `mobil` (`nopol`, `brand`, `type`, `tahun`, `harga`, `foto`, `status`) VALUES
('23132', 'Tesla', 'dqwd', '2024-10-11', 2321.00, 'figma fataa woila😦😀.png', 'tersedia'),
('57464', 'Bugatti', 'chyron', '2024-10-20', 2321.00, 'parental-advisory-transparent-yellow-9.png', 'tersedia');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

DROP TABLE IF EXISTS `transaksi`;
CREATE TABLE IF NOT EXISTS `transaksi` (
  `transaksiId` int NOT NULL AUTO_INCREMENT,
  `nik` int NOT NULL,
  `nopol` varchar(10) NOT NULL,
  `tgl_booking` date NOT NULL,
  `tgl_ambil` date NOT NULL,
  `tgl_kembali` date NOT NULL,
  `supir` tinyint(1) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `downpayment` decimal(10,2) NOT NULL,
  `kekurangan` decimal(10,2) NOT NULL,
  `status` enum('booking','approve','ambil','kembali') NOT NULL,
  PRIMARY KEY (`transaksiId`)
) ENGINE=MyISAM AUTO_INCREMENT=671668398 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `transaksi`
--

INSERT INTO `transaksi` (`transaksiId`, `nik`, `nopol`, `tgl_booking`, `tgl_ambil`, `tgl_kembali`, `supir`, `total`, `downpayment`, `kekurangan`, `status`) VALUES
(671668397, 4555566, '57464', '2024-12-02', '2024-12-12', '2024-12-26', 1, 38027264.00, 77577.00, 37949687.00, 'kembali'),
(671668396, 5745745, '23132', '2024-10-23', '2024-10-24', '2024-11-01', 1, 594176.00, 194176.00, 400000.00, 'kembali'),
(671668395, 5745745, '23132', '2024-10-23', '2024-10-25', '2024-10-31', 1, 148544.00, 30000.00, 118544.00, 'kembali');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `userId` int NOT NULL AUTO_INCREMENT,
  `user` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `lvl` enum('admin','petugas') NOT NULL,
  PRIMARY KEY (`userId`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`userId`, `user`, `password`, `lvl`) VALUES
(5, 'a', '$2y$10$Bj0/IjVY3MbiW1gyoxn6GeIGAjiqrcFliaLUx2yrhoK527BBUV3Ka', 'admin'),
(8, 'p', '$2y$10$LOaMdPl7h9J8oNfL3DTRMu0FLZkIACizaT31XCAbulVtzSc12WNbe', 'petugas');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
