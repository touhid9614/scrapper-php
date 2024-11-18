<?php

    require_once 'config.php';
    require_once 'includes/loader.php';
    // require_once 'includes/crm-defaults.php';

    session_start();

    require_once ADSYNCPATH . 'config.php';
    require_once ADSYNCPATH . 'Google/Util.php';
    require_once ADSYNCPATH . 'utils.php';
    require_once ADSYNCPATH . 'db_connect.php';

    $client_type = filter_input(INPUT_GET, 'client_type');
    $country_name = filter_input(INPUT_GET, 'country_name');
    $state = filter_input(INPUT_GET, 'state');


    $where = "(status = 'inactive' OR status = '' OR status = 'failed-trial')";

    if (!empty($client_type))
    {
        $where .= ' AND saler_type =' . "'$client_type'";
    }

    if (!empty($country_name))
    {
        $where .= ' AND country_name =' . "'$country_name'";
    }

    if (!empty($state))
    {
        $where .= ' AND state =' . "'$state'";
    }

    $dbQueryString = "SELECT dealership, websites, status, company_name FROM dealerships WHERE $where";
    $result = DbConnect::get_instance()->query($dbQueryString);
    $dealership_data = [];

    while ($row = mysqli_fetch_assoc($result))
    {
        $dealership_data[$row['dealership']]['url']     = $row['websites'];
        $dealership_data[$row['dealership']]['status']  = ucfirst($row['status']);
        $dealership_data[$row['dealership']]['company'] = ucfirst(trim($row['company_name']));

        if ($dealership_data[$row['dealership']]['company'] == '')
        {
            $dealership_data[$row['dealership']]['company'] = ucfirst($row['dealership']);
        }
    }

    $state_result = DbConnect::get_instance()->query("SELECT DISTINCT(state) AS state FROM dealerships WHERE CHAR_LENGTH(state) > 0");
    $state_data = [];

    while ($row = mysqli_fetch_assoc($state_result))
    {
        $state_data[] = $row['state'];
    }

    include 'bolts/header.php';
?>

<div class="inner-wrapper">

    <?php
        $select = 'crm-inactive';
        include 'bolts/sidebar.php';
    ?>

    <section role="main" class="content-body">
        <header class="page-header">

        </header>
        <div class="row">
            <form id="filter-form" method="GET" class="form-horizontal form-bordered">
                <div class="col-lg-12">
                    <section class="panel panel-info">
                        <header class="panel-heading">
                            <div class="panel-actions">
                                <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                            </div>
                            <h2 class="panel-title"> Filters </h2>
                        </header>

                        <div class="panel-body">
                            <div class="row mb-md">                             
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label"> Client Type </label>
                                        <div class="col-md-8">
                                            <select class="form-control" name="client_type" data-plugin-multiselect data-plugin-options='{ "maxHeight": 200 }'>
                                                <option value="" <?= !$client_type ? 'selected=""' : '' ?>>Any</option>
                                                <option value="Dealership" <?= $client_type == 'Dealership' ? 'selected=""' : '' ?>>Dealership</option>
                                                <option value="Local" <?= $client_type == 'Local' ? 'selected=""' : '' ?>>Local</option>
                                            </select>
                                        </div>
                                    </div>                                 
                                </div>

                                <div class="col-md-4 col-sm-6">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Country</label>
                                        <div class="col-sm-8">
                                            <select class="form-control" name="country_name">
                                                <option value=""> -Select Country- </option>
                                                <option value="USA" <?= $country_name == 'USA' ? 'selected=""' : '' ?>>USA</option>
                                                <option value="Canada" <?= $country_name == 'Canada' ? 'selected=""' : '' ?>>Canada</option>
                                            </select>
                                        </div>
                                    </div>                                   
                                </div>

                                <div class="col-md-4 col-sm-6">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">State</label>
                                        <div class="col-sm-8">
                                            <select class="form-control" name="state">
                                                <option value=""> -Select State- </option>
                                                <?php foreach ($state_data as $key => $val): ?>
                                                    <option value='<?= $val ?>' <?= ($state == $val) ? 'selected' : '' ?>> <?= $val ?>
                                                    </option>
                                                <?php endforeach; ?>                                                                                          
                                            </select>
                                        </div>
                                    </div>                                   
                                </div>
                            </div>

                            <div class="row mb-md">
                                <div class="col-md-6 col-sm-12"> </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label"></label>
                                        <div class="col-sm-8 clearfix">
                                            <button id="btn-filter" type="submit" class="btn btn-info mr-xs pull-right ml-xs">Apply Filter</button>
                                            <a href="crm-inactive.php" class="btn btn-default pull-right">Clear</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

                <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            <div class="panel-actions">

                            </div>
                            <h2 class="panel-title" style="text-align: center;">List of Inactive/Failed Trial Dealership</h2>
                        </header>

                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12 conflict-table">
                                    <table class="table table-bordered table-striped mb-none table-advanced">
                                        <thead>
                                            <tr>
                                                <th> Company Name </th>
                                                <th> Dealership Name </th>
                                                <th> Website URL </th>
                                                <th> Current Status </th>
                                                <th> Change Status </th>
                                                <th> Action </th>
                                            </tr>
                                        </thead>
                                        
                                        <tbody>
                                            <?php foreach ($dealership_data as $key => $value): ?>
                                                <tr>
                                                    <td> <?= $dealership_data[$key]['company'] ?> </td>
                                                    <td> <?= $key ?> </td>
                                                    <td> <i> <?= URLPrint($dealership_data[$key]['url']) ?> </i> </td>
                                                    <td> <?= $dealership_data[$key]['status'] ?> </td>
                                                    <td> 
                                                        <select id="status_<?= $key ?>" class="form-control" name="status_<?= $key ?>">
                                                            <option value="active" selected="true"> Active </option>       
                                                            <option value="trial"> Trial </option>
                                                            <option value="trial-setup"> Trial Setup </option>
                                                            <option value="completed-trial"> Completed Trial </option>
                                                        </select>
                                                    </td>
                                                    <td>          
                                                        <a onclick="changeDealershipStatus('<?= $key ?>')" class="btn btn-success pull-right">Update</a> 
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </form>
        </div>
    </section>
</div>

<?php
    include 'bolts/footer.php';