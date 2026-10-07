<?php
/*
 * Database structure for the booking system (guests, bookings, e-mail log...).
 *
 * You do NOT have to import anything by hand: the first time any page of the website is opened
 * after you copy these files, ensure_schema() creates the missing tables and adds the new column
 * (lodges.units). Existing data (lodges, messages, your edits...) is never touched.
 * (evangelinewebsite.sql contains the same structure for a brand-new database.)
 */
const SCHEMA_VERSION = 3;

function schema_statements(): array {
    $tail = 'ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci';
    return [
'users' => "CREATE TABLE IF NOT EXISTS `users` (
  `id`            INT(11) NOT NULL AUTO_INCREMENT,
  `name`          VARCHAR(100) NOT NULL,
  `email`         VARCHAR(150) NOT NULL,
  `phone`         VARCHAR(25)  NOT NULL DEFAULT '',
  `address`       VARCHAR(300) NOT NULL DEFAULT '',
  `pincode`       VARCHAR(12)  NOT NULL DEFAULT '',
  `dob`           DATE DEFAULT NULL,
  `password_hash` VARCHAR(255) NOT NULL,
  `picture`       VARCHAR(255) DEFAULT NULL,
  `is_active`     TINYINT(1)   NOT NULL DEFAULT 1,
  `created_at`    DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_login_at` DATETIME     DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_email` (`email`)
) $tail",

'password_resets' => "CREATE TABLE IF NOT EXISTS `password_resets` (
  `id`         INT(11) NOT NULL AUTO_INCREMENT,
  `user_id`    INT(11) NOT NULL,
  `token_hash` CHAR(64) NOT NULL,
  `expires_at` DATETIME NOT NULL,
  `used_at`    DATETIME DEFAULT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_token` (`token_hash`),
  KEY `idx_user` (`user_id`)
) $tail",

'user_tokens' => "CREATE TABLE IF NOT EXISTS `user_tokens` (
  `id`         INT(11) NOT NULL AUTO_INCREMENT,
  `user_id`    INT(11) NOT NULL,
  `selector`   CHAR(18) NOT NULL,
  `token_hash` CHAR(64) NOT NULL,
  `expires_at` DATETIME NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_selector` (`selector`),
  KEY `idx_user` (`user_id`)
) $tail",

'login_attempts' => "CREATE TABLE IF NOT EXISTS `login_attempts` (
  `id`         INT(11) NOT NULL AUTO_INCREMENT,
  `ip`         VARCHAR(45)  NOT NULL,
  `email`      VARCHAR(150) NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_ip` (`ip`, `created_at`),
  KEY `idx_email` (`email`, `created_at`)
) $tail",

'bookings' => "CREATE TABLE IF NOT EXISTS `bookings` (
  `id`               INT(11) NOT NULL AUTO_INCREMENT,
  `ref`              VARCHAR(20) NOT NULL,
  `user_id`          INT(11) DEFAULT NULL,
  `lodge_id`         INT(11) DEFAULT NULL,
  `lodge_name`       VARCHAR(120) NOT NULL,
  `check_in`         DATE NOT NULL,
  `check_out`        DATE NOT NULL,
  `nights`           INT(11) NOT NULL,
  `adults`           INT(11) NOT NULL DEFAULT 1,
  `children`         INT(11) NOT NULL DEFAULT 0,
  `std_nights`       INT(11) NOT NULL DEFAULT 0,
  `peak_nights`      INT(11) NOT NULL DEFAULT 0,
  `std_rate`         INT(11) NOT NULL DEFAULT 0,
  `peak_rate`        INT(11) NOT NULL DEFAULT 0,
  `subtotal`         INT(11) NOT NULL DEFAULT 0,
  `tax_percent`      DECIMAL(5,2) NOT NULL DEFAULT 0,
  `tax_amount`       INT(11) NOT NULL DEFAULT 0,
  `total`            INT(11) NOT NULL DEFAULT 0,
  `special_requests` TEXT,
  `status`           VARCHAR(12) NOT NULL DEFAULT 'pending',
  `source`           VARCHAR(10) NOT NULL DEFAULT 'online',
  `guest_name`       VARCHAR(100) NOT NULL DEFAULT '',
  `guest_email`      VARCHAR(150) NOT NULL DEFAULT '',
  `guest_phone`      VARCHAR(25)  NOT NULL DEFAULT '',
  `admin_note`       TEXT,
  `cancelled_by`     VARCHAR(10) DEFAULT NULL,
  `created_at`       DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at`       DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_ref` (`ref`),
  KEY `idx_lodge_dates` (`lodge_id`, `status`, `check_in`, `check_out`),
  KEY `idx_user` (`user_id`),
  KEY `idx_status` (`status`)
) $tail",

'email_log' => "CREATE TABLE IF NOT EXISTS `email_log` (
  `id`         INT(11) NOT NULL AUTO_INCREMENT,
  `to_email`   VARCHAR(150) NOT NULL,
  `subject`    VARCHAR(200) NOT NULL,
  `body`       TEXT NOT NULL,
  `status`     VARCHAR(10) NOT NULL DEFAULT 'queued',
  `error`      VARCHAR(255) DEFAULT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) $tail",
    ];
}

function ensure_schema(): void {
    global $pdo;
    try {
        $v = (int)value("SELECT setting_value FROM site_settings WHERE setting_key = 'schema_version'");
    } catch (Throwable $ex) {
        return;                    // site_settings missing = database not imported yet; the pages will report it
    }
    if ($v >= SCHEMA_VERSION) { return; }

    try {
        foreach (schema_statements() as $sql) { $pdo->exec($sql); }

        $has = (int)value("SELECT COUNT(*) FROM information_schema.COLUMNS
                           WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'lodges' AND COLUMN_NAME = 'units'");
        if (!$has) {
            try { $pdo->exec("ALTER TABLE `lodges` ADD COLUMN `units` INT(11) NOT NULL DEFAULT 1 AFTER `max_children`"); }
            catch (Throwable $ex) { /* another request added it at the same moment */ }
        }
        run("INSERT INTO site_settings (setting_key, setting_value) VALUES ('schema_version', ?)
             ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)", [(string)SCHEMA_VERSION]);
    } catch (Throwable $ex) {
        error_log('Evangeline schema upgrade failed: ' . $ex->getMessage());
        http_response_code(500);
        exit('<h3 style="font-family:sans-serif">The database could not be upgraded automatically.</h3>'
           . '<p style="font-family:sans-serif">The MySQL user in <code>admin/admin-include/db_config.php</code> needs permission to create tables. '
           . 'Alternatively import <b>evangelinewebsite.sql</b> in phpMyAdmin (this resets all content).</p>');
    }
}
