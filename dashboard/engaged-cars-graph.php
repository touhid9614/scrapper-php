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

    $date_range = filter_input_default(INPUT_GET, 'date_range');

    if (empty($date_range))
    {
        $date_range = 'all_time';
    }

    $xAxis = [];
    $engagedCounts = [];
    $soldCounts = [];

    if ($date_range == 'last_7' || $date_range == 'custom')
    {
        $date1 = new DateTime($start_date);
        $date2 = new DateTime($end_date);
        $interval = $date1->diff($date2);
        $interval_day = $interval->d + 1;

        for ($day = 0; $day < $interval_day; $day++)
        {
            $inc_date = date('Y-m-d', strtotime($start_date . ' +' . $day . ' day'));
            $timeinsecond = strtotime($inc_date);
            $timeinsecond_next = $timeinsecond + 86399;

            $soldQuery = DbConnect::get_instance()->query("SELECT count(*) as sold FROM {$cron_name}_scrapped_data WHERE deleted = 1 AND (updated_at BETWEEN $timeinsecond AND $timeinsecond_next)");
            $soldCounts[] = intval(mysqli_fetch_assoc($soldQuery)['sold']);
            $engaged_count = DbConnect::get_instance()->query("SELECT COALESCE(SUM(count),0) as count FROM engaged_vdp WHERE dealership='$cron_name' AND day='$inc_date'");
            $engagedCounts[] = intval(mysqli_fetch_assoc($engaged_count)['count']);
            $xAxis[] = $inc_date;
        }
    }
    else
    {
        $start_date = ($date_range == 'all_time') ? date('Y-m-d', strtotime('-56 day')) : $start_date;
        $end_date = ($date_range == 'all_time') ? date('Y-m-d') : $end_date;
        $date1 = new DateTime($start_date);
        $date2 = new DateTime($end_date);
        $interval = $date1->diff($date2);
        $interval_day = $interval->m * 30 + $interval->d;
        $week_no = floor($interval_day / 7);

        $inc = 0;

        for ($day = 0; $day < $week_no; $day++)
        {
            $inc++;
            $inc_date = date('Y-m-d', strtotime($start_date . ' +7 day'));
            $timeinsecond = strtotime($start_date);
            $timeinsecond_next = strtotime($inc_date);

            $soldQuery = DbConnect::get_instance()->query("SELECT count(*) as sold FROM {$cron_name}_scrapped_data WHERE deleted = 1 AND (updated_at BETWEEN $timeinsecond AND $timeinsecond_next)");
            $soldCounts[] = intval(mysqli_fetch_assoc($soldQuery)['sold']);

            $engaged_count = DbConnect::get_instance()->query("SELECT COALESCE(SUM(count),0) as count FROM engaged_vdp WHERE dealership='$cron_name' AND (day BETWEEN '$start_date' AND '$inc_date')");
            $engagedCounts[] = intval(mysqli_fetch_assoc($engaged_count)['count']);
            $xAxis[] = "Week-" . $inc . " (" . date('M-d', strtotime($start_date)) . " to " . date('M-d', strtotime($inc_date)) . ")";
            $start_date = date('Y-m-d', strtotime($inc_date . ' +1 day'));
        }
    }

    include 'bolts/header.php';
?>

<div class="inner-wrapper">

    <?php
        $select = 'engaged-cars-graph';
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
                            <label class="mb-2 mr-sm-2 mb-sm-0 ml-md" for="dealership">Dealership</label>
                            <select class="form-control mb-2 mr-sm-2 mb-sm-0" name="dealership" id="dealership">
                                <?php
                                if ($user['type'] == 'a')
                                {
                                    foreach ($cron_names as $c_name)
                                    {
                                        $selected = $cron_name == $c_name ? ' selected' : '';
                                        ?>
                                        <option value="<?= $c_name ?>"<?= $selected ?>><?= $c_name ?></option>
                                        <?php
                                    }
                                }
                                else
                                {
                                    ?>
                                    <option value="<?= $user['cron_name'] ?>"<?= ' selected' ?>><?= $user['cron_name'] ?> </option>
                                <?php
                                }
                                ?>
                            </select>

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
                                <input class="form-control mb-2 mr-sm-2 mb-sm-0" name="start_date" id="start_date" type="date" value="<?= $start_date ?>" required=""/>

                                <label class="mb-2 mr-sm-2 mb-sm-0 ml-md" for="end_date">End Date</label>
                                <input class="form-control mb-2 mr-sm-2 mb-sm-0" name="end_date" id="end_date" type="date" value="<?= $end_date ?>" required=""/>
                            </div>
                            <button class="btn btn-primary ml-md"> Apply Filter </button>                           
                        </form>
                    </div>
                </section>
            </div>
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div id="engaged-car-vs-sold">   </div>
                    </div>   
                </div>
            </div>
        </div>
    </section>
</div>

<?php
    include 'bolts/footer.php';
?>

<script type="text/javascript">
    Highcharts.chart('engaged-car-vs-sold', {
        chart: {
            type: 'spline'
        },
        title: {
            text: 'Engaged User Vs. Sold Cars'
        },
        xAxis: {
            categories: JSON.parse('<?= json_encode($xAxis) ?>')
        },
        yAxis: {
            title: {
                text: 'Number'
            },
            labels: {
                formatter: function () {
                    return this.value;
                }
            }
        },
        tooltip: {
            crosshairs: true,
            shared: true
        },
        plotOptions: {
            spline: {
                marker: {
                    radius: 4,
                    lineColor: '#666666',
                    lineWidth: 1
                }
            }
        },
        series: [{
                name: 'Engaged Car',
                marker: {
                    symbol: 'square'
                },
                data: JSON.parse('<?= json_encode($engagedCounts) ?>')

            }, {
                name: 'Sold Car',
                marker: {
                    symbol: 'diamond'
                },
                data: JSON.parse('<?= json_encode($soldCounts) ?>')
            }]
    });



    $("#date_range").change(function ()
    {
        if (this.value == "custom")
        {
            $("#custom_date_range").show();
        }
        else
        {
            $("#custom_date_range").hide();
        }
    });
</script>