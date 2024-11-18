<?php
require_once("./db.php");
require_once("./function.php");

$conn = new mysqli($db_config['db_host_name'], $db_config['db_user'], $db_config['db_pass'], $db_config['db_name']);
$debug = (isset($_GET['debug']) && !empty($_GET['debug'])) ? true : false;
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo '<pre>';

$test_case_sql = "SELECT * FROM test_case where active = 1 ";
$result = $conn->query($test_case_sql);
$test_cases = mysqli_fetch_all($result, MYSQLI_ASSOC);

foreach ($test_cases as $test_case) {
    $test_id = $test_case['id'];
    $test_case_result_sql = "SELECT * FROM result_test_case where test_case_id = $test_id ";
    $result = $conn->query($test_case_result_sql);
    $test_cases_result = mysqli_fetch_all($result, MYSQLI_ASSOC);

    foreach ($test_cases_result as $test_case_result) {
        $id = $test_case_result['id'];
        $car_data = json_decode($test_case_result['car_data']);
        $location_data = json_decode($test_case_result['location_data']);

        $year = $car_data->year;
        $make = $car_data->make;
        $model = $car_data->model;
        $trim = $car_data->trim;

        $country = $location_data->country;
        $latitude = $location_data->latitude;
        $longitude = $location_data->longitude;
        $radius = '250';
        $city = $location_data->city;

//        myPrint(' Year- '.$year);
//        myPrint(' $make- '.$make);
//        myPrint(' $model- '.$model);
//        myPrint(' $trim- '.$trim);
//        myPrint(' $country- '.$country);
//        myPrint(' $latitude- '.$latitude);
//        myPrint(' $longitude- '.$longitude);
//        myPrint(' $city- '.$city);

        $trade = getTradeData($year, $make, $model, $trim, $country, $latitude, $longitude, $radius, $city, $conn, $debug);
        $thresholds = [1.00, 1.05, 1.10];
        $trade_scane = trade_scane($trade['price_array'], $thresholds, $trade['price_mean'], $trade['price_sttd'], $trade['valid_price_found'], $debug);
        if ($debug) {
            print_r($trade);
            print_r($trade_scane);
        }

        $tra = json_encode($trade);
        $ts = json_encode($trade_scane);

        $sql = "UPDATE result_test_case SET details='$tra', result='$ts' WHERE id= $id";

        if ($conn->query($sql) === TRUE) {
            echo "<br>Result successfully insert";
        } else {
            echo "<br>Error: " . $conn->error;
        }
    }
}
