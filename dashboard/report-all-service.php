<?php

require_once 'config.php';
require_once 'includes/loader.php';
require_once ADSYNCPATH . 'db_connect.php';
require_once ADSYNCPATH . 'utils.php';


$dealerData = DbConnect::get_instance()->get_all_dealers("status like '%'");

$campaign_types = [
    'smedia_inventory' => 'sMedia Inventory',
    'dynamic_social_retargeting' => 'Dynamic Social Retargeting',
    'facebook_marketplace' => 'Facebook Marketplace',
    'smart_offer' => 'Smart Offer',
    'clean_click' => 'Clean Click',
    'social_lead_ads' => 'Social Lead Ads',
    'generic_social_ads' => 'Generic Social Ads',
    'generic_adwords_campaign' => 'Generic Adwords Campaign',
    'youtube-campaign' => 'YouTube Campaign',
    'bing-ads' => 'Bing Ads',
    'ai-buttons' => 'AI Buttons',
    'ai-buttons-trial' => 'AI Buttons Trial',
    'custom' => 'Custom',
    'smart-banner' => 'smart-banner',
];
$service_count=[];
foreach ($campaign_types as $id =>$type){
    $service_count[$type] = 0 ;
}
$count = [];
$replaceValue = ["-", "_"];

?>

<?php include 'bolts/header.php' ?>

<div class="inner-wrapper">

    <?php
    $select = 'dealer-status-service';
    include 'bolts/sidebar.php'
    ?>

    <section role="main" class="content-body">

        <header class="page-header">

        </header>
        <div class="row">
            <div class="col-lg-12">

                <section class="panel panel-info">
                    <header class="panel-heading">
                        <h2 class="panel-title"> Report of All dealer Active services</h2>
                    </header>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <table class="table table-bordered table-striped mb-none table-advanced">
                                    <thead>
                                    <tr>
                                        <th> Company Name </th>
                                        <th> Dealership Name </th>
                                        <th> Website </th>
                                        <th> Status </th>
                                        <?php foreach ($campaign_types as $campaign_id => $campaign_type): ?>
                                            <th><?= $campaign_type ?> </th>
                                        <?php endforeach; ?>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($dealerData as $dealer): ?>
                                        <tr>
                                            <td> <?= $dealer['company_name'] ?> </td>
                                            <td>
                                                <a href="details.php?dealership=<?= $dealer['dealership'] ?>"><?= $dealer['dealership'] ?></a>
                                            </td>
                                            <td>
                                                <a href="<?= $dealer['websites'] ?>"><?= $dealer['websites'] ?></a>
                                            </td>
                                            <td style="color:<?= $dealer['status'] == 'active' || $dealer['status'] == 'trial' ? 'green' : 'red' ?>"> <?= $dealer['status'] ?> </td>
                                            <?php $count[$dealer['status']]++; ?>

                                            <?php foreach ($campaign_types as $campaign_id => $campaign_type): ?>
                                                <?php
                                                $color = 'black';
                                                $font = 'normal';
                                                $value = 'No';

                                                if (in_array($campaign_type, $dealer['campaign_types']))
                                                {
                                                    $color = 'green';
                                                    $value = 'YES';
                                                    $font = 'bold';
                                                    $service_count[$campaign_type]++;
                                                }

                                                ?>
                                                <td style="color: <?= $color ?>;font-weight:<?= $font ?>"><?= $value ?> </td>
                                            <?php endforeach; ?>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th> Total</th>
                                        <th><?= count($dealerData) ?></th>
                                        <th>
                                        </th>
                                        <?php foreach ($campaign_types as $campaign_id => $campaign_type): ?>
                                            <th><?= $service_count[$campaign_type] ?></th>
                                        <?php endforeach; ?>
                                    </tr>
                                    </tfoot>
                                </table>

                            </div>
                        </div>
                    </div>


                </section>
            </div>
            <div class="col-lg-6">
                <section class="panel panel-featured panel-featured-primary">
                    <header class="panel-heading">
                        <div class="panel-actions">
                            <a href="#" class="panel-action panel-action-toggle" data-panel-toggle=""></a>
                        </div>

                        <h2 class="panel-title">Statistics of number of dealerships</h2>
                    </header>
                    <div class="panel-body" style="display: block;">
                        <table class="table table-bordered">
                            <tr>
                                <th>Total Number Of Dealerships</th>
                                <th><?= count($dealerData) ?></th>
                            </tr>
                        <?php foreach ($count as $type => $number): ?>
                        <tr>
                            <td><?= ucwords(str_replace($replaceValue, ' ', $type))  ?></td>
                            <th><?= $number ?></th>
                        </tr>
                        <?php endforeach; ?>
                        </table>
                    </div>
                </section>
            </div>
            <div class="col-lg-6">
                <section class="panel panel-featured panel-featured-warning">
                    <header class="panel-heading">
                        <div class="panel-actions">
                            <a href="#" class="panel-action panel-action-toggle" data-panel-toggle=""></a>
                        </div>

                        <h2 class="panel-title">Statistics of total service number of dealerships</h2>
                    </header>
                    <div class="panel-body" style="display: block;">
                        <table class="table table-bordered">
                        <?php foreach ($service_count as $type => $number): ?>
                            <tr>
                                <td><?= ucwords(str_replace($replaceValue, ' ', $type)) ?></td>
                                <th><?= $number ?></th>
                            </tr>
                        <?php endforeach; ?>
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

