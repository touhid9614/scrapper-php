<?php
require_once(__DIR__ . "/db.php");
require_once(__DIR__ . "/function.php");


$conn = new mysqli($db_config['db_host_name'], $db_config['db_user'], $db_config['db_pass'], $db_config['db_name']);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$test_case_sql = "SELECT * FROM test_case";

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
    if ($id > 0) {
        $test_case_sql .= " WHERE id=$id";
    }
}

$test_case_result = $conn->query($test_case_sql);
//$test_case_result = mysqli_fetch_all($result, MYSQLI_ASSOC);

//echo '<pre>';
//
if ($row = mysqli_fetch_array($test_case_result)) {
    //    print_r($row);
    $test_id = $row['id'];
    $car_data = json_decode($row['car_data'], true);
    $location_data = json_decode($row['location_data'], true);

    ?>

    <div style="overflow-x:auto;">

        <?php

        $test_case_result_sql = "SELECT * FROM result_test_case where test_case_id = $test_id ";

        $result = $conn->query($test_case_result_sql);
        $test_case_result = mysqli_fetch_all($result, MYSQLI_ASSOC);


        ?>

        <table class="table thead-light table-striped table-bordered">
            <tr>
                <th rowspan="2">#</th>
                <th colspan="4" class="text-center"> Car Info</th>
                <th colspan="5" class="text-center"> Location</th>
                <th rowspan="2" class="text-center"> Details</th>
                <th colspan="3" class="text-center"> Result</th>
            </tr>
            <tr>
                <th>Year</th>
                <th>Make</th>
                <th>Model</th>
                <th>Trim</th>

                <th>Country</th>
                <th>State</th>
                <th>City</th>
                <!--        <th>Zip</th>-->
                <th>Latitude</th>
                <th>Longitude</th>
                <!--        <th>Radius</th>-->


                <!--        <th>Number found</th>-->
                <!--        <th>Min Price</th>-->
                <!--        <th>Max Price</th>-->
                <!--        <th>Mean Price</th>-->
                <!--        <th>Sd Price</th>-->

                <th> Threshold 1.00</th>
                <th> Threshold 1.05</th>
                <th> Threshold 1.10</th>
            </tr>
            <?php
            $count = 1;
            foreach ($test_case_result as $ts) {
                echo '<tr>';
                echo "<td>$count</td>";
                $count++;

                $car_data = json_decode($ts['car_data']);
                $location_data = json_decode($ts['location_data']);
                $details_data = json_decode($ts['details']);
                $result_data = (array)json_decode($ts['result']);


                $year = $car_data->year;
                $make = $car_data->make;
                $model = $car_data->model;
                $trim = $car_data->trim;

                $country = $location_data->country;
                $state = $location_data->state;
                $city = $location_data->city;
                //        $zip =  $location_data->zip;
                $latitude = $location_data->latitude;
                $longitude = $location_data->longitude;
                $radius = '250';


                echo "<td>$year</td>";
                echo "<td>$make</td>";
                echo "<td>$model</td>";
                echo "<td>$trim</td>";

                echo "<td>$country</td>";
                echo "<td>$state</td>";
                echo "<td>$city</td>";
                //        echo "<td>$zip</td>";
                echo "<td>$latitude</td>";
                echo "<td>$longitude</td>";
                //        echo "<td>$radius</td>";

                echo "<td>";
                if (!empty($details_data)) {
                    if ($details_data->valid_price_found) {
                        echo "num_found: <b>" . $details_data->num_found . "</b><br>";
                        echo "valid_price_found: " . $details_data->valid_price_found . "<br>";
                        echo "missing_price: " . $details_data->missing_price . "<br>";
                        echo "max_price: " . $details_data->max_price . "<br>";
                        echo "min_price: " . $details_data->min_price . "<br>";
                        echo "price_mean: <b>" . $details_data->price_mean . "</b><br>";
                        echo "price_sttd: <b>" . $details_data->price_sttd . "</b><br>";
                    } else {
                        echo ' 0';
                    }
                } else {
                    echo 'No Result ';
                }
                echo "</td>";

                echo "<td>";
                if (isset($result_data['th_1']) && !empty($result_data['th_1'])) {
                    if ($details_data->valid_price_found) {
                        echo "<b>Price Low</b><br>";
                        echo "Number: " . $result_data['th_1']->price_low->number . '<br>';
                        echo "Percentage: " . $result_data['th_1']->price_low->percentage . '%<br>';
                        echo "<br><b>Price Good</b><br>";
                        echo "Number: " . $result_data['th_1']->price_good->number . '<br>';
                        echo "Percentage: " . $result_data['th_1']->price_good->percentage . '%<br>';
                        echo "<br><b>Price High</b><br>";
                        echo "Number: " . $result_data['th_1']->price_high->number . '<br>';
                        echo "Percentage: " . $result_data['th_1']->price_high->percentage . '%<br>';
                    } else {
                        echo ' 0';
                    }
                } else {
                    echo 'No Result';
                }
                echo "</td>";

                echo "<td>";
                if (isset($result_data['th_1.05']) && !empty($result_data['th_1.05'])) {
                    if ($details_data->valid_price_found) {
                        echo "<b>Price Low</b><br>";
                        echo "Number: " . $result_data['th_1.05']->price_low->number . '<br>';
                        echo "Percentage: " . $result_data['th_1.05']->price_low->percentage . '%<br>';
                        echo "<br><b>Price Good</b><br>";
                        echo "Number: " . $result_data['th_1.05']->price_good->number . '<br>';
                        echo "Percentage: " . $result_data['th_1.05']->price_good->percentage . '%<br>';
                        echo "<br><b>Price High</b><br>";
                        echo "Number: " . $result_data['th_1.05']->price_high->number . '<br>';
                        echo "Percentage: " . $result_data['th_1.05']->price_high->percentage . '%<br>';
                    } else {
                        echo ' 0';
                    }
                } else {
                    echo 'No Result ';
                }
                echo "</td>";

                echo "<td>";
                if (isset($result_data['th_1.1']) && !empty($result_data['th_1.1'])) {
                    if ($details_data->valid_price_found) {
                        echo "<b>Price Low</b><br>";
                        echo "Number: " . $result_data['th_1.1']->price_low->number . '<br>';
                        echo "Percentage: " . $result_data['th_1.1']->price_low->percentage . '%<br>';
                        echo "<br><b>Price Good</b><br>";
                        echo "Number: " . $result_data['th_1.1']->price_good->number . '<br>';
                        echo "Percentage: " . $result_data['th_1.1']->price_good->percentage . '%<br>';
                        echo "<br><b>Price High</b><br>";
                        echo "Number: " . $result_data['th_1.1']->price_high->number . '<br>';
                        echo "Percentage: " . $result_data['th_1.1']->price_high->percentage . '%<br>';
                    } else {
                        echo ' 0';
                    }
                } else {
                    echo 'No Result ';
                }
                echo "</td>";

                //        print_r($details_data);
                //        echo "</td><td>";
                //        print_r($result_data);
                //        echo "</td>";
                //        echo "<td>$details_data</td>";
                //        echo "<td>$result_data</td>";


                //        print_r($ts);
                //        foreach ($table as $row){
                //            echo "<td>$city[$row]</td>";
                //        }
                echo '</tr>';
            }
            ?>
        </table>
    </div>

    </br>
    <b><h5> Important note </h5></b>
    <h6> * If field value '0' that means no car found in this area.</h6>
    <h6> * If field value 'No Result' that means Report not create yet. Result will automatic create after 1 hr. </h6>
    <h6> * In search we use 250 radius in the center of geolocation.</h6>
    <h6> * Result Theory : average ± (threshold * standard deviation ).</h6>
    <?php
}
?>
