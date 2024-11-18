<?php
require_once 'config.php';
require_once 'includes/loader.php';
require_once 'includes/crm-defaults.php';

session_start();

require_once ADSYNCPATH . 'config.php';
require_once ADSYNCPATH . 'Google/Util.php';
require_once ADSYNCPATH . 'utils.php';
require_once ADSYNCPATH . 'db_connect.php';

global $user;
$cron_name = filter_input(INPUT_GET, 'dealership');
if(!$cron_name) {
    $cron_name = $user['cron_name'];
}

$selectedFeatures = [
    'dealership'    => 'Dealership',
    'url'           => 'URL',
    'page_view'     => 'PageView', 
    'time30s'       => 'Time > 30 Secons',
    'time60s'       => 'Time > 60 Seconds', 
    'time90s'       => 'Time > 90 Seconds',
    'scroll25'      => 'Scroll > 25',
    'scroll50'      => 'Scroll > 50',
    'scroll75'      => 'Scroll > 75',
    'scroll100'     => 'Scroll 100',
    'button_click'  => 'Button Click',
    'image_hovered' => 'Image Hovered',
    'image_clicked' => 'Image Clicked',
    'time_on_inventory' => 'Time On Inventory',
    'deleted'       => 'Status(0=Unsold, 1 = Sold)',
    'last_updated'     => 'Last Updated' 
];

$feature_data_query = DbConnect::get_instance()->query("SELECT * FROM salematrix_featuredata_all WHERE dealership = '$cron_name'");
$feature_data = [];
while ($record = mysqli_fetch_assoc($feature_data_query)) {
    $feature_data[] = $record;
}

include 'bolts/header.php'
?>

<div class="inner-wrapper">
    <?php
    $select = 'engaged-user';
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
                        <h2 class="panel-title">Calculate Feature Data for :: <?= $cron_name ?></h2>
                    </header>
                    <div class="panel-body">
                        <form method="GET" class="form-inline">
                            <label class="mb-2 mr-sm-2 mb-sm-0 ml-md" for="dealership">Dealership</label>
                            <select class="form-control mb-2 mr-sm-2 mb-sm-0 populate" name="dealership" id="dealership" data-plugin-selectTwo>
                                <?php
                                if ($user['type'] == 'a') {
                                    foreach ($cron_names as $c_name) {
                                        $selected = ($cron_name == $c_name) ? ' selected' : '';
                                        ?>
                                        <option value="<?= $c_name ?>"<?= $selected ?>><?= $c_name ?></option>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <option value="<?= $user['cron_name'] ?>"<?= ' selected' ?>><?= $user['cron_name'] ?> </option>
                                <?php } ?>
                            </select>
                            <button class="btn btn-primary ml-md"> Submit </button>                             
                        </form>
                    </div>
                </section>
            </div>



            <div class="col-lg-12">
                <section class="panel">

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <table class="table table-bordered table-striped mb-none table-advanced">
                                    <thead>
                                        <tr>
                                           <?php
                                            foreach ($selectedFeatures as $key => $value) {
                                                echo "<th> $value </th>";
                                            }
                                            ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($feature_data as $row_data) {  ?>
                                            <tr>
                                            <?php foreach ($row_data as $key => $value):
                                                if($key == 'url') { 
                                                    ?>
                                                    <td><a href="<?= $key ?>" target="_blank">
                                                        <i><?= $key ?></i>
                                                    </a></td> 
                                                <?php } else {
                                                    echo '<td>' . $value . '</td>';
                                                } ?>
                                            <?php endforeach; ?>  
                                            </tr>
                                        <?php } ?>
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