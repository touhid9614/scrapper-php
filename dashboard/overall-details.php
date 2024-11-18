<?php
require_once 'config.php';
require_once 'includes/loader.php';

session_start();

require_once ADSYNCPATH . 'config.php';
require_once ADSYNCPATH . 'Google/Util.php';
require_once ADSYNCPATH . 'utils.php';
require_once ADSYNCPATH . 'db_connect.php';
require_once ADSYNCPATH . 'boe_db_connect.php';
require_once 'includes/button.php';

global $cron_name, $date_range, $start_date, $end_date;

/*
  if ($date_range == 'all_time') {
  list($baselineViewedVdp, $endlineViewedVdp, $baselineCR1Vdp, $endlineCR1Vdp, $baselineCR2Vdp, $endlineCR2Vdp) = boedb_get_chart_vdp_data('');
  list($baselineViewedSip, $endlineViewedSip, $baselineCR1Sip, $endlineCR1Sip, $baselineCR2Sip, $endlineCR2Sip) = boedb_get_chart_sip_data('');
  } else {
  list($baselineViewedVdp, $endlineViewedVdp, $baselineCR1Vdp, $endlineCR1Vdp, $baselineCR2Vdp, $endlineCR2Vdp) = boedb_get_chart_vdp_data_daily('', '', $date_range, $start_date, $end_date);
  list($baselineViewedSip, $endlineViewedSip, $baselineCR1Sip, $endlineCR1Sip, $baselineCR2Sip, $endlineCR2Sip) = boedb_get_chart_sip_data_daily('', '', $date_range, $start_date, $end_date);
  } */

list($baselineViewedVdp, $endlineViewedVdp, $baselineCR1Vdp, $endlineCR1Vdp, $baselineCR2Vdp, $endlineCR2Vdp) = boedb_get_chartdata($start_date, $end_date, $date_range, 'vdp', '');
list($baselineViewedSip, $endlineViewedSip, $baselineCR1Sip, $endlineCR1Sip, $baselineCR2Sip, $endlineCR2Sip) = boedb_get_chartdata($start_date, $end_date, $date_range, 'srp', '');

$total_result_data_raw = boedb_get_options_data('', $date_range, $start_date, $end_date);

DbConnect::close_connection();

//For chart prepare data
$chartLabel = array();
for ($i = 0; $i < sizeof($baselineCR1Vdp); $i++) {
    $chartLabel[$i] = (string) $baselineCR1Vdp[$i]['label'];
}
$chartLabel = json_encode($chartLabel);

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
    for ($i = 0; $i < sizeof($listData); $i++) {
        $dataArr[$i] = floatval($listData[$i]['y']);
    }
    return $dataArr;
}



//Prepare data for Options tab
$total_result_data = [];
if (!$total_result_data_raw) {
    $total_result_data_raw = array();
}
foreach ($total_result_data_raw as $result_data) {
    $result_data['option1'] = strip_tags($result_data['option1']);
    $key = "{$result_data['option_group']}_{$result_data['option1']}";

    if (isset($total_result_data[$key])) {
        $total_result_data[$key]['total_viewed'] += $result_data['total_viewed'];
        $total_result_data[$key]['total_clicked'] += $result_data['total_clicked'];
        $total_result_data[$key]['total_fillup'] += $result_data['total_fillup'];
        $total_result_data[$key]['total_form_viewed'] += $result_data['total_form_viewed'];
    } else {
        $total_result_data[$key] = $result_data;
    }
}


include 'bolts/header.php';
?>

<div class="inner-wrapper">

    <?php
    $select = 'overall-details';
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
                        <h2 class="panel-title">Details for All Dealership</h2>
                    </header>
                    <div class="panel-body">
                        <form method="GET" class="form-inline">
                            <input name="dealership" type="hidden" value="<?= $cron_name ?>"/>
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

                            <button class="btn btn-primary ml-md">Apply Filter</button>
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
                                        <th>Viewed count</th>
                                        <th>Clicked count</th>
                                        <th>Fillup count</th>
                                        <th>CR (clicked) %</th>
                                        <th>CR (fillup) %</th>
                                    </tr>
                                </thead>
                                <?php
                                if (count($total_result_data) > 0) {
                                    foreach ($total_result_data as $item) {
                                        $cr1 = @(round($item['total_clicked'] / $item['total_viewed'], 4) * 100);
                                        $cr2 = @(round($item['total_fillup'] / $item['total_form_viewed'], 4) * 100);

                                        echo "<tr>";
                                        echo "<td>{$item['option1']}</td>";
                                        echo "<td>{$item['option_group']}</td>";
                                        echo "<td>{$item['total_viewed']}</td>";
                                        echo "<td>{$item['total_clicked']}</td>";
                                        echo "<td>{$item['total_fillup']}</td>";
                                        echo "<td>" . number_format($cr1, 2) . "</td>";
                                        echo "<td>" . number_format($cr2, 2) . "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='7' style='text-align: center;color: green;'>No data</td></tr>";
                                }
                                ?>
                            </table>
                        </div>

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
