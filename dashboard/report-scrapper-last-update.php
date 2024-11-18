<?php

require_once 'config.php';
require_once 'includes/loader.php';
require_once 'includes/crm-defaults.php';

require_once ADSYNCPATH . 'config.php';
require_once ADSYNCPATH . 'Google/Util.php';
require_once ADSYNCPATH . 'utils.php';
require_once ADSYNCPATH . 'db_connect.php';

$db_connect        = new DbConnect('');
$allactive_dealers = $db_connect->get_all_dealers("`status` = 'active' OR `status` = 'trial'");

$scrapper_report = [];
$i               = 0;
$status_list     = [];
$details_page    = "https://tools.smedia.ca/dashboard/details.php?dealership=";

$show_active = filter_input(INPUT_GET, 'show_active');
$show_trial  = filter_input(INPUT_GET, 'show_trial');

if ($show_active) {
    array_push($status_list, 'active');
}

if ($show_trial) {
    array_push($status_list, 'trial');
}

if (empty($status_list)) {
    $status_list = ['active', 'trial'];
}

foreach ($allactive_dealers as $cron_name => $dealer_data) {
    if (!empty($dealer_data['dealership'])) {
        $dealer_report                 = [];
        $dealership                    = $dealer_data['dealership'];
        $dealer_report['id']           = ++$i;
        $dealer_report['company_name'] = $dealer_data['company_name'];
        $dealer_report['websites']     = $dealer_data['websites'];
        $dealer_report['status']       = $dealer_data['status'];
        $dealer_report['scrape_time']  = gmdate("H:i:s", $dealer_data['scrapping_period']);

        if ($dealer_data['last_scrapped_at']) {
            $dealer_report['last_ran'] = date('D, d-M-Y H:i:s', $dealer_data['last_scrapped_at']);

            $diff = time() - $dealer_data['last_scrapped_at'];

            if ($diff >= 86400) {
                $days = floor($diff / 86400);
                $sec  = $diff % 86400;
                $dealer_report['ago']      = $days . " days " . gmdate("H:i:s", $sec);
            } else {
                $dealer_report['ago']      = gmdate("H:i:s", $diff);
            }
        } else {
            $dealer_report['last_ran'] = 'N/A';
            $dealer_report['ago']      = 'N/A';
        }

        if ($dealer_data['scrapping_period'] > 86400) {
            $s_d = (int)($dealer_data['scrapping_period'] / 86400);
            $s_r = $dealer_data['scrapping_period'] % 86400;
            $dealer_report['scrape_time'] = $s_d . ":" . gmdate("H:i:s", $s_r);
        }

        if (in_array($dealer_data['status'], $status_list)) {
            $scrapper_report[$dealership] = $dealer_report;
        }
    }
}

$db_connect->close_connection(DbConnect::CLOSE_READ_CONNECTION);

include 'bolts/header.php';
?>

<div class="inner-wrapper">

<?php
$select = 'scrapper-last-update';
include 'bolts/sidebar.php';
?>

    <section role="main" class="content-body">
        <header class="page-header">

        </header>
        <div class="row">
            <form id="filter-form" method="GET" class="form-horizontal form-bordered">
                <div class="col-lg-12">
                    <section class="panel panel-info panel-collapsed">
                        <header class="panel-heading">
                            <div class="panel-actions">
                                <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                            </div>
                            <h2 class="panel-title"> Last Scrapped Date According to Dealership </h2>
                        </header>

                        <div class="panel-body">
                            <div class="row mb-md">
                                <div class="col-md-3 col-sm-6">
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label"> Status </label>
                                        <div class="col-sm-9">
                                            <div class="checkbox-custom chekbox-primary">
                                                <input id="active" value="active" type="checkbox"
                                                name="show_active" <?= in_array('active', $status_list) ? 'data-current="checked" checked' : 'data-current=""'; ?>/>
                                                <label for="active"> Active </label>
                                            </div>
                                            <div class="checkbox-custom chekbox-primary">
                                                <input id="trial" value="trial" type="checkbox"
                                                        name="show_trial" <?= in_array('trial', $status_list) ? 'data-current="checked" checked' : 'data-current=""'; ?>/>
                                                <label for="trial"> Trial </label>
                                            </div>
                                        </div>
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
                            <table class="table table-bordered table-striped mb-none table-advanced" >
                                <thead>
                                    <tr>
                                        <th> # </th>
                                        <th> Dealership </th>
                                        <th> Company Name </th>
                                        <th> Websites </th>
                                        <th> Status </th>
                                        <th> Last Scrapped Date </th>
                                        <th> Time Ago </th>
                                        <th> Scrapping Duration </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($scrapper_report as $key => $value): ?>
                                        <tr>
                                            <td> <?= $value['id'] ?> </td>
                                            <td> <a href="<?= $details_page . $key ?>" target="_blank"><?= $key ?></a> </td>
                                            <td> <?= $value['company_name'] ?> </td>
                                            <td> <a href="<?= $value['websites'] ?>" target="_blank"><i><?= $value['websites'] ?></i></a></td>
                                            <td> <?= ucwords($value['status']) ?> </td>
                                            <td> <?= $value['last_ran'] ?> </td>
                                            <td> <?= $value['ago'] ?> </td>
                                            <td> <?= $value['scrape_time'] ?> </td>
                                        </tr>
                                    <?php endforeach;?>
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