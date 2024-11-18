<?php

use PhpParser\Error;
use PhpParser\NodeTraverser;
use PhpParser\ParserFactory;

require_once 'config.php';
require_once 'includes/loader.php';

session_start();

require_once ADSYNCPATH . 'config.php';
require_once ADSYNCPATH . 'Google/Util.php';
require_once ADSYNCPATH . 'utils.php';
require_once ADSYNCPATH . 'db_connect.php';

require_once 'client-management/configUpdater.php';

global $CronConfigs, $scrapper_configs, $user, $admins;

$cron_name   = filter_input(INPUT_GET, 'dealership');
$cron_config = isset($CronConfigs[$cron_name]) ? $CronConfigs[$cron_name] : null;

$db_connect         = new DbConnect($cron_name);
$que                = $db_connect->query("SELECT google_account_id, google_ad_campaign FROM dealerships WHERE dealership = '$cron_name'");
$result             = mysqli_fetch_assoc($que);
$google_account_id  = $result['google_account_id'];
$google_ad_campaign = (array) unserialize($result['google_ad_campaign']);

$google_ad_all_campaigns = [
    "new_search"        => no,
    "used_search"       => no,
    "new_placement"     => no,
    "used_placement"    => no,
    "new_display"       => no,
    "used_display"      => no,
    "new_retargeting"   => no,
    "used_retargeting"  => no,
    "new_marketbuyers"  => no,
    "used_marketbuyers" => no,
    "new_combined"      => no,
    "used_combined"     => no,
];

// delete this in future, reading from file
$google_account_id  = isset($cron_config['customer_id']) ? $cron_config['customer_id'] : null;
$google_ad_campaign = isset($cron_name['create']) ? $cron_name['create'] : $google_ad_all_campaigns;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && filter_input(INPUT_GET, 'dealership') === $cron_name && filter_input(INPUT_POST, 'save_google')) {
    $is_valid_id = false;
    $google_account_id = filter_input(INPUT_POST, 'google_account_id', FILTER_SANITIZE_STRING);

    preg_match_all('/^\d{3}-\d{3}-\d{4}$/m', $google_account_id, $is_valid_id, PREG_SET_ORDER, 0);
   
    $is_valid_id = !empty($is_valid_id);
    $google_ad_campaign = filter_input(INPUT_POST, 'google_ad_campaign', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY);
    $google_ad_campaign = array_merge($google_ad_all_campaigns, $google_ad_campaign);

    $google_ad_campaign = array_map(function ($val) {
        if ($val == 'yes') {
            return yes;
        }

        return $val;
    }, $google_ad_campaign);

    $google_ad_campaign_serialized = serialize($google_ad_campaign);

    if ($is_valid_id) {
        $query = $db_connect->query("UPDATE dealerships SET google_account_id='{$google_account_id}' WHERE dealership = '{$cron_name}'");
    }

    $query = $db_connect->query("UPDATE dealerships SET google_ad_campaign='{$google_ad_campaign_serialized}' WHERE dealership = '{$cron_name}'");

    /* WRITE IN FILE TOO FOR NOW, LATER IT'LL BE REMOVED WHEN DATA IS READ FROM DB INSTEAD OF FILE */
    $config_file_name = get_config_path($cron_name);
    $code             = file_get_contents($config_file_name);
    $parser           = (new ParserFactory)->create(ParserFactory::PREFER_PHP5);

    try {
        $ast = $parser->parse($code);
    } catch (Error $error) {
        echo "Parse error: {$error->getMessage()}\n";
        return;
    }

    $traverser = new NodeTraverser();

    /* GOOGLE CUSTOMER ID UPDATER */
    if (isset($cron_config['customer_id'])) {
        $traverser->addVisitor(new configUpdater([
            'key'   => ['customer_id'],
            'value' => $google_account_id,
        ]));
    } else {
        $traverser->addVisitor(new configCreator('customer_id', $google_account_id));
    }

    /* GOOGLE CAMPAIGN UPDATER */
    foreach ($google_ad_campaign as $key => $value) {
        if ($value == 1 || $value == "1") {
            $google_ad_campaign[$key] = yes;
        } else {
            $google_ad_campaign[$key] = no;
        }
    }

    if ($google_ad_campaign == null) {
        $google_ad_campaign = $google_ad_all_campaigns;
    }

    if (isset($cron_config['create'])) {
        $traverser->addVisitor(new configUpdater([
            'key'   => ['create'],
            'value' => $google_ad_campaign,
        ]));
    } else {
        $traverser->addVisitor(new configCreator('create', $google_ad_campaign));
    }

    $ast                 = $traverser->traverse($ast);
    $prettyPrinter       = new ePrinter();
    $config_file_content = $prettyPrinter->prettyPrintFile($ast);
    $config_file         = fopen($config_file_name, "w+");
    fwrite($config_file, $config_file_content);
    fclose($config_file);
}

include 'bolts/header.php';
?>

<div class="inner-wrapper">
    <?php
    $select = 'google_ads';
    include 'bolts/sidebar.php'
    ?>

    <section role="main" class="content-body">
        <header class="page-header">
            <h2> Google Advertisements </h2>
        </header>

        <div class="row">
            <div class="col-lg-12">
                <form id="google_ad_campaign" method="post">
                    <section class="panel">
                        <header class="panel-heading">
                            <h2 class="panel-title"> Google </h2>
                        </header>

                        <div class="panel-body">
                            <div class="row form-group-row">
                                <div class="col-md-4">
                                    <div class="form-group <?= isset($is_valid_id) && !$is_valid_id?'has-error':'' ?>">
                                        <label class="col-sm-5 control-label" for="google_account_id"> Google
                                            Advertisement ID : </label>
                                        <div class="col-sm-7">
                                            <input type="text" id="google_account_id" name="google_account_id"
                                                   class="form-control"
                                                   placeholder="xxx-xxx-xxxx" value="<?= $google_account_id ?>"
                                                   data-current="<?= $google_account_id ?>"
                                                   maxlength="255" data-toggle="popover" data-placement="bottom"
                                                   data-trigger="hover"
                                                   data-content="Enter your 10 digit google advertisement id in xxx-xxx-xxxx format.">
                                            <?php if (isset($is_valid_id) && !$is_valid_id): ?>
                                                <span id="google_account_id-error" class="help-block">Enter 10 digit google account ID in xxx-xxx-xxxx format.</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row form-group-row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <h4 class="col-sm-12">Google ad campaigns</h4>
                                    </div>
                                </div>
                            </div>


                            <!--  Start Google Ad Campaign  -->
                            <div class="row form-group-row">
                                <div class="col-md-4">
                                    <?php
                                    $params = ['new_search', 'used_search', 'new_marketbuyers', 'used_marketbuyers'];

                                    foreach ($params as $param)
                                    {
                                        $args =
                                        [
                                            'google_ad_campaign[' . $param . ']',
                                            $param,
                                            ucwords(str_replace('_', ' ', $param)),
                                            ((bool)$google_ad_campaign[$param] == yes)
                                        ];

                                        form_group_toggle_switch($args[0], $args[1], $args[2], $args[3]);
                                    }
                                    ?>
                                </div>

                                <div class="col-md-4">
                                    <?php
                                    $params = ['new_display', 'used_display', 'new_combined', 'used_combined'];

                                    foreach ($params as $param)
                                    {
                                        $args =
                                        [
                                            'google_ad_campaign[' . $param . ']',
                                            $param,
                                            ucwords(str_replace('_', ' ', $param)),
                                            ((bool)$google_ad_campaign[$param] == yes)
                                        ];

                                        form_group_toggle_switch($args[0], $args[1], $args[2], $args[3]);
                                    }
                                    ?>
                                </div>

                                <div class="col-md-4">
                                    <?php
                                    $params = ['new_retargeting', 'used_retargeting', 'new_placement', 'used_placement'];

                                    foreach ($params as $param)
                                    {
                                        $args =
                                        [
                                            'google_ad_campaign[' . $param . ']',
                                            $param,
                                            ucwords(str_replace('_', ' ', $param)),
                                            ((bool)$google_ad_campaign[$param] == yes)
                                        ];

                                        form_group_toggle_switch($args[0], $args[1], $args[2], $args[3]);
                                    }
                                    ?>
                                </div>
                            </div>
                            <!--  End Google Ad Campaign  -->
                        </div>
                        
                        <div class="panel-footer">
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" id="save_google" name="save_google" value="save_google"
                                            class="btn btn-primary pull-right"> Save Changes
                                    </button>
                                </div>
                            </div>
                        </div>
                    </section>
                </form>
            </div>
        </div>
    </section>
</div>

<?php
    include 'bolts/footer.php';
