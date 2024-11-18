<?php

    error_reporting(E_ERROR | E_PARSE);

    require_once 'config.php';
    require_once 'includes/loader.php';

    session_start();

    require_once ADSYNCPATH . 'utils.php';

    //Web Providers
    $providers =
    [
        'dealer'          => '/.*dealer\.com\/.*/i', //dealer.com
        'cdkglobal'       => '/.*cdk\.com\/.*/i', //cdk.com
        'edealer'         => '/.*edealer\.ca\/.*/i', //edealer.ca
        'dealerinspire'   => '/.*dealerinspire\.com\/.*/i', //dealerinspire.com
        'dealerspike'     => '/.*dealerspike\.com\/.*/i', //dealerspike.com
        'strathcom'       => '/.*strathcom\.com\/.*/i', //strathcom.com
        'convertus'       => '/.*convertus\.com\/.*/i', //convertus.com
        'dealereprocess'  => '/.*dealereprocess\.com\/.*/i', //dealereprocess.com
        'forddirect'      => '/.*forddirect\.com\/.*/i', //forddirect.com
        'dealeron'        => '/.*dealeron\.com\/.*/i', //dealeron.com
        '360'             => '/.*360\.agency\/.*/i', //360.agency
        'dealercarsearch' => '/.*dealercarsearch\.com\/.*/i', //dealercarsearch.com
        'psone'           => '/.*psone\.ca\/.*/i', //psone.ca
        'dealerdirect'    => '/.*dealerdirect\.eu\/.*/i', //dealerdirect.eu
        'fzautomotive'    => '/.*fzautomotive\.com\/.*/i', //fzautomotive.com
        'dealerfire'      => '/.*dealerfire\.com\/.*/i', //dealerfire.com
        'psmmarketing'    => '/.*psmmarketing\.com\/.*/i', //psmmarketing.com
        'carsforsale'     => '/.*carsforsale\.com\/.*/i', //carsforsale.com
        'dealercenter'    => '/.*dealercenter\.com\/.*/i', //dealercenter.com
        'tailbase'        => '/.*tailbase\.com\/.*/', //tailbase.com
        'interactrv'      => '/.*interactrv\.com\/.*/i', //interactrv.com
        'd2cmedia'        => '/.*d2cmedia\.com\/.*/i', //d2cmedia.com
        'arinet'          => '/.*arinet\.com\/.*/i', //arinet.com
        'foxdealer'       => '/.*foxdealer\.com\/.*/i', //foxdealer.com
        'waynereaves'     => '/.*waynereaves\.com\/.*/i', //waynereaves.com
        'motorcentral'    => '/.*motorcentral\.co\.nz\/.*/i', //motorcentral.co.nz
    ];

    $show = false;

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST["check_url"])
    {
        $show       = true;
        $result     = false;
        $dealer_url = $_POST['dealer_url'];
        $response   = HttpGet($dealer_url, true, true);

        $vendor = 'N/A';

        foreach ($providers as $provider => $regex)
        {
            if (preg_match($regex, $response))
            {
                $vendor = $provider;
                $result = true;
                break;
            }
        }
    }

    include 'bolts/header.php';
?>

    <div class="inner-wrapper">

        <?php
        $select = 'check-dealer';
        include 'bolts/sidebar.php'
        ?>
        <section role="main" class="content-body">
            <header class="page-header"></header>
            <div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            <div class="panel-actions">
                                <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                            </div>
                            <h2 class="panel-title"> Please provide website url of dealer to check whether we can provide our services or not </h2>
                        </header>

                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <?=$test?>
                                    <form method="post">
                                        <div class="col-md-7" style="margin-left: -15px">
                                            <input name="dealer_url" type='input' class='form-control' placeholder="https://www.smedia.ca/" required>
                                            <input name="check_url" type="submit" value="Check" class="btn btn-primary  btn-block">

                                            <?php
                                                if ($show)
                                                {
                                                    echo '<div style="margin-top: 20px" class="well">';

                                                    if ($result)
                                                    {
                                                        echo "<h4>Website:: $dealer_url </h4>";
                                                        echo '<p> Status:: <i class="fas fa-user-check"></i> Ok</p>';
                                                        echo '<p>Note: We can Provide service.</p>';
                                                        echo 'Website Provider : ' . strtoupper($vendor);

                                                    }
                                                    else
                                                    {
                                                        echo "<h4>Website:: $dealer_url </h4>";
                                                        echo '<p> Status:: <b><i class="fas fa-user-times"></i> Not Sure</b> </p>';
                                                        echo '<p> Note: We are not sure. Please ask DEV team about this dealer.</p>';
                                                    }

                                                    echo '</div>';
                                                }
                                            ?>
                                        </div>
                                    </form>
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