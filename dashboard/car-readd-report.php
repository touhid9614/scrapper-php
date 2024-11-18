<?php

require_once 'config.php';
require_once 'includes/loader.php';

session_start();

require_once ADSYNCPATH . 'config.php';
require_once ADSYNCPATH . 'utils.php';
require_once ADSYNCPATH . 'db_connect.php';

require_once dirname(__DIR__) . '/cartracker/car_tracker.php';

// GENERATE DATA
$db_connect     = new DbConnect('');
$car_tracker    = new CarTracker();
$dealer_list    = $db_connect->getCronNames();
$readd_overview = $car_tracker->generateReAddOverview($dealer_list, $db_connect);

include 'bolts/header.php';
?>

<div class="inner-wrapper">

<?php
$select = 'readd-report';
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
                            <h2 class="panel-title"> Car Readd Report </h2>
                        </header>

                        <div class="panel-body">

                        </div>
                    </section>
                </div>
            </form>
            <div class="col-lg-12">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <table class="table table-bordered table-striped mb-none table-advanced">
                                <thead style="text-align: center;">
                                    <tr>
                                        <th rowspan="2"> # </th>
                                        <th rowspan="2"> Dealership </th>
                                        <th colspan="4"> Readd Count </th>
                                    </tr>
                                    <tr>
                                        <th> New </th>
                                        <th> Used </th>
                                        <th> Certified </th>
                                        <th> Total </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;

                                    foreach ($readd_overview as $cron => $values) {
                                    ?>
                                    <tr>
                                        <td> <?= $i++ ?> </td>
                                        <td> <i><a href="readd-cars-list.php?dealership=<?= $cron ?>" target="_blank"><?= $cron ?></a></i> </td>
                                        <td> <?= $values['new'] ?> </td>
                                        <td> <?= $values['used'] ?> </td>
                                        <td> <?= $values['certified'] ?> </td>
                                        <td> <?= $values['total'] ?> </td>
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

<?php
include 'bolts/footer.php';
?>