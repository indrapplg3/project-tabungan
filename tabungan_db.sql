-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 20 Apr 2026 pada 04.14
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tabungan_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `menabung`
--

CREATE TABLE `menabung` (
  `id` int(11) NOT NULL,
  `tabungan_id` int(11) DEFAULT NULL,
  `nominal` int(11) DEFAULT NULL,
  `tanggal` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `menabung`
--

INSERT INTO `menabung` (`id`, `tabungan_id`, `nominal`, `tanggal`) VALUES
(9, 9, 1, '2026-04-11'),
(10, 9, 111, '2026-04-11'),
(11, 9, 111, '2026-04-11'),
(12, 9, 10, '2026-04-11'),
(18, 14, 1000, NULL),
(20, 14, 19000, NULL),
(21, 12, 22, NULL),
(22, 17, 20000, NULL),
(23, 18, 20000, NULL),
(24, 19, 3000, NULL),
(25, 20, 20000, NULL),
(27, 23, 100000, NULL),
(29, 22, 200000, NULL),
(30, 26, 1000, NULL),
(31, 27, 100000, NULL),
(32, 22, 150000, NULL),
(33, 28, 20000, NULL),
(34, 29, 200000, NULL),
(35, 29, 100000, NULL),
(36, 31, 1000, NULL),
(37, 31, 5000, NULL),
(39, 33, 200000, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tabungan`
--

CREATE TABLE `tabungan` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `judul` varchar(100) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `target_nominal` int(11) DEFAULT NULL,
  `target_tanggal` date DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'belum',
  `tanggal_mulai` date DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tabungan`
--

INSERT INTO `tabungan` (`id`, `user_id`, `judul`, `foto`, `target_nominal`, `target_tanggal`, `status`, `tanggal_mulai`, `updated_at`) VALUES
(9, 1, 'beli ipon', '6.-Upacara-Adat-Mallasuang-Manu.jpeg', 1222, '2026-04-17', 'selesai', '2026-04-18', NULL),
(12, 1, 'beli ipon', '6b4e49c5263140c330f3250a50fa7d6a.jpg', 22, '2026-04-25', 'selesai', '2026-04-11', NULL),
(14, 1, 'motor', 'aplikasi.jpg', 20000, '2026-04-21', 'selesai', '2026-04-11', NULL),
(17, 1, 'beli ipon', '1776350259_delete.png', 20000, '2026-04-24', 'selesai', '2026-04-16', NULL),
(18, 1, 'motor', '1776350397_delete.png', 20000, '2026-04-30', 'selesai', '2026-04-22', NULL),
(19, 1, 'motorrrr', '1776351303_delete.png', 3000, '2026-04-24', 'selesai', '2026-04-16', NULL),
(20, 8, 'motorrrr', '1776352208_26januari1.png', 20000, '2026-04-17', 'selesai', '2026-04-16', NULL),
(22, 8, 'beli ipon', '1776354147_navbar2.png', 350000, '2026-05-09', 'selesai', '2026-04-17', '2026-04-19 06:37:35'),
(23, 8, 'beli ipon', '1776354253_insert mapel.png', 100000, '2026-04-25', 'selesai', '2026-04-17', NULL),
(26, 8, 'HALIMUN', '1776427702_5b643d01-61f4-4f64-b45a-340726163a7d.jpg', 200000, '2026-04-29', 'belum', '2026-04-23', NULL),
(27, 8, 'azka', '1776553081_assets burung.png', 100000, '2026-04-30', 'selesai', '2026-04-20', NULL),
(28, 12, 'motor', '1776566498_26januari2.png', 20000, '2026-04-29', 'selesai', '2026-04-20', '2026-04-19 09:43:10'),
(29, 12, 'beli ipon', '1776566549_delete.png', 300000, '2026-04-29', 'selesai', '2026-04-20', '2026-04-19 09:44:03'),
(30, 1, 'beli ipon', '1776594046_faktur.png', 100000, '2026-04-30', 'belum', '2026-04-25', NULL),
(31, 15, 'motor', '1776595749_Chai-Kwe.webp', 30000, '2026-04-30', 'belum', '2026-04-19', NULL),
(33, 15, 'beli ipon', '1776595835_6b4e49c5263140c330f3250a50fa7d6a.jpg', 200000, '2026-04-19', 'selesai', '2026-04-19', '2026-04-19 17:50:52'),
(34, 4, 'beli ipon', '1776596029_6.-Upacara-Adat-Mallasuang-Manu.jpeg', 20000, '2026-04-23', 'belum', '2026-04-21', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`) VALUES
(1, 'indra', 'indra@gmail.com', '202cb962ac59075b964b07152d234b70'),
(4, 'hasan', 'indraa@gmail.com', '202cb962ac59075b964b07152d234b70'),
(5, 'candra', 'indraq@gmail.com', '202cb962ac59075b964b07152d234b70'),
(6, 'candra', 'indrap@gmail.com', '202cb962ac59075b964b07152d234b70'),
(7, 'popo', 'indrau@gmail.com', '202cb962ac59075b964b07152d234b70'),
(8, 'hasan', 'iindra@gmail.com', '202cb962ac59075b964b07152d234b70'),
(9, 'hasan', 'inndra@gmail.com', '202cb962ac59075b964b07152d234b70'),
(10, 'hasan', 'inddra@gmail.com', '202cb962ac59075b964b07152d234b70'),
(11, 'hasan', 'indrRa@gmail.com', '202cb962ac59075b964b07152d234b70'),
(12, 'hasan', 'ramadan@gmail.com', '202cb962ac59075b964b07152d234b70'),
(13, 'indra', 'indraramadhan@gmai.com', '202cb962ac59075b964b07152d234b70'),
(14, 'indrap', 'indrapp@gmail.com', '202cb962ac59075b964b07152d234b70'),
(15, 'INDRAA', 'INDRAAA@gmail.com', '202cb962ac59075b964b07152d234b70'),
(16, 'INDRAQ', 'iinndra@gmail.com', '202cb962ac59075b964b07152d234b70');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `menabung`
--
ALTER TABLE `menabung`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tabungan_id` (`tabungan_id`);

--
-- Indeks untuk tabel `tabungan`
--
ALTER TABLE `tabungan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `menabung`
--
ALTER TABLE `menabung`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT untuk tabel `tabungan`
--
ALTER TABLE `tabungan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `menabung`
--
ALTER TABLE `menabung`
  ADD CONSTRAINT `menabung_ibfk_1` FOREIGN KEY (`tabungan_id`) REFERENCES `tabungan` (`id`);

--
-- Ketidakleluasaan untuk tabel `tabungan`
--
ALTER TABLE `tabungan`
  ADD CONSTRAINT `tabungan_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
