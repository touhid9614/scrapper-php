<?php

require_once("./db.php");

$conn = new mysqli($db_config['db_host_name'], $db_config['db_user'], $db_config['db_pass'], $db_config['db_name']);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo '<pre>';
$sql="SELECT city,state,country,zip,latitude,longitude FROM dealer GROUP BY city ORDER BY  country ASC , state ASC , city ASC";

$result = $conn->query($sql);
$allCity= array();
while ($row = mysqli_fetch_array($result)) {
    if(empty($row['latitude']) || empty($row['longitude'])) {

        $sql2 = 'SELECT city,state,country,zip,latitude,longitude FROM dealer where city="' . $row['city'] . '"';
        $result2 = $conn->query($sql2);

        while ($row2 = mysqli_fetch_array($result2)) {
            if(empty($row2['latitude']) && empty($row2['longitude'])) {
                $row['latitude']=$row2['latitude'];
                $row['longitude']=$row2['longitude'];
                break;
            }
        }
    }
    foreach ($row as $key=>$value){
        $row[$key] = str_replace("'",' ' ,$value);
    }

    if(!empty($row['latitude']) && !empty($row['longitude'])) {
        array_push( $allCity,$row);
    }
}



$table = ['country','state','city','zip','latitude','longitude'];
/*
 $co=1;
foreach ($allCity as $city) {
    if($co>3840) {
        $sql = "INSERT INTO lat_long (country,state,city,zip,latitude,longitude) VALUES ('" . $city['country'] . "','" . $city['state'] . "','" . $city['city'] . "','" . $city['zip'] . "','" . $city['latitude'] . "','" . $city['longitude'] . "')";
        echo '<br>' . $sql;
        if ($conn->query($sql) === TRUE) {
            echo "<br>New record created successfully";
        } else {
            echo "<br>Error: " . $sql . "<br>" . $conn->error;
        }
    }
    $co++;
}
exit;
*/
?>

<style>
    table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    td, th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }

    tr:nth-child(even) {
        background-color: #dddddd;
    }
</style>

<table>
    <tr>
        <th>#</th>
        <th>Country</th>
        <th>State</th>
        <th>City</th>
        <th>Zip</th>
        <th>Latitude</th>
        <th>Longitude</th>
    </tr>

        <?php
        $count=1;
         foreach ($allCity as $city){
             echo '<tr>';
             echo "<td>$count</td>";
             $count++;
             foreach ($table as $row){
                 echo "<td>$city[$row]</td>";
             }
             echo '</tr>';
         }
        ?>
</table>
