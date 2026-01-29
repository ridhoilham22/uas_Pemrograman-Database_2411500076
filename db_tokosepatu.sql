-- phpMyAdmin SQL Dump
-- Database: db_toko_sepatu

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS `db_toko_sepatu`;
USE `db_toko_sepatu`;

-- --------------------------------------------------------
-- Table admin
-- --------------------------------------------------------
CREATE TABLE `admin` (
  `id_admin` int NOT NULL AUTO_INCREMENT,
  `email` varchar(128) NOT NULL,
  `username` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `nama_lengkap` varchar(128) NOT NULL,
  PRIMARY KEY (`id_admin`)
) ENGINE=InnoDB;

INSERT INTO `admin` VALUES
(1, 'admin@tokosepatu.com', 'admin', '12345', 'Admin Toko');

-- --------------------------------------------------------
-- Table pelanggan
-- --------------------------------------------------------
CREATE TABLE `pelanggan` (
  `id_pelanggan` int NOT NULL AUTO_INCREMENT,
  `nama_lengkap` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `alamat` varchar(128) NOT NULL,
  `no_telepon` varchar(15) NOT NULL,
  `foto_profil` varchar(128) NOT NULL,
  PRIMARY KEY (`id_pelanggan`)
) ENGINE=InnoDB;

-- --------------------------------------------------------
-- Table sepatu
-- --------------------------------------------------------
CREATE TABLE `sepatu` (
  `id_sepatu` int NOT NULL AUTO_INCREMENT,
  `nama_sepatu` varchar(128) NOT NULL,
  `merek` varchar(128) NOT NULL,
  `ukuran` varchar(10) NOT NULL,
  `tahun_rilis` varchar(4) NOT NULL,
  `stok` int NOT NULL,
  `gambar_sepatu` varchar(200) NOT NULL,
  PRIMARY KEY (`id_sepatu`)
) ENGINE=InnoDB;

-- --------------------------------------------------------
-- Table kategori
-- --------------------------------------------------------
CREATE TABLE `kategori` (
  `id_kategori` int NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(128) NOT NULL,
  PRIMARY KEY (`id_kategori`)
) ENGINE=InnoDB;

-- --------------------------------------------------------
-- Table sepatu_kategori
-- --------------------------------------------------------
CREATE TABLE `sepatu_kategori` (
  `id_sepatu` int NOT NULL,
  `id_kategori` int NOT NULL,
  KEY `id_sepatu_fk` (`id_sepatu`),
  KEY `id_kategori_fk` (`id_kategori`),
  CONSTRAINT `id_sepatu_fk` FOREIGN KEY (`id_sepatu`) REFERENCES `sepatu` (`id_sepatu`),
  CONSTRAINT `id_kategori_fk` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`)
) ENGINE=InnoDB;

-- --------------------------------------------------------
-- Table booking (reservasi sepatu)
-- --------------------------------------------------------
CREATE TABLE `booking` (
  `id_booking` int NOT NULL AUTO_INCREMENT,
  `tanggal_booking` date NOT NULL,
  `status` varchar(32) NOT NULL,
  `id_pelanggan` int NOT NULL,
  `id_sepatu` int NOT NULL,
  PRIMARY KEY (`id_booking`),
  KEY `id_pelanggan_fk` (`id_pelanggan`),
  KEY `id_sepatu_fk2` (`id_sepatu`),
  CONSTRAINT `id_pelanggan_fk` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`),
  CONSTRAINT `id_sepatu_fk2` FOREIGN KEY (`id_sepatu`) REFERENCES `sepatu` (`id_sepatu`)
) ENGINE=InnoDB;

-- --------------------------------------------------------
-- Table transaksi (pengganti peminjaman)
-- --------------------------------------------------------
CREATE TABLE `transaksi` (
  `id_transaksi` int NOT NULL AUTO_INCREMENT,
  `tanggal_transaksi` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `status` varchar(32) NOT NULL,
  `id_pelanggan` int NOT NULL,
  `id_sepatu` int NOT NULL,
  PRIMARY KEY (`id_transaksi`),
  KEY `id_pelanggan_f` (`id_pelanggan`),
  KEY `id_sepatu_f` (`id_sepatu`),
  CONSTRAINT `id_pelanggan_f` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`),
  CONSTRAINT `id_sepatu_f` FOREIGN KEY (`id_sepatu`) REFERENCES `sepatu` (`id_sepatu`)
) ENGINE=InnoDB;

COMMIT;
