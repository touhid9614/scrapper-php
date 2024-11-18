<?php

require_once 'config.php';
require_once 'db-config.php';
require_once 'db_connect.php';
require_once 'utils.php';

global $proxy_list;

$log = __DIR__ . "/caches/p2m.txt";

error_reporting(E_ALL);
ini_set('display_errors', 1);

$db_connect = new DbConnect('');

// setup mongo db
$mongo = new MongoDB\Client(
    "mongodb://crawler:zLPMRijB8iNAgrhb9z@mongo.smedia.ca:27017/smediacrawler?authSource=smediacrawler&readPreference=primary&appname=smedia&ssl=false"
);
$mongodb     = $mongo->smediacrawler;
$page_source = $mongodb->page_source;

$query      = "SELECT dealership FROM dealerships WHERE mongo_exported = false ORDER BY dealership ASC;";
$template_1 = "SELECT * FROM `%s` WHERE deleted = 0;";

$result  = mysqli_query(DbConnect::get_connection_read(), $query);
$dealers = [];

if (!$result) {
    die(mysqli_error(DbConnect::get_connection_read()));
}

while ($row = mysqli_fetch_array($result)) {
    $dealers[] = $row['dealership'];
}

$use_proxy   = true;
$in_cookies  = '';
$out_cookies = '';

foreach ($dealers as $dealership) {
    echo $dealership . " has been started";
    $table_name = $dealership . "_scrapped_data";
    $query1     = sprintf($template_1, $table_name, $table_name);
    $res1       = $db_connect->query($query1);

    while ($car_data = mysqli_fetch_assoc($res1)) {
        $url             = $car_data['url'];
        $page_source_raw = HttpGet($url, $proxy_list, $use_proxy, $in_cookies, $out_cookies);

        $payload = [
            "svin"                    => $car_data['svin'],
            "url"                     => $url,
            "dealership"              => $dealership,
            "page_source"             => $page_source_raw,
            "stock_number"            => $car_data['stock_number'],
            "stock_number_proposal"   => "",
            "vin"                     => $car_data['vin'],
            "vin_proposal"            => "",
            "stock_type"              => $car_data['stock_type'],
            "stock_type_proposal"     => "",
            "title"                   => $car_data['title'],
            "title_proposal"          => "",
            "year"                    => $car_data['year'],
            "year_proposal"           => "",
            "make"                    => $car_data['make'],
            "make_proposal"           => "",
            "model"                   => $car_data['model'],
            "model_proposal"          => "",
            "trim"                    => $car_data['trim'],
            "trim_proposal"           => "",
            "msrp"                    => $car_data['msrp'],
            "msrp_proposal"           => "",
            "price"                   => $car_data['price'],
            "price_proposal"          => "",
            "body_style"              => $car_data['body_style'],
            "body_style_proposal"     => "",
            "engine"                  => $car_data['engine'],
            "engine_proposal"         => "",
            "transmission"            => $car_data['transmission'],
            "transmission_proposal"   => "",
            "fuel_type"               => $car_data['fuel_type'],
            "fuel_type_proposal"      => "",
            "drivetrain"              => $car_data['drivetrain'],
            "drivetrain_proposal"     => "",
            "exterior_color"          => $car_data['exterior_color'],
            "exterior_color_proposal" => "",
            "interior_color"          => $car_data['interior_color'],
            "interior_color_proposal" => "",
            "kilometres"              => $car_data['kilometres'],
            "kilometres_proposal"     => "",
            "all_images"              => $car_data['all_images'],
            "all_images_proposal"     => "",
            "description"             => $car_data['description'],
            "description_proposal"    => "",
        ];

        $page_source->insertOne($payload);
    }

    $db_connect->query("UPDATE dealerships SET mongo_exported = true WHERE dealership = '$dealership';");
    file_put_contents($log, $table_name . "\n", FILE_APPEND);
}
