<?php

global $cron_name, $date_range, $start_date, $end_date, $single_config, $CronConfigs;
if (isset($_GET['dealership']) && !empty($_GET['dealership'])) {
    $single_config = $_GET['dealership'];
}

require_once 'config.php';
require_once 'includes/loader.php';

session_start();

require_once ADSYNCPATH . 'config.php';
require_once ADSYNCPATH . 'Google/Util.php';
require_once ADSYNCPATH . 'utils.php';
require_once ADSYNCPATH . 'db_connect.php';
require_once ADSYNCPATH . 'boe_db_connect.php';
require_once 'includes/button.php';

require_once 'includes/email_verification.php';

$total_result_data_raw = boedb_get_options_data($cron_name, $date_range, $start_date, $end_date);
$status = boedb_bs_get_status($cron_name);
$buttons = boedb_tbcs_get_ui_report($cron_name, '', $date_range, $start_date, $end_date);
$page_data = boedb_tbcs_get_page_data($cron_name, '', $date_range, $start_date, $end_date);

$total_result_data = [];

if (!$total_result_data_raw) {
    $total_result_data_raw = [];
}

foreach ($total_result_data_raw as $result_data) {
    $result_data['option1'] = strip_tags($result_data['option1']);
    $key = "{$result_data['option_group']}_{$result_data['option1']}_{$result_data['stock_type']}";

    if (isset($total_result_data[$key])) {
        $total_result_data[$key]['total_viewed'] += $result_data['total_viewed'];
        $total_result_data[$key]['total_clicked'] += $result_data['total_clicked'];
        $total_result_data[$key]['total_form_viewed'] += $result_data['total_form_viewed'];
        $total_result_data[$key]['total_fillup'] += $result_data['total_fillup'];
    } else {
        $total_result_data[$key] = $result_data;
    }
}

//For chart prepare data
list($baselineViewedVdp, $endlineViewedVdp, $baselineCR1Vdp, $endlineCR1Vdp, $baselineCR2Vdp, $endlineCR2Vdp) = boedb_get_chartdata($start_date, $end_date, $date_range, 'vdp', $cron_name);
list($baselineViewedSip, $endlineViewedSip, $baselineCR1Sip, $endlineCR1Sip, $baselineCR2Sip, $endlineCR2Sip) = boedb_get_chartdata($start_date, $end_date, $date_range, 'srp', $cron_name);

d($baselineViewedVdp, 'baseline before');

$chartLabel = array();
// for ($i = 0; $i < sizeof($baselineCR1Vdp); $i++) {
//     $chartLabel[$i] = (string) $baselineCR1Vdp[$i]['label'];
// }

foreach($baselineCR1Vdp as $i => $val) {
     $chartLabel[] = (string) $baselineCR1Vdp[$i]['label'];
}

if( isset($CronConfigs[$cron_name]) && isset($CronConfigs[$cron_name]['button_algorithm']) ){

    $results = get_ai_button_daily_total_data($cron_name, $start_date, $end_date);

    $all_data = [];

    $cur_date = $start_date;
    $stop_date = date('Y-m-d', strtotime($end_date . ' +1 day'));
    // $chartLabel = [];
    // $baselineViewedVdp = [];
    // $baselineCR1Vdp = [];
    // $baselineCR2Vdp = [];
    // $endlineViewedVdp = [];
    // $endlineCR1Vdp = [];
    // $endlineCR2Vdp = [];

    // $baselineViewedSip = [];
    // $baselineCR1Sip = [];
    // $baselineCR2Sip = [];
    // $endlineViewedSip = [];
    // $endlineCR1Sip = [];
    // $endlineCR2Sip = [];

    while($cur_date != $stop_date) {
        $chartLabel[] = date('m-d', strtotime($cur_date));
        if(!isset($baselineViewedVdp[$cur_date])) {
            $baselineViewedVdp[$cur_date] = ['y' => 0];
            $baselineCR1Vdp[$cur_date] = ['y' => 0];
            $baselineCR2Vdp[$cur_date] = ['y' => 0];
            $endlineViewedVdp[$cur_date] = ['y' => 0];
            $endlineCR1Vdp[$cur_date] = ['y' => 0];
            $endlineCR2Vdp[$cur_date] = ['y' => 0];

            $baselineViewedSip[$cur_date] = ['y' => 0];
            $baselineCR1Sip[$cur_date] = ['y' => 0];
            $baselineCR2Sip[$cur_date] = ['y' => 0];
            $endlineViewedSip[$cur_date] = ['y' => 0];
            $endlineCR1Sip[$cur_date] = ['y' => 0];
            $endlineCR2Sip[$cur_date] = ['y' => 0];
        }
        $cur_date = date('Y-m-d', strtotime($cur_date . ' +1 day'));
    }


    foreach($results as $result) {
        $result->s_view = intval($result->s_view);
        $result->s_click = intval($result->s_click);
        $result->s_fil_up = intval($result->s_fil_up);

        if($result->listing_type == 'srp'){
            if($result->line_type == 'baseline'){
                $baselineViewedSip[$result->date]['y'] = $result->s_view;
                $baselineCR1Sip[$result->date]['y'] = number_format( $result->s_click / $result->s_view, 5 ) * 100;
                if($result->s_click)
                    $baselineCR2Sip[$result->date]['y'] = number_format( $result->s_fill_up / $result->s_click, 5 ) * 100;
            }else{
                $endlineViewedSip[$result->date]['y'] = $result->s_view;
                $endlineCR1Sip[$result->date]['y'] = number_format( $result->s_click / $result->s_view, 5 ) * 100;
                if($result->s_click)
                    $endlineCR2Sip[$result->date]['y'] = number_format( $result->s_fill_up / $result->s_click, 5 ) * 100;
            }
        } else {
            if($result->line_type == 'baseline'){
                $baselineViewedVdp[$result->date]['y'] = $result->s_view;
                $baselineCR1Vdp[$result->date]['y'] = number_format( $result->s_click / $result->s_view, 5 ) * 100;
                if($result->s_click)
                    $baselineCR2Vdp[$result->date]['y'] = number_format( $result->s_fill_up / $result->s_click, 5 ) * 100;
            }else{
                $endlineViewedVdp[$result->date]['y'] = $result->s_view;
                $endlineCR1Vdp[$result->date]['y'] = number_format( $result->s_click / $result->s_view, 5 ) * 100;
                if($result->s_click)
                    $endlineCR2Vdp[$result->date]['y'] = number_format( $result->s_fill_up / $result->s_click, 5 ) * 100;
            }
        }
    }

    //d($baselineViewedVdp, 'baseline after');

    $baselineViewedVdp = array_values($baselineViewedVdp);
    $baselineCR1Vdp = array_values($baselineCR1Vdp);
    $baselineCR2Vdp = array_values($baselineCR2Vdp);
    $endlineViewedVdp = array_values($endlineViewedVdp);
    $endlineCR1Vdp = array_values($endlineCR1Vdp);
    $endlineCR2Vdp = array_values($endlineCR2Vdp);

    $baselineViewedSip = array_values($baselineViewedSip);
    $baselineCR1Sip = array_values($baselineCR1Sip);
    $baselineCR2Sip = array_values($baselineCR2Sip);
    $endlineViewedSip = array_values($endlineViewedSip);
    $endlineCR1Sip = array_values($endlineCR1Sip);
    $endlineCR2Sip = array_values($endlineCR2Sip);

    //d($baselineViewedVdp, 'baseline after value only');


    $results = get_ai_button_option_data($cron_name, $start_date, $end_date);
    // $total_result_data = [];

    foreach($results as $result) {
        $option = [];
        list($options['location'], $options['size'], $options['style'], $options["text_{$result->t_button_type}"]) = explode('][', trim($result->combination, '[]'));

        foreach($options as $option_group => $option1) {
            $option1 = strip_tags($option1);
            $key = "{$option_group}_{$option1}_{$result->stock_type}";
            if (isset($total_result_data[$key])) {
                $total_result_data[$key]['total_viewed'] += floatval($result->total_view);
                $total_result_data[$key]['total_clicked'] += floatval($result->total_click);
                $total_result_data[$key]['total_form_viewed'] += floatval($result->total_click);
                $total_result_data[$key]['total_fillup'] += floatval($result->total_fill_up);
            } else {
                $total_result_data[$key]['total_viewed'] = floatval($result->total_view);
                $total_result_data[$key]['total_clicked'] = floatval($result->total_click);
                $total_result_data[$key]['total_form_viewed'] = floatval($result->total_click);
                $total_result_data[$key]['total_fillup'] = floatval($result->total_fill_up);
                $total_result_data[$key]['stock_type'] = $result->stock_type;
                $total_result_data[$key]['option1'] = $option1;
                $total_result_data[$key]['option_group'] = $option_group;
            }
        }

    }

    $button_totals = get_ai_button_type_total_data($cron_name, $start_date, $end_date);
    // $buttons = [];
    foreach($button_totals as $button_total) {
        if(!isset($buttons[$button_total->button_type])){
            $buttons[$button_total->button_type] = [];
        } 

        $button_total->view = floatval($button_total->view);
        $button_total->click = floatval($button_total->click);
        $button_total->fill_up = floatval($button_total->fill_up);

        $old_view = $buttons[$button_total->button_type]['baseline_view'];
        $old_click = $buttons[$button_total->button_type]['baseline_click'];
        $old_fillups = $buttons[$button_total->button_type]['baseline_fillups'];

        $new_view = $button_total->view + $old_view;
        $new_click = $button_total->click + $old_click;
        $new_fillups = $button_total->fill_up + $old_fillups;

        $cr = $button_total->view ? round($button_total->click / ($button_total->view ? $button_total->view : 1), 4) * 100 : 0.00;

        if($button_total->line_type == 'baseline') {
            $buttons[$button_total->button_type]['baseline'] = $cr;
            $buttons[$button_total->button_type]['baseline_view'] = $new_view;
            $buttons[$button_total->button_type]['baseline_clicks'] = $new_click;
            $buttons[$button_total->button_type]['baseline_fillups'] = $new_fillups;
            $buttons[$button_total->button_type]['baseline_cr1'] = round($new_click*100/$new_view, 4);
            $buttons[$button_total->button_type]['baseline_cr2'] = round($new_fillups*100/$new_click, 4);
        } else {
            $buttons[$button_total->button_type]['endline'] = $cr;
            $buttons[$button_total->button_type]['endline_view'] = $new_view;
            $buttons[$button_total->button_type]['endline_clicks'] = $new_click;
            $buttons[$button_total->button_type]['endline_fillups'] = $new_fillups;
            $buttons[$button_total->button_type]['endline_cr1'] = round($new_click*100/$new_view, 4);
            $buttons[$button_total->button_type]['endline_cr2'] = round($new_fillups*100/$new_click, 4);
        }

    }

    $results = get_ai_button_daily_total_data($cron_name, $start_date, $end_date, ' line_type, listing_type ');

    if(!isset($page_data)) $page_data = [];
    if(!isset($page_data['vdp'])) $page_data['vdp'] = [];
    if(!isset($page_data['srp'])) $page_data['srp'] = [];


    foreach($results as $result) {

        if (isset($page_data[$result->listing_type][$result->line_type]['view'])) {
            $old_view = $page_data[$result->listing_type][$result->line_type]['view'];
            $old_click = $page_data[$result->listing_type][$result->line_type]['click'] * $old_view;
            $old_fillup = $page_data[$result->listing_type][$result->line_type]['fillup'] * $old_view;
        } else {
            $old_view = 0;
            $old_click = 0;
            $old_fillup = 0;
        }

        $new_view = $old_view + floatval($result->s_view);
        $new_click = round(100*($old_click + floatval($result->s_click))/$new_view);
        $new_fillup = round(100*($old_fillup + floatval($result->s_fill_up))/$new_view);

        $page_data[$result->listing_type][$result->line_type] = [
            'view' => $new_view,
            'click' => $new_click,
            'fillup' => $new_fillup,
        ];
    }
}

$chartLabel = json_encode($chartLabel);
DbConnect::close_connection();


$baselineCR1VdpData = json_encode(getOnlyYValue($baselineCR1Vdp));
$endlineCR1VdpData = json_encode(getOnlyYValue($endlineCR1Vdp));
$baselineCR2VdpData = json_encode(getOnlyYValue($baselineCR2Vdp));
$endlineCR2VdpData = json_encode(getOnlyYValue($endlineCR2Vdp));
$baselineViewedVdpData = json_encode(getOnlyYValue($baselineViewedVdp));
$endlineViewedVdpData = json_encode(getOnlyYValue($endlineViewedVdp));


$baselineCR1SipData = json_encode(getOnlyYValue($baselineCR1Sip));
$endlineCR1SipData = json_encode(getOnlyYValue($endlineCR1Sip));
$baselineCR2SipData = json_encode(getOnlyYValue($baselineCR2Sip));
$endlineCR2SipData = json_encode(getOnlyYValue($endlineCR2Sip));
$baselineViewedSipData = json_encode(getOnlyYValue($baselineViewedSip));
$endlineViewedSipData = json_encode(getOnlyYValue($endlineViewedSip));

function getOnlyYValue($listData) {
    $dataArr = array();
    // for ($i = 0; $i < sizeof($listData); $i++) {
    foreach($listData as $i => $val){
        // $dataArr[$i] = isset($listData[$i]['y']) ? floatval($listData[$i]['y']) : 0.00;
        $dataArr[] = isset($val['y']) ? floatval($val['y']) : 0.00;
    }
    return $dataArr;
}

$cron_config = $CronConfigs[$cron_name];
$button_configured = isset($cron_config['buttons']);
$form_configured = false;

foreach ($cron_config['buttons'] as $button_config) 
{
    $form_configured |= isset($button_config['button_action']);
}

include 'bolts/header.php';
?>

<div class="inner-wrapper">

    <?php
    $select = 'button-details';
    include 'bolts/sidebar.php'
    ?>

    <section role="main" class="content-body">
        <header class="page-header">

        </header>
        <div class="row">
            <div class="col-lg-12">

                <?php if (filter_input(INPUT_GET, 'dealership') != $cron_name) { ?>
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">�</button>
                        <strong><?= filter_input(INPUT_GET, 'dealership') ?></strong> is either Inactive or doesn't have Buttons configured.
                    </div>
                <?php } ?>

                <section class="panel panel-info">
                    <header class="panel-heading">
                        <div class="panel-actions">
                            <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                        </div>
                        <h2 class="panel-title">Details for :: <?= $cron_name ?></h2>
                    </header>
                    <div class="panel-body">
                        <form method="GET" class="form-inline">
                            <?php if ($user['type'] == 'a') { ?>
                            <label class="mb-2 mr-sm-2 mb-sm-0 ml-md" for="dealership">Dealership</label>
                            <select class="form-control populate mb-2 mr-sm-2 mb-sm-0" name="dealership" id="dealership" data-plugin-selectTwo>
                                <?php foreach ($cron_names as $c_name => $company) {
                                        $selected = $cron_name == $c_name ? ' selected' : '';
                                        ?>
                                        <option value="<?= $c_name ?>"<?= $selected ?>><?= $company ?></option>
                                        <?php
                                    } ?>
                            </select>
                            <?php } else { ?>
                            <input name="dealership" value="<?= $user['cron_name'] ?>" type="hidden"/>
                            <?php } ?>
                            <label class="mb-2 mr-sm-2 mb-sm-0 ml-md" for="date_range">Date Range</label>
                            <select class="form-control mb-2 mr-sm-2 mb-sm-0" name="date_range" id="date_range">
                                <?php
                                foreach (($date_ranges = date_range_data()) as $key => $val) {
                                    $selected = $date_range == $key ? ' selected' : '';
                                    ?>
                                    <option value="<?= $key ?>"<?= $selected ?>><?= $val ?></option>
                                <?php } ?>
                            </select>

                            <div class="form-group" id="custom_date_range" style="<?php if ($date_range != 'custom'): ?>display:none<?php endif; ?>">
                                <label class="mb-2 mr-sm-2 mb-sm-0 ml-md" for="start_date">Start Date</label>
                                <input class="form-control mb-2 mr-sm-2 mb-sm-0" name="start_date" id="start_date" type="date" value="<?= $start_date ?>" required=""/>

                                <label class="mb-2 mr-sm-2 mb-sm-0 ml-md" for="end_date">End Date</label>
                                <input class="form-control mb-2 mr-sm-2 mb-sm-0" name="end_date" id="end_date" type="date" value="<?= $end_date ?>" required=""/>
                            </div>

                            <button class="btn btn-primary ml-md"> Apply Filter </button>
                            <a href="../adwords3/caches/button-details.xlsx" class="btn btn-primary ml-md" download="<?= $cron_name ?>.xlsx"> Export </a>
                        </form>
                    </div>
                </section>
            </div>
            <div class="col-lg-12">
                <!-- Button Status Tabs -->
                <div class="tabs tabs-primary tabs-panel">
                    <ul class="nav nav-tabs">
                        <li class="nav-item active">
                            <a class="nav-link" href="#charts" data-toggle="tab">Charts</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#options" data-toggle="tab">Options</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#buttons" data-toggle="tab">Buttons</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#pageviews" data-toggle="tab">Pages</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#analysis" data-toggle="tab">Analysis</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#optimization" data-toggle="tab">Optimization</a>
                        </li>
                        <?php if ($button_configured): ?>
                            <li>
                                <a href="#aibuttons" data-toggle="tab" class="nav-link">AI Buttons</a>
                            </li>
                        <?php endif ?>
                    </ul>

                    <div class="tab-content clearfix">
                        <div id="charts" class="tab-pane active">

                            <div class="row">
                                <div class="col-lg-6">
                                    <div id="details-chart-vdpviewed">   </div>
                                </div>  
                                <div class="col-lg-6">
                                    <div id="details-chart-sipviewed">   </div>
                                </div> 
                            </div>

                            <div class="row" style="margin-top: 10px">
                                <div class="col-lg-6">
                                    <div id="details-chart-vdpcr1">   </div>
                                </div>
                                <div class="col-lg-6">
                                    <div id="details-chart-sipcr1">   </div>
                                </div>
                            </div>

                            <div class="row" style="margin-top: 10px">
                                <div class="col-lg-6">
                                    <div id="details-chart-vdpcr2">   </div>
                                </div>    
                                <div class="col-lg-6">
                                    <div id="details-chart-sipcr2">   </div>
                                </div>    
                            </div>
                        </div>

                        <div id="options" class="tab-pane">
                            <table class="table table-bordered table-striped mb-none table-advanced">
                                <thead>
                                    <tr>
                                        <th>Button option</th>
                                        <th>Option Group</th>
                                        <th>Stock Type</th>
                                        <th>Viewed Count</th>
                                        <th>Clicked Count</th>
                                        <th>Fillup Count</th>
                                        <th>CR (clicked) %</th>
                                        <th>CR (fillup) %</th>
                                    </tr>
                                </thead>
                                <?php
                                $opt_data = array();
                                $total_views = 0;
                                $total_clicks = 0;
                                $total_fillups = 0;

                                if (count($total_result_data) > 0) {
                                    foreach ($total_result_data as $item) {
                                        if (is_numeric($item['option1'])) {  //as we don't have group now, it's a hack to count only size group
                                            $total_views += $item['total_viewed'];
                                            $total_clicks += $item['total_clicked'];
                                            $total_fillups += $item['total_fillup'];
                                        }
                                        if ($item['total_viewed'] > 0) {
                                            $cr1 = round($item['total_clicked'] / $item['total_viewed'], 4) * 100;
                                            $cr2 = $item['total_form_viewed'] ? round($item['total_fillup'] / $item['total_form_viewed'], 4) * 100 : 0;
                                            $score = (1.0 * $item['total_clicked'] + 2.0 * $item['total_fillup']) / $item['total_viewed'];
                                        } else {
                                            $cr1 = 0;
                                            $cr2 = 0;
                                            $score = 0;
                                        }
                                        echo "<tr>";
                                        echo "    <td>{$item['option1']}</td>";
                                        echo "    <td>{$item['option_group']}</td>";
                                        echo "    <td>{$item['stock_type']}</td>";
                                        echo "    <td>{$item['total_viewed']}</td>";
                                        echo "    <td>{$item['total_clicked']}</td>";
                                        echo "    <td>{$item['total_fillup']}</td>";
                                        echo "    <td>" . number_format($cr1, 2) . "</td>";
                                        echo "    <td>" . number_format($cr2, 2) . "</td>";
                                        echo "</tr>";

                                        if (array_key_exists($item['option_group'], $opt_data)) {
                                            $opt_item = $opt_data[$item['option_group']];
                                            if (
                                                    ($opt_item['score'] < $score) || ($opt_item['score'] == $score && $opt_item['viewed'] < $item['total_viewed'])
                                            ) {
                                                $opt_data[$item['option_group']] = array(
                                                    'option' => $item['option1'],
                                                    'score' => $score,
                                                    'viewed' => $item['total_viewed'],
                                                    'clicked' => $item['total_clicked'],
                                                    'fillup' => $item['total_fillup']
                                                );
                                            }
                                        } else {
                                            $opt_item = array(
                                                'option' => $item['option1'],
                                                'score' => $score,
                                                'viewed' => $item['total_viewed'],
                                                'clicked' => $item['total_clicked'],
                                                'fillup' => $item['total_fillup']
                                            );
                                            $opt_data[$item['option_group']] = $opt_item;
                                        }
                                    }
                                } else {
                                    echo "<tr><td colspan='7' style='text-align: center;color: green;'>No data</td></tr>";
                                }

                                if ($total_views == 0) {
                                    $total_cr1 = round(0, 4) * 100;
                                    $total_cr2 = round(0, 4) * 100;
                                } else {
                                    $total_cr1 = round($total_clicks / $total_views, 4) * 100;
                                    $total_cr2 = round($total_fillups / $total_views, 4) * 100;
                                }
                                ?>
                            </table>
                        </div>

                        <div id="buttons" class="tab-pane">
                            <div class="row mb-md">
                                <?php
                                $button_count = 0;
                                foreach ($buttons as $button => $button_status) {
                                    if (!$button) {
                                        continue;
                                    }
                                    $button_count++;
                                    if ($button_count > 2) {
                                        ?>
                                    </div>
                                    <div class="row mb-md">
                                        <?php
                                        $button_count = 1;
                                    }
                                    ?>
                                    <div class="col-md-6">
                                        <div class="card bg-tertiary" style="padding: 10px;">
                                            <div class="card-content">
                                                <h3>Button (<?php echo $button ?>)</h3>
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <th>Combination</th>
                                                        <th>Views</th>
                                                        <th>CR (click) %</th>
                                                        <th>CR (fillup) %</th>
                                                    </tr>
                                                    <tr>
                                                        <th>Baseline</th>
                                                        <td><?php echo isset($button_status['baseline_view']) ? $button_status['baseline_view'] : '0' ?></td>
                                                        <td><?php echo isset($button_status['baseline_cr1']) ? $button_status['baseline_cr1'] : '0.00' ?></td>
                                                        <td><?php echo isset($button_status['baseline_cr2']) ? $button_status['baseline_cr2'] : '0.00' ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Endline</th>
                                                        <!--<td><?php //echo isset($total_views)? $total_views : '0'                                                                       ?></td>-->
                                                        <!--<td><?php //echo isset($total_cr1)? number_format($total_cr1, 2) : '0.00'                                                                       ?></td>-->
                                                        <td><?php echo isset($button_status['endline_view']) ? $button_status['endline_view'] : '0' ?></td>
                                                        <td><?php echo isset($button_status['endline_cr1']) ? $button_status['endline_cr1'] : '0.00' ?></td>
                                                        <td><?php echo isset($button_status['endline_cr2']) ? $button_status['endline_cr2'] : '0.00' ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Improvement</th>
                                                        <td></td>
                                                        <?php
                                                        $baseline_cr1 = isset($button_status['baseline_cr1']) ? $button_status['baseline_cr1'] : 0.00;
                                                        $baseline_cr2 = isset($button_status['baseline_cr2']) ? $button_status['baseline_cr2'] : 0.00;
                                                        $endline_cr1 = isset($button_status['endline_cr1']) ? $button_status['endline_cr1'] : 0.00;
                                                        $endline_cr2 = isset($button_status['endline_cr2']) ? $button_status['endline_cr2'] : 0.00;
                                                        ?>
                                                        <td><?php echo number_format($endline_cr1 - $baseline_cr1, 2) ?></td>
                                                        <td><?php echo number_format($endline_cr2 - $baseline_cr2, 2) ?></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>

                            </div>
                        </div>

                        <div id="pageviews" class="tab-pane">
                            <table class="table table-bordered table-striped mb-none table-advanced">
                                <tr>
                                    <th>Page Type</th>
                                    <th>Conversion Type</th>
                                    <th>Page View</th>
                                    <th>Click CR</th>
                                    <th>Fill-up CR</th>
                                </tr>
                                <?php
                                if (count($page_data) > 0) {
                                    // VDP
                                    echo "<tr>";
                                    echo "    <td>VDP</td>";
                                    echo "    <td>Baseline</td>";
                                    echo "    <td>" . $page_data['vdp']['baseline']['view'] . "</td>";
                                    echo "    <td>" . $page_data['vdp']['baseline']['click'] . "</td>";
                                    echo "    <td>" . $page_data['vdp']['baseline']['fillup'] . "</td>";
                                    echo "</tr>";

                                    echo "<tr>";
                                    echo "    <td>VDP</td>";
                                    echo "    <td>Endline</td>";
                                    echo "    <td>" . $page_data['vdp']['endline']['view'] . "</td>";
                                    echo "    <td>" . $page_data['vdp']['endline']['click'] . "</td>";
                                    echo "    <td>" . $page_data['vdp']['endline']['fillup'] . "</td>";
                                    echo "</tr>";
                                    //SRP
                                    echo "<tr>";
                                    echo "    <td>SRP</td>";
                                    echo "    <td>Baseline</td>";
                                    echo "    <td>" . $page_data['srp']['baseline']['view'] . "</td>";
                                    echo "    <td>" . $page_data['srp']['baseline']['click'] . "</td>";
                                    echo "    <td>" . $page_data['srp']['baseline']['fillup'] . "</td>";
                                    echo "</tr>";

                                    echo "<tr>";
                                    echo "    <td>SRP</td>";
                                    echo "    <td>Endline</td>";
                                    echo "    <td>" . $page_data['srp']['endline']['view'] . "</td>";
                                    echo "    <td>" . $page_data['srp']['endline']['click'] . "</td>";
                                    echo "    <td>" . $page_data['srp']['endline']['fillup'] . "</td>";
                                    echo "</tr>";
                                } else {
                                    echo "<tr><td colspan='3' style='text-align: center;color: green;'>No data</td></tr>";
                                }
                                ?>
                            </table>
                        </div>

                        <div id="analysis" class="tab-pane">
                            <table class="table table-bordered table-striped mb-none table-advanced dataTable">
                                <thead>
                                    <tr>
                                        <th>Button</th>
                                        <th>Projected Clicks (With 100% Baseline)</th>
                                        <th>Actual Clicks</th>
                                        <th> Click Improve </th>
                                        <th> Click Improve(%) </th>
                                        <th>Projected Fill-ups (With 100% Baseline)</th>
                                        <th>Actual Fill-ups</th>
                                        <th> Fill-ups Improve </th>
                                        <th> Fill-ups Improve(%) </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    foreach ($buttons as $button => $button_status) {
                                        if (!$button) {
                                            continue;
                                        }

                                        $baseline_views =  $button_status['baseline_view'];
                                        $endline_view = $button_status['endline_view'];
                                        $baseline_clicks = $button_status['baseline_clicks'];

                                        $total_views = $baseline_views + $endline_view;
                                        $projected_clicks = floor((($baseline_clicks / ($baseline_views ? $baseline_views : 1)) * $total_views));
                                        $actual_clicks = $button_status['baseline_clicks'] + $button_status['endline_clicks'];
                                        $projected_fillups = floor((($button_status['baseline_fillups'] / ($baseline_views ? $baseline_views : 1)) * $total_views));
                                        $actual_fillups = $button_status['baseline_fillups'] + $button_status['endline_fillups'];

                                        $click_improve = $actual_clicks - $projected_clicks;
                                        $click_improve_percent = $projected_clicks ? round((($click_improve / ($projected_clicks ? $projected_clicks : 1)) * 100), 2) : 0;
                                        $fillups_improve = $actual_fillups - $projected_fillups;
                                        $fillups_improve_percent = $projected_fillups ? round((($fillups_improve / ($projected_fillups ? $projected_fillups : 1)) * 100), 2) : 0;
                                        $buttons[$button]['total_views'] = $total_views;
                                        $buttons[$button]['projected_clicks'] = $projected_clicks;
                                        $buttons[$button]['actual_clicks'] = $actual_clicks;
                                        $buttons[$button]['projected_fillups'] = $projected_fillups;
                                        $buttons[$button]['actual_fillups'] = $actual_fillups;
                                        $buttons[$button]['click_improve'] = $click_improve;
                                        $buttons[$button]['click_improve_percent'] = $click_improve_percent;
                                        $buttons[$button]['fillups_improve'] = $fillups_improve;
                                        $buttons[$button]['fillups_improve_percent'] = $fillups_improve_percent;
                                        ?>
                                        <tr>
                                            <td><?php echo $button ?></td>
                                            <td><?php echo $projected_clicks ?></td>
                                            <td><?php echo $actual_clicks ?></td>
                                            <td><?php echo $click_improve ?></td>
                                            <td><?php echo $click_improve_percent ?></td>
                                            <td><?php echo $projected_fillups ?></td>
                                            <td><?php echo $actual_fillups ?></td>
                                            <td><?php echo $fillups_improve ?></td>
                                            <td><?php echo $fillups_improve_percent ?></td>
                                        </tr>
                                    <?php } ?>

                                    <?php

                                    /*
                                     * Previously sum of projected_clicks was used which was causing error.
                                     * The error was button-details and button-analysis pages data for a dealer was not matching.
                                     * This calculation is for all the buttons together & the error is fixed.
                                     */
                                    $total_buttons = array();
                                    foreach ($buttons as $k=>$subArray) {
                                        foreach ($subArray as $id=>$value) {
                                            $total_buttons[$id]+=$value;
                                        }
                                    }
                                    $overall_baseline_views = $total_buttons['baseline_view'];
                                    $overall_endline_views = $total_buttons['endline_view'];
                                    $overall_total_views = $overall_baseline_views + $overall_endline_views;

                                    $overall_baseline_clicks = $total_buttons['baseline_clicks'];
                                    $overall_projected_clicks = floor((($overall_baseline_clicks / ($overall_baseline_views ? $overall_baseline_views : 1)) * $overall_total_views));
                                    $overall_actual_clicks = $total_buttons['baseline_clicks'] + $total_buttons['endline_clicks'];
                                    $overall_projected_fillups = floor((($total_buttons['baseline_fillups'] / ($overall_baseline_views ? $overall_baseline_views : 1)) * $overall_total_views));
                                    $overall_actual_fillups = $total_buttons['baseline_fillups'] + $total_buttons['endline_fillups'];

                                    $overall_click_improve = $overall_actual_clicks - $overall_projected_clicks;
                                    $overall_click_improve_percent = $overall_projected_clicks ? round((($overall_click_improve / ($overall_projected_clicks ? $overall_projected_clicks : 1)) * 100), 2) : 0;
                                    $overall_fillups_improve = $overall_actual_fillups - $overall_projected_fillups;
                                    $overall_fillups_improve_percent = $overall_projected_fillups ? round((($overall_fillups_improve / ($overall_projected_fillups ? $overall_projected_fillups : 1)) * 100), 2) : 0;

                                    ?>

                                    <tr>
                                        <th>Overall</th>
                                        <th><?php echo $total_buttons['projected_clicks'] ?></th>
                                        <th><?php echo $total_buttons['actual_clicks'] ?></th>
                                        <th><?php echo $total_buttons['click_improve'] ?></th>
                                        <th><?php echo $total_buttons['click_improve_percent'] ?></th>
                                        <th><?php echo $total_buttons['projected_fillups'] ?></th>
                                        <th><?php echo $total_buttons['actual_fillups'] ?></th>
                                        <th><?php echo $total_buttons['fillups_improve'] ?></th>
                                        <th><?php echo $total_buttons['fillups_improve_percent'] ?></th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div id="optimization" class="tab-pane">
                            <table class="table table-bordered table-striped mb-none table-advanced">
                                <tr>
                                    <th>Option Group</th>
                                    <th>Button option</th>
                                </tr>
                                <?php
                                if (count($opt_data) > 0) {
                                    foreach ($opt_data as $group => $item) {
                                        echo "<tr>";
                                        echo "    <td>{$group}</td>";
                                        echo "    <td>{$item['option']}</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='2' style='text-align: center;color: green;'>No data</td></tr>";
                                }
                                ?>
                            </table>
                        </div>


                        <?php if ($button_configured): ?>
                            <div id="aibuttons" class="tab-pane">
                                <?php require_once 'client-management/details-aibuttons.php'; ?>
                            </div>
                        <?php endif ?>


                    </div>
                </div>
                <!-- End Button Status Tabs -->
            </div>
        </div>
    </section>
</div>

<?php
include 'bolts/footer.php';
include 'includes/button-details-charts.php';
include 'button-details-excel.php';


/*

//Create excel for export using php spreed sheet

ini_set("include_path", '/home/spidri/php:' . ini_get("include_path"));
//var_dump(extension_loaded ('zip'));
//exit;
//PhpSpreadsheet_Settings::setZipClass(PhpSpreadsheet::PCLZIP);

require 'vendor/php-spreadsheet/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();

//For Options tab
$spreadsheet->setActiveSheetIndex(0);
$spreadsheet->getActiveSheet()->setTitle('Options');
$sheet1 = $spreadsheet->getActiveSheet();
$sheet1->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$sheet1->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$sheet1->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$sheet1->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$sheet1->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$sheet1->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
$sheet1->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
$sheet1->setCellValue('A1', 'Button option')->getStyle('A1')->getFont()->setBold(true);
$sheet1->setCellValue('B1', 'Option Group')->getStyle('B1')->getFont()->setBold(true);
$sheet1->setCellValue('C1', 'Viewed Count')->getStyle('C1')->getFont()->setBold(true);
$sheet1->setCellValue('D1', 'Clicked Count')->getStyle('D1')->getFont()->setBold(true);
$sheet1->setCellValue('E1', 'Fillup Count')->getStyle('E1')->getFont()->setBold(true);
$sheet1->setCellValue('F1', 'CR (clicked) %')->getStyle('F1')->getFont()->setBold(true);
$sheet1->setCellValue('G1', 'CR (fillup) %')->getStyle('G1')->getFont()->setBold(true);

$col = 'A';
$row = 2;
if (count($total_result_data) > 0) {
    foreach ($total_result_data as $item) {
        if ($item['total_viewed'] > 0) {
            $cr1 = round($item['total_clicked'] / $item['total_viewed'], 4) * 100;
            $cr2 = round($item['total_fillup'] / $item['total_viewed'], 4) * 100;
        } else {
            $cr1 = 0;
            $cr2 = 0;
        }

        $sheet1->setCellValue($col . $row, $item['option1']);
        $col++;
        $sheet1->setCellValue($col . $row, $item['option_group']);
        $col++;
        $sheet1->setCellValue($col . $row, $item['total_viewed']);
        $col++;
        $sheet1->setCellValue($col . $row, $item['total_clicked']);
        $col++;
        $sheet1->setCellValue($col . $row, $item['total_fillup']);
        $col++;
        $sheet1->setCellValue($col . $row, number_format($cr1, 2));
        $col++;
        $sheet1->setCellValue($col . $row, number_format($cr2, 2));
        $col++;

        $col = 'A';
        $row++;
    }
}


//For Buttons Tab
$spreadsheet->createSheet();
$spreadsheet->setActiveSheetIndex(1);
$spreadsheet->getActiveSheet()->setTitle('Buttons');
$sheet2 = $spreadsheet->getActiveSheet();
$sheet2->getActiveSheet()->getDefaultColumnDimension()->setWidth(25);
$col = 'A';
$row = 1;



foreach ($buttons as $button => $button_status) {
    $sheet2->setCellValue($col . $row, 'Button: ' . $button)->getStyle($col . $row)->getFont()->setBold(true);
    $col = 'A';
    $row++;

    $sheet2->setCellValue($col . $row, 'Combination')->getStyle($col . $row)->getFont()->setBold(true);
    $col++;
    $sheet2->setCellValue($col . $row, 'Views')->getStyle($col . $row)->getFont()->setBold(true);
    $col++;
    $sheet2->setCellValue($col . $row, 'CR (click) %')->getStyle($col . $row)->getFont()->setBold(true);
    $col++;
    $sheet2->setCellValue($col . $row, 'CR (fillup) %')->getStyle($col . $row)->getFont()->setBold(true);
    $col = 'A';
    $row++;

    $sheet2->setCellValue($col . $row, 'Baseline');
    $col++;
    $sheet2->setCellValue($col . $row, isset($button_status['baseline_view']) ? $button_status['baseline_view'] : '0');
    $col++;
    $sheet2->setCellValue($col . $row, isset($button_status['baseline_cr1']) ? number_format($button_status['baseline_cr1'], 2) : '0.00');
    $col++;
    $sheet2->setCellValue($col . $row, isset($button_status['baseline_cr2']) ? number_format($button_status['baseline_cr2'], 2) : '0.00');
    $col = 'A';
    $row++;

    $sheet2->setCellValue($col . $row, 'Endline');
    $col++;
    $sheet2->setCellValue($col . $row, isset($button_status['endline_view']) ? $button_status['endline_view'] : '0');
    $col++;
    $sheet2->setCellValue($col . $row, isset($button_status['endline_cr1']) ? number_format($button_status['endline_cr1'], 2) : '0.00');
    $col++;
    $sheet2->setCellValue($col . $row, isset($button_status['endline_cr2']) ? number_format($button_status['endline_cr2'], 2) : '0.00');
    $col = 'A';
    $row++;


    $baseline_cr1 = isset($button_status['baseline_cr1']) ? number_format($button_status['baseline_cr1'], 2) : 0.00;
    $baseline_cr2 = isset($button_status['baseline_cr2']) ? number_format($button_status['baseline_cr2'], 2) : 0.00;
    $endline_cr1 = isset($button_status['endline_cr1']) ? number_format($button_status['endline_cr1'], 2) : 0.00;
    $endline_cr2 = isset($button_status['endline_cr2']) ? number_format($button_status['endline_cr2'], 2) : 0.00;
    $sheet2->setCellValue($col . $row, 'Improvement');
    $col++;
    $sheet2->setCellValue($col . $row, '');
    $col++;
    $sheet2->setCellValue($col . $row, number_format($endline_cr1 - $baseline_cr1, 2));
    $col++;
    $sheet2->setCellValue($col . $row, number_format($endline_cr2 - $baseline_cr2, 2));
    $col = 'A';
    $row += 3;
}


//For Page Tab
$spreadsheet->createSheet();
$spreadsheet->setActiveSheetIndex(2);
$spreadsheet->getActiveSheet()->setTitle('Pages');
$sheet3 = $spreadsheet->getActiveSheet();
$spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$sheet3->setCellValue('A1', 'Page Type')->getStyle('A1')->getFont()->setBold(true);
$sheet3->setCellValue('B1', 'Conversion Type')->getStyle('B1')->getFont()->setBold(true);
$sheet3->setCellValue('C1', 'Page View')->getStyle('C1')->getFont()->setBold(true);
$sheet3->setCellValue('D1', 'Click CR')->getStyle('D1')->getFont()->setBold(true);
$sheet3->setCellValue('E1', 'Fill-up CR')->getStyle('E1')->getFont()->setBold(true);
$col = 'A';
$row = 2;
if (count($page_data) > 0) {
    // VDP
    $sheet3->setCellValue($col . $row, 'VDP');
    $col++;
    $sheet3->setCellValue($col . $row, 'Baseline');
    $col++;
    $sheet3->setCellValue($col . $row, $page_data['vdp']['baseline']['view']);
    $col++;
    $sheet3->setCellValue($col . $row, $page_data['vdp']['baseline']['click']);
    $col++;
    $sheet3->setCellValue($col . $row, $page_data['vdp']['baseline']['fillup']);
    $col = 'A';
    $row++;

    $sheet3->setCellValue($col . $row, 'VDP');
    $col++;
    $sheet3->setCellValue($col . $row, 'Endline');
    $col++;
    $sheet3->setCellValue($col . $row, $page_data['vdp']['endline']['view']);
    $col++;
    $sheet3->setCellValue($col . $row, $page_data['vdp']['endline']['click']);
    $col++;
    $sheet3->setCellValue($col . $row, $page_data['vdp']['endline']['fillup']);
    $col = 'A';
    $row++;

    //SRP
    $sheet3->setCellValue($col . $row, 'SRP');
    $col++;
    $sheet3->setCellValue($col . $row, 'Baseline');
    $col++;
    $sheet3->setCellValue($col . $row, $page_data['srp']['baseline']['view']);
    $col++;
    $sheet3->setCellValue($col . $row, $page_data['srp']['baseline']['click']);
    $col++;
    $sheet3->setCellValue($col . $row, $page_data['srp']['baseline']['fillup']);
    $col = 'A';
    $row++;

    $sheet3->setCellValue($col . $row, 'SRP');
    $col++;
    $sheet3->setCellValue($col . $row, 'Endline');
    $col++;
    $sheet3->setCellValue($col . $row, $page_data['srp']['endline']['view']);
    $col++;
    $sheet3->setCellValue($col . $row, $page_data['srp']['endline']['click']);
    $col++;
    $sheet3->setCellValue($col . $row, $page_data['srp']['endline']['fillup']);
    $col = 'A';
    $row++;
}

//For Analysis Tab
$spreadsheet->createSheet();
$spreadsheet->setActiveSheetIndex(3);
$spreadsheet->getActiveSheet()->setTitle('Analysis');
$sheet4 = $spreadsheet->getActiveSheet();
$spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
$spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
$sheet4->setCellValue('A1', 'Button')->getStyle('A1')->getFont()->setBold(true);
$sheet4->setCellValue('B1', 'Projected Clicks (With 100% Baseline)')->getStyle('B1')->getFont()->setBold(true);
$sheet4->setCellValue('C1', 'Actual Clicks')->getStyle('C1')->getFont()->setBold(true);
$sheet4->setCellValue('D1', 'Click Improve')->getStyle('D1')->getFont()->setBold(true);
$sheet4->setCellValue('E1', 'Click Improve(%)')->getStyle('E1')->getFont()->setBold(true);
$sheet4->setCellValue('F1', 'Projected Fill-ups (With 100% Baseline)')->getStyle('F1')->getFont()->setBold(true);
$sheet4->setCellValue('G1', 'Actual Fill-ups')->getStyle('G1')->getFont()->setBold(true);
$sheet4->setCellValue('H1', 'Fill-ups Improve')->getStyle('H1')->getFont()->setBold(true);
$sheet4->setCellValue('I1', 'Fill-ups Improve(%)')->getStyle('I1')->getFont()->setBold(true);
$col = 'A';
$row = 2;

$total_pclicks = 0;
$total_aclicks = 0;
$total_pfillups = 0;
$total_afillups = 0;

foreach ($buttons as $button => $button_status) {
    if (!$button) {
        continue;
    }
    $baseline_views = $button_status['baseline_view'];
    $total_views = $button_status['baseline_view'] + $button_status['endline_view'];
    $projected_clicks = floor(($button_status['baseline_clicks'] / $baseline_views) * $total_views);
    $actual_clicks = $button_status['baseline_clicks'] + $button_status['endline_clicks'];
    $projected_fillups = floor(($button_status['baseline_fillups'] / $baseline_views) * $total_views);
    $actual_fillups = $button_status['baseline_fillups'] + $button_status['endline_fillups'];

    $total_pclicks += $projected_clicks;
    $total_aclicks += $actual_clicks;
    $total_pfillups += $projected_fillups;
    $total_afillups += $actual_fillups;

    $click_improve = $actual_clicks - $projected_clicks;
    $click_improve_percent = $projected_clicks ? round((($click_improve / $projected_clicks) * 100), 2) : 0;
    $fillups_improve = $actual_fillups - $projected_fillups;
    $fillups_improve_percent = $projected_fillups ? round((($fillups_improve / $projected_fillups) * 100), 2) : 0;

    $sheet4->setCellValue($col . $row, $button);
    $col++;
    $sheet4->setCellValue($col . $row, $projected_clicks);
    $col++;
    $sheet4->setCellValue($col . $row, $actual_clicks);
    $col++;
    $sheet4->setCellValue($col . $row, $click_improve);
    $col++;
    $sheet4->setCellValue($col . $row, $click_improve_percent);
    $col++;
    $sheet4->setCellValue($col . $row, $projected_fillups);
    $col++;
    $sheet4->setCellValue($col . $row, $actual_fillups);
    $col++;
    $sheet4->setCellValue($col . $row, $fillups_improve);
    $col++;
    $sheet4->setCellValue($col . $row, $fillups_improve_percent);
    $col = 'A';
    $row++;
}

$tclick_improve = $total_aclicks - $total_pclicks;
$tclick_improve_percent = $total_pclicks ? @round((($tclick_improve / $total_pclicks) * 100), 2) : 0;
$tfillups_improve = $total_afillups - $total_pfillups;
$tfillups_improve_percent = $total_pfillups ? @round((($tfillups_improve / $total_pfillups) * 100), 2) : 0;

$sheet4->setCellValue($col . $row, 'Total')->getStyle($col . $row)->getFont()->setBold(true);
$col++;
$sheet4->setCellValue($col . $row, $total_pclicks)->getStyle($col . $row)->getFont()->setBold(true);
$col++;
$sheet4->setCellValue($col . $row, $total_aclicks)->getStyle($col . $row)->getFont()->setBold(true);
$col++;
$sheet4->setCellValue($col . $row, $tclick_improve)->getStyle($col . $row)->getFont()->setBold(true);
$col++;
$sheet4->setCellValue($col . $row, $tclick_improve_percent)->getStyle($col . $row)->getFont()->setBold(true);
$col++;
$sheet4->setCellValue($col . $row, $total_pfillups)->getStyle($col . $row)->getFont()->setBold(true);
$col++;
$sheet4->setCellValue($col . $row, $total_afillups)->getStyle($col . $row)->getFont()->setBold(true);
$col++;
$sheet4->setCellValue($col . $row, $tfillups_improve)->getStyle($col . $row)->getFont()->setBold(true);
$col++;
$sheet4->setCellValue($col . $row, $tfillups_improve_percent)->getStyle($col . $row)->getFont()->setBold(true);

//For Optimization Tab
$spreadsheet->createSheet();
$spreadsheet->setActiveSheetIndex(4);
$spreadsheet->getActiveSheet()->setTitle('Optimization');
$sheet5 = $spreadsheet->getActiveSheet();
$sheet5->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$sheet5->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$sheet5->setCellValue('A1', 'Option Group')->getStyle('A1')->getFont()->setBold(true);
$sheet5->setCellValue('B1', 'Button option')->getStyle('B1')->getFont()->setBold(true);
$col = 'A';
$row = 2;

if (count($opt_data)) {
    foreach($opt_data as $group => $item) {
        $sheet5->setCellValue($col . $row, $group);
        $col++;
        $sheet5->setCellValue($col . $row, $item['option']);
        $col = 'A';
        $row++;
    }
}

$writer = new Xlsx($spreadsheet);
$writer->save('button-details.xlsx');

*/
