<?php

    require_once 'config.php';
    require_once 'includes/loader.php';

    session_start();

    require_once ADSYNCPATH . 'config.php';
    require_once ADSYNCPATH . 'Google/Util.php';
    require_once ADSYNCPATH . 'utils.php';
    require_once ADSYNCPATH . 'boe_db_connect.php';
    require_once ADSYNCPATH . 'db_connect.php';

    global $CronConfigs, $scrapper_configs; //, $connection;

    $cron_names = array_intersect(array_keys($CronConfigs), array_keys($scrapper_configs));

    $tag_state_dir = dirname(ABSPATH) . '/tag-state/';

    if (!file_exists($tag_state_dir))
    {
        if (!mkdir($tag_state_dir))
        {
            echo "\n//Unable to create tag state directory\n";
        }
    }


    $result = DbConnect::get_instance()->query("SELECT * FROM dealerships"); // Please don't use *
    $dealer_company = [];

    while ($row = mysqli_fetch_assoc($result))
    {
        $dealer_company[$row['dealership']] = $row['company_name'];
    }


    //$db_connect = new DbConnect($cron_name, $connection);
    //mysqli_close($connection);

    include 'bolts/header.php'
?>

<div class="inner-wrapper">

    <?php $select = 'button-overview';
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
                            <button class="btn btn-danger" id="export"> Export</button>
                            <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                        </div>
                        <h2 class="panel-title">Button Overview</h2>
                    </header>
                    <div class="panel-body">
                        <table class="table table-bordered table-striped mb-none table-advanced">
                            <thead>
                                <tr>
                                    <th> Company Name </th>
                                    <th> Dealership Name </th>
                                    <th> Baseline Views </th>
                                    <th> Baseline CR (Click) % </th>
                                    <th> Baseline CR (Fillup) % </th>
                                    <th> Endline Views </th>
                                    <th> Endline CR (Click) % </th>
                                    <th> Endline CR (Fillup) % </th>
                                    <th> Start date </th>
                                    <th> Viewed Status </th>
                                    <th> Launch Status </th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                $data = boedb_get_ui_overview_data();
                                $status_data = boedb_bs_get_rows();

                                if ($data && count($data) > 0)
                                {
                                    $ts1 = time();

                                    foreach ($data as $dealership => $item)
                                    {
                                        if( isset($CronConfigs[$dealership]) && isset($CronConfigs[$dealership]['button_algorithm']) ){
                                            $ai_data = get_ai_button_total_data($dealership, '', '', 'Type');
                                            $item['baseline_views'] = $ai_data[0]->View;
                                            $item['baseline_cr1'] = (floatval($ai_data[0]->Click) / floatval($ai_data[0]->View)) * 100;
                                            $item['baseline_cr2'] = (floatval($ai_data[0]->Fill_Up) / floatval($ai_data[0]->Click)) * 100;

                                            $item['endline_views'] = $ai_data[1]->View;
                                            $item['endline_cr1'] = (floatval($ai_data[1]->Click) / floatval($ai_data[1]->View)) * 100;
                                            $item['endline_cr2'] = (floatval($ai_data[1]->Fill_Up) / floatval($ai_data[1]->Click)) * 100;
                                        }
                                        $status_item = isset($status_data[$dealership]) ? $status_data[$dealership] : false;

                                        $cron_config = isset($CronConfigs[$dealership]) ? $CronConfigs[$dealership] : null;

                                        if (!$cron_config)
                                        {
                                            continue;
                                        }

                                        if (!isset($cron_config['buttons']))
                                        {
                                            continue;
                                        }

                                        $status = false;
                                        $is_launched = false;
                                        $start_date = false;

                                        if ($status_item)
                                        {
                                            $ts2 = strtotime($status_item['last_viewed']);
                                            $diff = $ts1 - $ts2;

                                            if ($diff <= 3600)
                                            {
                                                $status = true;
                                            }

                                            $db_connect_new = new DbConnect('');
                                            $adf_user = $db_connect_new->getADF($dealership);
                                            $db_connect_new->close_connection(DbConnect::CLOSE_READ_CONNECTION);
                                            $is_launched = isset($adf_user) && $adf_user['buttons_live']; //$status_item['is_launched'];
                                            $start_date = $status_item['launch_date'];
                                            unset($adf_user);
                                        }

                                        $company_name = isset($dealer_company[$dealership]) ? $dealer_company[$dealership] : 'N/A';
                                        $company_name = ucfirst(trim($company_name));

                                        echo "<tr>";
                                        echo "    <td><a href=\"button-details.php?dealership={$dealership}\">{$company_name}</a></td>";
                                        echo "    <td><a href=\"button-details.php?dealership={$dealership}\">{$dealership}</a></td>";
                                        echo "    <td>{$item['baseline_views']}</td>";
                                        echo "    <td>" . number_format($item['baseline_cr1'], 2) . "</td>";
                                        echo "    <td>" . number_format($item['baseline_cr2'], 2) . "</td>";
                                        echo "    <td>{$item['endline_views']}</td>";
                                        echo "    <td>" . number_format($item['endline_cr1'], 2) . "</td>";
                                        echo "    <td>" . number_format($item['endline_cr2'], 2) . "</td>";
                                        echo "    <td>{$start_date}</td>";

                                        if (!$status)
                                        {
                                            $warn = $status_item ? $status_item['last_viewed'] : $start_date;
                                            echo "<td style='color: red;'>Warn <br/>{$warn}</td>";
                                        }
                                        else
                                        {
                                            echo "<td style='color: Green;'>Good</td>";
                                        }

                                        if ($is_launched)
                                        {
                                            echo "<td style='color: Green;'>launched</td>";
                                        }
                                        else
                                        {
                                            echo "<td style='color: Red;'>Not launched</td>";
                                        }

                                        echo "</tr>";
                                    }
                                }
                                else
                                {
                                    echo "<tr><td colspan='5' style='text-align: center;color: green;'>No data</td></tr>";
                                }
                            ?>
                            </tbody>

                            <tfoot>
                                <tr>
                                    <th> Company Name </th>
                                    <th> Dealership Name </th>
                                    <th> Baseline Views </th>
                                    <th> Baseline CR (Click) % </th>
                                    <th> Baseline CR (Fillup) % </th>
                                    <th> Endline Views </th>
                                    <th> Endline CR (Click) % </th>
                                    <th> Endline CR (Fillup) % </th>
                                    <th> Start date </th>
                                    <th> Viewed Status </th>
                                    <th> Launch Status </th>
                                </tr>
                            </tfoot>
                        </table>

                        <table  style="display: none" id="exportTable">
                            <thead>
                            <tr>
                                <th> Company Name </th>
                                <th> Dealership Name </th>
                                <th> Baseline Views </th>
                                <th> Baseline CR (Click) % </th>
                                <th> Baseline CR (Fillup) % </th>
                                <th> Endline Views </th>
                                <th> Endline CR (Click) % </th>
                                <th> Endline CR (Fillup) % </th>
                                <th> Start date </th>
                                <th> Viewed Status </th>
                                <th> Launch Status </th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $data = boedb_get_ui_overview_data();
                            $status_data = boedb_bs_get_rows();

                            if ($data && count($data) > 0)
                            {
                                $ts1 = time();

                                foreach ($data as $dealership => $item)
                                {
                                    $status_item = isset($status_data[$dealership]) ? $status_data[$dealership] : false;

                                    $cron_config = isset($CronConfigs[$dealership]) ? $CronConfigs[$dealership] : null;

                                    if (!$cron_config)
                                    {
                                        continue;
                                    }

                                    if (!isset($cron_config['buttons']))
                                    {
                                        continue;
                                    }

                                    $status = false;
                                    $is_launched = false;
                                    $start_date = false;

                                    if ($status_item)
                                    {
                                        $ts2 = strtotime($status_item['last_viewed']);
                                        $diff = $ts1 - $ts2;

                                        if ($diff <= 3600)
                                        {
                                            $status = true;
                                        }

                                        $db_connect_new = new DbConnect('');
                                        $adf_user = $db_connect_new->getADF($dealership);
                                        $db_connect_new->close_connection();
                                        $is_launched = isset($adf_user) && $adf_user['buttons_live']; //$status_item['is_launched'];
                                        $start_date = $status_item['launch_date'];
                                        unset($adf_user);
                                    }

                                    $company_name = isset($dealer_company[$dealership]) ? $dealer_company[$dealership] : 'N/A';
                                    $company_name = ucfirst(trim($company_name));

                                    echo "<tr>";
                                    echo "    <td>{$company_name}</td>";
                                    echo "    <td>{$dealership}</td>";
                                    echo "    <td>{$item['baseline_views']}</td>";
                                    echo "    <td>" . number_format($item['baseline_cr1'], 2) . "</td>";
                                    echo "    <td>" . number_format($item['baseline_cr2'], 2) . "</td>";
                                    echo "    <td>{$item['endline_views']}</td>";
                                    echo "    <td>" . number_format($item['endline_cr1'], 2) . "</td>";
                                    echo "    <td>" . number_format($item['endline_cr2'], 2) . "</td>";
                                    echo "    <td>{$start_date}</td>";

                                    if (!$status)
                                    {
                                        $warn = $status_item ? $status_item['last_viewed'] : $start_date;
                                        echo "<td>Warn - {$warn}</td>";
                                    }
                                    else
                                    {
                                        echo "<td>Good</td>";
                                    }

                                    if ($is_launched)
                                    {
                                        echo "<td>launched</td>";
                                    }
                                    else
                                    {
                                        echo "<td>Not launched</td>";
                                    }

                                    echo "</tr>";
                                }
                            }
                            ?>
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
    <script>

    $( "#export" ).click(function() {
         $('table#exportTable').csvExport({
            title:'button-overview'
         });
    });

</script>
