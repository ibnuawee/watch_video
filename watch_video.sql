-- -------------------------------------------------------------
-- TablePlus 7.0.0(700)
--
-- https://tableplus.com/
--
-- Database: watch_video
-- Generation Time: 2026-06-20 16:57:41.0120
-- -------------------------------------------------------------


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` bigint(20) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` bigint(20) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `customers`;
CREATE TABLE `customers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `customers_user_id_foreign` (`user_id`),
  CONSTRAINT `customers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` varchar(255) NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` smallint(5) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','customer') NOT NULL DEFAULT 'customer',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `video_access_requests`;
CREATE TABLE `video_access_requests` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` bigint(20) unsigned NOT NULL,
  `video_id` bigint(20) unsigned NOT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `requested_at` timestamp NULL DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `access_start_at` timestamp NULL DEFAULT NULL,
  `access_end_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `video_access_requests_customer_id_foreign` (`customer_id`),
  KEY `video_access_requests_video_id_foreign` (`video_id`),
  CONSTRAINT `video_access_requests_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `video_access_requests_video_id_foreign` FOREIGN KEY (`video_id`) REFERENCES `videos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `video_categories`;
CREATE TABLE `video_categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `video_categories_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `videos`;
CREATE TABLE `videos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `video_category_id` bigint(20) unsigned DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `video_path` varchar(255) NOT NULL,
  `thumbnail_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `videos_video_category_id_foreign` (`video_category_id`),
  CONSTRAINT `videos_video_category_id_foreign` FOREIGN KEY (`video_category_id`) REFERENCES `video_categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `customers` (`id`, `user_id`, `phone`, `address`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 2, '08123456789', 'Alamat Customer Demo', '2026-06-20 07:22:13', '2026-06-20 07:22:13', NULL),
(2, 3, '081217886415', 'Jetak RT 4 / RW 2, Suruhkalang, Jaten, Karanganyar', '2026-06-20 07:55:43', '2026-06-20 07:55:43', NULL);

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_06_20_042719_create_customers_table', 1),
(5, '2026_06_20_042720_create_video_categories_table', 1),
(6, '2026_06_20_042727_create_videos_table', 1),
(7, '2026_06_20_042734_create_video_access_requests_table', 1);

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('IYBpt8WSe2gpRaVuj295K52WvchEOE21lQW0aLfk', 3, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJ3UlRrZFBwQzVkUkI2VTNzMXZUT2c0SXVvdWRtMlVPTWxOUXEzUmRBIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL2N1c3RvbWVyXC9kYXNoYm9hcmQiLCJyb3V0ZSI6ImN1c3RvbWVyLmRhc2hib2FyZCJ9LCJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI6M30=', 1781948877),
('JbuEsdsLoNzP9m8XsElk3FxwcIQRSa2OycUowG07', 1, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJjQXoyZVFaOGFjb0JNS092ZzJ1U0JpbWhkbTJoS3RRYUlkTWRkZ0xUIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL2FkbWluXC92aWRlb3MiLCJyb3V0ZSI6ImFkbWluLnZpZGVvcy5pbmRleCJ9LCJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI6MX0=', 1781948871);

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Admin', 'admin@mail.com', NULL, '$2y$12$W5tKh88/KoZ1OQwGqpHwM.rHf2l.fYBPNIL/UxPRjzGv9xHxbZi1W', 'admin', 'ju42icJD84nrwiTrtDHQKx7LfWohBSHWNFVzMLqDwolVTH4cHxSamOpDh6Vt', '2026-06-20 07:22:13', '2026-06-20 07:22:13', NULL),
(2, 'Customer Demo', 'customer@mail.com', NULL, '$2y$12$GMsiIszjhx7saOiSKHCpkOPi0Kii5nh8STBtjZT9ryvpkjaxeW2YW', 'customer', 'thRW4GlKGvcP0t7EXXR707SHp1wAlqRDyAYhqC2XCQv980Yh730E02CIW7me', '2026-06-20 07:22:13', '2026-06-20 07:22:13', NULL),
(3, 'ibnu arifin', 'ibnuarifin@gmail.com', NULL, '$2y$12$zqiYkdBd.//x2NaH/6tIJ.6eLRr2Nz0CF1THJzJUsaOBYZnuTPp9W', 'customer', 'us1I4QcfavRlbwGqGcDoXPYAmdoN0rVSsxznty7OIQ1azmZa8fj3x7aSGeyI', '2026-06-20 07:55:43', '2026-06-20 07:55:43', NULL);

INSERT INTO `video_access_requests` (`id`, `customer_id`, `video_id`, `status`, `requested_at`, `approved_at`, `access_start_at`, `access_end_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 'approved', '2026-06-20 07:50:42', '2026-06-20 07:51:12', '2026-06-20 07:50:00', '2026-06-27 07:50:00', '2026-06-20 07:50:42', '2026-06-20 07:51:12', NULL),
(2, 2, 1, 'rejected', '2026-06-20 07:56:11', NULL, NULL, NULL, '2026-06-20 07:56:11', '2026-06-20 07:56:39', NULL),
(3, 2, 1, 'approved', '2026-06-20 07:56:56', '2026-06-20 07:57:04', '2026-06-20 07:57:00', '2026-06-27 07:57:00', '2026-06-20 07:56:56', '2026-06-20 07:57:04', NULL),
(4, 2, 2, 'approved', '2026-06-20 08:36:08', '2026-06-20 08:36:55', '2026-06-20 08:36:00', '2026-06-20 08:40:00', '2026-06-20 08:36:08', '2026-06-20 08:36:55', NULL);

INSERT INTO `video_categories` (`id`, `name`, `slug`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Tutorial', 'tutorial', 'Video tutorial pembelajaran.', '2026-06-20 07:22:13', '2026-06-20 09:31:47', NULL),
(2, 'Training', 'training', 'Video training untuk customer.', '2026-06-20 07:22:13', '2026-06-20 09:31:44', NULL),
(3, 'Web Development', 'web-development', 'Video seputar pengembangan website.', '2026-06-20 07:22:13', '2026-06-20 09:31:42', NULL),
(4, 'Internal Video', 'internal-video', 'Video internal yang membutuhkan izin akses.', '2026-06-20 07:22:13', '2026-06-20 09:31:40', NULL),
(5, 'test', 'test', 'test', '2026-06-20 07:59:32', '2026-06-20 08:06:43', '2026-06-20 08:06:43');

INSERT INTO `videos` (`id`, `video_category_id`, `title`, `description`, `video_path`, `thumbnail_path`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'Tutorial instalasi Laravel', 'Tutorial instalasi laravel  diwindows', 'videos/4YRaN5vqJbGh2zZyprcLGVxlN788inYtJIZiYXhW.mp4', 'thumbnails/Wvsscp5SG3pleHXcrX7hGWeaz7484e5tS8kwoevP.jpg', '2026-06-20 07:50:20', '2026-06-20 09:47:11', NULL),
(2, 4, 'test', 'test', 'videos/Me5bMh55UXXQXqVb1oFvYvDDrLDmVHRps6iqGp4K.mp4', 'thumbnails/4why8TrywrwxqqAkI90alGrjjvcd50zquRdsAkQq.png', '2026-06-20 08:35:50', '2026-06-20 09:41:14', '2026-06-20 09:41:14');



/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;