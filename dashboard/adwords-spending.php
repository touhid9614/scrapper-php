<?php

ini_set('max_execution_time', 0);

require_once 'config.php';
require_once 'includes/loader.php';

session_start();

require_once ADSYNCPATH . 'config.php';
require_once ADSYNCPATH . 'db_connect.php';
require_once ADSYNCPATH . 'utils.php';

$_GET['customer'] = isset($_GET['customer']) ? $_GET['customer'] : 'marshal';

$customer 	   = $_GET['customer'];
$date          = date('Y-m-d', strtotime("-1 day"));
$current_year  = date('Y', strtotime($date));
$current_month = date('m', strtotime($date));
$yearData      = isset($_GET['year']) ? $_GET['year'] : $current_year;
$monthData     = isset($_GET['month']) ? $_GET['month'] : $current_month;

require_once ADSYNCPATH . 'Google/TokenHelper.php';
require_once ADSYNCPATH . 'Google/Types.php';
require_once ADSYNCPATH . 'Google/Util.php';
require_once ADSYNCPATH . 'Google/Consts.php';
require_once ADSYNCPATH . 'Google/Adwords.php';
require_once ADSYNCPATH . 'Google/Analytics.php';
require_once ADSYNCPATH . 'Google/SessionManager.php';

global $CronConfigs, $CurrentConfig, $developer_token;

$validYears    = ['2018', '2019', '2020', '2021'];
$validMonths   = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
$customer_list = ['marshal', 'reporting', 'googleads', 'campaignbuilder'];
$validMonthKey = [
	'01' => 'January',
	'02' => 'February',
	'03' => 'March',
	'04' => 'April',
	'05' => 'May',
	'06' => 'June',
	'07' => 'July',
	'08' => 'August',
	'09' => 'September',
	'10' => 'October',
	'11' => 'November',
	'12' => 'December'
];

$dealer_report = [];
$db_connect    = new DbConnect('');
$admins        = $db_connect->getAdmins();
$feth          = $db_connect->query("SELECT dealership, websites, assigned_to, adops, company_name, google_account_id FROM dealerships WHERE STATUS = 'active' AND google_account_id != '';");

while ($dealer = mysqli_fetch_assoc($feth)) {
    $cron_name  = $dealer['dealership'];
    $account_id = $dealer['google_account_id'];

    $dealer_report[$cron_name] = [
        'company_name'  => $dealer['company_name'],
        'websites'  	=> $dealer['websites'],
        'account_id'    => $account_id,
        'csm'           => $admins[$dealer['assigned_to']]['name'],
        'adops'         => $admins[$dealer['adops']]['name']
    ];

    $service = new AdwordsService(
        Consts::ServiceNamespace,
        $CurrentConfig,
        $developer_token,
        $account_id
    );

    $y        = $yearData;
    $m        = $monthData;
    $sdate    = $y . '-' . $m . '-01';
    $end_day  = date('t', strtotime($sdate));
    $date     = new DateTime($sdate);
    $edate    = $date->format('Y-m-t');
    $date_now = date("Y-m-d");
    $ym       = $y . $m;

    if ($date_now > $sdate) {
        $during = $y . $m . '01,' . $y . $m . $end_day;
        $report = $service->GetROIReportOverview($during);

        $total_report = count($report);
        $sum          = [
            'clicks'      => 0,
            'conversions' => 0,
            'impressions' => 0,
            'cost'        => 0,
            'cpe'         => 0,
            'total_budget'=> 0,
            'per_spent'   => 0
        ];

        for ($i = 0; $i < $total_report - 1; $i++) {
            $item = $report[$i];
            $sum['clicks'] 		+= trim(str_replace('-', '', $item['Clicks']));
            $sum['impressions'] += trim(str_replace('-', '', $item['Impressions']));
            $sum['cost'] 		+= trim(str_replace('-', '', $item['Cost'])) / 1000000;
            $sum['conversions'] += trim(str_replace('-', '', $item['Conversions']));
        }

        if ($sum['conversions']) {
        	$sum['conversions'] = round($sum['conversions'], 0);
            $sum['cpe']         = round($sum['cost'] / $sum['conversions'], 2);
        }

        if ($sum['cost']) {
        	$sum['cost'] = round($sum['cost'], 2);
        }

        if (isset($CronConfigs[$cron_name]['max_cost']) && $CronConfigs[$cron_name]['max_cost']) {
        	$sum['total_budget'] = $CronConfigs[$cron_name]['max_cost'];
        	$sum['per_spent'] 	 = round($sum['cost'] / $sum['total_budget'] * 100, 2);
        }

        $dealer_report[$cron_name] = array_merge($dealer_report[$cron_name], $sum);
    }
}

include 'bolts/header.php';
?>

<div class="inner-wrapper">
    <?php
    $select = 'ads-spending';
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
                            <h2 class="panel-title"> Adwords Spending Report </h2>
                        </header>

                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
		                                <label class="col-md-3 control-label"> Customer </label>
		                                <div class="col-md-9">
		                                    <select data-plugin-selectTwo class="form-control populate" name="customer" style="width: 50%">
		                                        <option value="">-- Select --</option>
		                                        <?php
		                                        foreach ($customer_list as $value) {
		                                        ?>
		                                            <option value="<?= $value ?>" <?= $customer == $value ? 'selected' : '' ?>><?= $value ?></option>
		                                        <?php
		                                        }
		                                        ?>
		                                    </select>
		                                </div>
		                            </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
		                                <label class="col-md-3 control-label"> Year </label>
		                                <div class="col-md-9">
		                                    <select data-plugin-selectTwo class="form-control populate" name="year" style="width: 50%">
		                                        <option value="">-- Select --</option>
		                                        <?php
		                                        foreach ($validYears as $value) {
		                                        ?>
		                                            <option value="<?= $value ?>" <?= $yearData == $value ? 'selected' : '' ?>><?= $value ?></option>
		                                        <?php
		                                        }
		                                        ?>
		                                    </select>
		                                </div>
		                            </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
		                                <label class="col-md-3 control-label"> Month </label>
		                                <div class="col-md-9">
		                                    <select data-plugin-selectTwo class="form-control populate" name="month" style="width: 50%">
		                                        <option value="">-- Select --</option>
		                                        <?php
		                                        foreach ($validMonths as $value) {
		                                        ?>
		                                            <option value="<?= $value ?>" <?= $monthData == $value ? 'selected' : '' ?>><?= $validMonthKey[$value] ?></option>
		                                        <?php
		                                        }
		                                        ?>
		                                    </select>
		                                </div>
		                            </div>
                                </div>
                            </div>

                            <div class="row">
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
                                		<th> URL </th>
                                		<th> AD OPS </th>
                                		<th> CSM </th>
                                		<th> Impressions </th>
                                		<th> Clicks </th>
                                		<th> Conversions </th>
                                		<th> CPE </th>
                                		<th> Cost </th>
                                		<th> %Spent </th>
                                        <th> Total Budget </th>
                                        <!-- <th> Dynamic Retargeting </th>
                                        <th> Dynamic Lookalike </th>
                                        <th> New Search </th>
                                        <th> Used Search </th>
                                        <th> Custom </th>
                                        <th> Youtube </th> -->
                                	</tr>
                                </thead>
                                <tbody>
                                	<?php
                                	$i = 1;

                                	foreach ($dealer_report as $cron => $data) {
                                	?>
                                	<tr>
                                		<td> <?= $i++ ?> </td>
                                		<td> <?= $cron ?> </td>
                                		<td> <?= $data['company_name'] ?> </td>
                                		<td> <?= $data['websites'] ?> </td>
                                		<td> <?= $data['adops'] ?> </td>
                                		<td> <?= $data['csm'] ?> </td>
                                		<td> <?= $data['impressions'] ?> </td>
                                		<td> <?= $data['clicks'] ?> </td>
                                		<td> <?= $data['conversions'] ?> </td>
                                		<td> <?= $data['cpe'] ?> </td>
                                		<td> <?= $data['cost'] ?> </td>
                                		<td> <?= $data['per_spent'] ?> </td>
                                		<td> <?= $data['total_budget'] ?> </td>
                                		<!-- <td> </td>
                                		<td> </td>
                                		<td> </td>
                                		<td> </td>
                                		<td> </td>
                                		<td> </td> -->
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