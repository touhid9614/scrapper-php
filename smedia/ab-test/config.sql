CREATE TABLE `tbl_ab_test_configs` (
  `dealership` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `option` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  UNIQUE KEY `tbl_ab_test_configs_UN` (`dealership`,`type`,`option`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
