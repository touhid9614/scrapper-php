<?php

require_once 'config.php';
require_once 'includes/loader.php';
require_once ADSYNCPATH . 'config.php';
require_once ADSYNCPATH . 'Google/Util.php';
require_once ADSYNCPATH . 'db_connect.php';
require_once ADSYNCPATH . 'utils.php';
require_once ADSYNCPATH . 'ajax-misc.php';

use Predis\Client as RedisClient;

global $connection, $user, $website_tag, $website_tag_new, $website_banner,
$email_tag, $tag_state, $redis, $redis_config;

$cron_name   = $user['cron_name'];
$cron_config = $user['cron_config'];

$db_connect = new DbConnect($cron_name);
$db_connect->create_meta_table('tracking_ids');
$all_dealerships = DbConnect::get_instance()->get_all_dealers(1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    switch (filter_input(INPUT_POST, 'action')) {
        case 'update_tracking_id': {
                $db_connect->update_meta('tracking_ids', "{$cron_name}_analytics_tracking_id", filter_input(INPUT_POST, 'analytics-id'));
                $db_connect->update_meta('tracking_ids', "{$cron_name}_facebook_pixel_id", filter_input(INPUT_POST, 'facebook-id'));
                $db_connect->update_meta('tracking_ids', "{$cron_name}_snapchat_pixel_id", filter_input(INPUT_POST, 'snapchat-id'));
                $db_connect->update_meta('tracking_ids', "{$cron_name}_adwords_tracking_id", filter_input(INPUT_POST, 'adwords-id'));
                $db_connect->update_meta('tracking_ids', "{$cron_name}_bing_tag_id", filter_input(INPUT_POST, 'bing-id'));
                break;
            }
        case 'clear_tag_cache': {
                clear_tag_cache($cron_name);
                break;
            }
    }
}

$website_tag_new = <<<NEW_TAG_SCRIPT_CODE
<script type="text/javascript" src="https://tm.smedia.ca/analytics/script.js" async></script>
NEW_TAG_SCRIPT_CODE;

$analytics_tracking_id  = $db_connect->get_meta('tracking_ids', "{$cron_name}_analytics_tracking_id");
$facebook_pixel_id      = $db_connect->get_meta('tracking_ids', "{$cron_name}_facebook_pixel_id");
$snapchat_pixel_id      = $db_connect->get_meta('tracking_ids', "{$cron_name}_snapchat_pixel_id");
$adwords_tracking_id    = $db_connect->get_meta('tracking_ids', "{$cron_name}_adwords_tracking_id");
$bing_tag_id            = $db_connect->get_meta('tracking_ids', "{$cron_name}_bing_tag_id");

$db_connect->close_connection();

if (!$redis) {
    $redis = new RedisClient($redis_config);
}

$tag_state_key   = 'tag_state_' . $cron_name . '_any';
$tag_last_loaded = (int)($redis->get($tag_state_key));

$common_check_message 	= "<i class=\"fa fa-check\"></i>";
$common_close_message 	= "<i class=\"fa fa-times\"></i>";
$tag_loaded 			= null;
$last_loaded 			= 'Last Loaded: Unknown';

if ($tag_last_loaded) {
    $tag_loaded = time() - $tag_last_loaded;

    if ($tag_loaded <= 6 * 3600) {
        $tag_text = '<span class="text-success">' . $common_check_message . ' INSTALLED</span>';
    } else if ($tag_loaded < 24 * 3600) {
        $tag_text = '<span class="text-warning">' . $common_close_message . ' WARNING</span>';
    } else {
        $tag_text = '<span class="text-danger">' . $common_close_message . ' NOT INSTALLED</span>';
    }

    $last_loaded = 'Last Loaded: ' . date ("d F Y H:i:s", $tag_last_loaded);
}
