<?php

global $user;
error_reporting(E_ERROR | E_PARSE);

require_once 'config.php';
require_once 'includes/loader.php';

session_start();

require_once ADSYNCPATH . 'utils.php';
require_once ADSYNCPATH . 'db_connect.php';

$dealership = $user['cron_name'];

$db_connect      = new DbConnect('');
$all_dealerships = $db_connect->get_all_dealers();

$query   = "SELECT url, engage_count, `option`, view_count FROM tbl_ab_test_wheelstv WHERE dealership = '{$dealership}';";
$fetch   = $db_connect->query($query);
$dataset = [];
$report  = [
    'On' => [
        'view_count'   => 0,
        'engage_count' => 0
    ],
    'Off' => [
        'view_count'   => 0,
        'engage_count' => 0
    ]
];

while ($row = mysqli_fetch_assoc($fetch)) {
	$dataset[$row['url']][$row['option']] = [
        'engage_count' => $row['engage_count'],
        'view_count'   => $row['view_count'],
        'ratio'        => $row['view_count'] ? round($row['engage_count']/$row['view_count']*100, 2) . '%' : null
    ];

    $report[$row['option']]['view_count']   += $row['view_count'];
    $report[$row['option']]['engage_count'] += $row['engage_count'];
}

include 'bolts/header.php';
?>

<div class="inner-wrapper">
    <?php
	$select = 'wheelstv-ab-test-report';
	include 'bolts/sidebar.php'
	?>
    <section role="main" class="content-body">
        <header class="page-header"></header>
        <div class="row">
            <div class="col-md-12">
                <section class="panel">
                    <header class="panel-heading">
                        <div class="panel-actions">
                            <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                        </div>
                        <h2 class="panel-title"> Configuration Panel </h2>
                    </header>

                    <div class="panel-body">
                        <form method="GET" class="form-inline">
                            <label class="  mb-2 mr-sm-2 mb-sm-0 ml-md" for="dealership"> Dealership </label>
                            &nbsp; &nbsp;
                            <select class="form-control mb-2 mr-sm-2 mb-sm-0 populate" name="dealership" id="dealership" data-plugin-selectTwo>
                                <?php
								if ($user['type'] == 'a') {
								    foreach ($all_dealerships as $dealer) {
								        $selected = ($dealership == $dealer['dealership']) ? ' selected' : '';
								        ?>
                                        <option value="<?=$dealer['dealership']?>" <?=$selected?>><?=$dealer['dealership']?></option>
                                    <?php
									}
								} else {
								    ?>
                                    <option value="<?=$user['cron_name']?>" <?=' selected'?>><?=$user['cron_name']?> </option>
                                <?php
								}?>
                            </select>

                            <button class="btn btn-primary ml-md"> Submit</button>
                        </form>
                    </div>
                </section>

                <section class="panel panel-info">
                    <header class="panel-heading">
                        <div class="panel-actions">
                            <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                        </div>
                        <h2 class="panel-title">WheelsTV A\B Testing Report for :: <strong><?=strtoupper($dealership)?></strong></h2>
                    </header>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered table-striped mb-none table-advanced">
                                <thead>
                                	<tr>
                                		<th rowspan="2"> # </th>
                                		<th rowspan="2"> URL </th>
                                		<th colspan="3"> Button Visible </th>
                                		<th colspan="3"> Button Removed </th>
                                	</tr>
                                    <tr>
                                        <!-- Button On -->
                                        <th> EPM Count </th>
                                        <th> View Count </th>
                                        <th> Ratio </th>

                                        <!-- Button Off -->
                                        <th> EPM Count </th>
                                        <th> View Count </th>
                                        <th> Ratio </th>
                                    </tr>
                                </thead>
                                <tbody>
                                	<?php
									$i = 1;

									foreach ($dataset as $url => $values) {
									    ?>
                                	<tr>
                                		<td> <?= $i++ ?> </td>
                                		<td><i><a target="_blank" href="<?= $url ?>"><?= $url ?></a></i></td>
                                		<td> <?= (isset($values['On']['engage_count']) ? $values['On']['engage_count'] : 0) ?> </td>
                                        <td> <?= (isset($values['On']['view_count']) ? $values['On']['view_count'] : 0) ?> </td>
                                        <td> <?= (isset($values['On']['ratio']) ? $values['On']['ratio'] : '0%') ?> </td>
                                		<td> <?= (isset($values['Off']['engage_count']) ? $values['Off']['engage_count'] : 0) ?> </td>
                                        <td> <?= (isset($values['Off']['view_count']) ? $values['Off']['view_count'] : 0) ?> </td>
                                        <td> <?= (isset($values['Off']['ratio']) ? $values['Off']['ratio'] : '0%') ?> </td>
                                	</tr>
                                	<?php
									}
									?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="2">Final Report</th>
                                        <th><?= $report['On']['engage_count'] ?></th>
                                        <th><?= $report['On']['view_count'] ?></th>
                                        <th><?= $report['On']['view_count'] ? round($report['On']['engage_count']/$report['On']['view_count']*100, 2) . '%' : '-' ?></th>
                                        <th><?= $report['Off']['engage_count'] ?></th>
                                        <th><?= $report['Off']['view_count'] ?></th>
                                        <th><?= $report['Off']['view_count'] ? round($report['Off']['engage_count']/$report['Off']['view_count']*100, 2) . '%' : '-' ?></th>
                                    </tr>
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