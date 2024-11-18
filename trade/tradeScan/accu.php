<?php

require_once("./db.php");
require_once("./function.php");


$conn = new mysqli($db_config['db_host_name'], $db_config['db_user'], $db_config['db_pass'], $db_config['db_name']);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$ymmt_sql= "SELECT * FROM ymmrank LIMIT 1";
$result = $conn->query($ymmt_sql);
$ymmt_data = mysqli_fetch_all($result, MYSQLI_ASSOC);

$area_sql = "SELECT * from lat_long GROUP BY state LIMIT 20";
$result = $conn->query($area_sql);
$area_data = mysqli_fetch_all($result, MYSQLI_ASSOC);

echo '<pre>';
/*
 * echo '<pre>';
 * print_r($ymmt_data);
 * print_r($area_data);
 */


foreach ($ymmt_data as $ymmt){
    $car_info= str_replace(" ", '_', $ymmt['name']);
    $year = $ymmt['year'];
    $make = $ymmt['make'];
    $model = $ymmt['model'];
    foreach ($area_data as $area){
        $state= str_replace(" ", '_', $area['state']);
        $country =  $area['country'];
        $latitude =  $area['latitude'];
        $longitude =  $area['longitude'];
        $radius =  '250';
        $city =  $area['city'];

        $data[$car_info][$state]['location']['country']= $country;
        $data[$car_info][$state]['location']['state']= $state;
        $data[$car_info][$state]['location']['city']= $city;
        $data[$car_info][$state]['location']['latitude']= $latitude;
        $data[$car_info][$state]['location']['longitude']= $longitude;


        $sqlBuild = "SELECT id from build B ";
        $check = true;

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

//        $sqlBuild .= " LIMIT 100";
//        myPrint($sqlBuild);
        $result = $conn->query($sqlBuild);
        $build_ids = array();

        while ($row = mysqli_fetch_array($result)) {
            array_push($build_ids, $row['id']);
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

//        myPrint($sql);
        $result = $conn->query($sql);

        $count = 0;
        $validPrice = 0;
        $totalPrice = 0;
        $minPrice = 100000000;
        $maxPrice = 0;
        $priceArray = array();

        while ($row = mysqli_fetch_array($result)) {
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
//        myPrint($validPrice);
//        print_r($priceArray);
        if($validPrice > 0){
            $average = round($totalPrice / $validPrice, 2);
            $sd = round(standDeviation($priceArray, $validPrice, $average), 2);

        } else {
            $average = 0;
            $sd = 0;
        }



        $data[$car_info][$state]['details']['num_found'] = $count;
        $data[$car_info][$state]['details']['valid_price_found'] = $validPrice;
        $data[$car_info][$state]['details']['missing_price'] = $count - $validPrice;
        $data[$car_info][$state]['details']['min_price'] = $minPrice;
        $data[$car_info][$state]['details']['max_price'] = $maxPrice;
        $data[$car_info][$state]['details']['sum_price'] = $totalPrice;
        $data[$car_info][$state]['details']['price_mean'] = $average;
        $data[$car_info][$state]['details']['price_sttd'] = $sd;

        //** Trade Scan app **//

        //** with 0 threshold **//
        $threshold = 1.00;
        $highPrice = $average + ($sd*$threshold) ;
        $lowPrice = $average - ($sd*$threshold );

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

        $data[$car_info][$state]['report']['th_'.$threshold]['price_low']['number'] = $low;
        $data[$car_info][$state]['report']['th_'.$threshold]['price_low']['percentage'] = $validPrice ? round((($low*100)/$validPrice),2) : 0;
        $data[$car_info][$state]['report']['th_'.$threshold]['price_good']['number'] = $good;
        $data[$car_info][$state]['report']['th_'.$threshold]['price_good']['percentage'] =$validPrice ? round((($good*100)/$validPrice),2): 0;
        $data[$car_info][$state]['report']['th_'.$threshold]['price_high']['number'] = $high;
        $data[$car_info][$state]['report']['th_'.$threshold]['price_high']['percentage'] =$validPrice ? round((($high*100)/$validPrice),2): 0;

        //** with 1.05 threshold **//
        $threshold = 1.05;
        $highPrice = $average + ($sd*$threshold) ;
        $lowPrice = $average - ($sd*$threshold );

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

        $data[$car_info][$state]['report']['th_'.$threshold]['price_low']['number'] = $low;
        $data[$car_info][$state]['report']['th_'.$threshold]['price_low']['percentage'] = $validPrice ? round((($low*100)/$validPrice),2) : 0;
        $data[$car_info][$state]['report']['th_'.$threshold]['price_good']['number'] = $good;
        $data[$car_info][$state]['report']['th_'.$threshold]['price_good']['percentage'] =$validPrice ? round((($good*100)/$validPrice),2): 0;
        $data[$car_info][$state]['report']['th_'.$threshold]['price_high']['number'] = $high;
        $data[$car_info][$state]['report']['th_'.$threshold]['price_high']['percentage'] =$validPrice ? round((($high*100)/$validPrice),2): 0;


        //** with 1.10 threshold **//
        $threshold = 1.10;
        $highPrice = $average + ($sd*$threshold) ;
        $lowPrice = $average - ($sd*$threshold );

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

        $data[$car_info][$state]['report']['th_'.$threshold]['price_low']['number'] = $low;
        $data[$car_info][$state]['report']['th_'.$threshold]['price_low']['percentage'] = $validPrice ? round((($low*100)/$validPrice),2) : 0;
        $data[$car_info][$state]['report']['th_'.$threshold]['price_good']['number'] = $good;
        $data[$car_info][$state]['report']['th_'.$threshold]['price_good']['percentage'] =$validPrice ? round((($good*100)/$validPrice),2): 0;
        $data[$car_info][$state]['report']['th_'.$threshold]['price_high']['number'] = $high;
        $data[$car_info][$state]['report']['th_'.$threshold]['price_high']['percentage'] =$validPrice ? round((($high*100)/$validPrice),2): 0;

    }
}

$myJSON = json_encode($data);

echo $myJSON;



