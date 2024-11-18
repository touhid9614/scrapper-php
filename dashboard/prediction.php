<?php
require_once 'config.php';
require_once 'includes/loader.php';
require_once 'includes/crm-defaults.php';

session_start();

require_once ADSYNCPATH . 'config.php';
require_once ADSYNCPATH . 'Google/Util.php';
require_once ADSYNCPATH . 'utils.php';
require_once ADSYNCPATH . 'db_connect.php';
require_once dirname(ABSPATH) . '/sale-prediction/predictor.php';

global $user;
$cron_name = filter_input(INPUT_GET, 'dealership');
if(!$cron_name) {
    $cron_name = $user['cron_name'];
}

$prediction_window = 7;

$selectedFeatures = [
    'page_view'     => ['mean' => 0, 'sd' => 0],
    'time30s'       => ['mean' => 0, 'sd' => 0],
    'time60s'       => ['mean' => 0, 'sd' => 0],
    'time90s'       => ['mean' => 0, 'sd' => 0],
    'scroll25'      => ['mean' => 0, 'sd' => 0],
    'scroll50'      => ['mean' => 0, 'sd' => 0],
    'scroll75'      => ['mean' => 0, 'sd' => 0],
    'scroll100'     => ['mean' => 0, 'sd' => 0],
    'button_click'  => ['mean' => 0, 'sd' => 0],
    'image_hovered' => ['mean' => 0, 'sd' => 0],
    'image_clicked' => ['mean' => 0, 'sd' => 0],
    'days'          => ['mean' => 0, 'sd' => 0]
];

$parameter_list = "page_view, time30s, time60s, time90s, scroll25, scroll50, scroll75, scroll100, button_click, image_hovered, image_clicked";

$sale_features_result    = DbConnect::get_instance()->query("SELECT calc_type, $parameter_list, day_to_sale as days FROM salematrix_overall WHERE dealership = '" . DbConnect::get_instance()->real_escape_string_read($cron_name) . "'");

$sale_features = $selectedFeatures;

while($row_data = mysqli_fetch_assoc($sale_features_result)) {
    foreach($selectedFeatures as $key => $value) {
        $sale_features[$key][$row_data['calc_type']] = $row_data[$key];
    }
}

mysqli_free_result($sale_features_result);

#Will require in final calculation
$significance = get_significant_features($sale_features);
$target_points = calculate_point_range(get_significant_values($sale_features, $significance), $significance);

$daily_gain_result       = DbConnect::get_instance()->query("SELECT calc_type, $parameter_list FROM salematrix_days WHERE dealership = '" . DbConnect::get_instance()->real_escape_string_read($cron_name) . "'");

$daily_features = $selectedFeatures;

while($row_data = mysqli_fetch_assoc($daily_gain_result)) {
    foreach($selectedFeatures as $key => $value) {
        $daily_features[$key][$row_data['calc_type']] = $row_data[$key];
    }
}

$daily_features['days'] = ['mean' => 1, 'sd' => 0];

mysqli_free_result($daily_gain_result);

#Will require in final calculation
$daily_gains = calculate_point_range($daily_features, $significance);

$scrapper_table = $cron_name . "_scrapped_data";
$vehicle_features_result = DbConnect::get_instance()->query("SELECT $scrapper_table.url, title, stock_number, price, $parameter_list, time_on_inventory as days FROM salematrix_featuredata_unsold JOIN $scrapper_table ON salematrix_featuredata_unsold.url = $scrapper_table.url WHERE dealership = '" . DbConnect::get_instance()->real_escape_string_read($cron_name) . "'");

$prediction = [];

while($row_data = mysqli_fetch_assoc($vehicle_features_result)) {
    $url = $row_data['url'];
    $vehicle_featrues = [];
    
    foreach($selectedFeatures as $key => $value) {
        $vehicle_featrues[$key] = $row_data[$key];
    }
    
    $vehicle_point = calculate_vehicle_point($vehicle_featrues, $significance);
    $required_days = predict_required_days($vehicle_point, $daily_gains, $target_points);
    
    $chance = chance_of_being_sold($prediction_window, $required_days['min'], $required_days['max']);
    
    $prediction[$url] = [
        'title'             => $row_data['title'],
        'stock_number'      => $row_data['stock_number'],
        'price'             => $row_data['price'],
        'time_on_inventory' => $row_data['days'],
        'chance'            => $chance,
        'days'              => $required_days
    ];
}

mysqli_free_result($vehicle_features_result);

$old_vehicle_features_result = DbConnect::get_instance()->query("SELECT $scrapper_table.url, title, stock_number, price,salematrix_featuredata_all.deleted, $parameter_list, time_on_inventory as days FROM salematrix_featuredata_all JOIN $scrapper_table ON salematrix_featuredata_all.url = $scrapper_table.url WHERE dealership = '" . DbConnect::get_instance()->real_escape_string_read($cron_name) . "'");

$total_predicted = 0;
$total_sold      = 0;

while($row_data = mysqli_fetch_assoc($old_vehicle_features_result)) {
    $url = $row_data['url'];
    $vehicle_featrues = [];
    
    foreach($selectedFeatures as $key => $value) {
        $vehicle_featrues[$key] = $row_data[$key];
    }
    
    $vehicle_point = calculate_vehicle_point($vehicle_featrues, $significance);
    $required_days = predict_required_days($vehicle_point, $daily_gains, $target_points);
    
    $chance = chance_of_being_sold($prediction_window, $required_days['min'], $required_days['max']);
    
    if($chance > 70) {
        $total_predicted++;
        if($row_data['deleted']) { $total_sold++; }
    }
}

$accuracy = $total_predicted >= 0?round(($total_sold/$total_predicted)*100, 2) : 0;

mysqli_free_result($old_vehicle_features_result);

include 'bolts/header.php';

?>

<div class="inner-wrapper">
     <?php
    $select = 'sale-prediction';
    include 'bolts/sidebar.php'
    ?>

    <section role="main" class="content-body">
        <header class="page-header">

        </header>
        <div class="row">
            <div class="col-lg-12">
               <section class="panel panel-info">
                    <header class="panel-heading">
                        <div class="panel-actions">
                            <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                        </div>
                        <h2 class="panel-title">Sales Prediction for :: <?= $cron_name ?> with <?= $accuracy ?>% accuracy</h2>
                    </header>
                    <div class="panel-body">
                        <form method="GET" class="form-inline">
                            <label class="mb-2 mr-sm-2 mb-sm-0 ml-md" for="dealership">Dealership</label>
                            <select class="form-control mb-2 mr-sm-2 mb-sm-0 populate" name="dealership" id="dealership" data-plugin-selectTwo>
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
                            <button class="btn btn-primary ml-md"> Submit </button>                             
                        </form>
                    </div>
                </section>
            </div>
            
            <div class="col-lg-12">
                <section class="panel">

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <table class="table table-bordered table-striped mb-none prediction-table">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Stock Number</th>
                                            <th>Price</th>
                                            <th>Time on Inventory</th>
                                            <th>Chance of sale in <?= $prediction_window ?> days (%)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($prediction as $url => $result) {  ?>
                                            <tr>
                                                <td><a target="_blank" href="<?= $url ?>"><?= $result['title'] ?></a></td>
                                                <td><?= $result['stock_number'] ?></td>
                                                <td><?= $result['price'] ?></td>
                                                <td><?= intval($result['time_on_inventory']) ?></td>
                                                <td><?= round($result['chance'], 2) ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
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
