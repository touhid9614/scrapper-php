<?php

/* SMEDIA DIRECTORY MAPPING */
$base_dir      = dirname(__DIR__);
$adwords_dir   = "{$base_dir}/adwords3";
$dealerxchange = "{$adwords_dir}/caches/dealerxchnage";
$csv_file_name = "ca_dealer_car_data.csv";

require_once "{$adwords_dir}/config.php";
require_once "{$adwords_dir}/db_connect.php";
require_once "{$adwords_dir}/tag_db_connect.php";
require_once "{$adwords_dir}/utils.php";

$server    = "feed.dealerxchange.com"; // 198.58.115.206:21
$port      = 21;
$user_name = "smedia";
$password  = 'Suy%Vz3@8!5#L5Z'; // Always keep password inside single quotes
$timeout   = 90;

$source  = "{$dealerxchange}/{$csv_file_name}";
$dest    = "{$csv_file_name}";
$strpos  = 0;
$passive = true;
$mode    = FTP_ASCII;

$connection = ftp_connect($server, $port, $timeout) or die("Couldn't connect to {$server}.");
ftp_login($connection, $user_name, $password) or die("Cannot login.");
ftp_pasv($connection, $passive);
ftp_put($connection, $dest, $source, $mode, $strpos) or die("Cannot upload.");
ftp_close($connection);