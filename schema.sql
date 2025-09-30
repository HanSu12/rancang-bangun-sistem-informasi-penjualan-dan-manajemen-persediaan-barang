-- MySQL schema for UMKM Penjualan & Persediaan
-- Charset & collation
SET NAMES utf8mb4;
SET CHARACTER SET utf8mb4;
SET collation_connection = 'utf8mb4_unicode_ci';

-- Ensure database exists (optional if created elsewhere)
-- CREATE DATABASE IF NOT EXISTS `db_umkm_penjualan` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
-- USE `db_umkm_penjualan`;

-- Drop order respects foreign keys
SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS `penjualan_detail`;
DROP TABLE IF EXISTS `penjualan`;
DROP TABLE IF EXISTS `stok_masuk`;
DROP TABLE IF EXISTS `barang`;
DROP TABLE IF EXISTS `supplier`;
DROP TABLE IF EXISTS `kategori`;
DROP TABLE IF EXISTS `users`;
SET FOREIGN_KEY_CHECKS = 1;

-- users
CREATE TABLE `users` (
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`nama_lengkap` VARCHAR(100) NOT NULL,
	`username` VARCHAR(50) NOT NULL,
	`password` VARCHAR(255) NOT NULL,
	`level` ENUM('admin','kasir') NOT NULL DEFAULT 'kasir',
	`created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
	`updated_at` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`),
	UNIQUE KEY `uq_users_username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- kategori
CREATE TABLE `kategori` (
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`nama_kategori` VARCHAR(100) NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE KEY `uq_kategori_nama` (`nama_kategori`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- supplier
CREATE TABLE `supplier` (
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`nama_supplier` VARCHAR(120) NOT NULL,
	`telepon` VARCHAR(30) NULL,
	`alamat` TEXT NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- barang
CREATE TABLE `barang` (
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`kode_barang` VARCHAR(50) NOT NULL,
	`nama_barang` VARCHAR(150) NOT NULL,
	`id_kategori` INT UNSIGNED NOT NULL,
	`harga_beli` DECIMAL(15,2) NOT NULL DEFAULT 0.00,
	`harga_jual` DECIMAL(15,2) NOT NULL DEFAULT 0.00,
	`stok` INT NOT NULL DEFAULT 0,
	`satuan` VARCHAR(20) NOT NULL DEFAULT 'pcs',
	`created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`),
	UNIQUE KEY `uq_barang_kode` (`kode_barang`),
	KEY `idx_barang_kategori` (`id_kategori`),
	CONSTRAINT `fk_barang_kategori` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id`) ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- penjualan
CREATE TABLE `penjualan` (
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`no_faktur` VARCHAR(50) NOT NULL,
	`total_harga` DECIMAL(15,2) NOT NULL DEFAULT 0.00,
	`jumlah_uang` DECIMAL(15,2) NOT NULL DEFAULT 0.00,
	`kembalian` DECIMAL(15,2) NOT NULL DEFAULT 0.00,
	`id_user` INT UNSIGNED NOT NULL,
	`created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`),
	UNIQUE KEY `uq_penjualan_faktur` (`no_faktur`),
	KEY `idx_penjualan_user` (`id_user`),
	CONSTRAINT `fk_penjualan_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- penjualan_detail
CREATE TABLE `penjualan_detail` (
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`id_penjualan` INT UNSIGNED NOT NULL,
	`id_barang` INT UNSIGNED NOT NULL,
	`harga_saat_transaksi` DECIMAL(15,2) NOT NULL,
	`jumlah` INT NOT NULL DEFAULT 1,
	`sub_total` DECIMAL(15,2) NOT NULL,
	PRIMARY KEY (`id`),
	KEY `idx_detail_penjualan` (`id_penjualan`),
	KEY `idx_detail_barang` (`id_barang`),
	CONSTRAINT `fk_detail_penjualan` FOREIGN KEY (`id_penjualan`) REFERENCES `penjualan` (`id`) ON UPDATE CASCADE ON DELETE CASCADE,
	CONSTRAINT `fk_detail_barang` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id`) ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- stok_masuk
CREATE TABLE `stok_masuk` (
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`id_barang` INT UNSIGNED NOT NULL,
	`id_supplier` INT UNSIGNED NOT NULL,
	`jumlah` INT NOT NULL,
	`tanggal_masuk` DATE NOT NULL,
	`keterangan` VARCHAR(191) NULL,
	PRIMARY KEY (`id`),
	KEY `idx_stok_barang` (`id_barang`),
	KEY `idx_stok_supplier` (`id_supplier`),
	CONSTRAINT `fk_stok_barang` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id`) ON UPDATE CASCADE ON DELETE RESTRICT,
	CONSTRAINT `fk_stok_supplier` FOREIGN KEY (`id_supplier`) REFERENCES `supplier` (`id`) ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
