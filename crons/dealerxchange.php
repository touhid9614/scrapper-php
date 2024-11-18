<?php

/* SMEDIA DIRECTORY MAPPING */
$base_dir      = dirname(__DIR__);
$adwords_dir   = "{$base_dir}/adwords3";
$dealerxchange = "{$adwords_dir}/caches/dealerxchnage";
$dest          = "ca_dealer_car_data.csv";
$source        = "{$dealerxchange}/{$dest}";

require_once "{$adwords_dir}/config.php";
require_once "{$adwords_dir}/db_connect.php";
require_once "{$adwords_dir}/tag_db_connect.php";
require_once "{$adwords_dir}/utils.php";

$db_connect = new DbConnect('');
$query      = "SELECT dealership, city, state, post_code, address, phone FROM dealerships WHERE (status = 'active' AND country_name = 'Canada' AND dealer_type = 'vehicle') ORDER BY dealership ASC;";

$query_template_1 = "SELECT * FROM `%s` WHERE deleted = false;";

$result      = $db_connect->query($query);
$tables      = [];
$dealer_data = [];

while ($row = mysqli_fetch_assoc($result)) {
    $tables[]                          = $row["dealership"] . "_scrapped_data";
    $dealer_data[$row["dealership"]]   = [];
    $dealer_data[$row["dealership"]][] = trim($row["city"]);
    $dealer_data[$row["dealership"]][] = trim($row["state"]);
    $dealer_data[$row["dealership"]][] = trim($row["post_code"]);
    $dealer_data[$row["dealership"]][] = trim($row["address"]);
    $dealer_data[$row["dealership"]][] = trim($row["phone"]);
}

$fields = ['stock_number', 'vin', 'stock_type', 'title', 'year', 'make', 'model', 'trim', 'msrp', 'price', 'body_style', 'engine', 'transmission', 'fuel_type', 'drivetrain', 'exterior_color', 'interior_color', 'kilometres', 'all_images', 'description'];

$url_fields      = ['url'];
$timestamps      = ['arrival_date', 'updated_at'];
$address_fields  = ['city', 'state', 'post_code', 'address', 'phone'];
$extended_fields = array_merge(['dealership'], $fields, $url_fields, $timestamps, $address_fields);

$outstream = fopen($source, 'w+');
fputcsv($outstream, $extended_fields);

foreach ($tables as $table_name) {
    $dealership = str_replace("_scrapped_data", "", $table_name);
    $query1     = sprintf($query_template_1, $table_name, $table_name);
    $scrap      = $db_connect->query($query1);

    $current_row_values = [$dealership];

    while ($row_data = mysqli_fetch_assoc($scrap)) {
        foreach ($fields as $current_field) {
            $current_row_values[] = trim($row_data[$current_field]);
        }

        foreach ($url_fields as $current_field) {
            $current_row_values[] = trim(forceHTTPS($row_data[$current_field]));
        }

        foreach ($timestamps as $current_field) {
            $current_row_values[] = gmdate("Y-m-d H:i:s", $row_data[$current_field]) . " (GMT -6:00)";
        }

        $current_row_values = array_merge($current_row_values, $dealer_data[$dealership]);

        fputcsv($outstream, $current_row_values);
        $current_row_values = [$dealership];
    }
}

fclose($outstream);
$db_connect->close_connection();

$server    = "feed.dealerxchange.com"; // 198.58.115.206:21
$port      = 21;
$user_name = "smedia";
$password  = 'Suy%Vz3@8!5#L5Z'; // Always keep password inside single quotes
$timeout   = 90;

$connection = ftp_connect($server, $port, $timeout) or die("Couldn't connect to FTP => {$server}.");
ftp_login($connection, $user_name, $password) or die("Can't login to FTP.");
ftp_pasv($connection, true);
ftp_put($connection, $dest, $source, FTP_ASCII) or die("Can't upload CSV to FTP.");
ftp_close($connection);