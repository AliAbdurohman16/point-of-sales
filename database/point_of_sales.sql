-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 28 Feb 2022 pada 12.17
-- Versi server: 10.4.21-MariaDB
-- Versi PHP: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `point_of_sales`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `katid` int(11) NOT NULL,
  `katnama` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`katid`, `katnama`) VALUES
(1, 'Makanan'),
(2, 'Minuman'),
(3, 'Obat'),
(4, 'Pakaian'),
(5, 'Elektronik'),
(43, 'Rokok'),
(44, 'Buah-buahan'),
(47, 'Keripik');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2021-02-23-084451', 'App\\Database\\Migrations\\Kategori', 'default', 'App', 1644627542, 1),
(2, '2021-02-23-085017', 'App\\Database\\Migrations\\Satuan', 'default', 'App', 1644627543, 1),
(3, '2021-02-23-091656', 'App\\Database\\Migrations\\Produk', 'default', 'App', 1644627543, 1),
(4, '2021-02-24-161052', 'App\\Database\\Migrations\\Supplier', 'default', 'App', 1644627543, 1),
(5, '2021-02-24-161641', 'App\\Database\\Migrations\\Pembelian', 'default', 'App', 1644627546, 1),
(6, '2021-02-24-163504', 'App\\Database\\Migrations\\Pembeliandetail', 'default', 'App', 1644627548, 1),
(7, '2021-02-24-170642', 'App\\Database\\Migrations\\Pelanggan', 'default', 'App', 1644627549, 1),
(8, '2021-02-24-170646', 'App\\Database\\Migrations\\Penjualan', 'default', 'App', 1644627551, 1),
(9, '2021-02-24-170649', 'App\\Database\\Migrations\\Penjualandetail', 'default', 'App', 1644627553, 1),
(10, '2021-02-24-170651', 'App\\Database\\Migrations\\Temppenjualan', 'default', 'App', 1644627555, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelanggan`
--

CREATE TABLE `pelanggan` (
  `pel_kode` int(11) NOT NULL,
  `pel_nama` varchar(100) NOT NULL,
  `pel_alamat` text NOT NULL,
  `pel_telp` char(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `pelanggan`
--

INSERT INTO `pelanggan` (`pel_kode`, `pel_nama`, `pel_alamat`, `pel_telp`) VALUES
(0, '-', '-', '-');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembelian`
--

CREATE TABLE `pembelian` (
  `beli_faktur` char(20) NOT NULL,
  `beli_tgl` date NOT NULL,
  `beli_jenisbayar` enum('T','K') NOT NULL DEFAULT 'T',
  `beli_supkode` int(11) NOT NULL,
  `beli_dispersen` double(11,2) NOT NULL DEFAULT 0.00,
  `beli_disuang` double(11,2) NOT NULL DEFAULT 0.00,
  `beli_totalkotor` double(11,2) NOT NULL DEFAULT 0.00,
  `beli_totalbersih` double(11,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembelian_detail`
--

CREATE TABLE `pembelian_detail` (
  `detbeli_id` bigint(11) NOT NULL,
  `detbeli_faktur` char(20) NOT NULL,
  `detbeli_kodebarcode` char(50) NOT NULL,
  `detbeli_hargabeli` double(11,2) NOT NULL DEFAULT 0.00,
  `detbeli_hargajual` double(11,2) NOT NULL DEFAULT 0.00,
  `detbeli_jml` double(11,2) NOT NULL DEFAULT 0.00,
  `detbeli_subtotal` double(11,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `penjualan`
--

CREATE TABLE `penjualan` (
  `jual_faktur` char(20) NOT NULL,
  `jual_tgl` date NOT NULL,
  `jual_pelkode` int(11) NOT NULL,
  `jual_dispersen` double(11,2) NOT NULL DEFAULT 0.00,
  `jual_disuang` double(11,2) NOT NULL DEFAULT 0.00,
  `jual_totalkotor` double(11,2) NOT NULL DEFAULT 0.00,
  `jual_totalbersih` double(11,2) NOT NULL DEFAULT 0.00,
  `jual_jmluang` double(11,2) NOT NULL,
  `jual_sisauang` double(11,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `penjualan`
--

INSERT INTO `penjualan` (`jual_faktur`, `jual_tgl`, `jual_pelkode`, `jual_dispersen`, `jual_disuang`, `jual_totalkotor`, `jual_totalbersih`, `jual_jmluang`, `jual_sisauang`) VALUES
('FJ2702220001', '2022-02-27', 0, 0.00, 0.00, 10500.00, 10500.00, 11000.00, 500.00),
('FJ2702220002', '2022-02-27', 0, 0.00, 0.00, 3500.00, 3500.00, 5000.00, 1500.00),
('FJ2702220003', '2022-02-27', 0, 0.00, 0.00, 35000.00, 35000.00, 35000.00, 0.00),
('FJ2802220001', '2022-02-28', 0, 0.00, 0.00, 6500.00, 6500.00, 10000.00, 3500.00),
('FJ3112690001', '2022-02-25', 0, 10.00, 0.00, 162000.00, 145800.00, 150000.00, 4200.00);

-- --------------------------------------------------------

--
-- Struktur dari tabel `penjualan_detail`
--

CREATE TABLE `penjualan_detail` (
  `detjual_id` bigint(11) NOT NULL,
  `detjual_faktur` char(20) NOT NULL,
  `detjual_kodebarcode` char(50) NOT NULL,
  `detjual_hargabeli` double(11,2) NOT NULL DEFAULT 0.00,
  `detjual_hargajual` double(11,2) NOT NULL DEFAULT 0.00,
  `detjual_jml` double(11,2) NOT NULL DEFAULT 0.00,
  `detjual_subtotal` double(11,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `penjualan_detail`
--

INSERT INTO `penjualan_detail` (`detjual_id`, `detjual_faktur`, `detjual_kodebarcode`, `detjual_hargabeli`, `detjual_hargajual`, `detjual_jml`, `detjual_subtotal`) VALUES
(7, 'FJ3112690001', '786284', 3999.00, 4000.00, 3.00, 12000.00),
(8, 'FJ3112690001', '287878888', 49999.00, 50000.00, 3.00, 150000.00),
(9, 'FJ2702220001', '2763238', 2999.00, 3500.00, 3.00, 10500.00),
(10, 'FJ2702220002', '2763238', 2999.00, 3500.00, 1.00, 3500.00),
(11, 'FJ2702220003', '2763238', 2999.00, 3500.00, 5.00, 17500.00),
(12, 'FJ2702220003', '2367237', 2999.00, 3500.00, 5.00, 17500.00),
(13, 'FJ2802220001', '2763238', 2999.00, 3500.00, 1.00, 3500.00),
(14, 'FJ2802220001', '27392983792', 2789.00, 3000.00, 1.00, 3000.00);

--
-- Trigger `penjualan_detail`
--
DELIMITER $$
CREATE TRIGGER `tri_delete_penjualan_detail` AFTER DELETE ON `penjualan_detail` FOR EACH ROW UPDATE produk SET stok_tersedia = stok_tersedia + old.detjual_jml WHERE kodebarcode = old.detjual_kodebarcode
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tri_insert_penjualan_detail` AFTER INSERT ON `penjualan_detail` FOR EACH ROW UPDATE produk SET stok_tersedia = stok_tersedia - new.detjual_jml WHERE kodebarcode = new.detjual_kodebarcode
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tri_update_penjualan_detail` AFTER UPDATE ON `penjualan_detail` FOR EACH ROW UPDATE produk SET stok_tersedia = (stok_tersedia + old.detjual_jml) - new.detjual_jml WHERE kodebarcode = new.detjual_kodebarcode
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk`
--

CREATE TABLE `produk` (
  `kodebarcode` char(50) NOT NULL,
  `namaproduk` varchar(100) NOT NULL,
  `produk_satid` int(11) NOT NULL,
  `produk_katid` int(11) NOT NULL,
  `stok_tersedia` double(11,2) NOT NULL DEFAULT 0.00,
  `harga_beli` double(11,2) NOT NULL DEFAULT 0.00,
  `harga_jual` double(11,2) NOT NULL DEFAULT 0.00,
  `gambar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `produk`
--

INSERT INTO `produk` (`kodebarcode`, `namaproduk`, `produk_satid`, `produk_katid`, `stok_tersedia`, `harga_beli`, `harga_jual`, `gambar`) VALUES
('2367237', 'Indomie Goreng', 1, 1, 10.00, 2999.00, 3500.00, '2367237-Indomie Goreng.jpg'),
('27392983792', 'Indomie Soto', 1, 1, 9.00, 2789.00, 3000.00, '27392983792-Mie Indomie Soto.jpg'),
('2763238', 'Sedaap Goreng', 1, 1, 3.00, 2999.00, 3500.00, '2763238-Sedaap Goreng.jpg'),
('287878888', 'Beras 10 KG', 10, 1, 10.00, 49999.00, 50000.00, ''),
('3543535', 'Kopi Kapal Api Mix', 1, 2, 0.00, 1299.00, 1500.00, '3543535-Kopi Kapal Api Mix.jpg'),
('786284', 'Frestea Original', 1, 2, 10.00, 3999.00, 4000.00, '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `satuan`
--

CREATE TABLE `satuan` (
  `satid` int(11) NOT NULL,
  `satnama` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `satuan`
--

INSERT INTO `satuan` (`satid`, `satnama`) VALUES
(1, 'Pcs'),
(2, 'Porsi'),
(3, 'Paket'),
(7, 'Bungkus'),
(10, 'Kg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `supplier`
--

CREATE TABLE `supplier` (
  `sup_kode` int(11) NOT NULL,
  `sup_nama` varchar(100) NOT NULL,
  `sup_alamat` text NOT NULL,
  `sup_telp` char(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `temp_penjualan`
--

CREATE TABLE `temp_penjualan` (
  `detjual_id` bigint(11) NOT NULL,
  `detjual_faktur` char(20) NOT NULL,
  `detjual_kodebarcode` char(50) NOT NULL,
  `detjual_hargabeli` double(11,2) NOT NULL DEFAULT 0.00,
  `detjual_hargajual` double(11,2) NOT NULL DEFAULT 0.00,
  `detjual_jml` double(11,2) NOT NULL DEFAULT 0.00,
  `detjual_subtotal` double(11,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Trigger `temp_penjualan`
--
DELIMITER $$
CREATE TRIGGER `tri_delete_temp_penjualan` AFTER DELETE ON `temp_penjualan` FOR EACH ROW UPDATE produk SET stok_tersedia = stok_tersedia + old.detjual_jml WHERE kodebarcode = old.detjual_kodebarcode
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tri_insert_temp_penjualan` AFTER INSERT ON `temp_penjualan` FOR EACH ROW UPDATE produk SET stok_tersedia = stok_tersedia - new.detjual_jml WHERE kodebarcode = new.detjual_kodebarcode
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tri_update_temp_penjualan` AFTER UPDATE ON `temp_penjualan` FOR EACH ROW UPDATE produk SET stok_tersedia = (stok_tersedia + old.detjual_jml) - new.detjual_jml WHERE kodebarcode = new.detjual_kodebarcode
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`katid`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`pel_kode`);

--
-- Indeks untuk tabel `pembelian`
--
ALTER TABLE `pembelian`
  ADD PRIMARY KEY (`beli_faktur`),
  ADD KEY `pembelian_beli_supkode_foreign` (`beli_supkode`);

--
-- Indeks untuk tabel `pembelian_detail`
--
ALTER TABLE `pembelian_detail`
  ADD PRIMARY KEY (`detbeli_id`),
  ADD KEY `pembelian_detail_detbeli_faktur_foreign` (`detbeli_faktur`),
  ADD KEY `pembelian_detail_detbeli_kodebarcode_foreign` (`detbeli_kodebarcode`);

--
-- Indeks untuk tabel `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`jual_faktur`),
  ADD KEY `penjualan_jual_pelkode_foreign` (`jual_pelkode`);

--
-- Indeks untuk tabel `penjualan_detail`
--
ALTER TABLE `penjualan_detail`
  ADD PRIMARY KEY (`detjual_id`),
  ADD KEY `penjualan_detail_detjual_faktur_foreign` (`detjual_faktur`),
  ADD KEY `penjualan_detail_detjual_kodebarcode_foreign` (`detjual_kodebarcode`);

--
-- Indeks untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`kodebarcode`),
  ADD KEY `produk_produk_satid_foreign` (`produk_satid`),
  ADD KEY `produk_produk_katid_foreign` (`produk_katid`);

--
-- Indeks untuk tabel `satuan`
--
ALTER TABLE `satuan`
  ADD PRIMARY KEY (`satid`);

--
-- Indeks untuk tabel `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`sup_kode`);

--
-- Indeks untuk tabel `temp_penjualan`
--
ALTER TABLE `temp_penjualan`
  ADD PRIMARY KEY (`detjual_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `kategori`
--
ALTER TABLE `kategori`
  MODIFY `katid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `pel_kode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `pembelian_detail`
--
ALTER TABLE `pembelian_detail`
  MODIFY `detbeli_id` bigint(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `penjualan_detail`
--
ALTER TABLE `penjualan_detail`
  MODIFY `detjual_id` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `satuan`
--
ALTER TABLE `satuan`
  MODIFY `satid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `supplier`
--
ALTER TABLE `supplier`
  MODIFY `sup_kode` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `temp_penjualan`
--
ALTER TABLE `temp_penjualan`
  MODIFY `detjual_id` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `pembelian`
--
ALTER TABLE `pembelian`
  ADD CONSTRAINT `pembelian_beli_supkode_foreign` FOREIGN KEY (`beli_supkode`) REFERENCES `supplier` (`sup_kode`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pembelian_detail`
--
ALTER TABLE `pembelian_detail`
  ADD CONSTRAINT `pembelian_detail_detbeli_faktur_foreign` FOREIGN KEY (`detbeli_faktur`) REFERENCES `pembelian` (`beli_faktur`) ON UPDATE CASCADE,
  ADD CONSTRAINT `pembelian_detail_detbeli_kodebarcode_foreign` FOREIGN KEY (`detbeli_kodebarcode`) REFERENCES `produk` (`kodebarcode`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `penjualan`
--
ALTER TABLE `penjualan`
  ADD CONSTRAINT `penjualan_jual_pelkode_foreign` FOREIGN KEY (`jual_pelkode`) REFERENCES `pelanggan` (`pel_kode`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `penjualan_detail`
--
ALTER TABLE `penjualan_detail`
  ADD CONSTRAINT `penjualan_detail_detjual_faktur_foreign` FOREIGN KEY (`detjual_faktur`) REFERENCES `penjualan` (`jual_faktur`) ON UPDATE CASCADE,
  ADD CONSTRAINT `penjualan_detail_detjual_kodebarcode_foreign` FOREIGN KEY (`detjual_kodebarcode`) REFERENCES `produk` (`kodebarcode`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD CONSTRAINT `produk_produk_katid_foreign` FOREIGN KEY (`produk_katid`) REFERENCES `kategori` (`katid`) ON UPDATE CASCADE,
  ADD CONSTRAINT `produk_produk_satid_foreign` FOREIGN KEY (`produk_satid`) REFERENCES `satuan` (`satid`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
