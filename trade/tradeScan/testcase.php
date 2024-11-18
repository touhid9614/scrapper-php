<?php
require_once("./db.php");
require_once("./function.php");

$conn = new mysqli($db_config['db_host_name'], $db_config['db_user'], $db_config['db_pass'], $db_config['db_name']);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo '<pre>';

$test_case_sql = "SELECT * FROM test_case";
$test_case_result = $conn->query($test_case_sql);
$test_case_data = mysqli_fetch_all($test_case_result, MYSQLI_ASSOC);

foreach ($test_case_data as $test_case) {

    $id = $test_case['id'];
    $car = json_decode($test_case['car_data']);
    $locations = json_decode($test_case['location_data']);

    foreach ($car as $year => $data) {
        foreach ($data as $make => $data) {
            if (count((array)$data)) {
                foreach ($data as $model => $data) {
                    if (count((array)$data)) {
                        foreach ($data as $trim) {
                            insertTestCase($test_case, $year, $make, $model, $trim, $locations, $conn);
                        }
                    } else {
                        insertTestCase($test_case, $year, $make, $model, '', $locations, $conn);
                    }
                }
            } else {
                insertTestCase($test_case, $year, $make, '', '', $locations, $conn);
            }
        }
    }

    if (!$test_case['result_insert']) {
        $sql = "UPDATE test_case SET result_insert='1' WHERE id= $id";
        if ($conn->query($sql) === TRUE) {
            echo "<br>New record created successfully";
        } else {
            echo "<br>Error: " . $conn->error;
        }
    }
}

