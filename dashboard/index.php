<?php
require_once 'config.php';
require_once 'includes/loader.php';
global $user;
?>
    <?php include 'bolts/header.php' ?>
<div class="inner-wrapper">
<?php $select = 'Dashboard';
include 'bolts/sidebar.php'
?>
    <script>
        var dashboard = true;
    </script>
    <section role="main" class="content-body">
        <header class="page-header"> </header>
        <!-- start: page -->
        <div class="row">
            <div class="col-md-6 col-lg-12 col-xl-6">
                <section class="panel">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="chart-data-selector" id="salesSelectorWrapper">
                                    <h2>Long Term Stats:                                        <strong>                                            <select class="form-control" id="salesSelector">                                                <option value="Porto Admin" selected>Clicks</option>                                                <option value="Porto Drupal" >Impressions</option>                                                <option value="Porto Wordpress" >CTR</option>                                            </select>                                        </strong>                                    </h2>
                                    <div id="salesSelectorItems" class="chart-data-selector-items mt-sm">
                                        <!-- Flot: Sales Porto Admin -->
                                        <div class="chart chart-sm" data-sales-rel="Porto Admin" id="yearlyClicks" class="chart-active"></div>
                                        <!-- Flot: Sales Porto Drupal -->
                                        <div class="chart chart-sm" data-sales-rel="Porto Drupal" id="yearlyImpressions" class="chart-hidden"></div>
                                        <!-- Flot: Sales Porto Wordpress -->
                                        <div class="chart chart-sm" data-sales-rel="Porto Wordpress" id="yearlyCTR" class="chart-hidden"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 text-center">
                                <h2 class="panel-title mt-md">Budget</h2>
                                <div class="liquid-meter-wrapper liquid-meter-sm mt-lg">
                                    <div class="liquid-meter">
                                        <meter min="0" max="100" value="0" id="meterBudget"></meter>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <div class="col-md-6 col-lg-12 col-xl-6">
                <div class="row">
                    <div class="col-md-12 col-lg-6 col-xl-6">
                        <section class="panel panel-featured-left panel-featured-secondary">
                            <div class="panel-body">
                                <div class="widget-summary">
                                    <div class="widget-summary-col widget-summary-col-icon">
                                        <div class="summary-icon bg-secondary"> <i class="fa fa-location-arrow fa-flip-horizontal"></i> </div>
                                    </div>
                                    <div class="widget-summary-col">
                                        <div class="summary">
                                            <h4 class="title">Clicks</h4>
                                            <div class="info"> <strong class="amount" id="totalClicks">0</strong> </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                    <div class="col-md-12 col-lg-6 col-xl-6">
                        <section class="panel panel-featured-left panel-featured-tertiary">
                            <div class="panel-body">
                                <div class="widget-summary">
                                    <div class="widget-summary-col widget-summary-col-icon">
                                        <div class="summary-icon bg-tertiary"> <i class="fa fa-desktop"></i> </div>
                                    </div>
                                    <div class="widget-summary-col">
                                        <div class="summary">
                                            <h4 class="title">Impressions</h4>
                                            <div class="info"> <strong class="amount" id="totalImpressions">0</strong> </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                    <div class="col-md-12 col-lg-6 col-xl-6">
                        <section class="panel panel-featured-left panel-featured-quartenary">
                            <div class="panel-body">
                                <div class="widget-summary">
                                    <div class="widget-summary-col widget-summary-col-icon">
                                        <div class="summary-icon bg-success"> <i class="fa fa-paper-plane"></i> </div>
                                    </div>
                                    <div class="widget-summary-col">
                                        <div class="summary">
                                            <h4 class="title">CTR</h4>
                                            <div class="info"> <strong class="amount" id="totalCTR">0.00%</strong> </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                    <div class="col-md-12 col-lg-6 col-xl-6">
                        <section class="panel panel-featured-left panel-featured-primary">
                            <div class="panel-body">
                                <div class="widget-summary">
                                    <div class="widget-summary-col widget-summary-col-icon">
                                        <div class="summary-icon bg-primary"> <i class="fa fa-usd"></i> </div>
                                    </div>
                                    <div class="widget-summary-col">
                                        <div class="summary">
                                            <h4 class="title">Spent</h4>
                                            <div class="info"> <strong class="amount" id="totalCost">$0.00</strong> </div>
                                        </div>
                                        <div class="summary-footer"> </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <section class="panel">
                    <header class="panel-heading">
                        <div class="panel-actions">
                            <a href="#" class="fa fa-caret-down"></a>
                        </div>
                        <h2 class="panel-title">Monthly Clicks</h2>
                        <p class="panel-subtitle">Details clicks by day</p>
                    </header>
                    <div class="panel-body">
                        <!-- Flot: Bars -->
                        <div class="chart chart-md" id="monthlyClicks"></div>
                    </div>
                </section>
            </div>
            <div class="col-md-12">
                <section class="panel">
                    <header class="panel-heading">
                        <div class="panel-actions">
                            <a href="#" class="fa fa-caret-down"></a>
                        </div>
                        <h2 class="panel-title">Monthly Impressions</h2>
                        <p class="panel-subtitle">Details impressions by day</p>
                    </header>
                    <div class="panel-body">
                        <!-- Flot: Bars -->
                        <div class="chart chart-md" id="monthlyImpressions"></div>
                    </div>
                </section>
            </div>
            <div class="col-md-12">
                <section class="panel">
                    <header class="panel-heading">
                        <div class="panel-actions">
                            <a href="#" class="fa fa-caret-down"></a>
                        </div>
                        <h2 class="panel-title">Monthly CTR</h2>
                        <p class="panel-subtitle">Details CTR Rate by day</p>
                    </header>
                    <div class="panel-body">
                        <!-- Flot: Bars -->
                        <div class="chart chart-md" id="monthlyCTR"></div>
                    </div>
                </section>
            </div>
        </div>
    </section>
</div>
<?php include 'bolts/footer.php' ?>