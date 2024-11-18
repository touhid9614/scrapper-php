<?php
    require_once 'config.php';
    require_once 'includes/loader.php';

    session_start();

    require_once ADSYNCPATH . 'config.php';
    require_once ADSYNCPATH . 'Google/Util.php';
    require_once ADSYNCPATH . 'utils.php';
    require_once ADSYNCPATH . 'db_connect.php';

    global $CronConfigs, $scrapper_configs, $connection;

    $cron_names = array_intersect(array_keys($CronConfigs), array_keys($scrapper_configs));

    $tag_state_dir = dirname(ABSPATH) . '/tag-state/';

    if (!file_exists($tag_state_dir))
    {
        if (!mkdir($tag_state_dir))
        {
            echo "\n//Unable to create tag state directory\n";
        }
    }

    $db_connect = new DbConnect($cron_name, $connection);

    $issues = [];

    foreach($cron_names as $cron_name)
    {
        $cron_config = $CronConfigs[$cron_name];

        if (!isset($cron_config['buttons']))    //Only process dealerships with button configuration
        {
            continue;
        }

        $baseline_query = "SELECT `dealership`, `button`, `combination`, sum(`viewed`) AS total_viewed, sum(`clicked`) AS total_clicked, sum(`fillup`) AS total_fillup FROM `tbl_btn_comb_stat` WHERE `dealership`='$cron_name' AND `combination`='baseline' AND DATEDIFF(NOW(), `date`) >= 0 AND DATEDIFF(NOW(), `date`) < 30 ";
        $endline_query  = "SELECT `dealership`, `button`, `combination`, sum(`viewed`) AS total_viewed, sum(`clicked`) AS total_clicked, sum(`fillup`) AS total_fillup FROM `tbl_btn_comb_stat` WHERE `dealership`='$cron_name' AND `combination`='endline' AND DATEDIFF(NOW(), `date`) >= 0 AND DATEDIFF(NOW(), `date`) < 30 ";

        $baseline_res = $db_connect->query($baseline_query);

        if (!$baseline_res)  //unable to pull data, ignore now
        {
            continue;
        }

        if (($row = mysqli_fetch_assoc($baseline_res)))
        {
            $baseline_views     = $row['total_viewed'];
            $baseline_clicks    = $row['total_clicked'];
        }

        mysqli_free_result($baseline_res);

        $endline_res = $db_connect->query($endline_query);

        if (!$endline_res) //unable to pull data, ignore now
        {
            continue;
        }

        if (($row = mysqli_fetch_assoc($endline_res)))
        {
            $endline_views     = $row['total_viewed'];
            $endline_clicks    = $row['total_clicked'];
        }

        mysqli_free_result($endline_res);

        $baseline_cr = $baseline_views > 0 ? $baseline_clicks/$baseline_views : 0;
        $endline_cr  = $endline_views > 0 ? $endline_clicks/$endline_views : 0;
        $has_issue = $baseline_views == 0 || $endline_views == 0 || $endline_clicks == 0 || $baseline_cr >= $endline_cr;

        if (!$has_issue)    //No issue so ignore
        {
            continue;
        }

        $tag_state_file = $tag_state_dir . $cron_name . '.any';

        $tag_text = '<i class="fa fa-times"></i>';

        if (file_exists($tag_state_file))
        {
            $tag_loaded = time() - filemtime($tag_state_file);
            $tag_text = gmdate("H:i:s", $tag_loaded);
        }

        $adf_user = $db_connect->getADF($cron_name);

        $issues[$cron_name] =
        [
            'view'              => ($baseline_views == 0 || $endline_views == 0) ? '<i class="fa fa-times"></i>' : '<i class="fa fa-check"></i>',
            'click'             => ($endline_clicks == 0) ? '<i class="fa fa-times"></i>' : '<i class="fa fa-check"></i>',
            'better-endline'    => ($baseline_cr >= $endline_cr) ? '<i class="fa fa-times"></i>' : '<i class="fa fa-check"></i>',
            'last-tag-loaded'   => $tag_text,
            'button-live'       => (isset($adf_user) && !$adf_user['buttons_live']) ? '<i class="fa fa-times"></i>' : '<i class="fa fa-check"></i>'
        ];

        unset($adf_user);
    }

    mysqli_close($connection);

    include 'bolts/header.php'
?>

<div class="inner-wrapper">

    <?php $select = 'button-issues';  include 'bolts/sidebar.php' ?>

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
                        <h2 class="panel-title">Button Issues (Last 30 days)</h2>
                    </header>
                    <div class="panel-body">
                        <table class="table table-bordered table-striped mb-none table-advanced">
                                <thead>
                                    <tr>
                                        <th class="export"> Dealership </th>
                                        <th class="export"> View </th>
                                        <th class="export"> Click </th>
                                        <th class="export"> Better Endline </th>
                                        <th class="export"> Last Tag Loaded </th>
                                        <th class="export"> Button Live </th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    foreach($issues as $cron_name => $issue)
                                    {
                                ?>
                                    <tr>
                                        <td><?= $cron_name ?></td>
                                        <td><?= $issue['view'] ?></td>
                                        <td><?= $issue['click'] ?></td>
                                        <td><?= $issue['better-endline'] ?></td>
                                        <td><?= $issue['last-tag-loaded'] ?></td>
                                        <td><?= $issue['button-live'] ?></td>
                                    </tr>
                                <?php
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

<?php include 'bolts/footer.php';
