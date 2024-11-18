<?php

require_once("./db.php");
require_once("./function.php");


$conn = new mysqli($db_config['db_host_name'], $db_config['db_user'], $db_config['db_pass'], $db_config['db_name']);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// echo $where;
// exit;

$debug =  isset($_GET['debug']) ? true : false;
$limit =  isset($_GET['limit']) ?  $_GET['limit'] : false;

$country =  isset($_GET['country']) ? strtolower($_GET['country']) : '';
$latitude =  isset($_GET['latitude']) ? strtolower($_GET['latitude']) : '';
$longitude =  isset($_GET['longitude']) ? strtolower($_GET['longitude']) : '';
$radius =  isset($_GET['radius']) ? strtolower($_GET['radius']) : '250';
$city =  isset($_GET['city']) ? strtolower($_GET['city']) : '';
$inventory_type = isset($_GET['car_type']) ? strtolower($_GET['car_type']) : '';


$year = isset($_GET['year']) ? $_GET['year'] : '';
$make = isset($_GET['make']) ? $_GET['make'] : '';
$model = isset($_GET['model']) ? $_GET['model'] : '';
$body_type = isset($_GET['body_type']) ? $_GET['body_type'] : '';
$vehicle_type = isset($_GET['vehicle_type']) ? $_GET['vehicle_type'] : '';
$fuel_type = isset($_GET['fuel_type']) ? $_GET['fuel_type'] : '';
$engine = isset($_GET['engine']) ? $_GET['engine'] : '';
$engine_size = isset($_GET['engine_size']) ? $_GET['engine_size'] : '';
$cylinders = isset($_GET['cylinders']) ? $_GET['cylinders'] : '';
$made_in = isset($_GET['made_in']) ? $_GET['made_in'] : '';
$trim_r = isset($_GET['trim_r']) ? $_GET['trim_r'] : '';
$body_subtype = isset($_GET['body_subtype']) ? $_GET['body_subtype'] : '';
$transmission = isset($_GET['transmission']) ? $_GET['transmission'] : '';
$drivetrain = isset($_GET['drivetrain']) ? $_GET['drivetrain'] : '';
$engine_block = isset($_GET['engine_block']) ? $_GET['engine_block'] : '';
$steering_type = isset($_GET['steering_type']) ? $_GET['steering_type'] : '';
$antibrake_sys = isset($_GET['antibrake_sys']) ? $_GET['antibrake_sys'] : '';
$tank_size = isset($_GET['tank_size']) ? $_GET['tank_size'] : '';
$overall_height = isset($_GET['overall_height']) ? $_GET['overall_height'] : '';
$overall_length = isset($_GET['overall_length']) ? $_GET['overall_length'] : '';
$overall_width = isset($_GET['overall_width']) ? $_GET['overall_width'] : '';
$std_seating = isset($_GET['std_seating']) ? $_GET['std_seating'] : '';
$opt_seating = isset($_GET['opt_seating']) ? $_GET['opt_seating'] : '';
$highway_miles = isset($_GET['highway_miles']) ? $_GET['highway_miles'] : '';
$city_miles = isset($_GET['city_miles']) ? $_GET['city_miles'] : '';
$brandclass = isset($_GET['brandclass']) ? $_GET['brandclass'] : '';
$fuelgrade = isset($_GET['fuelgrade']) ? $_GET['fuelgrade'] : '';
$drivetrain_grade = isset($_GET['drivetrain_grade']) ? $_GET['drivetrain_grade'] : '';
$bodytype_grade = isset($_GET['bodytype_grade']) ? $_GET['bodytype_grade'] : '';
$engine_block_grade = isset($_GET['engine_block_grade']) ? $_GET['engine_block_grade'] : '';
$trim_adjustment = isset($_GET['trim_adjustment']) ? $_GET['trim_adjustment'] : '';
$model_multiplier = isset($_GET['model_multiplier']) ? $_GET['model_multiplier'] : '';



$sqlBuild = "SELECT id from build B ";
// $sql = "SELECT I.price, I.id FROM inventory I 
// LEFT JOIN build B ON  I.build_id = B.id";

$check = true;

// if(!empty($country) && $country!='all'){
//     $sql .= "LEFT JOIN dealer D ON I.dealer_id = D.id WHERE D.country = $country  ";
// } else {
//     $check = true; 
// }

if (!empty($year)) {
    $sqlBuild .= $check ? ' WHERE ' : ' AND ';
    $check = false;
    $sqlBuild .= "  B.year = '$year' ";
}
if (!empty($make)) {
    $sqlBuild .= $check ? ' WHERE ' : ' AND ';
    $check = false;
    $sqlBuild .= " B.make like '%$make%' ";
}
if (!empty($model)) {
    $sqlBuild .= $check ? ' WHERE ' : ' AND ';
    $check = false;
    $sqlBuild .= " B.model like '%$model%' ";
}
if (!empty($body_type)) {
    $sqlBuild .= $check ? ' WHERE ' : ' AND ';
    $check = false;
    $sqlBuild .= " B.body_type like '%$body_type%' ";
}
if (!empty($vehicle_type)) {
    $sqlBuild .= $check ? ' WHERE ' : ' AND ';
    $check = false;
    $sqlBuild .= " B.vehicle_type like '%$vehicle_type%' ";
}
if (!empty($fuel_type)) {
    $sqlBuild .= $check ? ' WHERE ' : ' AND ';
    $check = false;
    $sqlBuild .= " B.fuel_type like '%$fuel_type%' ";
}
if (!empty($engine)) {
    $sqlBuild .= $check ? ' WHERE ' : ' AND ';
    $check = false;
    $sqlBuild .= " B.engine like '%$engine%' ";
}
if (!empty($cylinders)) {
    $sqlBuild .= $check ? ' WHERE ' : ' AND ';
    $check = false;
    $sqlBuild .= " B.cylinders like '%$cylinders%' ";
}
if (!empty($made_in)) {
    $sqlBuild .= $check ? ' WHERE ' : ' AND ';
    $check = false;
    $sqlBuild .= " B.made_in like '%$made_in%' ";
}
if (!empty($trim_r)) {
    $sqlBuild .= $check ? ' WHERE ' : ' AND ';
    $check = false;
    $sqlBuild .= " B.trim_r like '%$trim_r%' ";
}
if (!empty($body_subtype)) {
    $sqlBuild .= $check ? ' WHERE ' : ' AND ';
    $check = false;
    $sqlBuild .= " B.body_subtype like '%$body_subtype%' ";
}
if (!empty($transmission)) {
    $sqlBuild .= $check ? ' WHERE ' : ' AND ';
    $check = false;
    $sqlBuild .= " B.transmission like '%$transmission%' ";
}
if (!empty($drivetrain)) {
    $sqlBuild .= $check ? ' WHERE ' : ' AND ';
    $check = false;
    $sqlBuild .= " B.drivetrain like '%$drivetrain%' ";
}
if (!empty($engine_block)) {
    $sqlBuild .= $check ? ' WHERE ' : ' AND ';
    $check = false;
    $sqlBuild .= " B.engine_block like '%$engine_block%' ";
}
if (!empty($steering_type)) {
    $sqlBuild .= $check ? ' WHERE ' : ' AND ';
    $check = false;
    $sqlBuild .= " B.steering_type like '%$steering_type%' ";
}
if (!empty($antibrake_sys)) {
    $sqlBuild .= $check ? ' WHERE ' : ' AND ';
    $check = false;
    $sqlBuild .= " B.antibrake_sys like '%$antibrake_sys%' ";
}
if (!empty($tank_size)) {
    $sqlBuild .= $check ? ' WHERE ' : ' AND ';
    $check = false;
    $sqlBuild .= " B.tank_size like '%$tank_size%' ";
}
if (!empty($overall_height)) {
    $sqlBuild .= $check ? ' WHERE ' : ' AND ';
    $check = false;
    $sqlBuild .= " B.overall_height like '%$overall_height%' ";
}
if (!empty($overall_length)) {
    $sqlBuild .= $check ? ' WHERE ' : ' AND ';
    $check = false;
    $sqlBuild .= " B.overall_length like '%$overall_length%' ";
}
if (!empty($overall_width)) {
    $sqlBuild .= $check ? ' WHERE ' : ' AND ';
    $check = false;
    $sqlBuild .= " B.overall_width like '%$overall_width%' ";
}
if (!empty($std_seating)) {
    $sqlBuild .= $check ? ' WHERE ' : ' AND ';
    $check = false;
    $sqlBuild .= " B.std_seating like '%$std_seating%' ";
}
if (!empty($opt_seating)) {
    $sqlBuild .= $check ? ' WHERE ' : ' AND ';
    $check = false;
    $sqlBuild .= " B.opt_seating like '%$opt_seating%' ";
}
if (!empty($highway_miles)) {
    $sqlBuild .= $check ? ' WHERE ' : ' AND ';
    $check = false;
    $sqlBuild .= " B.highway_miles like '%$highway_miles%' ";
}
if (!empty($city_miles)) {
    $sqlBuild .= $check ? ' WHERE ' : ' AND ';
    $check = false;
    $sqlBuild .= " B.city_miles like '%$city_miles%' ";
}
if (!empty($brandclass)) {
    $sqlBuild .= $check ? ' WHERE ' : ' AND ';
    $check = false;
    $sqlBuild .= " B.brandclass like '%$brandclass%' ";
}
if (!empty($fuelgrade)) {
    $sqlBuild .= $check ? ' WHERE ' : ' AND ';
    $check = false;
    $sqlBuild .= " B.fuelgrade like '%$fuelgrade%' ";
}
if (!empty($drivetrain_grade)) {
    $sqlBuild .= $check ? ' WHERE ' : ' AND ';
    $check = false;
    $sqlBuild .= " B.drivetrain_grade like '%$drivetrain_grade%' ";
}
if (!empty($bodytype_grade)) {
    $sqlBuild .= $check ? ' WHERE ' : ' AND ';
    $check = false;
    $sqlBuild .= " B.bodytype_grade like '%$bodytype_grade%' ";
}
if (!empty($engine_block_grade)) {
    $sqlBuild .= $check ? ' WHERE ' : ' AND ';
    $check = false;
    $sqlBuild .= " B.engine_block_grade like '%$engine_block_grade%' ";
}
if (!empty($trim_adjustment)) {
    $sqlBuild .= $check ? ' WHERE ' : ' AND ';
    $check = false;
    $sqlBuild .= " B.trim_adjustment like '%$trim_adjustment%' ";
}
if (!empty($model_multiplier)) {
    $sqlBuild .= $check ? ' WHERE ' : ' AND ';
    $check = false;
    $sqlBuild .= " B.model_multiplier like '%$model_multiplier%' ";
}

if ($limit) {
    $sqlBuild .= " LIMIT $limit";
}

if ($debug) {
    myPrint($sqlBuild);

    $started = microtime(true);
}

//Execute your SQL query.
$result = $conn->query($sqlBuild);


if ($debug) {
    $end = microtime(true);
    $difference = $end - $started;
    $queryTime = number_format($difference, 10);

    myPrint("SQL query took $queryTime seconds.");
}

if ($debug) {
    $started = microtime(true);
}
$build_ids = array();
while ($row = mysqli_fetch_array($result)) {
    array_push($build_ids, $row['id']);
}

if ($debug) {
    $end = microtime(true);
    $difference = $end - $started;
    $queryTime = number_format($difference, 10);
    myPrint("Total Data " . count($build_ids));
    myPrint("Php Array took $queryTime seconds");
    // var_dump($build_ids);
}


$flag = true;
$sql = 'SELECT I.price FROM  inventory I';
if ((!empty($country) && $country != 'all') || !empty($city) || !empty($latitude) || !empty($longitude)) {

    $sql .= " LEFT JOIN dealer D ON I.dealer_id = D.id";
    

    if(!empty($country) && $country != 'all'){
        $sql .= $flag ? ' WHERE ' : ' AND ';
        $sql .= " D.country like '%$country%' ";
        $flag = false;
    }
    if(!empty($city)){
        $sql .= $flag ? ' WHERE ' : ' AND ';
        $sql .= " D.city like '%$city%' ";
        $flag = false;
    }

    if(!empty($latitude) && !empty($longitude)){
        $sql .= $flag ? ' WHERE ' : ' AND ';
        $flag = false;

        
        $lat = $latitude;
        $lng = $longitude;
        $range = $radius;
        

        $radius = $range * 0.621371;
        // This really only approximates a distance between the central point and the car location which is a somewhat simpler calculation than the actual distance.
        // The actual distance would be based on the Haversine formula:
        // 60 * 1.1515 * rad2deg(acos(sin(deg2rad({$location['latitude']})) * sin(deg2rad(latitude)) +  cos(deg2rad({$location['latitude']})) * cos(deg2rad($latitude)) * cos(deg2rad({$location['longitude']} - longitude))))
        $sql .= " (ABS($lng-`longitude`) * 69.1703234283616 * COS(latitude*0.0174532925199433)) < $radius AND (69.047 * ABS($lat-latitude)) < $radius ";
    }

}
if(!empty($inventory_type)){
    $sql .= $flag ? ' WHERE ' : ' AND ';
    $flag = false;
    $sql .= " I.inventory_type like '%$inventory_type%' ";
}
if (count($build_ids)) {
    $sql .= $flag ? ' WHERE ' : ' AND ';
    $sql .= '  I.build_id IN (' . implode(',', array_map('intval', $build_ids)) . ') ';
}





if ($debug) {
    myPrint($sql);

    $started = microtime(true);
}

$result = $conn->query($sql);

if ($debug) {
    $end = microtime(true);
    $difference = $end - $started;
    $queryTime = number_format($difference, 10);

    myPrint("SQL query took $queryTime seconds.");
}

$count = 0;
$validPrice = 0;
$totalPrice = 0;
$minPrice = 100000000;
$maxPrice = 0;
$priceArray = array();

if ($debug) {

    $started = microtime(true);
}

while ($row = mysqli_fetch_array($result)) {
    // var_dump($row);
    $count++;
    $price = (int) $row['price'];
    if (!empty($price)) {
        $validPrice++;
        if($price > $maxPrice){
            $maxPrice = $price;
        }
        if($price < $minPrice){
            $minPrice = $price;
        }
        $totalPrice += $price;
        array_push($priceArray, $price);
    }
}

if ($debug) {
    $end = microtime(true);
    $difference = $end - $started;
    $queryTime = number_format($difference, 10);

    myPrint("Php Array took $queryTime seconds");

    myPrint("Total Data: $count");
    myPrint("Total Valid price Data: $validPrice");
    myPrint("Total Price: $totalPrice");
    myPrint("Avg Price: " . $totalPrice / $validPrice);
}


$average = round($totalPrice / $validPrice, 2);
$sd = round(standDeviation($priceArray, $validPrice, $average), 2);


$data['num_found'] = $count;
$data['valid_price_found'] = $validPrice;
$data['missing_price'] = $count - $validPrice;
$data['min_price'] = $minPrice;
$data['max_price'] = $maxPrice;
$data['sum_price'] = $totalPrice;
$data['price_mean'] = $average;
$data['price_sttd'] = $sd;

//** Trade Scan app **//

//** Trade Scan app **//
$highPrice = $data['price_mean'] + $data['price_sttd'];
$lowPrice = $data['price_mean'] - $data['price_sttd'];

$low = 0;
$good = 0;
$high = 0;

foreach ($priceArray as $price){
    if($price >= $lowPrice && $price <= $highPrice ){
        $good++;
    } else {
        if($price < $lowPrice) {
            $low++;
        }
        if($price > $highPrice ) {
            $high++;
        }
    }
}

$data['report']['price_low']['number'] = $low;
$data['report']['price_low']['percentage'] = round((($low*100)/$validPrice),2);
$data['report']['price_good']['number'] = $good;
$data['report']['price_good']['percentage'] = round((($good*100)/$validPrice),2);
$data['report']['price_high']['number'] = $high;
$data['report']['price_high']['percentage'] = round((($high*100)/$validPrice),2);

//** 1.05 threshold **//

$threshold = 1.05;
$highPrice = $data['price_mean'] + ($data['price_sttd']*$threshold) ;
$lowPrice = $data['price_mean'] - ($data['price_sttd']*$threshold );

$low = 0;
$good = 0;
$high = 0;

foreach ($priceArray as $price){
    if($price >= $lowPrice && $price <= $highPrice ){
        $good++;
    } else {
        if($price < $lowPrice) {
            $low++;
        }
        if($price > $highPrice ) {
            $high++;
        }
    }
}

$data['report_threshold_'.$threshold]['price_low']['number'] = $low;
$data['report_threshold_'.$threshold]['price_low']['percentage'] = round((($low*100)/$validPrice),2);
$data['report_threshold_'.$threshold]['price_good']['number'] = $good;
$data['report_threshold_'.$threshold]['price_good']['percentage'] = round((($good*100)/$validPrice),2);
$data['report_threshold_'.$threshold]['price_high']['number'] = $high;
$data['report_threshold_'.$threshold]['price_high']['percentage'] = round((($high*100)/$validPrice),2);

//** 1.05 threshold **//

$threshold = 1.10;
$highPrice = $data['price_mean'] + ($data['price_sttd']*$threshold) ;
$lowPrice = $data['price_mean'] - ($data['price_sttd']*$threshold );

$low = 0;
$good = 0;
$high = 0;

foreach ($priceArray as $price){
    if($price >= $lowPrice && $price <= $highPrice ){
        $good++;
    } else {
        if($price < $lowPrice) {
            $low++;
        }
        if($price > $highPrice ) {
            $high++;
        }
    }
}

$data['report_threshold_'.$threshold]['price_low']['number'] = $low;
$data['report_threshold_'.$threshold]['price_low']['percentage'] = round((($low*100)/$validPrice),2);
$data['report_threshold_'.$threshold]['price_good']['number'] = $good;
$data['report_threshold_'.$threshold]['price_good']['percentage'] = round((($good*100)/$validPrice),2);
$data['report_threshold_'.$threshold]['price_high']['number'] = $high;
$data['report_threshold_'.$threshold]['price_high']['percentage'] = round((($high*100)/$validPrice),2);

//** Trade Scan app **//


$myJSON = json_encode($data);

echo $myJSON;
