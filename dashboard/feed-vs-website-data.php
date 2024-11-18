<?php

require_once 'config.php';
require_once 'includes/loader.php';
require_once 'includes/crm-defaults.php';

session_start();

require_once ADSYNCPATH . 'config.php';
require_once ADSYNCPATH . 'Google/Util.php';
require_once ADSYNCPATH . 'utils.php';
require_once ADSYNCPATH . 'db_connect.php';

global $scraper_configs, $CronConfigs;

$db_connect = new DbConnect('');
$data       = [];

$fetch = $db_connect->query("SELECT dealership, websites, company_name FROM dealerships WHERE status IN ('active', 'trial') ORDER BY dealership ASC;");

while ($row = mysqli_fetch_assoc($fetch)) {
    $dealer = $row['dealership'];
    $table  = $dealer . '_scrapped_data';

    $data[$dealer]["url"]          = $row["websites"];
    $data[$dealer]["company_name"] = $row["company_name"];

    $stock_types = ["new", "used", "certified"];

    foreach ($stock_types as $stk) {
        $data[$dealer]["site"][$stk]              = 0;
        $data[$dealer]["feed"][$stk]              = 0;
        $data[$dealer]["price"][$stk]             = 0;
        $data[$dealer]["image"][$stk]             = 0;
        $data[$dealer]["marketplace_image"][$stk] = 0;
    }

    $webcar = $db_connect->query("SELECT COUNT(`stock_type`) AS num_car, stock_type FROM {$table} WHERE deleted = 0 GROUP BY stock_type;");

    if (mysqli_num_rows($webcar) == 0) {
        continue;
    }

    while ($numOfCar = mysqli_fetch_assoc($webcar)) {
        if (in_array($numOfCar["stock_type"], $stock_types)) {
            $data[$dealer]["site"][$numOfCar["stock_type"]] += $numOfCar["num_car"];
        }
    }

    $data[$dealer]["feed"] = $data[$dealer]["site"];

    $check       = $db_connect->query("SELECT stock_type, all_images, price, stock_number FROM {$table} WHERE deleted = 0;");
    $all_cars_db = [];

    while ($carData = mysqli_fetch_assoc($check)) {
        $car_stock_type = strtolower($carData["stock_type"]);

        $all_cars_db[trim($carData["stock_number"])] = [
            "stock_type" => $car_stock_type,
            "all_images" => $carData["all_images"],
            "price"      => $carData["price"],
        ];
    }

    foreach ($all_cars_db as $stock_number => $car) {
        $priceCheck            = isProperPrice($car["price"]);
        $imageCheck            = isProperImage($car["all_images"], $CronConfigs[$dealer]);
        $marketplaceImageCheck = isProperImage($car["all_images"], $CronConfigs[$dealer], 4);

        if (!$priceCheck) {
            $data[$dealer]["price"][$car["stock_type"]]++;
            $data[$dealer]["feed"][$car["stock_type"]]--;
            continue;
        }

        if (!$imageCheck) {
            $data[$dealer]["image"][$car["stock_type"]]++;
            $data[$dealer]["feed"][$car["stock_type"]]--;
        }
        if (!$marketplaceImageCheck) {
            $data[$dealer]["marketplace_image"][$car["stock_type"]]++;
        }
    }

    foreach ($data as $dealer => $report) {
        foreach ($report as $key => $report) {
            foreach ($report as $current_type => $number) {
                if ($number < 0) {
                    $data[$dealer][$key][$current_type] = 0;
                }
            }
        }
    }
}

/**
 * Determines whether the specified all iamges is proper image.
 *
 * @param      string   $all_images  All iamges
 *
 * @return     boolean  True if the specified all iamges is proper image, False otherwise.
 */
function isProperImage($all_images, $cron_config, $default_min_image = 1)
{
    if (!$all_images || $all_images == "") {
        return false;
    }

    $images = explode("|", $all_images);

    if (count($images) == 0) {
        return false;
    }

    $min_images = isset($cron_config['banner']['min_images']) ? $cron_config['banner']['min_images'] : $default_min_image;

    if (count($images) < $min_images) {
        return false;
    }

    return true;
}