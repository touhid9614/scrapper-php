<?php

	require_once 'config.php';
	require_once 'includes/loader.php';

	session_start();

	require_once ADSYNCPATH . 'config.php';
	require_once ADSYNCPATH . 'Google/Util.php';
	require_once ADSYNCPATH . 'utils.php';
	require_once ADSYNCPATH . 'db_connect.php';

	/* DATA */
	$db_connect 	= new DbConnect('');
	$minDateQuery 	= $db_connect->query("SELECT MIN(`DAY`) AS minday FROM engaged_vdp;");
	$minDateResult 	= mysqli_fetch_assoc($minDateQuery);
	$minDate 		= $minDateResult['minday'];
	$minYear 		= (int)(substr($minDate, 0, 4));
	$minMonth 		= substr($minDate, 5, 2);
	$minDay 		= substr($minDate, 8, 2);
	$maxYear 		= (int)(date("Y"));
	$years 			= range($minYear, $maxYear);
	$EPM 			= [];
	$total 			= 0;

	if ($_SERVER['REQUEST_METHOD'] === 'POST')
	{
		$month     = filter_input(INPUT_POST, 'month');
        $year      = (int)(filter_input(INPUT_POST, 'year'));
        $status    = filter_input(INPUT_POST, 'status');

    	$mapMonth =
    	[
    		'Jan' => ['monthCode' => '01', 'monthEnd' => '31'],
    		'Feb' => ['monthCode' => '02', 'monthEnd' => '28'],
    		'Mar' => ['monthCode' => '03', 'monthEnd' => '31'],
    		'Apr' => ['monthCode' => '04', 'monthEnd' => '30'],
    		'May' => ['monthCode' => '05', 'monthEnd' => '31'],
    		'Jun' => ['monthCode' => '06', 'monthEnd' => '30'],
    		'Jul' => ['monthCode' => '07', 'monthEnd' => '31'],
    		'Aug' => ['monthCode' => '08', 'monthEnd' => '31'],
    		'Sep' => ['monthCode' => '09', 'monthEnd' => '30'],
    		'Oct' => ['monthCode' => '10', 'monthEnd' => '31'],
    		'Nov' => ['monthCode' => '11', 'monthEnd' => '30'],
    		'Dec' => ['monthCode' => '12', 'monthEnd' => '31']
    	];

    	if (checkdate('02', '29', $year))
    	{
    		$mapMonth['Feb']['monthEnd'] = '29';
    	}

    	$startDate 	= $year . '-' . $mapMonth[$month]['monthCode'] . '-01';
    	$endDate 	= $year . '-' . $mapMonth[$month]['monthCode'] . '-' . $mapMonth[$month]['monthEnd'];

    	$query = "SELECT dealership, SUM(COUNT) AS total FROM engaged_vdp WHERE (`day` BETWEEN '{$startDate}' AND '{$endDate}') GROUP BY dealership ORDER BY dealership;";
    	$epmFetch = $db_connect->query($query);

    	while($row = mysqli_fetch_assoc($epmFetch))
    	{
    		$EPM[$row['dealership']] = ['total' => $row['total']];
    		$total += $row['total'];
    	}

    	$fetchStatus = $db_connect->query("SELECT dealership, company_name, status, websites FROM dealerships ORDER BY dealership;");

    	while ($rowe = mysqli_fetch_assoc($fetchStatus))
    	{
    		if (isset($EPM[$rowe['dealership']]))
    		{
                if ($status == 'all')
                {
                    $EPM[$rowe['dealership']]['status']         = $rowe['status'];
                    $EPM[$rowe['dealership']]['company_name']   = $rowe['company_name'];
                    $EPM[$rowe['dealership']]['url']            = $rowe['websites'];

                }
                elseif (strtolower($rowe['status']) == strtolower($status))
                {
                    $EPM[$rowe['dealership']]['status']         = $rowe['status'];
                    $EPM[$rowe['dealership']]['company_name']   = $rowe['company_name'];
                    $EPM[$rowe['dealership']]['url']            = $rowe['websites'];
                }
                else
                {
                    unset($EPM[$rowe['dealership']]);
                }
    		}
    	}

    	// echo("<script type='text/javascript'> location.href = location.href; </script>");
	}

    include 'bolts/header.php';
?>

<div class="inner-wrapper">
    <?php
    $select = 'epm-monthly';
    include 'bolts/sidebar.php';
    ?>

    <section role="main" class="content-body">
        <header class="page-header">

        </header>

        <div class="row">
            <form id="filter-form" method="POST" class="form-horizontal form-bordered">
                <div class="col-lg-12">
                    <section class="panel panel-info">
                        <header class="panel-heading">
                            <div class="panel-actions">
                                <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                            </div>
                            <h2 class="panel-title"> Filters </h2>
                        </header>

                        <div class="panel-body">
                            <div class="row mb-md">
                                <div class="col-md-4 col-sm-4">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label"> Month </label>
                                        <div class="col-sm-8">
                                            <select class="form-control" name="month">
                                                <option value=""> -Select Month- </option>
                                                <option value="Jan" <?= $month == 'Jan' ? 'selected=""' : '' ?>> January </option>
                                                <option value="Feb" <?= $month == 'Feb' ? 'selected=""' : '' ?>> February </option>
                                                <option value="Mar" <?= $month == 'Mar' ? 'selected=""' : '' ?>> March </option>
                                                <option value="Apr" <?= $month == 'Apr' ? 'selected=""' : '' ?>> April </option>
                                                <option value="May" <?= $month == 'May' ? 'selected=""' : '' ?>> May </option>
                                                <option value="Jun" <?= $month == 'Jun' ? 'selected=""' : '' ?>> June </option>
                                                <option value="Jul" <?= $month == 'Jul' ? 'selected=""' : '' ?>> July </option>
                                                <option value="Aug" <?= $month == 'Aug' ? 'selected=""' : '' ?>> August </option>
                                                <option value="Sep" <?= $month == 'Sep' ? 'selected=""' : '' ?>> September </option>
                                                <option value="Oct" <?= $month == 'Oct' ? 'selected=""' : '' ?>> October </option>
                                                <option value="Nov" <?= $month == 'Nov' ? 'selected=""' : '' ?>> November </option>
                                                <option value="Dec" <?= $month == 'Dec' ? 'selected=""' : '' ?>> December </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-4">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label"> Year </label>
                                        <div class="col-sm-8">
                                            <select class="form-control" name="year">
                                                <option value=""> -Select Year- </option>
                                                <?php
                                                foreach ($years as $cur_year)
                                                {
                                                ?>
                                                    <option value='<?= $cur_year ?>' <?= $year == $cur_year ? 'selected=""' : '' ?>> <?= $cur_year ?>
                                                    </option>
                                                <?php
                                            	}
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-4">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label"> Current Status </label>
                                        <div class="col-sm-8">
                                            <select class="form-control" name="status" data-plugin-multiselect data-plugin-options='{ "maxHeight": 300 }'>
                                                <option value="all" <?= $status =='all' ? 'selected' : '' ?>> All </option>
                                                <option value="active" <?= $status == 'active' ? 'selected' : '' ?>> Active </option>
                                                <option value="trial" <?= $status == 'trial' ? 'selected' : '' ?>> Trial </option>
                                                <option value="trial-setup" <?= $status == 'trial-setup' ? 'selected' : '' ?>> Trial Setup </option>
                                                <option value="inactive" <?= $status == 'inactive' ? 'selected' : '' ?>> Inactive </option>
                                                <option value="unsure" <?= $status == 'unsure' ? 'selected' : '' ?>> Unsure </option>
                                                <option value="free" <?= $status == 'free' ? 'selected' : '' ?>> Free </option>
                                            </select>
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
                                            <a href="epm-monthly.php" class="btn btn-default pull-right">Clear</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </form>

            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        <div class="panel-actions">

                        </div>
                        <h2 class="panel-title" style="text-align: center;"> Monthly Engagement </h2>
                    </header>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-12 conflict-table">
                                <table class="table table-bordered table-striped mb-none table-advanced">
                                    <thead>
                                        <tr>
                                        	<th> Dealership Name </th>
                                            <th> Company Name </th>
                                            <th> Website URL </th>
                                            <th> Current Status </th>
                                            <th> Total Engagement </th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        foreach ($EPM as $dealer => $data)
                                        {
                                        ?>
                                            <tr>
                                                <td> <?= $dealer ?> </td>
                                                <td> <?= ucwords($data['company_name']) ?> </td>
                                                <td>
                                                    <a href="<?= $data['url'] ?>" target="_blank">
                                                        <i><?= $data['url'] ?></i>
                                                    </a>
                                                </td>
                                                <td> <?= ucwords($data['status']) ?> </td>
                                                <td> <strong><?= $data['total'] ?></strong> </td>
                                            </tr>
                                        <?php
                                    	}
                                    	?>
                                    </tbody>

                                    <tfoot>
                                        <th colspan="3"> </th>
                                        <th style="text-align: center;"> Total </th>
                                        <th style="text-align: center;"> <?= $total ?> </th>
                                    </tfoot>
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