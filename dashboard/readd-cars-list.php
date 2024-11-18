<?php

require_once 'config.php';
require_once 'includes/loader.php';

session_start();

require_once ADSYNCPATH . 'config.php';
require_once ADSYNCPATH . 'utils.php';
require_once ADSYNCPATH . 'db_connect.php';

require_once dirname(__DIR__) . '/cartracker/car_tracker.php';

$db_connect   = new DbConnect('');
$dealer_list  = $db_connect->getCronNames();
$readded_cars = [];
$dealership   = filter_input(INPUT_GET, 'dealership');

if (!$dealership || empty($dealership)) {
    $dealership = $dealer_list[0];
}

$car_tracker  = new CarTracker();
$readded_cars = $car_tracker->generateReAddReport($dealership, $db_connect);

include 'bolts/header.php';
?>

<div class="inner-wrapper">
    <?php
    $select = 'readd-cars';
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
                            <h2 class="panel-title"> Readd Car Report </h2>
                        </header>

                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
		                                <label class="col-md-3 control-label"> Dealership </label>
		                                <div class="col-md-9">
		                                    <select data-plugin-selectTwo class="form-control populate" name="dealership" style="width: 50%">
		                                        <option value=""> -- Select -- </option>
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
                            <h2> Readded Cars <?= $dealership ? " :: " . $dealership : '' ?> </h2>
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
                                		<th> Current URL </th>
                                		<!-- <th> Previous URL </th> -->
                                		<th> Current Stock Number </th>
                                		<th> Previous Stock Number </th>
                                		<th> VIN </th>
                                		<th> Stock Type </th>
                                		<th> Year </th>
                                		<th> Make </th>
                                		<th> Model </th>
                                		<th> Readded By </th>
                                		<th> History </th>
                                	</tr>
                                </thead>
                                <tbody>
                                	<?php
                                	$i = 1;

                                	foreach ($readded_cars as $svin => $car) {
                                	?>
                                	<tr>
                                		<td> <?= $i++ ?> </td>
                                		<!-- <td> <?= $svin ?> </td> -->
                                		<td> <?= $car['current_url'] ?> </td>
                                		<!-- <td> <?= $car['previous_url'] ?> </td> -->
                                		<td> <?= $car['current_stock_number'] ?> </td>
                                		<td> <?= $car['previous_stock_number'] ?> </td>
                                		<td> <?= substr($car['current_vin'], 0, 17) ?> </td>
                                		<td> <?= $car['stock_type'] ?> </td>
                                		<td> <?= $car['year'] ?> </td>
                                		<td> <?= $car['make'] ?> </td>
                                		<td> <?= $car['model'] ?> </td>
                                		<td> <?= $car['readded_by'] ?> </td>
                                		<td> 
                                		<?php 
                                			$history = $car['add_delete_history'];
                                			foreach ($history as $key => $value) {
                                				echo date('d-M-y', $key) . " : " . $value . "<br><br>";
                                			}
                                		?> 
                                		</td>
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
