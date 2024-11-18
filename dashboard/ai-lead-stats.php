<?php
    ini_set('max_execution_time', 300);
    require_once 'config.php';
    require_once 'includes/loader.php';
    session_start();
    require_once ADSYNCPATH . 'config.php';
    require_once ADSYNCPATH . 'Google/Util.php';
    require_once ADSYNCPATH . 'db_connect.php';
    require_once ADSYNCPATH . 'tag_db_connect.php';
    require_once ADSYNCPATH . 'boe_db_connect.php';
    require_once ADSYNCPATH . 'utils.php';
    require_once 'includes/button.php';
    global $user, $connection;

    # ini_set('display_errors', 1);
    # ini_set('display_startup_errors', 1);
    # error_reporting(E_ALL);


    global $user, $connection;
    global $CronConfigs, $scrapper_configs, $connection;
    global $date_range, $start_date, $end_date;
    $cron_names = array_intersect(array_keys($CronConfigs), array_keys($scrapper_configs));

    $db_connect = new DbConnect('');

    $last_month = strtotime("first day of previous month");
    $fillup_key = date('mY');
    $lfillup_key = date('mY', $last_month);

    $start_date = date('Y-m-01');
    $end_date = date('Y-m-d');


    //Get baseline views and total views by dealership
    $viewsdata = get_viewsdata_dealership($start_date, $end_date);
    $viewsdata_new = get_ai_button_dealership_total_data($start_date, $end_date);

    foreach($viewsdata_new as $cn => $data) {
        if (!isset($viewsdata[$cn])) {
            $viewsdata[$cn] = $data;
        } else {
            $viewsdata[$cn]['baseline_view'] = $viewsdata[$cn]['baseline_view'] + $data['baseline_view'];
            $viewsdata[$cn]['baseline_clicks'] = $viewsdata[$cn]['baseline_clicks'] + $data['baseline_clicks'];
            $viewsdata[$cn]['baseline_fillups'] = $viewsdata[$cn]['baseline_fillups'] + $data['baseline_fillups'];
        }
    }


    foreach ($cron_names as $cron_name)
    {
        $cron_config = $CronConfigs[$cron_name];

        if (!isset($cron_config['buttons']))
        {
            continue;
        }   //Only process dealerships with button configuration

        $has_form = false;

        foreach ($cron_config['buttons'] as $button_config)
        {
            if (isset($button_config['button_action']))
            {
                $has_form = true;
                break;
            }
        }

        if (!$has_form)
        {
            continue;
        }

        $fillup_params =
        [
            'dealership' => $cron_name,
            'month' => $fillup_key,
        ];

        $lfillup_params =
        [
            'dealership' => $cron_name,
            'month' => $lfillup_key,
        ];

        $fillups_query_prep = $db_connect->prepare_query_params($fillup_params, DbConnect::PREPARE_WHERE);
        $lfillups_query_prep = $db_connect->prepare_query_params($lfillup_params, DbConnect::PREPARE_WHERE);

        $fillups_query = "SELECT leads_type, count(id) as total_submits FROM `leads_ai_dealerships` where $fillups_query_prep GROUP BY leads_type";
        $lastmonth_fillups_query = "SELECT leads_type, count(id)as total_submits FROM `leads_ai_dealerships` where $lfillups_query_prep GROUP BY leads_type";

        $baseline_fillups = 0;
        $endline_fillups = 0;
        $baseline_lastmonth_fillups = 0;
        $endline_lastmonth_fillups = 0;

        $fillups_res = $db_connect->query($fillups_query);

        if (!$fillups_res)
        {
            continue;
        }

        while ($row = mysqli_fetch_assoc($fillups_res))
        {
            if ($row['leads_type'] == 'baseline')
            {
                $baseline_fillups += $row['total_submits'];
            }
            else
            {
                $endline_fillups += $row['total_submits'];
            }
        }

        mysqli_free_result($fillups_res);


        $lastmonth_fillups_res = $db_connect->query($lastmonth_fillups_query);

        if (!$lastmonth_fillups_res)
        {
            continue;
        }

        while ($row = mysqli_fetch_assoc($lastmonth_fillups_res))
        {
            if ($row['leads_type'] == 'baseline')
            {
                $baseline_lastmonth_fillups += $row['total_submits'];
            }
            else
            {
                $endline_lastmonth_fillups += $row['total_submits'];
            }
        }

        mysqli_free_result($lastmonth_fillups_res);


        $total_projection = 0;
        $baseline_views = (isset($viewsdata[$cron_name]['baseline_view'])) ? $viewsdata[$cron_name]['baseline_view'] : 0;
        $baseline_fillups_com = (isset($viewsdata[$cron_name]['baseline_fillups'])) ? $viewsdata[$cron_name]['baseline_fillups'] : 0;
        $total_views = ((isset($viewsdata[$cron_name]['baseline_view'])) ? $viewsdata[$cron_name]['baseline_view'] : 0) + ((isset($viewsdata[$cron_name]['endline_view'])) ? $viewsdata[$cron_name]['endline_view'] : 0);

        $adf_user = $db_connect->getADF($cron_name);

        $result[$cron_name] =
        [
            'submits' => $baseline_fillups,
            'submits_endline' => $endline_fillups,
            'total_projection' => ($baseline_views==0 ? 0 : @(round(((($baseline_fillups_com/$baseline_views)*$total_views)),2))),
            'last_submits' => $baseline_lastmonth_fillups,
            'last_submits_endline' => $endline_lastmonth_fillups,
            'form-live' => (isset($adf_user) && isset($adf_user['form_live']) && !!$adf_user['form_live']) ? 'Yes' : 'No' // '<i class="fa fa-check"></i>' : '<i class="fa fa-times"></i>'
        ];

        unset($adf_user);
    }

    include 'bolts/header.php'
?>

<div class="inner-wrapper">

<?php
    $select = 'ai-lead-export';
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
                        <h2 class="panel-title">Select Dealership And Date Range to Export</h2>
                    </header>
                    <div class="panel-body">
                        <form method="GET" class="form-inline" action="export_ai_leads.php">
                            <?php if ($user['type'] == 'a') { ?>
                                <label class="mb-2 mr-sm-2 mb-sm-0 ml-md" for="dealership">Dealership</label>
                                <select class="form-control populate mb-2 mr-sm-2 mb-sm-0" name="dealership" id="dealership" data-plugin-selectTwo>
                                    <?php foreach ($cron_names as $c_name) {
                                        ?>
                                        <option value="<?= $c_name ?>"><?= $c_name ?></option>
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
                                    ?>
                                    <option value="<?= $key ?>"><?= $val ?></option>
                                <?php } ?>
                            </select>

                            <div class="form-group" id="custom_date_range" style="<?php if ($date_range != 'custom'): ?>display:none<?php endif; ?>">
                                <label class="mb-2 mr-sm-2 mb-sm-0 ml-md" for="start_date">Start Date</label>
                                <input class="form-control mb-2 mr-sm-2 mb-sm-0" name="start_date" id="start_date" type="date" value="<?= $start_date ?>" required=""/>

                                <label class="mb-2 mr-sm-2 mb-sm-0 ml-md" for="end_date">End Date</label>
                                <input class="form-control mb-2 mr-sm-2 mb-sm-0" name="end_date" id="end_date" type="date" value="<?= $end_date ?>" required=""/>
                            </div>
                            <button type="submit" class="btn btn-primary ml-md"> Export </button>
                        </form>
                    </div>
                </section>
            </div>
            <div class="col-md-12">
                <section class="panel">
                    <header class="panel-heading">
                        <div class="panel-actions">
                            <a href="#" class="fa fa-caret-down"></a>
                        </div>
                        <h2 class="panel-title"> Leads Statistics </h2>
                        <p class="panel-subtitle"></p>
                    </header>

                    <div class="panel-body">
                        <!--Page Coming soon-->
                        <table class="table table-bordered table-striped mb-none table-advanced">
                            <thead>
                                <tr>
                                    <th> Dealership </th>
                                    <th> Monthly (Baseline) </th>
                                    <th> Monthly (Endline) </th>
                                    <th> Monthly (Total) </th>
                                    <th> Monthly Projection </th>
                                    <th> Last Month Fillups </th>
                                    <th> Form Live </th>
                                    <th>  </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($result as $c_name => $res): ?>
                                    <tr>
                                        <td><a href="button-details.php?dealership=<?= $c_name ?>"><?= $c_name ?></a></td>
                                        <td><?= $res['submits'] ?></td>
                                        <td><?= $res['submits_endline'] ?></td>
                                        <td><?= ($res['submits'] + $res['submits_endline']) ?></td>
                                        <td><?= $res['total_projection'] ?></td>
                                        <td><?= ($res['last_submits'] + $res['last_submits_endline']) ?></td>
                                        <td><?= $res['form-live'] ?></td>
                                        <td><a class="btn btn-sm btn-success" href="export_ai_leads.php?dealership=<?= $c_name ?>">Export</a></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
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
<script type="text/javascript">
    $("#date_range").change(function () {
        if (this.value == "custom") {
            $("#custom_date_range").show();
        } else {
            $("#custom_date_range").hide();
        }
    });
</script>
