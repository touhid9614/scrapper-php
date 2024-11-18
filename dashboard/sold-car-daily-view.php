<?php

require_once 'config.php';
require_once 'includes/loader.php';

session_start();

require_once ADSYNCPATH . 'config.php';
require_once ADSYNCPATH . 'utils.php';
require_once ADSYNCPATH . 'db_connect.php';

require_once dirname(__DIR__) . '/cartracker/car_tracker.php';

global $scrapper_configs, $CronConfigs;

$db_connect  = new DbConnect('');
$car_tracker = new CarTracker();

$dealership  = filter_input(INPUT_GET, 'dealership');
$start_date  = filter_input(INPUT_GET, 'start_date');

$dealer_list = $db_connect->getCronNames();

if (!$dealership || empty($dealership)) {
    $dealership = $dealer_list[0];
}

if (!$start_date) {
    $start_date = date('d-M-Y', time());
}

$sold_cars     = [];
$sold_cars_api = [];
$sold_cars_api = $car_tracker->getSaleReportByDay($dealership, $start_date, $db_connect);
$sold_cars     = $sold_cars_api['sold_cars'];
$readded_cars  = $car_tracker->generateReAddReport($dealership, $db_connect);

include 'bolts/header.php';
?>

<div class="inner-wrapper">
    <?php
    $select = 'daily-sold-cars';
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
                            <h2 class="panel-title"> Daily Car Removal Report </h2>
                        </header>

                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
		                                <label class="col-md-3 control-label"> Dealership </label>
		                                <div class="col-md-9">
		                                    <select data-plugin-selectTwo class="form-control populate" name="dealership" style="width: 50%">
		                                        <option value="">-- Select --</option>
		                                        <?php
		                                        foreach ($dealer_list as $value) {
		                                        ?>
		                                            <option value="<?= $value ?>" <?= $dealership == $value ? 'selected' : '' ?>><?= $value ?></option>
		                                        <?php
		                                        }
		                                        ?>
		                                    </select>
		                                </div>
		                            </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="mb-2 mr-sm-2 mb-sm-0 ml-md" for="start_date"> Date</label>
                                        <input class="form-control mb-2 mr-sm-2 mb-sm-0" name="start_date" id="start_date" type="date" value="<?= $start_date ?>" data-current="<?= $start_date ?>" required="" />
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
                            <h2> Sold Cars <?= $dealership ? " :: " . strtoupper($dealership) : '' ?> </h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
        	<div class="col-lg-12">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                        	<table id = "overview-table" class = "table table-bordered table-striped">
                        		<tr>
                                    <th colspan="2"> Number Of Sale </th>
                        			<td> <?= $sold_cars_api['no_of_sale'] ?> </td>
                        		</tr>
                        		<tr>
                                    <th colspan="2"> Removal Date </th>
                        			<td> <?= $sold_cars_api['start_date'] ?> </td>
                        		</tr>
                        		<tr>
                                    <th colspan="2"> Removal Day </th>
                        			<td> <?= date('D', $sold_cars_api['start_date']) ?> </td>
                        		</tr>
                        		<tr>
                                    <th colspan="2"> Period (In Days) </th>
                        			<td> <?= $sold_cars_api['sale_length'] ?> </td>
                        		</tr>
                        		<tr>
                                    <th colspan="2"> Average Inventory Period </th>
                        			<td> <?= $sold_cars_api['avg_inv_period'] ?> </td>
                        		</tr>
                        		<tr>
                                    <th colspan="2"> New Sale </th>
                        			<td> <?= $sold_cars_api['new_sale'] ?> </td>
                        		</tr>
                        		<tr>
                                    <th colspan="2"> Used Sale </th>
                        			<td> <?= $sold_cars_api['used_sale'] ?> </td>
                        		</tr>
                        		<tr>
                                    <th rowspan="7"> Sale By Day </th>
                                    <th> Sunday </th>
                        			<td> <?= $sold_cars_api['sale_by_day']['sun'] ?> </td>
                        		</tr>
                        		<tr>
                                    <th> Monday </th>
                        			<td> <?= $sold_cars_api['sale_by_day']['mon'] ?> </td>
                        		</tr>
                        		<tr>
                                    <th> Tuesday </th>
                        			<td> <?= $sold_cars_api['sale_by_day']['tue'] ?> </td>
                        		</tr>
                        		<tr>
                                    <th> Wednesday </th>
                        			<td> <?= $sold_cars_api['sale_by_day']['wed'] ?> </td>
                        		</tr>
                        		<tr>
                                    <th> Thrusday </th>
                        			<td> <?= $sold_cars_api['sale_by_day']['thr'] ?> </td>
                        		</tr>
                        		<tr>
                                    <th> Friday </th>
                        			<td> <?= $sold_cars_api['sale_by_day']['fri'] ?> </td>
                        		</tr>
                                <tr>
                                    <th> Saturday </th>
                                    <td> <?= $sold_cars_api['sale_by_day']['sat'] ?> </td>
                                </tr>
                        	</table>
                        </div>
                    </div>
                </div>
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
                                		<!-- <th> svin </th> -->
                                		<th> Stock Number </th>
                                		<th> VIN </th>
                                		<th> URL </th>
                                		<th> Stock Type </th>
                                		<th> Year </th>
                                		<th> Make </th>
                                		<th> Model </th>
                                		<!-- <th> Title </th> -->
                                		<th> Arrival Date </th>
                                		<th> Removal Date </th>
                                		<th> Removal Day </th>
                                		<th> Inventory Period </th>
                                        <th> 14 Days since removal </th>
                                        <th> History </th>
                                	</tr>
                                </thead>
                                <tbody>
                                	<?php
                                	$i = 1;

                                	foreach ($sold_cars as $svin => $car) {
                                	?>
                                	<tr>
                                		<td> <?= $i++ ?> </td>
                                		<!-- <td> <?= $svin ?> </td> -->
                                		<td> <?= $car['stock_number'] ?> </td>
                                		<td> <?= substr($car['vin'], 0, 17) ?> </td>
                                		<td> <i><?= $car['url'] ?></i> </td>
                                		<td> <?= $car['stock_type'] ?> </td>
                                		<td> <?= $car['year'] ?> </td>
                                		<td> <?= $car['make'] ?> </td>
                                		<td> <?= $car['model'] ?> </td>
                                		<!-- <td> <?= $car['title'] ?> </td> -->
                                		<td> <?= $car['arrival_date'] ?> </td>
                                		<td> <?= $car['sale_date'] ?> </td>
                                		<td> <?= $car['sale_day'] ?> </td>
                                		<td> <?= $car['inventory_period'] ?> </td>
                                        <td> <?= ((strtotime($car['sale_date']) + 14*86400) <= time()) ? 'Yes' : 'No' ?> </td>
                                        <td> <?php
                                        	$history = $readded_cars[$svin]['add_delete_history'];
                                			foreach ($history as $key => $value) {
                                				echo date('d-M-y', $key) . " : " . $value . "<br><br>";
                                			}

                                			if (!$history) {
                                				echo $car['arrival_date'] . " : Arrival<br><br>";
                                				echo $car['sale_date'] . " : Deleted";
                                			}
                                        ?> </td>
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