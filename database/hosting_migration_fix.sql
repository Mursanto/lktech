-- ============================================================
-- HOSTING MIGRATION FIX SCRIPT
-- Jalankan di phpMyAdmin hosting: db_lktech
-- Dibuat: 2026-09-24
-- Tujuan: Menambahkan kolom-kolom baru yang belum ada di hosting
-- ============================================================

-- 1. TABLE: investors (BARU)
CREATE TABLE IF NOT EXISTS `investors` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `share_percentage` decimal(5,2) NOT NULL DEFAULT '0.00',
  `notes` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. TABLE: products
ALTER TABLE `products` ADD COLUMN IF NOT EXISTS `ownership_type` ENUM('lktech','investor') NOT NULL DEFAULT 'lktech' AFTER `tipe_stok`;
ALTER TABLE `products` ADD COLUMN IF NOT EXISTS `investor_id` bigint(20) UNSIGNED DEFAULT NULL AFTER `ownership_type`;
ALTER TABLE `products` ADD COLUMN IF NOT EXISTS `views_count` bigint(20) UNSIGNED NOT NULL DEFAULT '0' AFTER `tipe_stok`;
ALTER TABLE `products` ADD COLUMN IF NOT EXISTS `is_banner_hero` tinyint(1) NOT NULL DEFAULT '0' AFTER `views_count`;
ALTER TABLE `products` ADD COLUMN IF NOT EXISTS `is_promo_utama` tinyint(1) NOT NULL DEFAULT '0' AFTER `is_banner_hero`;
ALTER TABLE `products` ADD COLUMN IF NOT EXISTS `video_url` varchar(500) DEFAULT NULL AFTER `image_path`;

-- Foreign key investor_id -> investors
SET @fk_exists = (SELECT COUNT(*) FROM information_schema.TABLE_CONSTRAINTS WHERE CONSTRAINT_SCHEMA = DATABASE() AND TABLE_NAME = 'products' AND CONSTRAINT_NAME = 'products_investor_id_foreign' AND CONSTRAINT_TYPE = 'FOREIGN KEY');
SET @sql = IF(@fk_exists = 0, 'ALTER TABLE `products` ADD CONSTRAINT `products_investor_id_foreign` FOREIGN KEY (`investor_id`) REFERENCES `investors` (`id`) ON DELETE SET NULL', 'SELECT 1');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

-- 3. TABLE: sales
ALTER TABLE `sales` ADD COLUMN IF NOT EXISTS `order_status` ENUM('menunggu_pembayaran','diproses','selesai','batal') NOT NULL DEFAULT 'menunggu_pembayaran' AFTER `payment_status`;
ALTER TABLE `sales` ADD COLUMN IF NOT EXISTS `subtotal` int(11) NOT NULL DEFAULT '0' AFTER `total_amount`;
ALTER TABLE `sales` ADD COLUMN IF NOT EXISTS `discount` int(11) NOT NULL DEFAULT '0' AFTER `subtotal`;

-- Backfill data
UPDATE `sales` SET `order_status` = 'selesai' WHERE `payment_status` = 'success' AND `order_status` = 'menunggu_pembayaran';
UPDATE `sales` SET `order_status` = 'batal' WHERE `payment_status` = 'failed' AND `order_status` = 'menunggu_pembayaran';
UPDATE `sales` SET `subtotal` = `total_amount` WHERE `subtotal` = 0 AND `total_amount` > 0;

-- 4. TABLE: sale_details
ALTER TABLE `sale_details` ADD COLUMN IF NOT EXISTS `investor_payout_status` ENUM('pending','paid') NOT NULL DEFAULT 'pending' AFTER `profit`;
ALTER TABLE `sale_details` ADD COLUMN IF NOT EXISTS `payout_date` date DEFAULT NULL AFTER `investor_payout_status`;
ALTER TABLE `sale_details` ADD COLUMN IF NOT EXISTS `payout_account` varchar(255) DEFAULT NULL AFTER `payout_date`;
ALTER TABLE `sale_details` ADD COLUMN IF NOT EXISTS `payout_attachment` varchar(255) DEFAULT NULL AFTER `payout_account`;

-- 5. TABLE: web_settings
ALTER TABLE `web_settings` ADD COLUMN IF NOT EXISTS `promo_product_links` json DEFAULT NULL AFTER `promo_banners`;
ALTER TABLE `web_settings` ADD COLUMN IF NOT EXISTS `is_promo_active` tinyint(1) NOT NULL DEFAULT '1' AFTER `id`;

-- 6. Verifikasi
SELECT 'products' as tabel, COLUMN_NAME as kolom, COLUMN_TYPE as tipe FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'products' AND COLUMN_NAME IN ('ownership_type','investor_id','views_count','is_banner_hero','is_promo_utama','video_url')
UNION ALL
SELECT 'sales', COLUMN_NAME, COLUMN_TYPE FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'sales' AND COLUMN_NAME IN ('order_status','subtotal','discount')
UNION ALL
SELECT 'sale_details', COLUMN_NAME, COLUMN_TYPE FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'sale_details' AND COLUMN_NAME IN ('investor_payout_status','payout_date','payout_account','payout_attachment')
UNION ALL
SELECT 'web_settings', COLUMN_NAME, COLUMN_TYPE FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'web_settings' AND COLUMN_NAME IN ('promo_product_links','is_promo_active')
ORDER BY tabel, kolom;
