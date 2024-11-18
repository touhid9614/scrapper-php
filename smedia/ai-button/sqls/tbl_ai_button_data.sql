CREATE TABLE IF NOT EXISTS `tbl_ai_button_data` (
  `combination_id` int(11) unsigned DEFAULT NULL,
  `view` int(11) unsigned DEFAULT NULL,
  `click` int(11) unsigned DEFAULT NULL,
  `fill_up` int(11) unsigned DEFAULT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;