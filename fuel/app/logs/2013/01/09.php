<?php defined('COREPATH') or exit('No direct script access allowed'); ?>

Error - 2013-01-09 11:01:41 --> 42000 - SQLSTATE[42000]: Syntax error or access violation: 1064 You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'NOT NULL,
	`secure_key` varchar(32) NOT NULL,
	`payment` varchar(10) NOT NULL,
	' at line 7 with query: "CREATE TABLE IF NOT EXISTS `achat_orders` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`user_id` int(11) NOT NULL,
	`user_addr` int(11) NOT NULL,
	`cart_id` int(11) NOT NULL,
	`country_code` varchar(2) NOT NULL,
	`state` enum NOT NULL,
	`secure_key` varchar(32) NOT NULL,
	`payment` varchar(10) NOT NULL,
	`total_paid_taxed` decimal(8,2) NOT NULL,
	`currency_code` varchar(3) NOT NULL,
	`created_at` int(11) NOT NULL,
	`updated_at` int(11) NOT NULL,
	PRIMARY KEY `id` (`id`)
) DEFAULT CHARACTER SET utf8;" in /Users/panda/Sites/season13/fuel/core/classes/database/pdo/connection.php on line 175
Error - 2013-01-09 11:04:12 --> 42000 - SQLSTATE[42000]: Syntax error or access violation: 1064 You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '11 NOT NULL,
	`taxed_price` decimal(8,2) NOT NULL,
	`discount` decimal(3,2) NOT ' at line 4 with query: "CREATE TABLE IF NOT EXISTS `achat_cartproducts` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`cart_id` int(11) NOT NULL,
	`product_id` 11 NOT NULL,
	`taxed_price` decimal(8,2) NOT NULL,
	`discount` decimal(3,2) NOT NULL,
	`offer` int(1) NOT NULL,
	`offer_target` varchar(255) NOT NULL,
	`created_at` int(11) NOT NULL,
	`updated_at` int(11) NOT NULL,
	PRIMARY KEY `id` (`id`)
) DEFAULT CHARACTER SET utf8;" in /Users/panda/Sites/season13/fuel/core/classes/database/pdo/connection.php on line 175
Error - 2013-01-09 15:52:21 --> 23000 - SQLSTATE[23000]: Integrity constraint violation: 1048 Column 'source_ref' cannot be null with query: "INSERT INTO `admin_13userpossesions` (`user_mail`, `episode_id`, `source`, `source_ref`, `created_at`, `updated_at`) VALUES ('lphuabin@gmail.com', '2', '5', null, 1357743141, 1357743141)" in /Users/panda/Sites/season13/fuel/core/classes/database/pdo/connection.php on line 175
