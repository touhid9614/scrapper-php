<?php

require_once 'adwords3/config.php';
require_once 'adwords3/Google/Util.php';
require_once 'adwords3/db_connect.php';
require_once 'adwords3/cron_misc.php';

global $CronConfigs, $connection;

$cron_name      = isset($_GET['dealership']) ? $_GET['dealership'] : null;
$inc_stock_type = isset($_GET['type']) ? $_GET['type'] : 'all';
$all_cars_db    = [];

if (isset($CronConfigs[$cron_name])) {
    $cron_config = $CronConfigs[$cron_name];
    $cars_db     = [];
    $ads_db      = [];
    $all_cars_db = [];
    $db_connect  = new DbConnect($cron_name);
    $db_connect->LoadCarAds($cars_db, $ads_db, $all_cars_db, $cron_config);
}
?>
<table>
    <tr>
        <th>Stock No.</th>
        <th>Title</th>
        <th>Placements</th>
    </tr>
    <?php
    foreach ($all_cars_db as $stock_number => $car):
        if ($car['deleted'] == 0 && ($inc_stock_type == 'all' || $inc_stock_type == $car['stock_type'])):
            $year       = $car['year'];
            $make       = $car['make'];
            $model      = $car['model'];
            $price      = $car['price'];
            $stock_type = $car['stock_type'];
            $title      = "$year $make $model";

            $placement_urls = get_placement_urls($db_connect, $cron_config, $car);
            ?>
                 <tr>
                    <td><?php echo $stock_number ?></td>
                    <td><a href="<?=$car['url']?>" target="_blank"><?=str_replace('&', '&amp;', $title)?></a></td>
                    <td><?=count($placement_urls)?></td>
                </tr>
    <?php
        endif;
    endforeach;
    ?>
    </table>
<?php
$db_connect->close_connection(DbConnect::CLOSE_READ_CONNECTION);