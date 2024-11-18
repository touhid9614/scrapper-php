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
    $emptyDealershipQuery = "SELECT customer, url FROM dealerships_billing WHERE dealership=''";
    $emptyDealershipQueryResult = DbConnect::get_instance()->query($emptyDealershipQuery);
    $unavailable_in_dashboard_mapped = [];

    while ($row = mysqli_fetch_assoc($emptyDealershipQueryResult))
    {
        $unavailable_in_dashboard_mapped[ucfirst(trim($row['customer']))] = $row['url'];
    }

    $unemptyDealershipQuery = "SELECT dealership FROM dealerships_billing WHERE dealership !=''";
    $unemptyDealershipQueryResult = DbConnect::get_instance()->query($unemptyDealershipQuery);
    $dealerships_billing_names = [];

    while ($row = mysqli_fetch_assoc($unemptyDealershipQueryResult)) 
    {
        $dealerships_billing_names[] = $row['dealership'];
    }

    $activeDealershipQuery = "SELECT dealership FROM dealerships WHERE status ='active'";
    $activeDealershipQueryResult = DbConnect::get_instance()->query($activeDealershipQuery);
    $dealerships_active = [];

    while ($row = mysqli_fetch_assoc($activeDealershipQueryResult)) 
    {
        $dealerships_active[] = $row['dealership'];
    }

    $dealership_names_not_in_sheet  = array_diff($dealerships_active,$dealerships_billing_names);
    $result_data = [];

    foreach ($dealership_names_not_in_sheet as $currentDealershipName) 
    {
        $URLQuery = "SELECT websites, company_name, status FROM dealerships WHERE dealership = '$currentDealershipName'";
        $URLQueryResult = DbConnect::get_instance()->query($URLQuery);
        $URLFetch = mysqli_fetch_assoc($URLQueryResult);
        $result_data[$currentDealershipName] = 
        [
            'url'           => $URLFetch['websites'],
            'company_name'  => ucfirst(trim($URLFetch['company_name'])),
            'status'        => $URLFetch['status']
        ];
    }

    $shouldBeTrialQuery =   "SELECT dealerships_trial_clients.company_name, dealerships.dealership, dealerships_trial_clients.url, dealerships_trial_clients.status as status_in_sheet, dealerships.status as status_in_dealerships FROM dealerships_trial_clients JOIN dealerships ON dealerships_trial_clients.company_name = dealerships.company_name WHERE dealerships.status = 'active'";
    $shouldBeTrialQueryResult = DbConnect::get_instance()->query($shouldBeTrialQuery);

    include 'bolts/header.php'
?>

<div class="inner-wrapper">

    <?php
        $select = 'crm-conflict';
        include 'bolts/sidebar.php'
    ?>

    <section role="main" class="content-body">
        <header class="page-header">
            <h2 class="panel-title"><?= "Conflicts Between Spreedsheet and Dashboard" ?></h2>
        </header>

        <div class="row">
            <div class="col-lg-12">
                <div class="tabs">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#general" data-toggle="tab" class="text-center">
                                <i class="fa fa-book"> </i> Dealerships Unavailable In dashboard
                            </a>
                        </li>

                        <li>
                            <a href="#budget" data-toggle="tab" class="text-center">
                                <i class="fa fa-bar-chart"> </i> Dealerships Unavailable In Spreedsheet
                            </a>
                        </li>

                        <li>
                            <a href="#trial-tab" data-toggle="tab" class="text-center">
                                <i class="fa fa-cube"> </i> Should Be Trial
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
                                                <th> Company Name </th>
                                                <th> Website URL </th>  
                                            </tr>
                                        </thead>
                                        <tbody>
                                    <?php
                                        foreach ($unavailable_in_dashboard_mapped as $key => $value) 
                                        {
                                    ?>
                                            <tr>
                                                <td> <?= checkAndSet($key) ?> </td>
                                                <td> <i><?= URLSplit($value) ?></i> </td>
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
                                                <th> Company Name </th>
                                                <th> Dealership Name </th>
                                                <th> Website URL </th>
                                                <th> Current Status </th>        
                                                <th> Change Status </th>            
                                                <th> Action </th>            
                                            </tr>
                                        </thead>

                                        <tbody>
                                    <?php
                                        foreach ($result_data as $key => $value) 
                                        {
                                    ?>
                                            <tr>
                                                <td> <?= checkAndSet($value['company_name']) ?> </td>
                                                <td> <?= checkAndSet($key) ?> </td>
                                                <td> <i><?= URLPrint($value['url']) ?></i> </td>
                                                <td> <?= checkAndSet(ucfirst($value['status'])) ?> </td>
                                                <td> 
                                                    <select id="status_<?= $key ?>" class="form-control" name="status_<?= $key ?>">
                                                        <option value="active">Active</option>
                                                        <option value="inactive" selected="true">Inactive</option>          
                                                        <option value="trial">Trial</option>
                                                        <option value="trial-setup">Trial Setup</option>
                                                        <option value="completed-trial">Completed Trial</option>
                                                        <option value="failed-trial">Failed Trial</option>
                                                    </select> 
                                                </td>
                                                <td>                                               
                                                    <a onclick="changeDealershipStatus('<?= $key ?>')" class="btn btn-success pull-right">Update
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

                        <div id="trial-tab" class="tab-pane"> 
                            <div class="row">
                                <div class="col-lg-12">
                                    <table class="table table-bordered table-hover table-striped mb-none table-advanced">
                                        <thead>
                                            <tr>
                                                <th>Company Name</th>
                                                <th>Dealership Name</th>
                                                <th>Website URL</th>
                                                <th>Status In Spreedsheet</th>
                                                <th>Status In Dealerships</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                    <?php
                                        while ($row =  mysqli_fetch_assoc($shouldBeTrialQueryResult))
                                        { 
                                    ?>
                                            <tr>
                                                <td> <?= checkAndSet(ucfirst(trim($row['company_name']))) ?> </td>
                                                <td> <?= checkAndSet($row['dealership']) ?> </td>
                                                <td><i> <?= URLSplit($row['url']) ?></i> </td>
                                                <td> <?= checkAndSet(ucfirst($row['status_in_sheet'])) ?> </td>
                                                <td> <?= checkAndSet(ucfirst($row['status_in_dealerships'])) ?> </td>
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