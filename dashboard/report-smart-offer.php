<?php

require_once 'config.php';
require_once 'includes/loader.php';
require_once ADSYNCPATH . 'db_connect.php';
require_once ADSYNCPATH . 'utils.php';

global $user;
$all_dealerships = DbConnect::get_instance()->get_all_dealers(1);
$dealership = $user['cron_name'];

//$dealership = filter_input(INPUT_GET, 'dealership');

$smart_offer = [];
if (isset($dealership)) {

    $query = "SELECT * FROM monthly_offer_lead_count_meta_data where meta_key LIKE '%$dealership%'";
    $result = DbConnect::get_instance()->query($query);


    while ($row = mysqli_fetch_assoc($result)) {
        $key = explode("_", $row['meta_key']);
        $value = explode(":", $row['meta_value']);
        $type = in_array("view", $key) ? 'view' : 'fillUp';

        $date = end($key);

        if (is_numeric($date)) {
            $monthNum = substr($date, 0, 2);
            $year = substr($date, 2);

            $monthText = date('F', mktime(0, 0, 0, $monthNum, 10));
            $smart_offer[$year][$monthText][$type] = trim(end($value),";");
        }
    }
}
?>


<?php include 'bolts/header.php' ?>

<div class="inner-wrapper">
    <?php
    $select = 'report-smart-offer';
    include 'bolts/sidebar.php'
    ?>
    <script>
        var report_smart_offer = true;
    </script>

    <section role="main" class="content-body">

        <header class="page-header">

        </header>
        <div class="row">
            <div class="col-lg-12">
                <header class="panel-heading">
                    <div class="panel-actions">
                        <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                    </div>
                    <h2 class="panel-title"> Configuration Panel </h2>
                </header>

                <div class="panel-body">
                    <form method="GET" class="
                        form-inline">
                        <label class="  mb-2 mr-sm-2 mb-sm-0 ml-md" for="dealership"> Dealership </label>
                        &nbsp; &nbsp;
                        <select class="form-control mb-2 mr-sm-2 mb-sm-0 populate" name="dealership" id="dealership"
                                data-plugin-selectTwo>
                            <?php
                            if ($user['type'] == 'a') {
                                foreach ($all_dealerships as $dealer) {
                                    $selected = ($dealership == $dealer['dealership']) ? ' selected' : '';
                                    ?>
                                    <option value="<?= $dealer['dealership'] ?>"<?= $selected ?>><?= $dealer['dealership'] ?></option>
                                    <?php

                                }
                            } else {
                                ?>
                                <option value="<?= $user['cron_name'] ?>"<?= ' selected' ?>><?= $user['cron_name'] ?> </option>
                                <?php
                            } ?>
                        </select>
                        &nbsp; &nbsp;
                        <button class="btn btn-primary ml-md"> Submit</button>
                    </form>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <section class="panel panel-info">
                            <header class="panel-heading">
                                <div class="panel-actions">
                                    <a href="#" class="fa fa-caret-down"></a>
                                </div>
                                <h2 class="panel-title">Monthly Fill Ups</h2>
                                <p class="panel-subtitle">Fill ups per month</p>
                            </header>
                            <div class="panel-body">
                                <!-- Flot: Bars -->
                                <div class="chart chart-md" id="monthlyFillUps"></div>
                            </div>
                        </section>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <section class="panel panel-info">
                            <header class="panel-heading">
                                <div class="panel-actions">
                                    <a href="#" class="fa fa-caret-down"></a>
                                </div>
                                <h2 class="panel-title">Monthly Views</h2>
                                <p class="panel-subtitle">Views per month</p>
                            </header>
                            <div class="panel-body">
                                <!-- Flot: Bars -->
                                <div class="chart chart-md" id="monthlyViews"></div>
                            </div>
                        </section>
                    </div>
                </div>
                <section class="panel panel-info">
                    <header class="panel-heading">
                        <div class="panel-actions">
                            <?= $flag ? '' : '<button class="btn btn-danger" id="export"> Export</button>' ?>
                        </div>
                        <h2 class="panel-title"> Report of Smart offer view and fill up information of <i><?= $dealership ?> </i></h2>
                    </header>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <table class="table table-bordered table-striped mb-none table-advanced" id="exportTable">
                                    <thead>
                                    <tr>
                                        <th class="export">Year</th>
                                        <th class="export">Month</th>
                                        <th class="export">Fill Up</th>
                                        <th class="export">View</th>
                                        <th class="export">Fill Up / View %</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    foreach ($smart_offer as $year => $value) {
                                        foreach ($value as $month => $val) { ?>
                                            <tr>
                                                <td><?= $year ?></td>
                                                <td><?= $month ?></td>
                                                <td><?= empty($val['fillUp']) ? 0 : $val['fillUp'] ?></td>
                                                <td><?= empty($val['view']) ? 0 : $val['view'] ?></td>
                                                <td><?= round((empty($val['fillUp']) ? 0 : $val['fillUp']) / (empty($val['view']) ? 0 : $val['view']) * 100.00, 3) ?> %</td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                        <?php
                                    }
                                    ?>
                                    </tbody>
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

?>
<script>

    $("#export").click(function () {
        $('table#exportTable').csvExport({
            title: 'Sold_and_active_car'
        });
    });

</script>


