<?php

require_once 'config.php';
require_once 'includes/loader.php';
require_once 'includes/crm-defaults.php';

session_start();

require_once ADSYNCPATH . 'config.php';
require_once ADSYNCPATH . 'Google/Util.php';
require_once ADSYNCPATH . 'utils.php';
require_once ADSYNCPATH . 'db_connect.php';

global $scrapper_configs, $CronConfigs;

$csvDealers = [];
$groupNames = [];

foreach ($scrapper_configs as $cron => $sc) {
    $entry_points = isset($sc['entry_points']) ? $sc['entry_points'] : [];
    $temp         = '';

    foreach ($entry_points as $stk_type => $url) {
        if (is_array($url)) {
            continue;
        }

        if (endsWith($url, '.csv')) {
            $temp = $url;
        }
    }

    if (!empty($temp) && isset($CronConfigs[$cron])) {
        $csvDealers[$cron] = $temp;
    }
}

$dealerSet   = array_keys($csvDealers);
$joinDealers = implode("', '", $dealerSet);
$query       = "SELECT dealership, company_name, group_name, data_provider, status, websites FROM dealerships WHERE dealership IN ('$joinDealers');";
$db_connect  = new DbConnect('');
$result      = $db_connect->query($query);

while ($row = mysqli_fetch_assoc($result)) {
    $groupNames[$row['dealership']] = [
        'company_name' => $row['company_name'],
        'group_name'   => $row['group_name'],
        'data_provider'=> $row['data_provider'],
        'websites'     => $row['websites'],
        'status'       => $row['status']
    ];
}

$csvDataApi  = json_decode(HttpGet('https://tm.smedia.ca/APIs/dashboard/clientDataTime.php'), true);
$csvFileTime = $csvDataApi['files'];

include 'bolts/header.php';
?>

<div class="inner-wrapper">
    <?php
    $select = 'csv-dealers';
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
                            <a href="#" class="panel-action" data-panel-toggle></a>
                        </div>
                        <h2 class="panel-title"> CSV Dealerships </h2>
                    </header>
                </section>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <table class="table table-bordered table-striped mb-none table-advanced">
                                <thead>
                                	<tr>
                                		<th> # </th>
                                		<th> Dealership </th>
                                		<th> Company Name </th>
                                		<th> Group Name </th>
                                        <th> Inventory Provider </th>
                                		<th> Website </th>
                                		<th> Status </th>
                                		<th> CSV URL(s) </th>
                                        <th> Last Updated At </th>
                                	</tr>
                                </thead>
                                <tbody>
                                	<?php
                                	$i = 1;

                                	foreach ($csvDealers as $cron => $values) {
                                	?>
                                	<tr>
                                		<td> <?= $i++ ?> </td>
                                		<td><i><a target="_blank" href="details.php?dealership=<?= $cron ?>"><?= $cron ?></a></i></td>
                                		<td> <?= $groupNames[$cron]['company_name'] ?> </td>
                                		<td> <?= $groupNames[$cron]['group_name'] ?> </td>
                                        <td> <?= $groupNames[$cron]['data_provider'] ?> </td>
                                		<td><i><a target="_blank" href="<?= $groupNames[$cron]['websites'] ?>"><?= $groupNames[$cron]['websites'] ?></a></i></td>
                                		<td> <?= $groupNames[$cron]['status'] ?> </td>
                                		<td> <?= $values ?> </td>
                                        <td> <?= $csvFileTime[trim($values)] ?> </td>
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