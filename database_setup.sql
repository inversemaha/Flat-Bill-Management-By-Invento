-- ==========================================
-- Multi-Tenant Flat & Bill Management System
-- Database Setup Script
-- ==========================================

-- Create database
CREATE DATABASE IF NOT EXISTS `flat_bill_management` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `flat_bill_management`;

-- ==========================================
-- TABLE STRUCTURES
-- ==========================================

-- Users table (Admin and House Owners)
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','house_owner') NOT NULL DEFAULT 'house_owner',
  `status` enum('active','inactive','pending') NOT NULL DEFAULT 'active',
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `last_login_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `idx_users_role` (`role`),
  KEY `idx_users_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Buildings table
CREATE TABLE `buildings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `total_floors` int(11) NOT NULL,
  `total_flats` int(11) NOT NULL,
  `house_owner_id` bigint(20) unsigned NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `buildings_house_owner_id_foreign` (`house_owner_id`),
  KEY `idx_buildings_status` (`status`),
  CONSTRAINT `buildings_house_owner_id_foreign` FOREIGN KEY (`house_owner_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Flats table
CREATE TABLE `flats` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `flat_number` varchar(50) NOT NULL,
  `floor_number` int(11) NOT NULL,
  `flat_size` varchar(50) DEFAULT NULL,
  `rent_amount` decimal(10,2) DEFAULT NULL,
  `flat_owner_name` varchar(255) NOT NULL,
  `flat_owner_phone` varchar(20) NOT NULL,
  `flat_owner_email` varchar(255) DEFAULT NULL,
  `flat_owner_address` text DEFAULT NULL,
  `is_occupied` tinyint(1) NOT NULL DEFAULT '0',
  `building_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `flats_building_id_flat_number_unique` (`building_id`,`flat_number`),
  KEY `idx_flats_occupied` (`is_occupied`),
  KEY `idx_flats_floor` (`floor_number`),
  CONSTRAINT `flats_building_id_foreign` FOREIGN KEY (`building_id`) REFERENCES `buildings` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tenants table
CREATE TABLE `tenants` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text DEFAULT NULL,
  `national_id` varchar(50) DEFAULT NULL,
  `occupation` varchar(100) DEFAULT NULL,
  `emergency_contact_name` varchar(255) DEFAULT NULL,
  `emergency_contact_phone` varchar(20) DEFAULT NULL,
  `move_in_date` date DEFAULT NULL,
  `move_out_date` date DEFAULT NULL,
  `status` enum('active','inactive','moved_out') NOT NULL DEFAULT 'active',
  `flat_id` bigint(20) unsigned DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tenants_flat_id_foreign` (`flat_id`),
  KEY `idx_tenants_status` (`status`),
  KEY `idx_tenants_email` (`email`),
  CONSTRAINT `tenants_flat_id_foreign` FOREIGN KEY (`flat_id`) REFERENCES `flats` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Bill Categories table
CREATE TABLE `bill_categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `house_owner_id` bigint(20) unsigned NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `bill_categories_house_owner_id_name_unique` (`house_owner_id`,`name`),
  CONSTRAINT `bill_categories_house_owner_id_foreign` FOREIGN KEY (`house_owner_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Bills table
CREATE TABLE `bills` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `month` varchar(7) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `due_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total_amount` decimal(10,2) GENERATED ALWAYS AS ((`amount` + `due_amount`)) STORED,
  `status` enum('paid','unpaid','overdue') NOT NULL DEFAULT 'unpaid',
  `due_date` date NOT NULL,
  `paid_date` timestamp NULL DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `payment_details` text DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `flat_id` bigint(20) unsigned NOT NULL,
  `bill_category_id` bigint(20) unsigned NOT NULL,
  `tenant_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bills_flat_id_foreign` (`flat_id`),
  KEY `bills_bill_category_id_foreign` (`bill_category_id`),
  KEY `bills_tenant_id_foreign` (`tenant_id`),
  KEY `idx_bills_status` (`status`),
  KEY `idx_bills_month` (`month`),
  KEY `idx_bills_due_date` (`due_date`),
  CONSTRAINT `bills_bill_category_id_foreign` FOREIGN KEY (`bill_category_id`) REFERENCES `bill_categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `bills_flat_id_foreign` FOREIGN KEY (`flat_id`) REFERENCES `flats` (`id`) ON DELETE CASCADE,
  CONSTRAINT `bills_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Password reset tokens table
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Personal access tokens table (for API)
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Sessions table
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

-- Failed jobs table (for queues)
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Jobs table (for queues)
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Migrations table
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================
-- SAMPLE DATA INSERTION
-- ==========================================

-- Insert Admin User
INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `status`, `phone`, `address`, `created_at`, `updated_at`) VALUES
(1, 'System Administrator', 'admin@flatbill.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 'active', '+880-1700-000000', 'Admin Office, Dhaka, Bangladesh', NOW(), NOW());

-- Insert House Owners
INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `status`, `phone`, `address`, `created_at`, `updated_at`) VALUES
(2, 'Abdullah Al Mamun', 'abdullah.mamun@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'house_owner', 'active', '+880-1711-123456', 'Gulshan-2, Dhaka, Bangladesh', NOW(), NOW()),
(3, 'Fatema Khatun', 'fatema.khatun@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'house_owner', 'active', '+880-1722-654321', 'Dhanmondi-15, Dhaka, Bangladesh', NOW(), NOW()),
(4, 'Mohammad Hasan', 'mohammad.hasan@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'house_owner', 'active', '+880-1733-789012', 'Uttara-10, Dhaka, Bangladesh', NOW(), NOW());

-- Insert Buildings
INSERT INTO `buildings` (`id`, `name`, `address`, `total_floors`, `total_flats`, `house_owner_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Green Tower', '123 Gulshan Avenue, Gulshan-2, Dhaka-1212', 8, 16, 2, 'active', NOW(), NOW()),
(2, 'Blue Residency', '456 Dhanmondi Road, Dhanmondi-15, Dhaka-1209', 10, 20, 3, 'active', NOW(), NOW()),
(3, 'Golden Heights', '789 Uttara Sector-10, Uttara, Dhaka-1230', 12, 24, 4, 'active', NOW(), NOW());

-- Insert Flats
INSERT INTO `flats` (`id`, `flat_number`, `floor_number`, `flat_size`, `rent_amount`, `flat_owner_name`, `flat_owner_phone`, `flat_owner_email`, `flat_owner_address`, `is_occupied`, `building_id`, `created_at`, `updated_at`) VALUES
-- Green Tower Flats (Building 1)
(1, '101', 1, '3 Bedroom', 25000.00, 'Abdullah Al Mamun', '+880-1711-123456', 'abdullah.mamun@example.com', 'Gulshan-2, Dhaka', 1, 1, NOW(), NOW()),
(2, '102', 1, '2 Bedroom', 20000.00, 'Abdullah Al Mamun', '+880-1711-123456', 'abdullah.mamun@example.com', 'Gulshan-2, Dhaka', 1, 1, NOW(), NOW()),
(3, '201', 2, '3 Bedroom', 26000.00, 'Abdullah Al Mamun', '+880-1711-123456', 'abdullah.mamun@example.com', 'Gulshan-2, Dhaka', 0, 1, NOW(), NOW()),
(4, '202', 2, '2 Bedroom', 21000.00, 'Abdullah Al Mamun', '+880-1711-123456', 'abdullah.mamun@example.com', 'Gulshan-2, Dhaka', 1, 1, NOW(), NOW()),
-- Blue Residency Flats (Building 2)
(5, 'A101', 1, '4 Bedroom', 35000.00, 'Fatema Khatun', '+880-1722-654321', 'fatema.khatun@example.com', 'Dhanmondi-15, Dhaka', 1, 2, NOW(), NOW()),
(6, 'A102', 1, '3 Bedroom', 28000.00, 'Fatema Khatun', '+880-1722-654321', 'fatema.khatun@example.com', 'Dhanmondi-15, Dhaka', 1, 2, NOW(), NOW()),
(7, 'B201', 2, '4 Bedroom', 36000.00, 'Fatema Khatun', '+880-1722-654321', 'fatema.khatun@example.com', 'Dhanmondi-15, Dhaka', 0, 2, NOW(), NOW()),
-- Golden Heights Flats (Building 3)
(8, 'GH-301', 3, '2 Bedroom', 18000.00, 'Mohammad Hasan', '+880-1733-789012', 'mohammad.hasan@example.com', 'Uttara-10, Dhaka', 1, 3, NOW(), NOW()),
(9, 'GH-302', 3, '3 Bedroom', 22000.00, 'Mohammad Hasan', '+880-1733-789012', 'mohammad.hasan@example.com', 'Uttara-10, Dhaka', 1, 3, NOW(), NOW());

-- Insert Tenants
INSERT INTO `tenants` (`id`, `name`, `email`, `phone`, `address`, `national_id`, `occupation`, `emergency_contact_name`, `emergency_contact_phone`, `move_in_date`, `status`, `flat_id`, `created_at`, `updated_at`) VALUES
(1, 'Mohammad Rahman', 'mohammad.rahman@gmail.com', '+880-1788-111222', 'Mirpur-1, Dhaka', '1234567890123', 'Software Engineer', 'Abdul Rahman', '+880-1799-333444', '2024-01-01', 'active', 1, NOW(), NOW()),
(2, 'Rashida Begum', 'rashida.begum@yahoo.com', '+880-1777-555666', 'Mohammadpur, Dhaka', '2345678901234', 'Teacher', 'Nasir Ahmed', '+880-1766-777888', '2024-02-15', 'active', 2, NOW(), NOW()),
(3, 'Karim Ahmed', 'karim.ahmed@hotmail.com', '+880-1755-999000', 'Wari, Dhaka', '3456789012345', 'Business Analyst', 'Salma Ahmed', '+880-1744-111222', '2024-03-01', 'active', 4, NOW(), NOW()),
(4, 'Nasreen Sultana', 'nasreen.sultana@outlook.com', '+880-1733-222333', 'Tejgaon, Dhaka', '4567890123456', 'Doctor', 'Mahmud Hasan', '+880-1722-444555', '2024-01-15', 'active', 5, NOW(), NOW()),
(5, 'Aminul Islam', 'aminul.islam@gmail.com', '+880-1711-666777', 'Ramna, Dhaka', '5678901234567', 'Architect', 'Rahima Islam', '+880-1700-888999', '2024-02-01', 'active', 6, NOW(), NOW()),
(6, 'Shahida Khatun', 'shahida.khatun@yahoo.com', '+880-1688-000111', 'Lalbagh, Dhaka', '6789012345678', 'Bank Officer', 'Rafiq Khatun', '+880-1677-222333', '2024-03-15', 'active', 8, NOW(), NOW()),
(7, 'Jubayer Hossain', 'jubayer.hossain@gmail.com', '+880-1666-444555', 'Motijheel, Dhaka', '7890123456789', 'Marketing Manager', 'Rashid Hossain', '+880-1655-666777', '2024-01-20', 'active', 9, NOW(), NOW());

-- Insert Bill Categories
INSERT INTO `bill_categories` (`id`, `name`, `description`, `house_owner_id`, `is_active`, `created_at`, `updated_at`) VALUES
-- Categories for House Owner 2 (Abdullah Al Mamun)
(1, 'Electricity', 'Monthly electricity bill', 2, 1, NOW(), NOW()),
(2, 'Gas Bill', 'Monthly gas consumption bill', 2, 1, NOW(), NOW()),
(3, 'Water Bill', 'Monthly water supply bill', 2, 1, NOW(), NOW()),
(4, 'Utility Charges', 'Common utility and maintenance charges', 2, 1, NOW(), NOW()),
-- Categories for House Owner 3 (Fatema Khatun)
(5, 'Electricity', 'Monthly electricity bill', 3, 1, NOW(), NOW()),
(6, 'Gas Bill', 'Monthly gas consumption bill', 3, 1, NOW(), NOW()),
(7, 'Water Bill', 'Monthly water supply bill', 3, 1, NOW(), NOW()),
(8, 'Utility Charges', 'Common utility and maintenance charges', 3, 1, NOW(), NOW()),
-- Categories for House Owner 4 (Mohammad Hasan)
(9, 'Electricity', 'Monthly electricity bill', 4, 1, NOW(), NOW()),
(10, 'Gas Bill', 'Monthly gas consumption bill', 4, 1, NOW(), NOW()),
(11, 'Water Bill', 'Monthly water supply bill', 4, 1, NOW(), NOW()),
(12, 'Utility Charges', 'Common utility and maintenance charges', 4, 1, NOW(), NOW());

-- Insert Bills
INSERT INTO `bills` (`id`, `month`, `amount`, `due_amount`, `status`, `due_date`, `paid_date`, `payment_method`, `payment_details`, `notes`, `flat_id`, `bill_category_id`, `tenant_id`, `created_at`, `updated_at`) VALUES
-- Bills for Green Tower (Building 1)
(1, '2024-09', 1200.00, 92.00, 'unpaid', '2024-10-10', NULL, NULL, NULL, 'September electricity bill', 1, 1, 1, NOW(), NOW()),
(2, '2024-09', 850.00, 0.00, 'paid', '2024-10-15', '2024-09-28 10:30:00', 'Bank Transfer', 'Paid via mobile banking', 'September gas bill', 1, 2, 1, NOW(), NOW()),
(3, '2024-09', 450.00, 0.00, 'paid', '2024-10-20', '2024-09-25 14:15:00', 'Cash', 'Paid in cash to office', 'September water bill', 2, 3, 2, NOW(), NOW()),
(4, '2024-09', 1500.00, 0.00, 'unpaid', '2024-10-05', NULL, NULL, NULL, 'September utility charges', 4, 4, 3, NOW(), NOW()),

-- Bills for Blue Residency (Building 2)
(5, '2024-09', 1800.00, 150.00, 'unpaid', '2024-10-08', NULL, NULL, NULL, 'September electricity bill with previous due', 5, 5, 4, NOW(), NOW()),
(6, '2024-09', 1100.00, 0.00, 'paid', '2024-10-12', '2024-09-30 16:45:00', 'Online Banking', 'Paid through internet banking', 'September gas bill', 6, 6, 5, NOW(), NOW()),

-- Bills for Golden Heights (Building 3)
(7, '2024-09', 950.00, 0.00, 'unpaid', '2024-10-15', NULL, NULL, NULL, 'September electricity bill', 8, 9, 6, NOW(), NOW()),
(8, '2024-09', 720.00, 0.00, 'paid', '2024-10-18', '2024-09-29 11:20:00', 'Mobile Banking', 'Paid via bKash', 'September gas bill', 9, 10, 7, NOW(), NOW()),
(9, '2024-09', 380.00, 0.00, 'unpaid', '2024-10-22', NULL, NULL, NULL, 'September water bill', 8, 11, 6, NOW(), NOW()),
(10, '2024-09', 1200.00, 50.00, 'unpaid', '2024-10-25', NULL, NULL, NULL, 'September utility charges with small due', 9, 12, 7, NOW(), NOW());

-- ==========================================
-- INDEXING FOR PERFORMANCE
-- ==========================================

-- Additional indexes for better performance
CREATE INDEX idx_bills_composite ON bills(flat_id, status, month);
CREATE INDEX idx_tenants_composite ON tenants(flat_id, status);
CREATE INDEX idx_flats_composite ON flats(building_id, is_occupied);

-- ==========================================
-- COMPLETION MESSAGE
-- ==========================================
SELECT 'Database setup completed successfully!' as Status;
SELECT 'Admin Login: admin@flatbill.com / password' as AdminAccess;
SELECT 'House Owner Login: abdullah.mamun@example.com / password' as HouseOwnerAccess;
SELECT 'Total Users Created: ' as Info, COUNT(*) as Count FROM users;
SELECT 'Total Buildings Created: ' as Info, COUNT(*) as Count FROM buildings;
SELECT 'Total Flats Created: ' as Info, COUNT(*) as Count FROM flats;
SELECT 'Total Tenants Created: ' as Info, COUNT(*) as Count FROM tenants;
SELECT 'Total Bills Created: ' as Info, COUNT(*) as Count FROM bills;