<?php

    require_once 'config.php';
    require_once 'includes/loader.php';

    session_start();

    require_once ADSYNCPATH . 'config.php';
    require_once ADSYNCPATH . 'Google/Util.php';
    require_once ADSYNCPATH . 'utils.php';
    require_once ADSYNCPATH . 'boe_db_connect.php';
    require_once 'includes/button.php';
    //require_once ADSYNCPATH . 'db_connect.php';

    global $CronConfigs, $scrapper_configs; //, $connection;
    global $cron_name, $date_range, $start_date, $end_date;

    $cron_names = array_intersect(array_keys($CronConfigs), array_keys($scrapper_configs));

    $tag_state_dir = dirname(ABSPATH) . '/tag-state/';

    if (!file_exists($tag_state_dir)) 
    {
        if (!mkdir($tag_state_dir)) 
        {
            echo "\n//Unable to create tag state directory\n";
        }
    }

    if ($date_range == 'all_time') 
    {
        $start_date = "";
        $end_date = "";
    }

    $dealership_data = get_viewsdata_dealership($start_date, $end_date);
    $dealership_data_new = get_ai_button_dealership_total_data($start_date, $end_date);

    foreach($dealership_data_new as $dealership => $data) {
        if(isset($dealership_data[$dealership])) {
            $dealership_data[$dealership]['baseline_view'] = intval($dealership_data[$dealership]['baseline_view']) + intval($data['baseline_view']);
            $dealership_data[$dealership]['endline_view'] = intval($dealership_data[$dealership]['endline_view']) + intval($data['endline_view']);
            $dealership_data[$dealership]['baseline_clicks'] = intval($dealership_data[$dealership]['baseline_clicks']) + intval($data['baseline_clicks']);
            $dealership_data[$dealership]['endline_clicks'] = intval($dealership_data[$dealership]['endline_clicks']) + intval($data['endline_clicks']);
            $dealership_data[$dealership]['baseline_fillups'] = intval($dealership_data[$dealership]['baseline_fillups']) + intval($data['baseline_fillups']);
            $dealership_data[$dealership]['endline_fillups'] = intval($dealership_data[$dealership]['endline_fillups']) + intval($data['endline_fillups']);
        } else {
            $dealership_data[$dealership] = $data;
        }
    }


    include 'bolts/header.php'
?>

<div class="inner-wrapper">

    <?php
        $select = 'button-analysis';
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
                            <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                        </div>
                        <h2 class="panel-title">Button Analysis</h2>
                    </header>

                    <div class="panel-body">
                        <form method="GET" class="form-inline">
                            <label class="mb-2 mr-sm-2 mb-sm-0 ml-md" for="date_range">Date Range</label>
                            <select class="form-control mb-2 mr-sm-2 mb-sm-0" name="date_range" id="date_range">
                            <?php
                                foreach (($date_ranges = date_range_data()) as $key => $val) 
                                {
                                    $selected = $date_range == $key ? ' selected' : '';
                            ?>
                                    <option value="<?= $key ?>"<?= $selected ?>><?= $val ?></option>
                            <?php 
                                } 
                            ?>
                            </select>

                            <div class="form-group" id="custom_date_range" style="<?php if ($date_range != 'custom'): ?>display:none<?php endif; ?>">
                                <label class="mb-2 mr-sm-2 mb-sm-0 ml-md" for="start_date">Start Date</label>
                                <input class="form-control mb-2 mr-sm-2 mb-sm-0" name="start_date" id="start_date" type="date" value="<?= $start_date ?>"/>

                                <label class="mb-2 mr-sm-2 mb-sm-0 ml-md" for="end_date">End Date</label>
                                <input class="form-control mb-2 mr-sm-2 mb-sm-0" name="end_date" id="end_date" type="date" value="<?= $end_date ?>"/>
                            </div>

                            <button class="btn btn-primary ml-md">Apply Filter</button>
                        </form>
                    </div>


                    <div class="panel-body">
                        <table class="table table-bordered table-striped mb-none table-advanced">
                            <thead>
                                <tr>
                                    <th>Dealership Name</th>
                                    <th>Projected Clicks (With 100% Baseline)</th>
                                    <th>Actual Clicks</th>
                                    <th>Click Improve </th>
                                    <th>Click Improve(%) </th>
                                    <th>Projected Fill-ups (With 100% Baseline)</th>
                                    <th>Actual Fill-ups</th>      
                                    <th>Fill-ups Improve </th>
                                    <th>Fill-ups Improve(%) </th>
                                </tr>
                            </thead>
                            
                            <tbody>
                            <?php
                                foreach ($dealership_data as $button => $button_status) 
                                {
                                    if (!$button) 
                                    {
                                        continue;
                                    }

                                    $baseline_views = $button_status['baseline_view'];
                                    $total_views = $button_status['baseline_view'] + $button_status['endline_view'];
                                    $projected_clicks = floor(($button_status['baseline_clicks'] / ($baseline_views ? $baseline_views : 1)) * $total_views);
                                    $actual_clicks = $button_status['baseline_clicks'] + $button_status['endline_clicks'];
                                    $projected_fillups = floor(($button_status['baseline_fillups'] / ($baseline_views ? $baseline_views : 1)) * $total_views);
                                    $actual_fillups = $button_status['baseline_fillups'] + $button_status['endline_fillups'];

                                    $click_improve = $actual_clicks - $projected_clicks;
                                    $click_improve_percent = @round((($click_improve / ($projected_clicks ? $projected_clicks : 1)) * 100), 2);
                                    $fillups_improve = $actual_fillups - $projected_fillups;
                                    $fillups_improve_percent = @round((($fillups_improve / ($projected_fillups ? $projected_fillups : 1)) * 100), 2);

                                    $click_color = ($click_improve > 0) ? 'text-success' : (($click_improve < 0) ? 'text-danger' : '');
                                    $fillup_color = ($fillups_improve > 0) ? 'text-success' : (($fillups_improve < 0) ? 'text-danger' : '');
                            ?>
                                    <tr>
                                        <td><a href="button-details.php?dealership=<?= $button ?>"><?= $button ?></a></td>
                                        <td><?= $projected_clicks ?></td>
                                        <td><?= $actual_clicks ?></td>
                                        <td class="<?= $click_color ?>"><?= $click_improve ?></td>
                                        <td class="<?= $click_color ?>"><?= $click_improve_percent ?></td>
                                        <td><?= $projected_fillups ?></td>
                                        <td><?= $actual_fillups ?></td>
                                        <td class="<?= $fillup_color ?>"><?= $fillups_improve ?></td>
                                        <td class="<?= $fillup_color ?>"><?= $fillups_improve_percent ?></td>
                                    </tr>
                            <?php 
                                } 
                            ?>
                            </tbody>

                            <tfoot>
                                <tr>
                                    <th>Dealership Name</th>
                                    <th>Projected Clicks (With 100% Baseline)</th>
                                    <th>Actual Clicks</th>
                                    <th>Click Improve </th>
                                    <th>Click Improve(%) </th>
                                    <th>Projected Fill-ups (With 100% Baseline)</th>
                                    <th>Actual Fill-ups</th> 
                                    <th>Fill-ups Improve </th>
                                    <th>Fill-ups Improve(%) </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </section>
            </div>
        </div>
    </section>
</div>


<?php
    include 'bolts/footer.php';
?>

<script src="app/js/button-analysis.js"></script>
