<?php
function myPrint($str)
{
    echo "<br>" . $str . "<br>";
}

function standDeviation($arr, $num_of_elements, $average)
{
    // $num_of_elements = count($arr); 
    $variance = 0.0;

    // calculating mean using array_sum() method
    // $average = array_sum($arr)/$num_of_elements; 


    foreach ($arr as $i) {
        // sum of squares of differences between  
        // all numbers and means.
        $variance += pow(($i - $average), 2);
    }

    return (float)sqrt($variance / $num_of_elements);
}

function insertTestCase($test_case, $year, $make, $model, $trim, $locations, $conn)
{
    $id = $test_case['id'];
    $car_data = array();

    $car_data['id'] = $id;
    $car_data['year'] = $year;
    $car_data['make'] = $make;
    $car_data['model'] = $model;
    $car_data['trim'] = $trim;

    $car_data = json_encode($car_data);

    foreach ($locations as $location) {
        $loc = json_encode($location);
//        print_r($location);
//        print_r($car_data);
        if (!$test_case['result_insert']) {
            $test_case_result_sql = "INSERT INTO result_test_case (test_case_id,car_data,location_data) VALUES ('" . $id . "','" . $car_data . "','" . $loc . "')";
            if ($conn->query($test_case_result_sql) === TRUE) {
                echo "<br>New test case record created successfully";
            } else {
                echo "<br>Error: " . $conn->error;
            }
        }
    }
}

function getTradeData($year, $make, $model, $trim, $country, $latitude, $longitude, $radius, $city, $conn, $debug)
{
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
        $sqlBuild .= " B.make = '$make' ";
    }
    if (!empty($model)) {
        $sqlBuild .= $check ? ' WHERE ' : ' AND ';
        $check = false;
        $sqlBuild .= " B.model = '$model' ";
    }
    if (!empty($trim)) {
        $sqlBuild .= $check ? ' WHERE ' : ' AND ';
        $check = false;
        $sqlBuild .= " B.trim = '$trim' ";
    }

//        $sqlBuild .= " LIMIT 100";
    if ($debug) {
        myPrint($sqlBuild);
    }
    $result = $conn->query($sqlBuild);
    $build_ids = array();

    while ($row = mysqli_fetch_array($result)) {
        array_push($build_ids, $row['id']);
    }
    if ($debug) {
        myPrint("Row Count: " . count($build_ids));
    }

    if (count($build_ids)) {
        $flag = true;
        $sql = 'SELECT I.price FROM  inventory I';
        if ((!empty($country) && $country != 'all') || !empty($city) || !empty($latitude) || !empty($longitude)) {

            $sql .= " LEFT JOIN dealer D ON I.dealer_id = D.id";


            if (!empty($country) && $country != 'all') {
                $sql .= $flag ? ' WHERE ' : ' AND ';
                $sql .= " D.country like '%$country%' ";
                $flag = false;
            }
            if (!empty($city)) {
                $sql .= $flag ? ' WHERE ' : ' AND ';
                $sql .= " D.city like '%$city%' ";
                $flag = false;
            }

            if (!empty($latitude) && !empty($longitude)) {
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

        if (!empty($inventory_type)) {
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
        }
        $result = $conn->query($sql);

        $count = 0;
        $validPrice = 0;
        $totalPrice = 0;
        $minPrice = 100000000;
        $maxPrice = 0;
        $priceArray = array();

        while ($row = mysqli_fetch_array($result)) {
            $count++;
            $price = (int)$row['price'];
            if (!empty($price)) {
                $validPrice++;
                if ($price > $maxPrice) {
                    $maxPrice = $price;
                }
                if ($price < $minPrice) {
                    $minPrice = $price;
                }
                $totalPrice += $price;
                array_push($priceArray, $price);
            }
        }
        if ($debug) {
            myPrint("Price Count: " . count($priceArray));
            myPrint("valid Count: " . $validPrice);
//        print_r($priceArray);
        }
        if ($validPrice > 0) {
            $average = round($totalPrice / $validPrice, 2);
            $sd = round(standDeviation($priceArray, $validPrice, $average), 2);

        } else {
            $average = 0;
            $sd = 0;
        }


        $data['num_found'] = $count;
        $data['valid_price_found'] = $validPrice;
        $data['missing_price'] = $count - $validPrice;
        $data['min_price'] = $minPrice;
        $data['max_price'] = $maxPrice;
        $data['sum_price'] = $totalPrice;
        $data['price_mean'] = $average;
        $data['price_sttd'] = $sd;
        $data['price_array'] = $priceArray;

        return $data;
    } else {
        $data['num_found'] = 0;
        $data['valid_price_found'] = 0;
        $data['missing_price'] = 0;
        $data['min_price'] = 0;
        $data['max_price'] = 0;
        $data['sum_price'] = 0;
        $data['price_mean'] = 0;
        $data['price_sttd'] = 0;
        $data['price_array'] = [];

        return $data;
    }
}

function trade_scane($priceArray, $thresholds, $average, $sd, $validPriceCar)
{

    foreach ($thresholds as $threshold) {
        $highPrice = $average + ($sd * $threshold);
        $lowPrice = $average - ($sd * $threshold);

        $low = 0;
        $good = 0;
        $high = 0;

        foreach ($priceArray as $price) {
            if ($price >= $lowPrice && $price <= $highPrice) {
                $good++;
            } else {
                if ($price < $lowPrice) {
                    $low++;
                }
                if ($price > $highPrice) {
                    $high++;
                }
            }
        }

        $data['th_' . $threshold]['price_low']['number'] = $low;
        $data['th_' . $threshold]['price_low']['percentage'] = $validPriceCar ? round((($low * 100) / $validPriceCar), 2) : 0;
        $data['th_' . $threshold]['price_good']['number'] = $good;
        $data['th_' . $threshold]['price_good']['percentage'] = $validPriceCar ? round((($good * 100) / $validPriceCar), 2) : 0;
        $data['th_' . $threshold]['price_high']['number'] = $high;
        $data['th_' . $threshold]['price_high']['percentage'] = $validPriceCar ? round((($high * 100) / $validPriceCar), 2) : 0;
    }

    return $data;

}