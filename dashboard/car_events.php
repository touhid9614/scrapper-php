<?php
require_once 'config.php';
require_once 'includes/loader.php';
require_once 'includes/crm-defaults.php';

session_start();

$base_dir = dirname(__DIR__);
require_once ADSYNCPATH . 'config.php';
require_once ADSYNCPATH . 'Google/Util.php';
require_once ADSYNCPATH . 'utils.php';
require_once ADSYNCPATH . 'db_connect.php';

include 'bolts/header.php';

/*
$cron_name = filter_input(INPUT_GET, 'dealership');
if (!$cron_name) {
    $cron_name = $user['cron_name'];
} */

$selectedFeatures = [
    'dealership' => 'Dealership',
    'statistics' => 'Statistics',
    'page_view' => 'PageView',
    'time30s' => 'Time > 30 Secons',
    'time60s' => 'Time > 60 Seconds',
    'time90s' => 'Time > 90 Seconds',
    'scroll25' => 'Scroll > 25',
    'scroll50' => 'Scroll > 50',
    'scroll75' => 'Scroll > 75',
    'scroll100' => 'Scroll 100',
    'button_click' => 'Button Click',
    'image_hovered' => 'Image Hovered',
    'image_clicked' => 'Image Clicked',
    'day_to_sale' => 'Day to Sale',
    'last_updated' => 'Last Updated'
];

$finalFeaturesData = DbConnect::get_instance()->query("SELECT * FROM salematrix_overall");
$dayFinalFeaturesData = DbConnect::get_instance()->query("SELECT *  FROM salematrix_days");
$pageviewFeaturesData = DbConnect::get_instance()->query("SELECT *  FROM salematrix_pageview");

?>

<div class="inner-wrapper">

    <?php
    $select = 'sale_prediction';
    include 'bolts/sidebar.php'
    ?>

    <section role="main" class="content-body">
        <header class="page-header">
            <h2 class="panel-title"> Car Sale Prediction </h2>
        </header>

        <div class="row">
            
            <div class="col-lg-12">
            <section class="panel panel-info">
                    <header class="panel-heading">
                        <div class="panel-actions">
                            <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                        </div>
                        <h2 class="panel-title"> Car Sale Prediction Matrix Data</h2>
                    </header>              
                </section>

                <section class="panel panel-info">
                <div class="tabs">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#all_sale_matrix" data-toggle="tab" class="text-center">
                                <i class="fa fa-book"></i> Over All Sale Matrix
                            </a>
                        </li>

                        <li>
                            <a href="#day_sale_matrix" data-toggle="tab" class="text-center">
                                <i class="fa fa-address-card"></i> Daily Engagement Matrics
                            </a>
                        </li>
                        
                        <li>
                            <a href="#pageview_matrix" data-toggle="tab" class="text-center">
                                <i class="fa fa-address-card"></i> Per Page View Matrix
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content">
                     
                        <div id="all_sale_matrix" class="tab-pane active">
                        <div class="row">
                            <div class="col-lg-12">
                                <br>
                                <table class="table table-bordered table-striped mb-none table-advanced">
                                    <thead>
                                        <tr>
                                            <?php
                                            foreach ($selectedFeatures as $key => $value) {
                                                echo "<th> $value </th>";
                                            }
                                            ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    while ($row_data = mysqli_fetch_assoc($finalFeaturesData)) { ?>
                                            <tr>
                                            <?php foreach ($row_data as $key => $value): ?>
                                            <td><?= ucfirst($value) ?></td>
                                            <?php endforeach; ?>  
                                            </tr>
                                    <?php

                                }
                                ?>
                                    </tbody>
                                </table>
                                
                            </div>
                        </div>
                        </div>
                        <div id="day_sale_matrix" class="tab-pane">
                        <div class="row">
                            <div class="col-lg-12">
                            
                            <br>
                                <table class="table table-bordered table-striped mb-none table-advanced">
                                    <thead>
                                        <tr>
                                            <?php
                                            foreach ($selectedFeatures as $key => $value) {
                                                if($key == 'day_to_sale')   continue;
                                                echo "<th> $value </th>";
                                            }
                                            ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    while ($row_data = mysqli_fetch_assoc($dayFinalFeaturesData)) { ?>
                                            <tr>
                                            <?php foreach ($row_data as $key => $value) : ?>
                                            <td><?= ucfirst($value) ?></td>
                                            <?php endforeach; ?>  
                                            </tr>
                                    <?php

                                }
                                ?>
                                    </tbody>
                                </table>
                                
                            </div>
                        </div>
                        </div>
                        
                        
                        <div id="pageview_matrix" class="tab-pane">
                        <div class="row">
                            <div class="col-lg-12">
                            
                            <br>
                                <table class="table table-bordered table-striped mb-none table-advanced">
                                    <thead>
                                        <tr>
                                            <?php
                                            foreach ($selectedFeatures as $key => $value) {
                                                if($key == 'statistics' || $key == 'day_to_sale')   continue;
                                                echo "<th> $value </th>";
                                            }
                                            ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    while ($row_data = mysqli_fetch_assoc($pageviewFeaturesData)) { ?>
                                            <tr>
                                            <?php foreach ($row_data as $key => $value) : ?>
                                            <td><?= ucfirst($value) ?></td>
                                            <?php endforeach; ?>  
                                            </tr>
                                    <?php

                                }
                                ?>
                                    </tbody>
                                </table>
                                
                            </div>
                        </div>
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