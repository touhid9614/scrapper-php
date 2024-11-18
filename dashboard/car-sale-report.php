<?php

require_once 'config.php';
require_once 'includes/loader.php';

session_start();

require_once ADSYNCPATH . 'config.php';
require_once ADSYNCPATH . 'utils.php';
require_once ADSYNCPATH . 'db_connect.php';

require_once dirname(__DIR__) . '/cartracker/car_tracker.php';

// GENERATE DATA
$db_connect  = new DbConnect('');
$car_tracker = new CarTracker();

$start_date  = filter_input(INPUT_GET, 'start_date');
$end_date    = filter_input(INPUT_GET, 'end_date');
$show_active = filter_input(INPUT_GET, 'show_active');
$show_trial  = filter_input(INPUT_GET, 'show_trial');

if (!$start_date || !$end_date) {
    $start_date = '01' . date('-M-Y', time());
    $end_date   = date('d-M-Y', time());
}

if ($show_active) {
    array_push($status_list, 'active');
}

if ($show_trial) {
    array_push($status_list, 'trial');
}

if (empty($status_list)) {
    $status_list = ['active', 'trial'];
}

$dealerships        = $db_connect->getCronNames($status_list);
$car_tracker_report = [];
$details_page       = "https://tools.smedia.ca/dashboard/details.php?dealership=";

foreach ($dealerships as $dealer) {
    $thisDealerReport = $car_tracker->generateSaleReport($dealer, $start_date, $end_date, $db_connect);
    unset($thisDealerReport['sold_cars']);
    $car_tracker_report[$dealer] = $thisDealerReport;
}
// DATA END

include 'bolts/header.php';
?>

<div class="inner-wrapper">

    <?php
    $select = 'sale-report';
    include 'bolts/sidebar.php';
    ?>

    <section role="main" class="content-body">
        <header class="page-header">

        </header>
        <div class="row">
            <form id="filter-form" method="GET" class="form-horizontal form-bordered">
                <div class="col-lg-12">
                    <section class="panel panel-info">
                        <header class="panel-heading">
                            <div class="panel-actions">
                                <a href="#" class="panel-action" data-panel-toggle></a>
                            </div>
                            <h2 class="panel-title"> Car Removal Report </h2>
                        </header>

                        <div class="panel-body">
                            <div class="row mb-md">
                                <div class="col-md-3 col-sm-6">
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label"> Status </label>
                                        <div class="col-sm-9">
                                            <div class="checkbox-custom chekbox-primary">
                                                <input id="active" value="active" type="checkbox" name="show_active" <?= in_array('active', $status_list) ? 'data-current="checked" checked' : 'data-current=""'; ?> />
                                                <label for="active"> Active </label>
                                            </div>
                                            <div class="checkbox-custom chekbox-primary">
                                                <input id="trial" value="trial" type="checkbox" name="show_trial" <?= in_array('trial', $status_list) ? 'data-current="checked" checked' : 'data-current=""'; ?> />
                                                <label for="trial"> Trial </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3 col-sm-6">
                                    <div class="form-group">
                                        <label class="mb-2 mr-sm-2 mb-sm-0 ml-md" for="start_date">Start Date</label>
                                        <input class="form-control mb-2 mr-sm-2 mb-sm-0" name="start_date" id="start_date" type="date" value="<?= $start_date ?>" data-current="<?= $start_date ?>" required="" />
                                    </div>
                                </div>

                                <div class="col-md-3 col-sm-6">
                                    <div class="form-group">
                                        <label class="mb-2 mr-sm-2 mb-sm-0 ml-md" for="end_date">End Date</label>
                                        <input class="form-control mb-2 mr-sm-2 mb-sm-0" name="end_date" id="end_date" type="date" value="<?= $end_date ?>" data-current="<?= $end_date ?>" required="" />
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-md">
                                <div class="col-md-6 col-sm-12"> </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label"></label>
                                        <div class="col-sm-8 clearfix">
                                            <button id="btn-filter" type="submit" class="btn btn-info mr-xs pull-right ml-xs">Apply Filter</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </form>

            <div class="col-lg-12">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <h2> Report for <?= $start_date ?> to <?= $end_date ?> </h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <table class="table table-bordered table-striped mb-none table-advanced">
                                <thead>
                                    <tr>
                                        <th rowspan="2"> # </th>
                                        <th rowspan="2"> Dealership </th>
                                        <th rowspan="2"> Period (in days) </th>
                                        <th rowspan="2"> Removed </th>
                                        <th rowspan="2"> New Removed </th>
                                        <th rowspan="2"> Used Removed </th>
                                        <th rowspan="2"> Average Inventory Period </th>
                                        <th colspan="7"> Removal By Weekday </th>
                                    </tr>
                                    <tr>
                                        <th> Sat </th>
                                        <th> Sun </th>
                                        <th> Mon </th>
                                        <th> Tue </th>
                                        <th> Wed </th>
                                        <th> Thr </th>
                                        <th> Fri </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;

                                    foreach ($car_tracker_report as $key => $value) { ?>
                                        <tr>
                                            <td> <?= $i++ ?> </td>
                                            <td> <a href="<?= $details_page . $key ?>" target="_blank"><?= $key ?></a> </td>
                                            <td> <?= $value['sale_length'] ?> </td>
                                            <td> <?= $value['no_of_sale'] ?> </td>
                                            <td> <?= $value['new_sale'] ?> </td>
                                            <td> <?= $value['used_sale'] ?> </td>
                                            <td> <?= $value['avg_inv_period'] ?> </td>
                                            <td> <?= $value['sale_by_day']['sat'] ?> </td>
                                            <td> <?= $value['sale_by_day']['sun'] ?> </td>
                                            <td> <?= $value['sale_by_day']['mon'] ?> </td>
                                            <td> <?= $value['sale_by_day']['tue'] ?> </td>
                                            <td> <?= $value['sale_by_day']['wed'] ?> </td>
                                            <td> <?= $value['sale_by_day']['thr'] ?> </td>
                                            <td> <?= $value['sale_by_day']['fri'] ?> </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php
include 'bolts/footer.php';
?>