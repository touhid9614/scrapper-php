<?php

    use PhpParser\Error;
    use PhpParser\NodeDumper;
    use PhpParser\ParserFactory;
    use PhpParser\Node;
    use PhpParser\Node\Expr;
    use PhpParser\Node\Scalar;
    use PhpParser\Node\Name;
    use PhpParser\Node\Expr\ArrayItem;
    use PhpParser\Node\Expr\Array_;
    use PhpParser\NodeTraverser;
    use PhpParser\NodeVisitorAbstract;
    use PhpParser\PrettyPrinter;

    require_once 'config.php';
    require_once 'includes/loader.php';

    session_start();

    require_once ADSYNCPATH . 'config.php';
    require_once ADSYNCPATH . 'Google/Util.php';
    require_once ADSYNCPATH . 'utils.php';
    require_once ADSYNCPATH . 'db_connect.php';

    require_once 'client-management/configUpdater.php';

    global $CronConfigs, $scrapper_configs, $user, $admins;

    $cron_name = filter_input(INPUT_GET, 'dealership');
    $cron_config = isset($CronConfigs[$cron_name]) ? $CronConfigs[$cron_name] : null;

    $db_connect = new DbConnect($cron_name);
    $que = $db_connect->query("SELECT bing_account_id, bing_ad_campaign FROM dealerships WHERE dealership = '$cron_name'");
    $result = mysqli_fetch_assoc($que);
    $bing_account_id = $result['bing_account_id'];
    $bing_ad_campaign = (array)unserialize($result['bing_ad_campaign']);

    $bing_ad_all_campaigns = 
    [
        "new_search" => no,
        "used_search" => no
    ];

    // delete this in future, reading from file
    $bing_account_id = isset($cron_config['bing_account_id']) ? $cron_config['bing_account_id'] : null;
    $bing_ad_campaign = isset($cron_name['bing_create']) ? $cron_name['bing_create'] : $bing_ad_all_campaigns;


    if ($_SERVER['REQUEST_METHOD'] === 'POST' && filter_input(INPUT_GET, 'dealership') === $cron_name && filter_input(INPUT_POST, 'save_bing'))
    {
        $is_valid_id = false;

//        if( empty($bing_account_id) )
//        {
            $bing_account_id = filter_input(INPUT_POST, 'bing_account_id', FILTER_SANITIZE_STRING);
            preg_match_all('/^[1-9]\d{8}$/m', $bing_account_id, $is_valid_id, PREG_SET_ORDER, 0);
            $is_valid_id = !empty($is_valid_id);
//        }
        $bing_ad_campaign = filter_input(INPUT_POST, 'bing_ad_campaign', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY);
        $bing_ad_campaign = array_merge($bing_ad_all_campaigns, $bing_ad_campaign);

        $bing_ad_campaign = array_map(function($val)
        {
            if ($val == 'yes')
            {
                return yes;
            }

            return $val;
        }, $bing_ad_campaign);

        $bing_ad_campaign_serialized = serialize($bing_ad_campaign);

        if ($is_valid_id)
        {
            $query = $db_connect->query("UPDATE dealerships SET bing_account_id='{$bing_account_id}' WHERE dealership = '{$cron_name}'");
        }

        $query = $db_connect->query("UPDATE dealerships SET bing_ad_campaign='{$bing_ad_campaign_serialized}' WHERE dealership = '{$cron_name}'");


        /* WRITE IN FILE TOO FOR NOW, LATER IT'LL BE REMOVED WHEN DATA IS READ FROM DB INSTEAD OF FILE */
        $config_file_name = get_config_path($cron_name);
        $code = file_get_contents($config_file_name);
        $parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP5);

        try
        {
            $ast = $parser->parse($code);
        }
        catch (Error $error)
        {
            echo "Parse error: {$error->getMessage()}\n";

            return;
        }

        $traverser  = new NodeTraverser();

        /* BING CUSTOMER ID UPDATER */
        if (isset($cron_config['bing_account_id']))
        {
            $traverser->addVisitor(new configUpdater(
            [
                'key'   => ['bing_account_id'],
                'value' => $bing_account_id
            ]));
        }
        else
        {
            $traverser->addVisitor(new configCreator('bing_account_id', $bing_account_id));
        }

        /* BING CAMPAIGN UPDATER */
        foreach ($bing_ad_campaign as $key => $value) 
        {
            if ($value == 1 || $value == "1")
            {
                $bing_ad_campaign[$key] = yes;
            }
            else
            {
                $bing_ad_campaign[$key] = no;
            }
        }

        if ($bing_ad_campaign == null)
        {
            $bing_ad_campaign = $bing_ad_all_campaigns;
        }

        if (isset($cron_config['bing_create']))
        {
            $traverser->addVisitor(new configUpdater(
            [
                'key'   => ['bing_create'],
                'value' => $bing_ad_campaign
            ]));
        }
        else
        {
            $traverser->addVisitor(new configCreator('bing_create', $bing_ad_campaign));
        }

        $ast                    = $traverser->traverse($ast);
        $prettyPrinter          = new ePrinter();
        $config_file_content    = $prettyPrinter->prettyPrintFile($ast);
        $config_file            = fopen($config_file_name, "w+");
        fwrite($config_file, $config_file_content);
        fclose($config_file);
    }





	include 'bolts/header.php';
?>

<div class="inner-wrapper">
<?php
    $select = 'bing_ads';
    include 'bolts/sidebar.php'
?>

    <section role="main" class="content-body">
        <header class="page-header">
            <h2> Bing Advertisements </h2>
        </header>

        <div class="row">
            <div class="col-lg-12">
                <form id="bing_ad_campaign" method="post">
                    <section class="panel">
                        <header class="panel-heading">
                            <h2 class="panel-title"> Bing </h2>
                        </header>

                        <div class="panel-body">
                            <div class="row form-group-row">
                                <div class="col-md-4">
                                    <div class="form-group <?= isset($is_valid_id) && !$is_valid_id?'has-error':'' ?>">
                                        <label class="col-sm-5 control-label" for="bing_account_id"> Bing Account ID : </label>
                                        <div class="col-sm-7">
                                            <input type="text" id="bing_account_id" name="bing_account_id"
                                                   class="form-control"
                                                   value="<?= $bing_account_id ?>"
                                                   data-current="<?= $bing_account_id ?>"
                                                   maxlength="255" data-toggle="popover" data-placement="bottom"
                                                   data-trigger="hover"
                                                   data-content="Enter your bing advertisement id.">
                                            <?php if(isset($is_valid_id) && !$is_valid_id): ?>
                                                <span id="bing_account_id-error" class="help-block">Enter 9 digit bing account ID.</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row form-group-row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <h4 class="col-sm-12">Bing ad campaigns</h4>
                                    </div>
                                </div>
                            </div>

                            <!--  Start Bing Ad Campaign  -->
                            <div class="row form-group-row">
                                <div class="col-md-4">
                                    <?php
                                    $params = ['new_search', 'used_search'];

                                    foreach ($params as $param)
                                    {
                                        $args =
                                            [
                                                'bing_ad_campaign[' . $param . ']',
                                                $param,
                                                ucwords(str_replace('_', ' ', $param)),
                                                ($bing_ad_campaign[$param] == 'yes')
                                            ];

                                        form_group_toggle_switch($args[0], $args[1], $args[2], $args[3]);
                                    }
                                    ?>
                                </div>

                            </div>
                            <!--  End Bing Ad Campaign  -->

                        </div>
                        <div class="panel-footer">
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" id="save_bing" name="save_bing" value="save_bing"
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