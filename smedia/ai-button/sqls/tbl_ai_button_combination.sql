CREATE TABLE IF NOT EXISTS `tbl_ai_button_combination` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `combination` varchar(255) DEFAULT NULL,
  `button_type` varchar(80) DEFAULT NULL,
  `dealership_id` int(11) DEFAULT NULL,
  `total_view` int(10) unsigned DEFAULT '0',
  `total_click` int(10) unsigned DEFAULT '0',
  `total_fill_up` int(10) unsigned DEFAULT '0',
  `total_score` int(10) unsigned DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `combination_button_type_dealership_id` (`combination`,`button_type`,`dealership_id`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=latin1;