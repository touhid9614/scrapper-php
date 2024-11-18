<?php

require_once 'config.php';
require_once 'includes/loader.php';

session_start();

require_once ADSYNCPATH . 'config.php';
require_once ADSYNCPATH . 'Google/Util.php';
require_once ADSYNCPATH . 'utils.php';
require_once ADSYNCPATH . 'db_connect.php';
require_once 'configuration-manager/smart-offer-template.php';
require_once 'configuration-manager/config-processor.php';

global $config_templates, $user;

$cron_name = $user['cron_name'];

$cron_config     = isset($CronConfigs[$cron_name]) ? $CronConfigs[$cron_name] : null;
$scrapper_config = isset($scrapper_configs[$cron_name]) ? $scrapper_configs[$cron_name] : null;

if (!$cron_config || !$scrapper_config) {
    die("Error: Unable to find configuration for {$cron_name}");
}

$lead_config = key_exists('lead', $cron_config) ? $cron_config['lead'] : null;

$smart_offer_template = [
    'smart-offer' => $config_templates['smart_offer'],
];

$lead_config['enable_adf'] = isset($lead_config['special_to']) ? 'yes' : '';

if (!isset($lead_config['lead_in']) && $scrapper_config['vdp_url_regex']) {
    $lead_config['lead_in'] = [
        'vdp'  => $scrapper_config['vdp_url_regex'],
        'service_regex' => '',
    ];
}

if (isset($lead_config['lead_in']) && !is_array($lead_config['lead_in'])) {
    $lead_config['lead_in'] = ['' => $lead_config['lead_in']];
}

if (isset($lead_config['lead_in'])) {
    foreach ($lead_config['lead_in'] as $name => $regex) {
        $named_config                                = config_keys_enclosed($config_templates['smart_offer_single'], "lead[{$name}]");
        $named_config['name']                        = "Smart Offer ({$name})";
        $smart_offer_template["smart-offer-{$name}"] = $named_config;
    }

    $lead_config['lead_in'] = array_asoc_to_pair($lead_config['lead_in']);
}

$lead_data = ['enable_smart-offer' => !!$lead_config, 'lead' => $lead_config];

include 'bolts/header.php'
?>

<div class="inner-wrapper">

<?php
$select = 'config-smart-offer';
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
                        <h2 class="panel-title">sMart Offer Configuration :: <?=$cron_name?></h2>
                    </header>

                    <div id="config-manager" class="panel-body">

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
    (function($) {
        smedia_prepare_configuration($);
        sMedia.Configuration.init('#config-manager',
        <?=json_encode($smart_offer_template)?>,
        <?=json_encode(array_remake($lead_data))?>);
        sMedia.Configuration.render();
    })(jQuery);
</script>