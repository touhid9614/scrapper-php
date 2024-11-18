<?php

require_once 'config.php';
require_once 'includes/loader.php';

session_start();

require_once ADSYNCPATH . 'config.php';
require_once ADSYNCPATH . 'utils.php';
require_once ADSYNCPATH . 'db_connect.php';

require_once dirname(__DIR__) . '/cartracker/car_tracker.php';

global $scrapper_configs, $CronConfigs;

$db_connect    = new DbConnect('');
$dealer_list   = $db_connect->getCronNames();
$sold_cars     = [];
$sold_cars_api = [];

$dealership  = filter_input(INPUT_GET, 'dealership');
$start_date  = filter_input(INPUT_GET, 'start_date');
$end_date    = filter_input(INPUT_GET, 'end_date');
$car_tracker = new CarTracker();

if (!$dealership || empty($dealership)) {
    $dealership = $dealer_list[0];
}

if (!$start_date || !$end_date) {
    $start_date = '01' . date('-M-Y', time());
    $end_date   = date('d-M-Y', time());
}

$sold_cars_api = $car_tracker->generateSaleReport($dealership, $start_date, $end_date, $db_connect);
$sold_cars     = $sold_cars_api['sold_cars'];

$all_months_data = getMonthsInRange($start_date, $end_date);

foreach ($all_months_data as $key => $value) {
    $all_months_data[$key]['data'] = $car_tracker->generateMonthlySaleCalenderReport($dealership, $value['month'], $value['year'], $db_connect);
}

// CREATE A CALENDER VIEW ON SOLD CARS
function buildCalendar($month, $year, $monthlyData = [], $dealer)
{
    // Create array containing abbreviations of days of week.
    $daysOfWeek = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thrusday', 'Friday', 'Saturday');

    // What is the first day of the month in question?
    $firstDayOfMonth = mktime(0, 0, 0, $month, 1, $year);

    // How many days does this month contain?
    $numberDays = date('t', $firstDayOfMonth);

    // Retrieve some information about the first day of the
    // month in question.
    $dateComponents = getdate($firstDayOfMonth);

    // What is the name of the month in question?
    $monthName = $dateComponents['month'];

    // What is the index value (0-6) of the first day of the
    // month in question.
    $dayOfWeek = $dateComponents['wday'];

    // Create the table tag opener and day headers
    $calendar = "<table class='calendar'>";
    $calendar .= "<caption>$monthName $year</caption>";
    $calendar .= "<tr class='weekdays'>";

    // Create the calendar headers
    foreach ($daysOfWeek as $day) {
        $calendar .= "<th scope='col'>$day</th>";
    }

    // Create the rest of the calendar
    // Initiate the day counter, starting with the 1st.
    $currentDay = 1;
    $calendar .= "</tr><tr class='days'>";

    // The variable $dayOfWeek is used to
    // ensure that the calendar
    // display consists of exactly 7 columns.
    if ($dayOfWeek > 0) {
        for ($dc = 0; $dc < $dayOfWeek; $dc++) {
            $calendar .= "<td class='day other-month'></td>";
        }
    }

    $month = str_pad($month, 2, "0", STR_PAD_LEFT);

    while ($currentDay <= $numberDays) {
        // Seventh column (Saturday) reached. Start a new row.
        if ($dayOfWeek == 7) {
            $dayOfWeek = 0;
            $calendar .= "</tr><tr>";
        }

        $currentDayRel = str_pad($currentDay, 2, "0", STR_PAD_LEFT);
        $date          = "$year-$month-$currentDayRel";
        $calendar      .= "<td class='day' rel='$date'><div class='date'>$currentDay</div>";

        // Insert calender data
        if (isset($monthlyData[$currentDay])) {
            $totalSale = $monthlyData[$currentDay]['total'];
            $newSale   = $monthlyData[$currentDay]['new'];
            $usedSale  = $monthlyData[$currentDay]['used'];

            if ((strtotime($date) + 14*86400) > time()) {
                $calendar  .= "<a target='_blank' href='sold-car-daily-view.php?dealership=$dealer&start_date=$date'><div class='event'><div class='event-desc'>Removed: $totalSale</div><div class='event-time'>New: $newSale, Used: $usedSale</div></div></a>";
            } else {
                $calendar  .= "<a target='_blank' href='sold-car-daily-view.php?dealership=$dealer&start_date=$date'><div class='event'><div class='event-desc'>Sold: $totalSale</div><div class='event-time'>New: $newSale, Used: $usedSale</div></div></a>";
            }
        }

        $calendar .= "</td>";

        // Increment counters
        $currentDay++;
        $dayOfWeek++;
    }

    // Complete the row of the last week in month, if necessary
    if ($dayOfWeek != 7) {
        $remainingDays = 7 - $dayOfWeek;

        for ($rc = 0; $rc < $remainingDays; $rc++) {
            $calendar .= "<td class='day other-month'></td>";
        }
    }

    $calendar .= "</tr>";
    $calendar .= "</table>";

    return $calendar;
}

include 'bolts/header.php';
?>

<div class="inner-wrapper">
    <?php
    $select = 'sold-cars';
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

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="mb-2 mr-sm-2 mb-sm-0 ml-md" for="start_date">Start Date</label>
                                        <input class="form-control mb-2 mr-sm-2 mb-sm-0" name="start_date" id="start_date" type="date" value="<?= $start_date ?>" data-current="<?= $start_date ?>" required="" />
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="mb-2 mr-sm-2 mb-sm-0 ml-md" for="end_date">End Date</label>
                                        <input class="form-control mb-2 mr-sm-2 mb-sm-0" name="end_date" id="end_date" type="date" value="<?= $end_date ?>" data-current="<?= $end_date ?>" required="" />
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
                                    <th colspan="2"> Number Of Removal </th>
                        			<td> <?= $sold_cars_api['no_of_sale'] ?> </td>
                        		</tr>
                                <tr>
                                    <th colspan="2"> Number Of Sale </th>
                                    <td> <?= $sold_cars_api['forteen_ago'] ?> </td>
                                </tr>
                        		<tr>
                                    <th colspan="2"> Start Date </th>
                        			<td> <?= $sold_cars_api['start_date'] ?> </td>
                        		</tr>
                        		<tr>
                                    <th colspan="2"> End Date </th>
                        			<td> <?= $sold_cars_api['end_date'] ?> </td>
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
                                    <th colspan="2"> New Removed </th>
                        			<td> <?= $sold_cars_api['new_sale'] ?> </td>
                        		</tr>
                        		<tr>
                                    <th colspan="2"> Used Removed </th>
                        			<td> <?= $sold_cars_api['used_sale'] ?> </td>
                        		</tr>
                        		<tr>
                                    <th rowspan="7"> Removal By Day </th>
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

        <!-- SHOW MONTHLY CALENDER -->
        <?php foreach ($all_months_data as $key => $value) { ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <?= buildCalendar($value['month'], $value['year'], $all_months_data[$key]['data'], $dealership); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>

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

<link rel="stylesheet" type="text/css" href="./app/css/soldCarsList.css">

<?php
    include 'bolts/footer.php';