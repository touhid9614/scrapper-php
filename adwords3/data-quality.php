<?php

require_once 'config.php';
require_once 'db_connect.php';
require_once 'utils.php';

global $scrapper_configs, $connection;

set_time_limit(0);

$db_connect   = new DbConnect('');
$cron_names   = array_keys($scrapper_configs);
$cron_names[] = 'all_imported';
$quality_data = [];

$total_cars              = 0;
$total_with_trims        = 0;
$total_with_body         = 0;
$total_with_engine       = 0;
$total_with_transmission = 0;
$total_with_images       = 0;

foreach ($cron_names as $cron_name) {
    $qt = "{$cron_name}_scrapped_data";

    $cars              = get_count($db_connect, $qt, "1");
    $with_trims        = get_count($db_connect, $qt, "`trim` != ''");
    $with_body         = get_count($db_connect, $qt, "`body_style` != ''");
    $with_engine       = get_count($db_connect, $qt, "`engine` != ''");
    $with_transmission = get_count($db_connect, $qt, "`transmission` != ''");
    $with_images       = get_count($db_connect, $qt, "`all_images` != ''");

    $quality_data[$cron_name] = array(
        'all'          => $cars,
        'trims'        => $with_trims,
        'body'         => $with_body,
        'engine'       => $with_engine,
        'transmission' => $with_transmission,
        'images'       => $with_images,
    );

    if ($cron_name == 'all_imported') {continue;}

    $total_cars += $cars;
    $total_with_trims += $with_trims;
    $total_with_body += $with_body;
    $total_with_engine += $with_engine;
    $total_with_transmission += $with_transmission;
    $total_with_images += $with_images;
}

function table_exist(DbConnect $db_connect, $table_name)
{
    $query = "SHOW TABLES LIKE '" . $table_name . "'";

    $result = $db_connect->query($query);

    if (mysqli_num_rows($result) == 1) {
        return true;
    }

    mysqli_free_result($result);

    return false;
}

function get_count(DbConnect $db_connect, $table_name, $where)
{
    $stock_type = filter_input(INPUT_GET, 'stock_type');

    $fw = "";

    if ($stock_type) {
        $fw = "stock_type = '$stock_type' AND";
    }

    if (!table_exist($db_connect, $table_name)) {return 0;}
    $query = "SELECT count(`stock_number`) as `count` from $table_name WHERE $fw $where and deleted = 0";

    $res = $db_connect->query($query);

    if (!$res) {
        return 0;
    }

    $row = mysqli_fetch_array($res);

    if (!$row) {
        return 0;
    }

    return $row['count'];
}

$db_connect->close_connection();

?>

<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Data Quality Chart</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css" integrity="sha384-aUGj/X2zp5rLCbBxumKTCw2Z50WgIr1vs/PFN4praOTvYXWlVyh2UtNUU0KAUhAX" crossorigin="anonymous">
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" integrity="sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" crossorigin="anonymous"></script>
    </head>
    <body>
        <table class="table table-bordered">
            <tr>
                <th>Dealership</th>
                <th>Total</th>
                <th>With Trim</th>
                <th>With Body Style</th>
                <th>With Engine</th>
                <th>With Trans.</th>
                <th>With Images</th>
            </tr>
            <?php foreach ($quality_data as $cron_name => $qd): if ($qd['all'] == 0) {continue;}?>
                <tr>
                    <td><?php echo $cron_name ?></td>
                    <td><?php echo $qd['all'] ?></td>
                    <td><?php echo $qd['all'] > 0 ? round(($qd['trims'] / $qd['all']) * 100, 2) : '0.00' ?>%</td>
                    <td><?php echo $qd['all'] > 0 ? round(($qd['body'] / $qd['all']) * 100, 2) : '0.00' ?>%</td>
                    <td><?php echo $qd['all'] > 0 ? round(($qd['engine'] / $qd['all']) * 100, 2) : '0.00' ?>%</td>
                    <td><?php echo $qd['all'] > 0 ? round(($qd['transmission'] / $qd['all']) * 100, 2) : '0.00' ?>%</td>
                    <td><?php echo $qd['all'] > 0 ? round(($qd['images'] / $qd['all']) * 100, 2) : '0.00' ?>%</td>
                </tr>
                <?php endforeach;?>
            <tr class="info">
                <th>Total</th>
                <th><?php echo $total_cars ?></th>
                <th><?php echo $total_cars > 0 ? round(($total_with_trims / $total_cars) * 100, 2) : '0.00' ?>%</th>
                <th><?php echo $total_cars > 0 ? round(($total_with_body / $total_cars) * 100, 2) : '0.00' ?>%</th>
                <th><?php echo $total_cars > 0 ? round(($total_with_engine / $total_cars) * 100, 2) : '0.00' ?>%</th>
                <th><?php echo $total_cars > 0 ? round(($total_with_transmission / $total_cars) * 100, 2) : '0.00' ?>%</th>
                <th><?php echo $total_cars > 0 ? round(($total_with_images / $total_cars) * 100, 2) : '0.00' ?>%</th>
            </tr>
        </table>
    </body>
</html>