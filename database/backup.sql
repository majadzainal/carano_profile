-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               9.1.0 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table carano_utama_db.cache
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table carano_utama_db.cache: ~0 rows (approximately)

-- Dumping structure for table carano_utama_db.cache_locks
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table carano_utama_db.cache_locks: ~0 rows (approximately)

-- Dumping structure for table carano_utama_db.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table carano_utama_db.failed_jobs: ~0 rows (approximately)

-- Dumping structure for table carano_utama_db.faqs
CREATE TABLE IF NOT EXISTS `faqs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `question_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `question_en` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `answer_id` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `answer_en` text COLLATE utf8mb4_unicode_ci,
  `category` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Umum',
  `sort_order` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table carano_utama_db.faqs: ~6 rows (approximately)
REPLACE INTO `faqs` (`id`, `question_id`, `question_en`, `answer_id`, `answer_en`, `category`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
	(25, 'Negara asal mana saja yang menjadi cakupan utama pengiriman CARANO?', 'Which origin countries are covered by CARANO’s main import corridors?', 'Cakupan koridor utama kami meliputi penjemputan langsung dari gudang pabrik di Jepang, China, Taiwan, Korea Selatan, dan Singapura menuju Indonesia.', 'Our primary corridors cover direct factory pickup across Japan, China, Taiwan, South Korea, and Singapore into Indonesia.', 'Rute & Cakupan', 1, 1, '2026-11-24 00:19:03', '2026-11-24 00:19:03'),
	(26, 'Pelabuhan tujuan mana saja yang dilayani di Indonesia?', 'Which Indonesian destination ports do you serve?', 'Kami melayani bongkar muat dan kepabeanan di tiga pelabuhan utama Indonesia: Pelabuhan Tanjung Priok (Jakarta), Tanjung Emas (Semarang), dan Tanjung Perak (Surabaya), dilanjutkan pengiriman darat ke lokasi tujuan Anda.', 'We handle port discharge and customs clearance across Indonesia’s three major ports: Tanjung Priok (Jakarta), Tanjung Emas (Semarang), and Tanjung Perak (Surabaya), followed by domestic delivery to your destination.', 'Rute & Cakupan', 2, 1, '2026-11-24 00:19:03', '2026-11-24 00:19:03'),
	(27, 'Apakah PT. CARANO UTAMA LOGISTIK mengurus dokumen ekspor, pajak, dan Bea Cukai sekaligus?', 'Does PT. CARANO UTAMA LOGISTIK handle export docs, taxes, and Indonesian customs clearance end-to-end?', 'Ya. Kami menyediakan layanan end-to-end mulai dari pengurusan dokumen & pajak negara asal, asuransi kargo laut, hingga penyelesaian dokumen, pajak impor, dan Bea Cukai di terminal tujuan.', 'Yes. Our end-to-end service includes origin export documentation, origin taxes, marine cargo insurance, as well as import documentation, duties, and terminal customs clearance in Indonesia.', 'Dokumen & Bea Cukai', 3, 1, '2026-11-24 00:19:03', '2026-11-24 00:19:03'),
	(28, 'Apakah saya bisa mengirim kargo di bawah 1 kontainer penuh (LCL)?', 'Can we ship volumes smaller than a full container (LCL)?', 'Tentu. Selain FCL (Full Container Load 20ft/40ft), kami juga melayani pengiriman LCL dengan proses konsolidasi, stripping aman, dan trucking langsung ke alamat tujuan Anda.', 'Certainly. Alongside FCL (20ft/40ft containers), we handle LCL consolidation complete with supervised stripping and door-to-door trucking delivery.', 'Layanan', 4, 1, '2026-11-24 00:19:03', '2026-11-24 00:19:03'),
	(29, 'Apakah tersedia layanan pengiriman darat dan udara selain pengiriman laut?', 'Do you also provide domestic trucking and air freight support alongside sea freight?', 'Ya. Kami mendukung pengiriman multimoda: armada trucking untuk strapping/pickup negara asal maupun stripping/delivery domestik di Indonesia, serta opsi Air Freight untuk kebutuhan kargo mendesak.', 'Yes. We provide multimodal solutions combining origin & domestic trucking, container stripping, and priority air freight support for urgent shipments.', 'Layanan', 5, 1, '2026-11-24 00:19:03', '2026-11-24 00:19:03'),
	(30, 'Bagaimana cara meminta estimasi biaya (quotation) pengiriman?', 'How do I request a shipping quotation?', 'Anda cukup mengisi formulir Konsultasi / Minta Penawaran pada halaman Kontak dengan mencantumkan negara asal, pelabuhan tujuan, dan estimasi jenis/volume barang. Tim kami akan merespons cepat melalui email atau WhatsApp.', 'Simply complete the Request a Quote form on our Contact page with your origin country, destination port, and cargo details. Our team will promptly follow up via email or WhatsApp.', 'Penawaran', 6, 1, '2026-11-24 00:19:03', '2026-11-24 00:19:03');

-- Dumping structure for table carano_utama_db.inquiries
CREATE TABLE IF NOT EXISTS `inquiries` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `company_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `origin_country` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `destination_port` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `service_type` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cargo_details` text COLLATE utf8mb4_unicode_ci,
  `status` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'new',
  `admin_notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `inquiries_status_index` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table carano_utama_db.inquiries: ~1 rows (approximately)
REPLACE INTO `inquiries` (`id`, `company_name`, `contact_name`, `email`, `phone`, `origin_country`, `destination_port`, `service_type`, `cargo_details`, `status`, `admin_notes`, `created_at`, `updated_at`) VALUES
	(5, 'PT. Nusantara Precision Manufacturing', 'Budi Santoso', 'procurement@nusantaraprecision.co.id', '081298765432', 'Jepang', 'Pelabuhan Tanjung Priok', 'Sea Freight Impor (FCL & LCL)', 'Estimasi 1x20ft FCL komponen mesin industri dari Osaka menuju kawasan industri Cikarang. Mohon penawaran all-in termasuk asuransi dan bea cukai.', 'new', NULL, '2026-11-24 00:19:03', '2026-11-24 00:19:03');

-- Dumping structure for table carano_utama_db.jobs
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table carano_utama_db.jobs: ~0 rows (approximately)

-- Dumping structure for table carano_utama_db.job_batches
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table carano_utama_db.job_batches: ~0 rows (approximately)

-- Dumping structure for table carano_utama_db.media_files
CREATE TABLE IF NOT EXISTS `media_files` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `filename` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `original_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mime_type` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_size` bigint unsigned NOT NULL DEFAULT '0',
  `alt_text` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `uploaded_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `media_files_uploaded_by_foreign` (`uploaded_by`),
  CONSTRAINT `media_files_uploaded_by_foreign` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table carano_utama_db.media_files: ~8 rows (approximately)
REPLACE INTO `media_files` (`id`, `filename`, `original_name`, `file_path`, `mime_type`, `file_size`, `alt_text`, `uploaded_by`, `created_at`, `updated_at`) VALUES
	(17, 'logo-carano-mark.png', 'Logo Carano Baru (Emblem).png', '/images/brand/logo-carano-mark.png', 'image/png', 223317, 'Emblem Resmi PT. CARANO UTAMA LOGISTIK', 5, '2026-11-24 00:19:03', '2026-11-24 00:19:03'),
	(18, 'logo-carano-light.png', 'Logo Carano Baru (Seal Light).png', '/images/brand/logo-carano-light.png', 'image/png', 364995, 'Logo Resmi PT. CARANO UTAMA LOGISTIK (Light)', 5, '2026-11-24 00:19:03', '2026-11-24 00:19:03'),
	(19, 'logo-carano-dark.png', 'Logo Carano Baru (Seal Dark).png', '/images/brand/logo-carano-dark.png', 'image/png', 290056, 'Logo Resmi PT. CARANO UTAMA LOGISTIK (Dark)', 5, '2026-11-24 00:19:03', '2026-11-24 00:19:03'),
	(20, 'hero-port-maritime.jpg', 'Ilustrasi Pelabuhan & Kapal Kontainer.jpg', '/images/illustrations/hero-port-maritime.jpg', 'image/jpeg', 844431, 'Terminal Pelabuhan Kontainer Internasional', 5, '2026-11-24 00:19:03', '2026-11-24 00:19:03'),
	(21, 'sea-freight-vessel.jpg', 'Ilustrasi Sea Freight Kapal Laut.jpg', '/images/illustrations/sea-freight-vessel.jpg', 'image/jpeg', 1053146, 'Kapal Kontainer Sea Freight', 5, '2026-11-24 00:19:03', '2026-11-24 00:19:03'),
	(22, 'port-customs-terminal.jpg', 'Ilustrasi Terminal Bea Cukai & Trucking.jpg', '/images/illustrations/port-customs-terminal.jpg', 'image/jpeg', 797684, 'Terminal Kontainer dan Armada Trucking', 5, '2026-11-24 00:19:03', '2026-11-24 00:19:03'),
	(23, 'warehouse-export-strapping.jpg', 'Ilustrasi Gudang Pabrik & Strapping.jpg', '/images/illustrations/warehouse-export-strapping.jpg', 'image/jpeg', 902400, 'Gudang Ekspor dan Pengemasan Strapping', 5, '2026-11-24 00:19:03', '2026-11-24 00:19:03'),
	(24, 'CARANO_Road_Map_Shipment.pdf', 'CARANO_Road Map Shipment.pdf', '/uploads/docs/CARANO_Road_Map_Shipment.pdf', 'application/pdf', 94785, 'Dokumen Road Map Shipment PT. CARANO UTAMA LOGISTIK', 5, '2026-11-24 00:19:03', '2026-11-24 00:19:03');

-- Dumping structure for table carano_utama_db.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table carano_utama_db.migrations: ~4 rows (approximately)
REPLACE INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '0001_01_01_000000_create_users_table', 1),
	(2, '0001_01_01_000001_create_cache_table', 1),
	(3, '0001_01_01_000002_create_jobs_table', 1),
	(4, '2026_11_24_000001_create_carano_cms_tables', 1);

-- Dumping structure for table carano_utama_db.page_sections
CREATE TABLE IF NOT EXISTS `page_sections` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `page_slug` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `section_key` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `section_label` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `badge_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `badge_en` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_en` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subtitle_id` text COLLATE utf8mb4_unicode_ci,
  `subtitle_en` text COLLATE utf8mb4_unicode_ci,
  `body_id` longtext COLLATE utf8mb4_unicode_ci,
  `body_en` longtext COLLATE utf8mb4_unicode_ci,
  `cta_label_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cta_label_en` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cta_url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `secondary_cta_label_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `secondary_cta_label_en` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `secondary_cta_url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_path` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `extra_json` json DEFAULT NULL,
  `sort_order` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `page_sections_section_key_unique` (`section_key`),
  KEY `page_sections_page_slug_index` (`page_slug`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table carano_utama_db.page_sections: ~9 rows (approximately)
REPLACE INTO `page_sections` (`id`, `page_slug`, `section_key`, `section_label`, `badge_id`, `badge_en`, `title_id`, `title_en`, `subtitle_id`, `subtitle_en`, `body_id`, `body_en`, `cta_label_id`, `cta_label_en`, `cta_url`, `secondary_cta_label_id`, `secondary_cta_label_en`, `secondary_cta_url`, `image_path`, `extra_json`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
	(37, 'home', 'home_hero', 'Homepage — Hero Banner', 'INTEGRATED IMPORT & MULTIMODAL LOGISTICS', 'INTEGRATED IMPORT & MULTIMODAL LOGISTICS', 'Mengoptimalkan Alur Pengiriman Impor dari Pabrik Asia hingga Pintu Gudang Anda.', 'Optimizing End-to-End Import Shipments from Asian Factories to Your Warehouse.', 'PT. CARANO UTAMA LOGISTIK menangani seluruh rantai pasok impor—mulai dari strapping & trucking di Jepang, China, Taiwan, Korea & Singapura, kepabeanan ekspor-impor, perjalanan laut, hingga stripping dan delivery di Indonesia.', 'PT. CARANO UTAMA LOGISTIK manages your entire import supply chain—from factory strapping & trucking in Japan, China, Taiwan, Korea & Singapore, export-import customs, ocean freight, to stripping and final delivery across Indonesia.', NULL, NULL, 'Konsultasi Pengiriman', 'Request a Quote', '/kontak', 'Unduh Road Map PDF', 'Download Road Map PDF', '/uploads/docs/CARANO_Road_Map_Shipment.pdf', NULL, NULL, 1, 1, '2026-11-24 00:19:03', '2026-11-24 00:19:03'),
	(38, 'home', 'home_metrics', 'Homepage — Statistik Utama', 'JEJAK OPERASIONAL', 'OPERATIONAL FOOTPRINT', 'Jaringan Koridor Impor Terukur & Andal', 'Measurable & Reliable Import Corridor Network', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '{"items": [{"value": "5", "desc_en": "Japan, China, Taiwan, Korea & Singapore", "desc_id": "Jepang, China, Taiwan, Korea & Singapura", "unit_en": "Origin Countries", "unit_id": "Negara Asal"}, {"value": "3", "desc_en": "Tanjung Priok, Tanjung Emas & Tanjung Perak", "desc_id": "Tanjung Priok, Tanjung Emas & Tanjung Perak", "unit_en": "Major Indonesian Ports", "unit_id": "Pelabuhan Utama RI"}, {"value": "10", "desc_en": "Transparent end-to-end Shipment Road Map", "desc_id": "Road Map Shipment transparan dari hulu ke hilir", "unit_en": "Controlled Stages", "unit_id": "Tahap Terkontrol"}, {"value": "3", "desc_en": "Sea Freight, Inland Trucking & Air Support", "desc_id": "Laut (Sea), Darat (Trucking) & Udara (Air)", "unit_en": "Integrated Modes", "unit_id": "Moda Terpadu"}]}', 2, 1, '2026-11-24 00:19:03', '2026-11-24 00:19:03'),
	(39, 'home', 'home_challenge', 'Homepage — Tantangan & Solusi Impor', 'MENGAPA SISTEM TERINTEGRASI PENTING', 'WHY INTEGRATED LOGISTICS MATTERS', 'Menghilangkan Hambatan Klasik dalam Rantai Impor Lintas Negara.', 'Eliminating Classic Bottlenecks in Cross-Border Import Chains.', 'Koordinasi terpisah antara agen negara asal, pelayaran, bea cukai, dan trucking lokal sering menimbulkan biaya demurrage serta keterlambatan. CARANO menyatukan semuanya dalam satu kendali.', 'Fragmented coordination across origin agents, ocean carriers, customs brokers, and local haulers triggers demurrage fees and delays. CARANO unifies every stage under one accountable team.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '{"cards": [{"tag_en": "Cross-Border Docs & Taxes", "tag_id": "Dokumen & Pajak Lintas Negara", "problem_en": "Mismatched HS Codes, export docs, or incomplete insurance trigger costly cargo holds.", "problem_id": "Kesalahan HS Code, dokumen ekspor negara asal, atau kelengkapan asuransi memicu penahanan kargo.", "solution_en": "CARANO verifies origin export paperwork, origin duties, cargo insurance, and Indonesian terminal customs.", "solution_id": "Tim CARANO memverifikasi dokumen ekspor, pajak negara asal, asuransi, hingga Bea Cukai terminal Indonesia."}, {"tag_en": "Port Queue & Berthing", "tag_id": "Antrean & Sandar Pelabuhan", "problem_en": "Lack of visibility during vessel anchorage disrupts factory and warehouse receiving schedules.", "problem_id": "Kurangnya visibilitas saat kapal stand by di pelabuhan menghambat perencanaan jadwal produksi.", "solution_en": "Proactive tracking of berthing queues across Tanjung Priok, Tanjung Emas, and Tanjung Perak through discharge.", "solution_id": "Monitoring proaktif antrean kapal di Tanjung Priok, Tanjung Emas, dan Tanjung Perak hingga kontainer turun."}, {"tag_en": "Cargo Handling & Last-Mile", "tag_id": "Handling Fisik & Last-Mile", "problem_en": "Cargo damage risks during strapping/stripping and unreliable inland delivery fleets.", "problem_id": "Risiko kerusakan barang saat loading/stripping dan keterlambatan armada pengiriman darat.", "solution_en": "Strict origin factory strapping paired with disciplined stripping, trucking, and on-time door delivery.", "solution_id": "Standar strapping ketat di pabrik asal serta proses stripping, trucking, dan delivery tepat waktu ke lokasi tujuan."}]}', 3, 1, '2026-11-24 00:19:03', '2026-11-24 00:19:03'),
	(40, 'home', 'home_roadmap_intro', 'Homepage — Intro Road Map Shipment', 'ROAD MAP SHIPMENT', 'ROAD MAP SHIPMENT', '10 Tahap Pengiriman Terstruktur dari Pabrik Asal ke Tujuan Akhir.', '10 Structured Shipment Stages from Origin Factory to Final Destination.', 'Klik setiap tahapan di bawah untuk melihat bagaimana PT. CARANO UTAMA LOGISTIK menjaga ketepatan dokumen, keamanan fisik kargo, dan kecepatan arus barang Anda.', 'Select each stage below to see how PT. CARANO UTAMA LOGISTIK ensures document compliance, physical cargo safety, and smooth freight flow.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, 1, '2026-11-24 00:19:03', '2026-11-24 00:19:03'),
	(41, 'home', 'home_services_intro', 'Homepage — Intro Layanan Modular', 'SOLUSI LAYANAN', 'OUR SOLUTIONS', 'Layanan Logistik Modular Sesuai Skala Bisnis Anda.', 'Modular Logistics Solutions Tailored to Your Business Scale.', 'Baik pengiriman kontainer penuh (FCL), konsolidasi (LCL), pengurusan bea cukai khusus, maupun dukungan pengiriman udara mendesak.', 'Whether Full Container Load (FCL), consolidation (LCL), dedicated customs brokerage, or urgent air freight support.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, 1, '2026-11-24 00:19:03', '2026-11-24 00:19:03'),
	(42, 'home', 'home_network_intro', 'Homepage — Intro Jaringan Rute', 'JARINGAN RUTE INTERNASIONAL', 'INTERNATIONAL CORRIDOR NETWORK', 'Menghubungkan 5 Pusat Industri Asia ke 3 Gerbang Maritim Indonesia.', 'Connecting 5 Asian Manufacturing Hubs to 3 Indonesian Maritime Gateways.', 'Arahkan kursor atau pilih hub negara asal dan pelabuhan tujuan pada peta untuk mengeksplorasi cakupan operasional aktif kami.', 'Hover or click any origin hub or Indonesian destination port on the map to explore our active corridor coverage.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, 1, '2026-11-24 00:19:03', '2026-11-24 00:19:03'),
	(43, 'home', 'home_why_us', 'Homepage — Keunggulan CARANO', 'KEUNGGULAN KAMI', 'WHY CARANO', 'Ketelitian Operasional Berpadu dengan Dedikasi Layanan.', 'Operational Precision Paired with Dedicated Accountability.', 'Sebagaimana filosofi Carano—wadah kehormatan yang menyambut dengan amanah—kami memperlakukan setiap kontainer dan dokumen klien dengan standar tertinggi.', 'Inspired by the Carano—a traditional emblem of honor and trust—we safeguard every client container and document with uncompromising standards.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '{"pillars": [{"desc_en": "Unified coordination from overseas factory pickup through warehouse unloading.", "desc_id": "Koordinasi terpusat dari pabrik di luar negeri hingga pembongkaran di gudang Anda.", "title_en": "Single Point of Contact", "title_id": "Satu Pintu (Single Point of Contact)"}, {"desc_en": "Full legal handling of export docs, cargo insurance, duties, and Indonesian terminal customs.", "desc_id": "Pengurusan legal dokumen ekspor, asuransi kargo, pajak, dan kepabeanan terminal Indonesia.", "title_en": "Customs & Tax Compliance", "title_id": "Kepatuhan Bea Cukai & Pajak"}, {"desc_en": "On-ground teams across Tanjung Priok, Tanjung Emas, and Tanjung Perak.", "desc_id": "Tim lapangan langsung di Tanjung Priok, Tanjung Emas, dan Tanjung Perak.", "title_en": "3 Strategic Java Ports Coverage", "title_id": "Cakupan 3 Pelabuhan Strategis Jawa"}, {"desc_en": "Structured milestone updates across loading, sea transit, berthing queue, and final delivery.", "desc_id": "Pembaruan berkala di tiap fase: loading, perjalanan laut, antrean sandar, hingga delivery.", "title_en": "Proactive Milestone Updates", "title_id": "Transparansi Status Real-Time"}]}', 7, 1, '2026-11-24 00:19:03', '2026-11-24 00:19:03'),
	(44, 'home', 'home_cta', 'Homepage — Pre-Footer CTA Banner', 'SIAP MENGIRIM BERSAMA CARANO?', 'READY TO SHIP WITH CARANO?', 'Diskusikan Kebutuhan Impor & Dapatkan Estimasi Rute Terbaik.', 'Discuss Your Import Plan & Receive a Tailored Route Estimate.', 'Tim konsultan logistik PT. CARANO UTAMA LOGISTIK siap membantu menghitung estimasi waktu, kebutuhan dokumen, dan penawaran transparan untuk rute Asia Timur – Indonesia.', 'Our logistics specialists at PT. CARANO UTAMA LOGISTIK are ready to assist with lead times, document checklists, and transparent East Asia – Indonesia quotations.', NULL, NULL, 'Minta Penawaran Sekarang', 'Request a Quote Now', '/kontak', 'Lihat Alur 10 Tahap', 'Explore 10-Step Roadmap', '/alur-pengiriman', NULL, NULL, 8, 1, '2026-11-24 00:19:03', '2026-11-24 00:19:03'),
	(45, 'about', 'about_story', 'Tentang Kami — Profil, Visi & Misi', 'TENTANG PT. CARANO UTAMA LOGISTIK', 'ABOUT PT. CARANO UTAMA LOGISTIK', 'Menjembatani Perdagangan Global dengan Amanah, Presisi, dan Integrasi Multimoda.', 'Bridging Global Trade with Trust, Precision, and Multimodal Integration.', 'PT. CARANO UTAMA LOGISTIK adalah perusahaan jasa pengurusan transportasi dan logistik impor yang berfokus pada koridor industri Asia Timur dan Asia Tenggara menuju Indonesia.', 'PT. CARANO UTAMA LOGISTIK is an international freight forwarding and import logistics company focused on East and Southeast Asian industrial corridors into Indonesia.', '<p>Berlandaskan filosofi <strong>Carano</strong>—simbol penghormatan dan ketulusan pelayanan dalam budaya Nusantara—kami hadir membawa standar baru dalam pengelolaan logistik impor. Logo kami memadukan wadah Carano yang menopang bola dunia serta tiga moda transportasi utama: <strong>Laut, Darat, dan Udara</strong>.</p><p>Dengan fokus rute dari gudang pabrik di <strong>Jepang, China, Taiwan, Korea Selatan, dan Singapura</strong> menuju <strong>Tanjung Priok, Tanjung Emas, dan Tanjung Perak</strong>, kami memastikan setiap proses mulai dari strapping, dokumen ekspor, asuransi, kepabeanan terminal, hingga pengiriman darat berjalan terukur dan bebas hambatan.</p>', '<p>Rooted in the philosophy of the <strong>Carano</strong>—a traditional emblem of honor and sincere stewardship—we deliver a modern standard in international import logistics. Our emblem unites the Carano supporting the globe alongside three integrated transport modes: <strong>Sea, Land, and Air</strong>.</p><p>Specializing in corridors from factory warehouses across <strong>Japan, China, Taiwan, South Korea, and Singapore</strong> into <strong>Tanjung Priok, Tanjung Emas, and Tanjung Perak</strong>, we ensure every milestone from origin strapping, export documentation, insurance, terminal customs clearance, to final trucking operates smoothly and transparently.</p>', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '{"vision_en": "To be Indonesia’s most trusted import logistics partner, delivering transparent, secure, and globally competitive cross-border supply chains.", "vision_id": "Menjadi mitra logistik impor terpercaya dan terdepan di Indonesia yang menghadirkan rantai pasok lintas negara yang transparan, aman, dan berdaya saing global.", "missions_en": ["Execute our 10-step Shipment Road Map with discipline, punctuality, and clear documentation.", "Maintain full regulatory compliance across origin taxes, customs clearance, and cargo insurance.", "Cultivate dependable networks across ports, ocean carriers, and domestic trucking partners.", "Provide proactive status visibility and cost-efficient routing advice for every client."], "missions_id": ["Menjalankan 10 tahapan Road Map Shipment secara disiplin, tepat waktu, dan terdokumentasi.", "Memastikan kepatuhan penuh terhadap regulasi pajak, bea cukai, dan proteksi asuransi kargo.", "Membangun jaringan kolaborasi solid bersama mitra pelabuhan, pelayaran, dan armada darat.", "Memberikan komunikasi proaktif dan konsultasi solusi biaya yang efisien bagi setiap klien."]}', 1, 1, '2026-11-24 00:19:03', '2026-11-24 00:19:03');

-- Dumping structure for table carano_utama_db.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table carano_utama_db.password_reset_tokens: ~0 rows (approximately)

-- Dumping structure for table carano_utama_db.posts
CREATE TABLE IF NOT EXISTS `posts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(160) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_en` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `excerpt_id` text COLLATE utf8mb4_unicode_ci,
  `excerpt_en` text COLLATE utf8mb4_unicode_ci,
  `body_id` longtext COLLATE utf8mb4_unicode_ci,
  `body_en` longtext COLLATE utf8mb4_unicode_ci,
  `category` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Logistics',
  `featured_image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `published_at` timestamp NULL DEFAULT NULL,
  `author_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `posts_slug_unique` (`slug`),
  KEY `posts_author_id_foreign` (`author_id`),
  KEY `posts_status_index` (`status`),
  CONSTRAINT `posts_author_id_foreign` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table carano_utama_db.posts: ~3 rows (approximately)
REPLACE INTO `posts` (`id`, `slug`, `title_id`, `title_en`, `excerpt_id`, `excerpt_en`, `body_id`, `body_en`, `category`, `featured_image`, `meta_title`, `meta_description`, `status`, `published_at`, `author_id`, `created_at`, `updated_at`) VALUES
	(13, 'panduan-10-tahap-road-map-shipment-impor-laut', 'Memahami 10 Tahap Road Map Shipment agar Impor Laut Bebas Biaya Tak Terduga', 'Understanding the 10-Step Ocean Import Road Map to Prevent Unexpected Costs', 'Pelajari bagaimana alur pengiriman terstruktur dari pabrik di Asia Timur hingga delivery di Indonesia membantu importir menekan risiko demurrage dan keterlambatan.', 'Learn how a structured 10-step journey from East Asian factories to Indonesian warehouses helps importers eliminate demurrage and delays.', '<p>Dalam aktivitas impor lintas negara, ketidaksinkronan antara jadwal pabrik di negara asal, kesiapan dokumen ekspor, dan proses kepabeanan di pelabuhan tujuan merupakan penyebab utama pembengkakan biaya logistik.</p><h2>Mengapa Pemetaan 10 Tahap Penting?</h2><p>Di <strong>PT. CARANO UTAMA LOGISTIK</strong>, setiap pengiriman mengikuti standar <em>Road Map Shipment</em> yang terbagi dalam tiga fase besar: penanganan di negara asal (tahap 1–4), transportasi laut (tahap 5–6), serta kepabeanan dan pengiriman akhir di Indonesia (tahap 7–10).</p><blockquote>Transparansi dokumen sebelum kapal tiba di Tanjung Priok, Tanjung Emas, atau Tanjung Perak dapat memangkas waktu pengeluaran kontainer secara signifikan.</blockquote><h3>Checklist Kunci Sebelum Kapal Berangkat</h3><ul><li>Pastikan Commercial Invoice dan Packing List sesuai dengan HS Code aktual.</li><li>Aktifkan asuransi kargo laut sejak barang meninggalkan gudang pabrik asal.</li><li>Siapkan Certificate of Origin (Form E / IJEPA / AK) untuk mengoptimalkan tarif bea masuk.</li></ul>', '<p>In cross-border import operations, misalignment between overseas factory readiness, export paperwork, and destination customs clearance is the leading cause of unexpected logistics costs.</p><h2>Why a 10-Step Shipment Road Map Matters</h2><p>At <strong>PT. CARANO UTAMA LOGISTIK</strong>, every consignment follows a disciplined 10-step Road Map divided into three clear phases: origin handling (steps 1–4), international ocean transit (steps 5–6), and Indonesian terminal clearance & delivery (steps 7–10).</p><blockquote>Pre-arrival document readiness before vessel arrival at Tanjung Priok, Tanjung Emas, or Tanjung Perak significantly accelerates container release.</blockquote><h3>Key Pre-Departure Checklist</h3><ul><li>Align Commercial Invoice and Packing List descriptions with accurate HS Codes.</li><li>Activate marine cargo insurance prior to origin factory loading.</li><li>Prepare Certificates of Origin (Form E / IJEPA / AK) to optimize import duty rates.</li></ul>', 'Panduan Impor', '/images/illustrations/hero-port-maritime.jpg', 'Panduan 10 Tahap Road Map Shipment Impor Laut | PT. CARANO UTAMA LOGISTIK', 'Pelajari 10 tahap pengiriman impor laut dari pabrik Jepang, China, Taiwan, Korea & Singapura menuju Indonesia.', 'published', '2026-11-12 00:19:03', 5, '2026-11-24 00:19:03', '2026-11-24 00:19:03'),
	(14, 'memilih-pelabuhan-tujuan-tanjung-priok-emas-perak', 'Strategi Memilih Pelabuhan Tujuan: Tanjung Priok, Tanjung Emas, atau Tanjung Perak?', 'Choosing the Optimal Destination Port: Tanjung Priok, Tanjung Emas, or Tanjung Perak?', 'Menentukan pelabuhan bongkar yang paling dekat dengan pabrik atau gudang distribusi dapat menghemat biaya trucking domestik hingga puluhan persen.', 'Selecting the discharge port closest to your manufacturing or distribution hub can substantially reduce domestic haulage costs.', '<p>Pemilihan pelabuhan tujuan di Pulau Jawa sangat menentukan efisiensi total biaya <em>landed cost</em> perusahaan Anda. Meskipun Tanjung Priok merupakan pelabuhan tersibuk, pengiriman untuk kawasan industri Jawa Tengah atau Jawa Timur sering kali jauh lebih ekonomis melalui Tanjung Emas atau Tanjung Perak.</p><h2>Pertimbangan Utama Memilih Pelabuhan</h2><ul><li><strong>Tanjung Priok (Jakarta):</strong> Ideal untuk distribusi Jabodetabek, Bekasi, Cikarang, Karawang, dan Banten dengan frekuensi kapal direct tertinggi.</li><li><strong>Tanjung Emas (Semarang):</strong> Memangkas jarak trucking darat untuk kawasan industri Kendal, Semarang, Ungaran, dan Solo.</li><li><strong>Tanjung Perak (Surabaya):</strong> Gerbang terbaik untuk Jawa Timur serta distribusi lanjutan menuju Kalimantan, Sulawesi, dan Bali.</li></ul><p>Tim konsultan <strong>PT. CARANO UTAMA LOGISTIK</strong> siap membantu melakukan simulasi rute dan biaya terbaik sebelum Anda menerbitkan Purchase Order kepada supplier luar negeri.</p>', '<p>Choosing the right Indonesian port of discharge directly affects your total landed cost. While Tanjung Priok offers the highest sailing frequency, cargo destined for Central or East Java often achieves superior cost efficiency via Tanjung Emas or Tanjung Perak.</p><h2>Key Port Selection Factors</h2><ul><li><strong>Tanjung Priok (Jakarta):</strong> Best for Greater Jakarta, Cikarang, Karawang, and West Java estates with maximum direct vessel frequency.</li><li><strong>Tanjung Emas (Semarang):</strong> Minimizes inland trucking distance for Kendal, Semarang, and Central Java factories.</li><li><strong>Tanjung Perak (Surabaya):</strong> Premier gateway for East Java and onward distribution to Eastern Indonesia.</li></ul><p>Consult with <strong>PT. CARANO UTAMA LOGISTIK</strong> to compare door-to-door landed costs before finalizing supplier shipping instructions.</p>', 'Strategi Rute', '/images/illustrations/port-customs-terminal.jpg', 'Memilih Pelabuhan Tanjung Priok, Tanjung Emas & Tanjung Perak', 'Perbandingan efisiensi pelabuhan Tanjung Priok, Tanjung Emas, dan Tanjung Perak untuk impor laut Indonesia.', 'published', '2026-11-19 00:19:03', 5, '2026-11-24 00:19:03', '2026-11-24 00:19:03'),
	(15, 'pentingnya-strapping-dan-asuransi-kargo-impor', 'Mengapa Strapping di Pabrik Asal & Asuransi Kargo Tidak Boleh Diabaikan', 'Why Origin Factory Strapping & Marine Cargo Insurance Are Essential', 'Perjalanan laut internasional menghadapi getaran, kelembapan, dan proses bongkar muat berkali-kali. Begini cara melindungi investasi kargo Anda.', 'International sea voyages involve vibration, humidity, and multiple crane transfers. Here is how to protect your cargo investment.', '<p>Selama perjalanan laut dari Jepang, China, Taiwan, Korea, atau Singapura menuju Indonesia, kontainer mengalami beberapa kali pemindahan mekanis mulai dari truk pabrik, crane pelabuhan muat, tumpukan kapal, hingga proses <em>discharge</em> dan <em>stripping</em> di terminal tujuan.</p><h2>Perlindungan Fisik & Finansial</h2><p>Itulah mengapa tahap <strong>Strapping & Trucking</strong> serta <strong>Asuransi Kargo</strong> menjadi bagian tak terpisahkan dari Road Map Shipment PT. CARANO UTAMA LOGISTIK. Strapping yang tepat mencegah pergeseran palet di dalam kontainer, sementara asuransi memberikan ketenangan finansial terhadap risiko tak terduga selama transit maritim.</p>', '<p>During ocean transit from Japan, China, Taiwan, Korea, or Singapore to Indonesia, containers undergo multiple mechanical handlings from origin trucks and port cranes to vessel stacking and destination stripping.</p><h2>Physical & Financial Protection</h2><p>That is why export-grade <strong>Strapping & Trucking</strong> and <strong>Marine Cargo Insurance</strong> are built into PT. CARANO UTAMA LOGISTIK’s core Shipment Road Map—preventing cargo shift while safeguarding financial value throughout maritime transit.</p>', 'Keamanan Kargo', '/images/illustrations/warehouse-export-strapping.jpg', 'Pentingnya Strapping & Asuransi Kargo Laut Impor', 'Standar pengamanan strapping di pabrik asal dan proteksi asuransi untuk pengiriman laut internasional.', 'published', '2026-11-22 00:19:03', 5, '2026-11-24 00:19:03', '2026-11-24 00:19:03');

-- Dumping structure for table carano_utama_db.roadmap_steps
CREATE TABLE IF NOT EXISTS `roadmap_steps` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `step_number` int unsigned NOT NULL DEFAULT '1',
  `phase` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'origin',
  `title_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_en` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_id` text COLLATE utf8mb4_unicode_ci,
  `description_en` text COLLATE utf8mb4_unicode_ci,
  `highlights_id` json DEFAULT NULL,
  `highlights_en` json DEFAULT NULL,
  `icon` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'package',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table carano_utama_db.roadmap_steps: ~10 rows (approximately)
REPLACE INTO `roadmap_steps` (`id`, `step_number`, `phase`, `title_id`, `title_en`, `description_id`, `description_en`, `highlights_id`, `highlights_en`, `icon`, `is_active`, `created_at`, `updated_at`) VALUES
	(41, 1, 'origin', 'Gudang Pabrik (Jepang, China, Taiwan, Korea & Singapura)', 'Origin Factory Warehouse (Japan, China, Taiwan, Korea & Singapore)', 'Koordinasi langsung dengan supplier atau pabrik di 5 negara asal utama untuk verifikasi kesiapan barang, pengecekan packing list, dan penjadwalan penjemputan.', 'Direct coordination with overseas suppliers across 5 key Asian manufacturing hubs to verify cargo readiness, packing lists, and pickup scheduling.', '["Cakupan 5 negara asal utama Asia", "Verifikasi kuantitas & kemasan kargo", "Penjadwalan pickup langsung di pabrik"]', '["Coverage across 5 major Asian origin hubs", "Cargo quantity & packaging verification", "Direct factory pickup scheduling"]', 'factory', 1, '2026-11-24 00:19:03', '2026-11-24 00:19:03'),
	(42, 2, 'origin', 'Strapping & Trucking', 'Strapping & Origin Trucking', 'Pengikatan dan pengamanan muatan (strapping) sesuai standar ekspor internasional serta pengangkutan darat menggunakan armada truk menuju pelabuhan muat.', 'Export-grade cargo strapping and securing paired with reliable inland trucking from the factory warehouse to the port of loading.', '["Pengamanan fisik strapping & lashing", "Armada trucking terjadwal di negara asal", "Dokumentasi foto kondisi muatan"]', '["Export-grade strapping & lashing", "Scheduled origin inland trucking", "Photo documentation of cargo condition"]', 'truck', 1, '2026-11-24 00:19:03', '2026-11-24 00:19:03'),
	(43, 3, 'origin', 'Pelabuhan Muat / Asal', 'Port of Loading (Origin Port)', 'Penerimaan kargo di kawasan pelabuhan muat asal, penimbangan VGM (Verified Gross Mass), serta konsolidasi kontainer di Container Yard (CY).', 'Cargo gate-in at the origin port of loading, VGM weighing compliance, and container staging inside the Container Yard (CY).', '["Gate-in Container Yard negara asal", "Verifikasi berat kontainer (VGM)", "Sinkronisasi jadwal closing kapal"]', '["Origin Container Yard gate-in", "Verified Gross Mass (VGM) compliance", "Vessel closing schedule synchronization"]', 'anchor', 1, '2026-11-24 00:19:03', '2026-11-24 00:19:03'),
	(44, 4, 'origin', 'Pengurusan Dokumen, Pajak Negara Asal & Asuransi', 'Origin Export Docs, Local Taxes & Cargo Insurance', 'Penyelesaian dokumen ekspor (Invoice, Packing List, B/L, COO/Form E/AK/IJEPA), kewajiban pajak negara asal, serta aktivasi polis asuransi kargo laut.', 'Full execution of export documentation (Invoice, Packing List, B/L, COO), origin tax clearance, and marine cargo insurance coverage.', '["Export customs clearance & Bill of Lading", "Penyelesaian pajak ekspor negara asal", "Perlindungan asuransi kargo menyeluruh"]', '["Export clearance & Bill of Lading", "Origin country tax settlement", "Comprehensive marine cargo insurance"]', 'file-check', 1, '2026-11-24 00:19:03', '2026-11-24 00:19:03'),
	(45, 5, 'sea', 'Kontainer Masuk ke Kapal', 'Container Loading onto Vessel', 'Proses pemuatan kontainer secara aman ke atas kapal kargo (vessel loading) disertai konfirmasi On-Board Bill of Lading resmi.', 'Safe crane loading of containers aboard the designated ocean vessel followed by official On-Board Bill of Lading confirmation.', '["Konfirmasi muat kapal (On-Board)", "Validasi nomor segel & kontainer", "Penerbitan jadwal ETD & ETA resmi"]', '["Confirmed vessel On-Board status", "Container & seal number validation", "Official ETD & ETA sailing schedule"]', 'container', 1, '2026-11-24 00:19:03', '2026-11-24 00:19:03'),
	(46, 6, 'sea', 'Perjalanan Laut', 'International Ocean Voyage', 'Pemantauan perjalanan kapal kargo selama transit laut internasional hingga mendekati perairan Indonesia, disertai persiapan dokumen pra-kedatangan (pre-alert).', 'Active vessel tracking throughout the international ocean voyage accompanied by pre-arrival document preparation for faster clearance.', '["Tracking posisi kapal & pembaruan ETA", "Persiapan dokumen pra-kedatangan (Pre-Alert)", "Mitigasi dini jika ada perubahan rute"]', '["Vessel tracking & live ETA updates", "Pre-arrival customs document readiness", "Early mitigation for schedule shifts"]', 'ship', 1, '2026-11-24 00:19:03', '2026-11-24 00:19:03'),
	(47, 7, 'destination', 'Stand By di Daerah Pelabuhan & Masuk Antrian (Tanjung Priok, Tanjung Emas, Tanjung Perak)', 'Port Anchorage & Berthing Queue (Tanjung Priok, Tanjung Emas, Tanjung Perak)', 'Koordinasi kedatangan kapal saat berada di area labuh (anchorage) dan antrean sandar di 3 pelabuhan utama Indonesia: Tanjung Priok, Tanjung Emas, dan Tanjung Perak.', 'Coordinating vessel arrival at anchorage and monitoring berthing queues across Indonesia’s 3 major ports: Tanjung Priok, Tanjung Emas, and Tanjung Perak.', '["Tanjung Priok (Jakarta)", "Tanjung Emas (Semarang)", "Tanjung Perak (Surabaya)"]', '["Tanjung Priok (Jakarta)", "Tanjung Emas (Semarang)", "Tanjung Perak (Surabaya)"]', 'radar', 1, '2026-11-24 00:19:03', '2026-11-24 00:19:03'),
	(48, 8, 'destination', 'Kapal Sandar, Lalu Kontainer Keluar dari Kapal', 'Vessel Berthing & Container Discharge', 'Setelah kapal bersandar di dermaga, kontainer dibongkar dari kapal (discharge) menuju lapangan penumpukan terminal secara terpantau.', 'Upon vessel berthing at the quay, containers are discharged safely from the ship to the terminal stacking yard under active monitoring.', '["Konfirmasi sandar dermaga (Berthing)", "Pembongkaran kontainer (Discharge)", "Penerbitan Delivery Order (DO) pelayaran"]', '["Confirmed berth arrival", "Monitored container discharge", "Carrier Delivery Order (DO) processing"]', 'arrow-down-circle', 1, '2026-11-24 00:19:03', '2026-11-24 00:19:03'),
	(49, 9, 'destination', 'Pengurusan Dokumen, Pajak & Bea Cukai di Terminal', 'Import Documentation, Taxes & Terminal Customs Clearance', 'Penyelesaian PIB (Pemberitahuan Impor Barang), pembayaran bea masuk & pajak impor, pemeriksaan kepabeanan, hingga terbitnya SPPB (Surat Persetujuan Pengeluaran Barang).', 'Execution of import customs declarations (PIB), duty & import tax settlement, customs inspection coordination, through SPPB release.', '["Pengajuan PIB & penyelesaian Bea Masuk/Pajak", "Koordinasi pemeriksaan Bea Cukai terminal", "Penerbitan SPPB & izin keluar pelabuhan"]', '["Import declaration (PIB) & duty settlement", "Terminal Customs clearance coordination", "SPPB release & port gate-out permit"]', 'shield-check', 1, '2026-11-24 00:19:03', '2026-11-24 00:19:03'),
	(50, 10, 'destination', 'Stripping, Trucking & Delivery ke Tujuan', 'Stripping, Domestic Trucking & Final Delivery', 'Pembongkaran muatan dari kontainer (stripping) atau pengiriman langsung via trailer/truk domestik hingga serah terima aman di gudang/lokasi tujuan klien.', 'Container deconsolidation (stripping) or direct trailer haulage and final door-to-door delivery with verified proof of receipt at your warehouse.', '["Proses stripping aman & terinventarisasi", "Pengiriman trucking ke seluruh tujuan", "Serah terima resmi (Proof of Delivery)"]', '["Safe, inventoried container stripping", "Domestic trucking to destination site", "Verified Proof of Delivery (POD)"]', 'map-pin-check', 1, '2026-11-24 00:19:03', '2026-11-24 00:19:03');

-- Dumping structure for table carano_utama_db.services
CREATE TABLE IF NOT EXISTS `services` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `badge_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `badge_en` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_en` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_desc_id` text COLLATE utf8mb4_unicode_ci,
  `short_desc_en` text COLLATE utf8mb4_unicode_ci,
  `body_id` longtext COLLATE utf8mb4_unicode_ci,
  `body_en` longtext COLLATE utf8mb4_unicode_ci,
  `icon` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ship',
  `image_path` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `features_id` json DEFAULT NULL,
  `features_en` json DEFAULT NULL,
  `sort_order` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `services_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table carano_utama_db.services: ~4 rows (approximately)
REPLACE INTO `services` (`id`, `slug`, `badge_id`, `badge_en`, `title_id`, `title_en`, `short_desc_id`, `short_desc_en`, `body_id`, `body_en`, `icon`, `image_path`, `features_id`, `features_en`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
	(17, 'sea-freight-import', 'LAYANAN UTAMA', 'CORE SERVICE', 'Sea Freight Impor (FCL & LCL)', 'International Sea Freight Import (FCL & LCL)', 'Pengiriman kontainer penuh (20ft/40ft/HQ) dan konsolidasi LCL reguler dari Jepang, China, Taiwan, Korea, dan Singapura menuju 3 pelabuhan utama Indonesia.', 'Scheduled Full Container Load (20ft/40ft/HQ) and LCL consolidation from Japan, China, Taiwan, Korea, and Singapore into Indonesia’s 3 main maritime ports.', '<p>Layanan <strong>Sea Freight Impor</strong> PT. CARANO UTAMA LOGISTIK dirancang untuk menjaga kepastian jadwal pasokan industri dan perdagangan Anda. Kami bekerja sama dengan jaringan pelayaran internasional tepercaya untuk menyediakan ruang kontainer yang stabil serta tarif kompetitif.</p><h3>Cakupan Layanan</h3><ul><li>Pengiriman <strong>FCL (Full Container Load)</strong> 20ft, 40ft, dan 40ft High Cube.</li><li>Pengiriman <strong>LCL (Less than Container Load)</strong> dengan konsolidasi mingguan yang efisien.</li><li>Pelayanan langsung ke Pelabuhan Tanjung Priok, Tanjung Emas, dan Tanjung Perak.</li><li>Pemantauan posisi kapal dan jadwal sandar secara berkala.</li></ul>', '<p>PT. CARANO UTAMA LOGISTIK’s <strong>Sea Freight Import</strong> solution is engineered to protect your industrial and commercial supply schedules. We partner with tier-one ocean carriers to secure reliable container space and competitive rates.</p><h3>Service Scope</h3><ul><li><strong>FCL (Full Container Load)</strong> in 20ft, 40ft, and 40ft High Cube equipment.</li><li><strong>LCL (Less than Container Load)</strong> weekly consolidation for flexible volumes.</li><li>Direct arrival coverage at Tanjung Priok, Tanjung Emas, and Tanjung Perak.</li><li>Proactive vessel voyage tracking and berthing queue updates.</li></ul>', 'ship', '/images/illustrations/sea-freight-vessel.jpg', '["FCL 20ft / 40ft / 40HQ & LCL Konsolidasi", "Rute reguler 5 Negara Asal Asia Timur", "Monitoring ETA & antrean sandar kapal"]', '["FCL 20ft / 40ft / 40HQ & LCL Consolidation", "Regular sailings from 5 Asian Origin Hubs", "Proactive ETA & berthing queue tracking"]', 1, 1, '2026-11-24 00:19:03', '2026-11-24 00:19:03'),
	(18, 'origin-handling-insurance', 'ORIGIN LOGISTICS', 'ORIGIN LOGISTICS', 'Origin Pickup, Strapping, Export Docs & Asuransi', 'Origin Pickup, Strapping, Export Docs & Insurance', 'Penjemputan langsung di gudang pabrik luar negeri, pengamanan strapping, trucking ke pelabuhan muat, dokumen & pajak negara asal, hingga proteksi asuransi kargo.', 'Direct factory warehouse pickup abroad, export-grade strapping, origin trucking, export documentation & local taxes, plus full marine cargo insurance.', '<p>Keberhasilan pengiriman impor dimulai sejak barang meninggalkan gudang pabrik di negara asal. Jaringan agen CARANO di <strong>Jepang, China, Taiwan, Korea Selatan, dan Singapura</strong> memastikan kargo Anda ditangani dengan prosedur keselamatan dan legalitas yang ketat.</p><h3>Yang Kami Tangani di Negara Asal</h3><ul><li>Koordinasi jadwal muat bersama pabrik/eksportir.</li><li>Pengemasan pengaman <em>strapping</em> dan pengangkutan darat menuju pelabuhan asal.</li><li>Pengurusan dokumen ekspor, kepatuhan pajak negara asal, dan Certificate of Origin.</li><li>Penerbitan polis asuransi kargo laut untuk meminimalkan risiko finansial.</li></ul>', '<p>A smooth import shipment begins the moment cargo leaves the overseas factory. Our partner network across <strong>Japan, China, Taiwan, South Korea, and Singapore</strong> handles physical security and export compliance with precision.</p><h3>Origin Handling Scope</h3><ul><li>Factory loading coordination with overseas suppliers.</li><li>Export-standard cargo strapping and inland trucking to the Port of Loading.</li><li>Export clearance, origin tax settlement, and Certificate of Origin processing.</li><li>Marine cargo insurance activation to safeguard cargo value.</li></ul>', 'shield-check', '/images/illustrations/warehouse-export-strapping.jpg', '["Pickup gudang pabrik & strapping profesional", "Dokumen ekspor & pajak negara asal", "Proteksi asuransi kargo laut terjamin"]', '["Factory pickup & export-grade strapping", "Export paperwork & origin tax compliance", "Comprehensive marine cargo insurance"]', 2, 1, '2026-11-24 00:19:03', '2026-11-24 00:19:03'),
	(19, 'customs-clearance-bea-cukai', 'KEPABEANAN', 'CUSTOMS BROKERAGE', 'Customs Clearance, Pajak & Bea Cukai Terminal', 'Customs Clearance, Duties & Terminal Compliance', 'Pengurusan profesional PIB, klasifikasi HS Code, pembayaran bea masuk & pajak impor, serta pengeluaran barang resmi (SPPB) di pelabuhan Indonesia.', 'Licensed handling of import declarations (PIB), HS Code advisory, import duty & tax settlement, and swift SPPB customs release at Indonesian terminals.', '<p>Proses kepabeanan di terminal pelabuhan membutuhkan akurasi regulasi dan kecepatan respons agar terhindar dari biaya penumpukan (<em>demurrage/detention</em>). Tim kepabeanan CARANO mendampingi penuh mulai dari pemeriksaan dokumen sebelum kapal tiba hingga kontainer keluar terminal.</p><h3>Keunggulan Kepabeanan CARANO</h3><ul><li>Audit kelengkapan dokumen pra-kedatangan (Invoice, Packing List, B/L, Form Fasilitas FTA).</li><li>Pengajuan PIB akurat dan konsultasi HS Code sesuai regulasi terbaru.</li><li>Pengurusan di Terminal Tanjung Priok, Tanjung Emas, dan Tanjung Perak.</li></ul>', '<p>Terminal customs clearance requires regulatory accuracy and rapid responsiveness to prevent unnecessary demurrage and detention costs. CARANO’s customs specialists verify paperwork pre-arrival and guide your cargo smoothly through SPPB release.</p><h3>Customs Capabilities</h3><ul><li>Pre-arrival audit of Invoice, Packing List, B/L, and FTA preference certificates.</li><li>Accurate PIB filing and HS Code compliance advisory.</li><li>Dedicated operations at Tanjung Priok, Tanjung Emas, and Tanjung Perak.</li></ul>', 'file-check', '/images/illustrations/port-customs-terminal.jpg', '["Verifikasi pra-kedatangan & konsultasi HS Code", "Pengurusan PIB, Bea Masuk & Pajak Impor", "Proses cepat hingga terbit SPPB"]', '["Pre-arrival audit & HS Code advisory", "PIB filing, import duties & tax handling", "Streamlined clearance to SPPB release"]', 3, 1, '2026-11-24 00:19:03', '2026-11-24 00:19:03'),
	(20, 'stripping-trucking-multimodal', 'MULTIMODAL & LAST-MILE', 'MULTIMODAL & LAST-MILE', 'Stripping, Trucking Domestik & Dukungan Air Freight', 'Stripping, Domestic Trucking & Air Freight Support', 'Pembongkaran kontainer (stripping), distribusi armada truk ke gudang tujuan di seluruh Indonesia, serta opsi kargo udara cepat untuk kebutuhan mendesak.', 'Safe container stripping, domestic trucking delivery directly to your warehouse, plus express air freight options for time-critical shipments.', '<p>Selaras dengan tiga moda transportasi pada logo <strong>PT. CARANO UTAMA LOGISTIK</strong> (Laut, Darat, dan Udara), kami melengkapi layanan impor laut Anda dengan proses <em>stripping</em> di gudang, pengiriman darat door-to-door, serta layanan <em>Air Freight</em> untuk pengiriman suku cadang atau komoditas berkecepatan tinggi.</p><h3>Dukungan Distribusi & Multimoda</h3><ul><li>Stripping kontainer dengan pengecekan fisik dan daftar inventaris.</li><li>Armada trailer kontainer, wingbox, CDD, hingga engkel menuju lokasi akhir.</li><li>Solusi <strong>Air Freight</strong> prioritas dari bandara hub Asia Timur ke Indonesia.</li></ul>', '<p>Reflecting all three logistics modes in the <strong>PT. CARANO UTAMA LOGISTIK</strong> emblem (Sea, Land, and Air), we complement your sea freight with careful warehouse stripping, door-to-door domestic trucking, and priority air freight for urgent industrial shipments.</p><h3>Multimodal & Last-Mile Scope</h3><ul><li>Supervised container stripping with physical tally verification.</li><li>Container trailers, wingbox, and box trucks to final warehouse sites.</li><li>Priority <strong>Air Freight</strong> support from East Asian hubs into Indonesia.</li></ul>', 'truck', '/images/illustrations/hero-port-maritime.jpg', '["Stripping terawasi & laporan serah terima", "Armada trucking domestik door-to-door", "Opsi Air Freight untuk kargo mendesak"]', '["Supervised stripping & tally reporting", "Door-to-door domestic trucking fleet", "Priority Air Freight for urgent cargo"]', 4, 1, '2026-11-24 00:19:03', '2026-11-24 00:19:03');

-- Dumping structure for table carano_utama_db.sessions
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table carano_utama_db.sessions: ~0 rows (approximately)

-- Dumping structure for table carano_utama_db.site_settings
CREATE TABLE IF NOT EXISTS `site_settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `group` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'general',
  `label` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value_id` longtext COLLATE utf8mb4_unicode_ci,
  `value_en` longtext COLLATE utf8mb4_unicode_ci,
  `type` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'text',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `site_settings_key_unique` (`key`),
  KEY `site_settings_group_index` (`group`)
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table carano_utama_db.site_settings: ~18 rows (approximately)
REPLACE INTO `site_settings` (`id`, `key`, `group`, `label`, `value_id`, `value_en`, `type`, `sort_order`, `created_at`, `updated_at`) VALUES
	(73, 'company_name', 'brand', 'Nama Perusahaan Resmi', 'PT. CARANO UTAMA LOGISTIK', 'PT. CARANO UTAMA LOGISTIK', 'text', 1, '2026-11-24 00:19:02', '2026-11-24 00:19:02'),
	(74, 'company_short_name', 'brand', 'Nama Singkat Brand', 'CARANO', 'CARANO', 'text', 2, '2026-11-24 00:19:02', '2026-11-24 00:19:02'),
	(75, 'company_tagline', 'brand', 'Tagline Perusahaan', 'Mitra Logistik Impor End-to-End Asia Timur ke Indonesia', 'End-to-End East Asia to Indonesia Import Logistics Partner', 'text', 3, '2026-11-24 00:19:02', '2026-11-24 00:19:02'),
	(76, 'logo_light', 'brand', 'Logo Utama (Background Terang)', '/images/brand/logo-carano-light.png', '/images/brand/logo-carano-light.png', 'image', 4, '2026-11-24 00:19:02', '2026-11-24 00:19:02'),
	(77, 'logo_dark', 'brand', 'Logo Footer / Sidebar (Background Gelap)', '/images/brand/logo-carano-dark.png', '/images/brand/logo-carano-dark.png', 'image', 5, '2026-11-24 00:19:02', '2026-11-24 00:19:02'),
	(78, 'logo_mark', 'brand', 'Ikon Mark Carano', '/images/brand/logo-carano-mark.png', '/images/brand/logo-carano-mark.png', 'image', 6, '2026-11-24 00:19:02', '2026-11-24 00:19:02'),
	(79, 'brochure_pdf', 'brand', 'File Brosur / Road Map Shipment (PDF)', '/uploads/docs/CARANO_Road_Map_Shipment.pdf', '/uploads/docs/CARANO_Road_Map_Shipment.pdf', 'file', 7, '2026-11-24 00:19:02', '2026-11-24 00:19:02'),
	(80, 'contact_address', 'contact', 'Alamat Kantor', 'Jl. Duta Boulevard Barat No.C-10, RT.001/RW.011, Harapan Baru, Kec. Bekasi Utara, Kota Bekasi, Jawa Barat 17123', 'Jl. Duta Boulevard Barat No.C-10, RT.001/RW.011, Harapan Baru, North Bekasi, Bekasi City, West Java 17123, Indonesia', 'textarea', 10, '2026-11-24 00:19:02', '2026-11-24 00:19:02'),
	(81, 'contact_maps_url', 'contact', 'Link Google Maps Kantor', 'https://maps.app.goo.gl/8u9aomAeqFG2EM7H7', 'https://maps.app.goo.gl/8u9aomAeqFG2EM7H7', 'url', 11, '2026-11-24 00:19:02', '2026-11-24 00:19:02'),
	(82, 'contact_website', 'contact', 'Website Resmi', 'http://www.caranoutama.co.id/', 'http://www.caranoutama.co.id/', 'url', 12, '2026-11-24 00:19:02', '2026-11-24 00:19:02'),
	(83, 'contact_email', 'contact', 'Email Resmi', 'info@caranoutama.co.id', 'info@caranoutama.co.id', 'email', 13, '2026-11-24 00:19:02', '2026-11-24 00:19:02'),
	(84, 'contact_phone', 'contact', 'Nomor Telepon', '021-38312253', '+62 21 3831 2253', 'phone', 14, '2026-11-24 00:19:02', '2026-11-24 00:19:02'),
	(85, 'contact_whatsapp', 'contact', 'Nomor WhatsApp (Format 628xxx)', '622138312253', '622138312253', 'phone', 15, '2026-11-24 00:19:02', '2026-11-24 00:19:02'),
	(86, 'business_hours', 'contact', 'Jam Operasional', 'Senin – Jumat: 08.30 – 17.30 WIB | Sabtu: 08.30 – 13.00 WIB', 'Mon – Fri: 08:30 – 17:30 WIB | Sat: 08:30 – 13:00 WIB', 'text', 16, '2026-11-24 00:19:02', '2026-11-24 00:19:02'),
	(87, 'social_linkedin', 'social', 'URL LinkedIn', 'https://linkedin.com', 'https://linkedin.com', 'url', 20, '2026-11-24 00:19:02', '2026-11-24 00:19:02'),
	(88, 'social_instagram', 'social', 'URL Instagram', 'https://instagram.com', 'https://instagram.com', 'url', 21, '2026-11-24 00:19:02', '2026-11-24 00:19:02'),
	(89, 'seo_default_title', 'seo', 'Default SEO Title', 'PT. CARANO UTAMA LOGISTIK — Solusi Impor & Logistik Maritim End-to-End', 'PT. CARANO UTAMA LOGISTIK — End-to-End International Import & Maritime Logistics', 'text', 30, '2026-11-24 00:19:02', '2026-11-24 00:19:02'),
	(90, 'seo_default_description', 'seo', 'Default SEO Description', 'Layanan logistik impor laut terintegrasi dari pabrik Jepang, China, Taiwan, Korea & Singapura menuju Tanjung Priok, Tanjung Emas, dan Tanjung Perak hingga pengiriman ke tujuan.', 'Integrated sea freight import logistics from factories in Japan, China, Taiwan, Korea & Singapore to Tanjung Priok, Tanjung Emas, and Tanjung Perak through final door delivery.', 'textarea', 31, '2026-11-24 00:19:02', '2026-11-24 00:19:02');

-- Dumping structure for table carano_utama_db.trade_hubs
CREATE TABLE IF NOT EXISTS `trade_hubs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_en` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_id` text COLLATE utf8mb4_unicode_ci,
  `description_en` text COLLATE utf8mb4_unicode_ci,
  `map_x` double NOT NULL DEFAULT '50',
  `map_y` double NOT NULL DEFAULT '50',
  `sort_order` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `trade_hubs_type_index` (`type`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table carano_utama_db.trade_hubs: ~8 rows (approximately)
REPLACE INTO `trade_hubs` (`id`, `type`, `code`, `name_id`, `name_en`, `country`, `description_id`, `description_en`, `map_x`, `map_y`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
	(33, 'origin', 'JP', 'Jepang', 'Japan', 'Japan', 'Penjemputan pabrik manufaktur & otomotif area Tokyo, Yokohama, Osaka, dan Kobe dengan dukungan Form IJEPA.', 'Factory pickup across Tokyo, Yokohama, Osaka, and Kobe industrial zones with IJEPA documentation support.', 835, 118, 1, 1, '2026-11-24 00:19:03', '2026-11-24 00:19:03'),
	(34, 'origin', 'KR', 'Korea Selatan', 'South Korea', 'South Korea', 'Akses pelabuhan utama Busan & Incheon untuk pengiriman mesin, komponen elektronik, dan bahan baku industri.', 'Direct port access via Busan & Incheon for machinery, electronics, and industrial raw materials.', 718, 108, 2, 1, '2026-11-24 00:19:03', '2026-11-24 00:19:03'),
	(35, 'origin', 'CN', 'China', 'China', 'China', 'Jaringan luas dari Shanghai, Ningbo, Shenzhen, Guangzhou, hingga Qingdao lengkap dengan fasilitas Form E.', 'Extensive coverage from Shanghai, Ningbo, Shenzhen, Guangzhou, and Qingdao with Form E compliance.', 565, 152, 3, 1, '2026-11-24 00:19:03', '2026-11-24 00:19:03'),
	(36, 'origin', 'TW', 'Taiwan', 'Taiwan', 'Taiwan', 'Koneksi cepat melalui Pelabuhan Kaohsiung & Keelung untuk peralatan presisi, manufaktur, dan suku cadang.', 'Rapid ocean connections via Kaohsiung & Keelung for precision machinery, manufacturing goods, and parts.', 650, 240, 4, 1, '2026-11-24 00:19:03', '2026-11-24 00:19:03'),
	(37, 'origin', 'SG', 'Singapura', 'Singapore', 'Singapore', 'Hub transshipment strategis ASEAN melalui PSA Singapore dengan frekuensi pelayaran tinggi ke Indonesia.', 'Strategic ASEAN transshipment hub via PSA Singapore with high-frequency sailings into Indonesia.', 388, 398, 5, 1, '2026-11-24 00:19:03', '2026-11-24 00:19:03'),
	(38, 'destination', 'IDJKT', 'Pelabuhan Tanjung Priok', 'Port of Tanjung Priok', 'Jakarta, Indonesia', 'Gerbang logistik utama Indonesia untuk melayani kawasan industri Jabodetabek, Karawang, Cikarang, dan Jawa Barat.', 'Indonesia’s premier maritime gateway serving Greater Jakarta, Cikarang, Karawang, and West Java industrial estates.', 448, 495, 1, 1, '2026-11-24 00:19:03', '2026-11-24 00:19:03'),
	(39, 'destination', 'IDSRG', 'Pelabuhan Tanjung Emas', 'Port of Tanjung Emas', 'Semarang, Indonesia', 'Pusat masuk kargo strategis untuk kawasan industri Jawa Tengah, Kendal, Semarang, Solo, dan Yogyakarta.', 'Strategic cargo gateway for Central Java industrial parks including Semarang, Kendal, Solo, and Yogyakarta.', 525, 506, 2, 1, '2026-11-24 00:19:03', '2026-11-24 00:19:03'),
	(40, 'destination', 'IDSUB', 'Pelabuhan Tanjung Perak', 'Port of Tanjung Perak', 'Surabaya, Indonesia', 'Hub maritim utama Jawa Timur & Indonesia Timur yang menghubungkan Surabaya, Gresik, Sidoarjo, dan Pasuruan.', 'Primary East Java and Eastern Indonesia maritime hub serving Surabaya, Gresik, Sidoarjo, and Pasuruan.', 596, 514, 3, 1, '2026-11-24 00:19:03', '2026-11-24 00:19:03');

-- Dumping structure for table carano_utama_db.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'editor',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table carano_utama_db.users: ~1 rows (approximately)
REPLACE INTO `users` (`id`, `name`, `email`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
	(5, 'Admin Carano Utama', 'admin@caranologistik.co.id', 'admin', '2026-11-24 00:19:02', '$2y$12$OuSuqng2dwAW4TqatB/w8.LpCtlVLTlMCQIWWuOVmxdiztQXGWyRi', NULL, '2026-11-24 00:19:02', '2026-11-24 00:19:02');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
