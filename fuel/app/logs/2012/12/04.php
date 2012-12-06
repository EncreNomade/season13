<?php defined('COREPATH') or exit('No direct script access allowed'); ?>

Error - 2012-12-04 14:00:38 --> Error - SQLSTATE[42S02]: Base table or view not found: 1146 Table 'EncreNomade.webservice_plateformapps' doesn't exist with query: "SELECT `t0`.`id` AS `t0_c0`, `t0`.`appid` AS `t0_c1`, `t0`.`appsecret` AS `t0_c2`, `t0`.`appname` AS `t0_c3`, `t0`.`description` AS `t0_c4`, `t0`.`active` AS `t0_c5`, `t0`.`ip` AS `t0_c6`, `t0`.`host` AS `t0_c7`, `t0`.`extra` AS `t0_c8`, `t0`.`created_at` AS `t0_c9`, `t0`.`updated_at` AS `t0_c10` FROM `webservice_plateformapps` AS `t0`" in /Users/panda/Sites/season13/fuel/core/classes/database/pdo/connection.php on line 175
Error - 2012-12-04 14:02:49 --> Error - SQLSTATE[42S02]: Base table or view not found: 1146 Table 'EncreNomade.achat_13products' doesn't exist with query: "SELECT `t0`.`id` AS `t0_c0`, `t0`.`reference` AS `t0_c1`, `t0`.`type` AS `t0_c2`, `t0`.`pack` AS `t0_c3`, `t0`.`content` AS `t0_c4`, `t0`.`presentation` AS `t0_c5`, `t0`.`tags` AS `t0_c6`, `t0`.`title` AS `t0_c7`, `t0`.`category` AS `t0_c8`, `t0`.`metas` AS `t0_c9`, `t0`.`on_sale` AS `t0_c10`, `t0`.`price` AS `t0_c11`, `t0`.`discount` AS `t0_c12`, `t0`.`sales` AS `t0_c13`, `t0`.`created_at` AS `t0_c14`, `t0`.`updated_at` AS `t0_c15` FROM `achat_13products` AS `t0`" in /Users/panda/Sites/season13/fuel/core/classes/database/pdo/connection.php on line 175
Error - 2012-12-04 14:03:04 --> 42000 - SQLSTATE[42000]: Syntax error or access violation: 1064 You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'var_char(32) NOT NULL,
	`owner` varchar(255) NOT NULL,
	`order_source` varchar(2' at line 3 with query: "CREATE TABLE IF NOT EXISTS `achat_13extorders` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`reference` var_char(32) NOT NULL,
	`owner` varchar(255) NOT NULL,
	`order_source` varchar(255) NOT NULL,
	`appid` int(32) NOT NULL,
	`price` decimal(20,6) NOT NULL,
	`app_name` var_char(32) NOT NULL,
	`created_at` int(11) NOT NULL,
	`updated_at` int(11) NOT NULL,
	PRIMARY KEY `id` (`id`)
) DEFAULT CHARACTER SET utf8;" in /Users/panda/Sites/season13/fuel/core/classes/database/pdo/connection.php on line 175
Error - 2012-12-04 14:05:03 --> 8 - Undefined variable: current_user in /Users/panda/Sites/season13/fuel/app/views/admin/template.php on line 20
Error - 2012-12-04 14:53:37 --> 8 - Undefined variable: css_supp in /Users/panda/Sites/season13/fuel/app/views/template.php on line 288
Error - 2012-12-04 14:53:42 --> 8 - Undefined variable: css_supp in /Users/panda/Sites/season13/fuel/app/views/template.php on line 288
Error - 2012-12-04 14:58:35 --> 8 - Undefined variable: current_user in /Users/panda/Sites/season13/fuel/app/views/admin/template.php on line 20
Error - 2012-12-04 15:25:34 --> Parsing Error - syntax error, unexpected ')' in /Users/panda/Sites/season13/fuel/app/views/achat/13product/_form.php on line 22
