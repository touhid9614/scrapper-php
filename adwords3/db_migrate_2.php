<?php

require_once 'config.php';
require_once 'db-config.php';
require_once 'db_connect.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

$query        = "SELECT dealership FROM dealerships ORDER BY dealership ASC;";
$table_create = <<<TABLE
CREATE TABLE `%s_cartrack_data` (
	`svin` VARCHAR(50) NOT NULL COLLATE 'latin1_swedish_ci',
	`current_url` VARCHAR(1024) NOT NULL COLLATE 'latin1_swedish_ci',
	`previous_url` VARCHAR(1024) NOT NULL COLLATE 'latin1_swedish_ci',
	`current_stock_number` VARCHAR(50) NULL COLLATE 'latin1_swedish_ci',
	`previous_stock_number` VARCHAR(50) NULL COLLATE 'latin1_swedish_ci',
	`current_vin` VARCHAR(50) NULL COLLATE 'latin1_swedish_ci',
	`previous_vin` VARCHAR(50) NULL COLLATE 'latin1_swedish_ci',
	`readded_by` ENUM('svin','vin','url','stock_number') NULL COLLATE 'latin1_swedish_ci',
	`readded_at` BIGINT(20) NOT NULL DEFAULT '0',
	`deleted_at` BIGINT(20) NOT NULL DEFAULT '0',
	`active` BIT(1) NOT NULL DEFAULT b'1',
	`add_delete_history` BLOB NULL,
	PRIMARY KEY (`svin`) USING BTREE
) COLLATE='latin1_swedish_ci' ENGINE=InnoDB;
TABLE;

$result  = mysqli_query(DbConnect::get_connection_read(), $query);
$dealers = [];

if (!$result) {
    die(mysqli_error(DbConnect::get_connection_read()));
}

while ($row = mysqli_fetch_array($result)) {
    $dealers[] = $row['dealership'];
}

foreach ($dealers as $dealership) {
    $table = sprintf($table_create, $dealership, $dealership);
    $res1  = mysqli_query(DbConnect::get_connection_read(), $table);

    if (!$res1) {
        echo "An error occured while creating {$dealership}_cartrack_data.<br>";
    } else {
        echo "{$dealership}_cartrack_data table has been created.<br>";
    }
}