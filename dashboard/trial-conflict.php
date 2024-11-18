<?php
require_once 'config.php';
require_once 'includes/loader.php';
require_once 'includes/crm-defaults.php';

session_start();

require_once ADSYNCPATH . 'config.php';
require_once ADSYNCPATH . 'Google/Util.php';
require_once ADSYNCPATH . 'utils.php';
require_once ADSYNCPATH . 'db_connect.php';
require_once ADSYNCPATH . 'tag_db_connect.php';

global $CronConfigs, $scrapper_configs;
$cron_names = array_intersect(array_keys($CronConfigs), array_keys($scrapper_configs));

$clientQuery       = "SELECT * FROM dealerships_trial_clients";
$clientQueryResult = DbConnect::get_instance()->query($clientQuery);

$dealerships_Trial_Clients = []; //stores url
$i                         = 0;
while ($row = mysqli_fetch_assoc($clientQueryResult)) {
    $dealerships_Trial_Clients[$i++] = $row['url'];
}

$otherDealerQuery       = "SELECT * FROM dealerships WHERE (status !='active' AND status != 'inactive')";
$otherDealerQueryResult = DbConnect::get_instance()->query($otherDealerQuery);

$dealerships_Other = [];
$i                 = 0;
while ($row = mysqli_fetch_assoc($otherDealerQueryResult)) {
    $dealerships_Other[$i++] = $row['websites'];
}

$dealership_names_not_in_sheet     = array_diff($dealerships_Other, $dealerships_Trial_Clients);
$dealership_names_not_in_Dashboard = array_diff($dealerships_Trial_Clients, $dealerships_Other);
$trial_Clients_With_URL            = [];

foreach ($dealership_names_not_in_Dashboard as $currentDealershipName) {
    $URLQuery                                          = "SELECT company_name FROM dealerships_trial_clients WHERE url = '$currentDealershipName'";
    $URLQueryResult                                    = DbConnect::get_instance()->query($URLQuery);
    $URLFetch                                          = mysqli_fetch_assoc($URLQueryResult);
    $trial_Clients_With_URL[$URLFetch['company_name']] = $currentDealershipName;
}

$result_data = [];
foreach ($dealership_names_not_in_sheet as $currentDealershipURL) {
    $URLQuery                             = "SELECT dealership, company_name, status FROM dealerships WHERE websites = '$currentDealershipURL'";
    $URLQueryResult                       = DbConnect::get_instance()->query($URLQuery);
    $URLFetch                             = mysqli_fetch_assoc($URLQueryResult);
    $result_data[$URLFetch['dealership']] =
        [
        'url'          => $currentDealershipURL,
        'company_name' => ucfirst(trim($URLFetch['company_name'])),
        'status'       => $URLFetch['status'],
    ];
}

include 'bolts/header.php'
?>

<div class="inner-wrapper">

<?php
$select = 'crm-trial-conflict';
include 'bolts/sidebar.php'
?>

<section role="main" class="content-body">
    <header class="page-header">
        <h2 class="panel-title"><?="Conflicts Between Trial Spreedsheet and Dashboard"?></h2>
    </header>
    <div class="row">
        <div class="col-lg-12">

            <div class="tabs">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#general" data-toggle="tab" class="text-center">
                            <i class="fa fa-book"></i> Dealerships Unavailable In Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="#budget" data-toggle="tab" class="text-center">
                            <i class="fa fa-bar-chart"></i>Dealerships Unavailable In Trial Spreedsheet
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div id="general" class="tab-pane active">
                        <div class="row">
                            <div class="col-lg-12">
                                <table class="table table-bordered table-hover table-striped mb-none table-advanced">
                                    <thead>
                                        <tr>
                                            <th>Company Name</th>
                                            <th>Website URL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
foreach ($trial_Clients_With_URL as $key => $value) {
    ?>
                                        <tr>
                                            <td> <?=checkAndSet($key)?> </td>
                                            <td><i><?=URLPrint($value)?></i></td>
                                        </tr>
                                        <?php
}
?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div id="budget" class="tab-pane">
                        <div class="row">
                            <div class="col-lg-12">
                                <table class="table table-bordered table-hover table-striped mb-none table-advanced">
                                    <thead>
                                        <tr>
                                            <th>Company Name</th>
                                            <th>Dealership Name</th>
                                            <th>Website URL</th>
                                            <th>Current Status</th>
                                            <th>Change Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
foreach ($result_data as $key => $value) {
    ?>
                                        <tr>
                                            <td> <?=checkAndSet($value['company_name'])?> </td>
                                            <td> <?=checkAndSet($key)?> </td>
                                            <td> <i><?=URLPrint($value['url'])?></i> </td>
                                            <td> <?=checkAndSet(ucfirst($value['status']))?> </td>
                                            <td>
                                                <select id="status_<?=$key?>" class="form-control" name="status_<?=$key?>">
                                                    <option value="active">Active</option>
                                                    <option value="inactive" selected="true">Inactive</option>
                                                    <option value="trial">Trial</option>
                                                    <option value="trial-setup">Trial Setup</option>
                                                    <option value="completed-trial">Completed Trial</option>
                                                    <option value="failed-trial">Failed Trial</option>
                                                </select>
                                            </td>
                                            <td>
                                                <a onclick="changeDealershipStatus('<?=$key?>')" class="btn btn-success pull-right">Update
                                                </a>
                                            </td>
                                        </tr>
                                        <?php
}
?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</div>

<?php
include 'bolts/footer.php';
