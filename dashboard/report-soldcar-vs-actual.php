<?php
/**
 * Created by PhpStorm.
 * User: Wahidul
 * Date: 3/14/2019
 * Time: 11:22 AM
 */

require_once 'config.php';
require_once 'includes/loader.php';
require_once 'includes/crm-defaults.php';

session_start();

require_once ADSYNCPATH . 'config.php';
require_once ADSYNCPATH . 'Google/Util.php';
require_once ADSYNCPATH . 'utils.php';
require_once ADSYNCPATH . 'db_connect.php';

global $CronConfigs, $scrapper_configs, $connection;
$cron_names = array_intersect(array_keys($CronConfigs), array_keys($scrapper_configs));
$cron_name = $_POST['dealership'];
$sold_car_vs_actual_file = $_POST['soldcar_vs_actual_file'];
$target_dir = __DIR__ . '/assets/upload/soldcar/';
$target_file = $target_dir . $_FILES['soldcar_vs_actual_file']['name'];
if (!file_exists($target_file)) {
    mkdir($target_dir, 0777, true);
}
move_uploaded_file($_FILES['soldcar_vs_actual_file']['tmp_name'], $target_file);

$decode_resp = csv_real_decode(file_get_contents($target_file));
$actual_solds = [];
foreach ($decode_resp as $record) {
    $stock_number = trim($record['VehicleStockNumber']);
    $actual_solds[$stock_number]['title'] = $record['VehicleYear'] . ' ' . $record['VehicleMake'] . ' ' . $record['VehicleModel'];
    $actual_solds[$stock_number]['sold_date'] = $record['SoldDate'];
}

$db_sold_car = [];
$get_allcar = DbConnect::get_instance()->query("SELECT * FROM {$cron_name}_scrapped_data WHERE deleted = '1'");
while ($car = mysqli_fetch_assoc($get_allcar)) {
    $db_sold_car[$car['stock_number']]['title'] = $car['year'] . ' ' . $car['make'] . ' ' . $car['model'];
    $db_sold_car[$car['stock_number']]['sold_date'] = date('d/m/Y', $car['updated_at']);
}

include 'bolts/header.php'
?>

<div class="inner-wrapper">
    <?php
    $select = 'soldcar-vs-actual';
    include 'bolts/sidebar.php'
    ?>
    <section role="main" class="content-body">
        <header class="page-header"></header>
        <?php

        ?>
        <div class="row">
            <div class="col-lg-12">
                <section class="panel panel-info">
                    <header class="panel-heading">
                        <div class="panel-actions">
                            <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                        </div>
                        <h2 class="panel-title"> Report for Sold Car VS Actual</h2>
                    </header>
                    <div class="panel-body">
                        <form method="POST" action="report-soldcar-vs-actual.php" class="form-inline"
                              enctype="multipart/form-data">
                            <label class="mb-2 mr-sm-2 mb-sm-0 ml-md" for="dealership">Dealership</label>
                            <select class="form-control mb-2 mr-sm-2 mb-sm-0 populate" name="dealership" id="dealership"
                                    data-plugin-selectTwo>
                                <?php
                                if ($user['type'] == 'a') {
                                    foreach ($cron_names as $c_name) {
                                        $selected = ($cron_name == $c_name) ? ' selected' : '';
                                        ?>
                                        <option value="<?= $c_name ?>"<?= $selected ?>><?= $c_name ?></option>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <option value="<?= $user['cron_name'] ?>"<?= ' selected' ?>><?= $user['cron_name'] ?> </option>
                                <?php } ?>
                            </select>

                            <input class="form-control mb-2 mr-sm-2 mb-sm-0" type="file" name="soldcar_vs_actual_file"
                                   placeholder="Upload File">

                            <button class="btn btn-primary ml-md"> Submit</button>
                            <button type="button" class="btn btn-gplus ml-md" id="export"> Export</button>
                        </form>
                    </div>
                </section>
            </div>

            <div class="col-lg-12">
                <section class="panel">

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <table class="table table-bordered table-striped mb-none table-advanced">
                                    <thead>
                                    <tr>
                                        <th> Stock Number</th>
                                        <th> Title</th>
                                        <th> Sold Date</th>
                                        <th> DB Sold Date</th>
                                        <th> Day Difference</th>
                                        <th> Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($actual_solds as $stock_number => $car): ?>
                                        <tr>
                                            <td> <?= $stock_number ?> </td>
                                            <td> <?= $car['title'] ?> </td>
                                            <td> <?= date("F j, Y", strtotime($car['sold_date'])) ?></td>
                                            <?php
                                            $db_sold_date = isset($db_sold_car[$stock_number]) ? $db_sold_car[$stock_number]['sold_date'] : '';
                                            $sold_date = str_replace('-', '/', substr($car['sold_date'], 0, 9));
                                            $db_sold_date_human_readable = isset($db_sold_car[$stock_number]) ? date("F j, Y",strtotime($db_sold_car[$stock_number]['sold_date'])) : '';
                                            echo "<td> $db_sold_date_human_readable </td>";
                                            if($db_sold_date && $sold_date) {
                                                $diff_day   = (((strtotime($sold_date) - strtotime($db_sold_date)) / 3600) / 24);
                                                echo "<td> $diff_day </td>";
                                                if($diff_day === 0) {
                                                    echo "<td> OK </td>";
                                                } else {
                                                    echo "<td> NOT OK </td>";
                                                }
                                            }else {
                                                echo "<td> N/A </td>";
                                                echo "<td> NOT OK </td>";
                                            }
                                            ?>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>

                                <table id="export-table" style="display: none">
                                    <tr>
                                        <th> Stock Number</th>
                                        <th> Title</th>
                                        <th> Sold Date</th>
                                        <th> DB Sold Date</th>
                                        <th> Day Difference</th>
                                        <th> Status</th>
                                    </tr>
                                    <?php foreach ($actual_solds as $stock_number => $car): ?>
                                        <tr>
                                            <td> <?= $stock_number ?> </td>
                                            <td> <?= $car['title'] ?> </td>
                                            <td> <?= $car['sold_date'] ?></td>
                                            <?php
                                            $db_sold_date = isset($db_sold_car[$stock_number]) ? $db_sold_car[$stock_number]['sold_date'] : '';
                                            $sold_date = str_replace('-', '/', substr($car['sold_date'], 0, 9));
                                            $db_sold_date_human_readable = isset($db_sold_car[$stock_number]) ? date("F j, Y",strtotime($db_sold_car[$stock_number]['sold_date'])) : '';
                                            echo "<td> $db_sold_date_human_readable </td>";
                                            if($db_sold_date && $sold_date) {
                                                $diff_day   = (((strtotime($sold_date) - strtotime($db_sold_date)) / 3600) / 24);
                                                echo "<td> $diff_day </td>";
                                                if($diff_day === 0) {
                                                    echo "<td> OK </td>";
                                                } else {
                                                    echo "<td> NOT OK </td>";
                                                }
                                            }else {
                                                echo "<td> N/A </td>";
                                                echo "<td> NOT OK </td>";
                                            }
                                            ?>
                                        </tr>
                                    <?php endforeach; ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>
</div>

<?php
include 'bolts/footer.php';
?>

<script>
    $( "#export" ).click(function() {
        $('table#export-table').csvExport({
            title:'report_soldcar_vs_actual'
        });
    });
</script>
