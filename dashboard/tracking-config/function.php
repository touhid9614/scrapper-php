<?php

$db_connect = new DbConnect();

global $default_tag_config;

require_once __DIR__ . '/defeault_tag_config.php';

$account_config = $default_tag_config;

/**
 * Gets the account identifier.
 *
 * @param      <type>  $dealership  The dealership
 * @param      <type>  $type        The type
 *
 * @return     array   The account identifier.
 */
function get_account_id($dealership, $type)
{
    global $db_connect;

    $query = "SELECT * FROM tag_config WHERE dealership = '{$dealership}' AND tag_type = '{$type}' ORDER BY id DESC;";

    $result     = $db_connect->query($query);
    $data       = [];
    $expect     = ['additional', 'adwords'];
    $duplicates = [];

    if (in_array($type, $expect)) {
        while ($row = mysqli_fetch_object($result)) {
            $data = $row;
        }
    } else {
        while ($row = mysqli_fetch_object($result)) {
            if (isset($duplicates[$row->account_id])) {
                $duplicates[$row->account_id] += 1;
            } else {
                $duplicates[$row->account_id] = 1;
            }

            $dup                           = $duplicates[$row->account_id] > 1 ? "(" . $duplicates[$row->account_id] . ")" : "";
            $data[$row->account_id . $dup] = $row;
        }
    }

    return $data;
}

/**
 * Gets the account identifier.
 *
 * @param      <type>  $delete_id  The tag Id
 *
 * @return     bool    ( description_of_the_return_value )
 */
function account_tag_config_delete($delete_id)
{
    global $db_connect;

    $query = "DELETE FROM tag_config WHERE id = {$delete_id};";
    $db_connect->query($query);

    return true;
}

/**
 * Posts an identifier.
 *
 * @param      <type>  $dealership  The dealership
 * @param      <type>  $type        The type
 * @param      <type>  $id          The identifier
 *
 * @return     bool    ( description_of_the_return_value )
 */
function post_id($dealership, $type, $id)
{
    global $db_connect, $account_config;

    $fetchWeb = $db_connect->query("SELECT websites FROM dealerships WHERE dealership = '{$dealership}';");
    $row      = mysqli_fetch_assoc($fetchWeb);
    $website  = $row['websites'];

    $config = isset($account_config[$type]) ? serialize($account_config[$type]) : 'NULL';
    $query  = "INSERT INTO tag_config (dealership, website, tag_type, account_id, config) VALUES ('{$dealership}', '{$website}', '{$type}', '{$id}', '{$config}')";
    $db_connect->query($query);

    return true;
}

/**
 * { function_description }
 *
 * @param      <type>  $id      The identifier
 * @param      <type>  $active  The active
 * @param      <type>  $config  The configuration
 *
 * @return     bool    ( description_of_the_return_value )
 */
function update_config($id, $active, $config, $dealership, $account_id = null)
{
    global $db_connect;

    $fetchWeb      = $db_connect->query("SELECT websites FROM dealerships WHERE dealership = '{$dealership}';");
    $row           = mysqli_fetch_assoc($fetchWeb);
    $website       = $row['websites'];
    $update_config = serialize($config);
    $query         = "UPDATE tag_config SET active = '{$active}', website = '{$website}', config = '{$update_config}' WHERE id = {$id};";

    if ($account_id) {
        $query = "UPDATE tag_config SET active = '{$active}', website = '{$website}', config = '{$update_config}', account_id = '{$account_id}' WHERE id = {$id};";
    }

    $db_connect->query($query);
}

/**
 * Posts an additional script.
 *
 * @param      <type>  $dealership  The dealership
 * @param      <type>  $type        The type
 * @param      <type>  $config      The configuration
 *
 * @return     bool    ( description_of_the_return_value )
 */
function post_additional_script($dealership, $type, $config)
{
    global $db_connect;

    $fetchWeb = $db_connect->query("SELECT websites FROM dealerships WHERE dealership = '{$dealership}';");
    $row      = mysqli_fetch_assoc($fetchWeb);
    $website  = $row['websites'];

    $update_config = serialize($config);
    $query         = "INSERT INTO tag_config (dealership, website, tag_type, config) VALUES ('{$dealership}', '{$website}', '{$type}', '{$update_config}');";

    $db_connect->query($query);
    return true;
}

/**
 * { function_description }
 */
function alldatapull()
{
    global $db_connect, $CronConfigs;

    $all_dealerships = $db_connect->get_all_dealers(1);

    foreach ($all_dealerships as $dealer) {
        $cron_name = $dealer['dealership'];
        $status    = $dealer['status'];

        echo 'Dealer :: ' . $cron_name . ' :: ' . $status . '<br><br>';

        $ids['analytics'] = $db_connect->get_meta('tracking_ids', "{$cron_name}_analytics_tracking_id");
        $ids['facebook']  = $db_connect->get_meta('tracking_ids', "{$cron_name}_facebook_pixel_id");
        $ids['snapchat']  = $db_connect->get_meta('tracking_ids', "{$cron_name}_snapchat_pixel_id");
        $ids['adwords']   = $db_connect->get_meta('tracking_ids', "{$cron_name}_adwords_tracking_id");
        $ids['bing']      = $db_connect->get_meta('tracking_ids', "{$cron_name}_bing_tag_id");

        $tag_configs = $db_connect->get_meta('tag_configs', "{$cron_name}_tag_configs");
        $pages       = ['vdp', 'ty', 'other'];
        $bing_id_new = $CronConfigs[$cron_name]['bing_account_id'];
        $config_type = ['analytics', 'adwords', 'bing', 'facebook', 'additional', 'snapchat'];

        foreach ($config_type as $type) {
            $keys = [];

            if ($type == 'analytics') {
                $keys = ['install_analytics' => 'checkbox', 'ga' => 'array', 'profitable_engagement' => 'checkbox|vdp', 'scroll_depth' => 'checkbox'];
            } else if ($type == 'adwords') {
                $keys = ['adwords_conversion_id' => 'text', 'adwords_conversion_label' => 'text'];
            } else if ($type == 'bing') {
                $keys = ['install_bing' => 'checkbox', 'bing_events' => 'array|vdp'];
            } else if ($type == 'facebook') {
                $keys = ['install_fbq' => 'checkbox', 'fbq' => 'array', 'viewcontent' => 'array|vdp'];
            } else if ($type == 'additional') {
                $keys = ['additional_scripts' => 'array'];
            }

            $config = [];

            foreach ($pages as $page) {
                foreach ($keys as $key => $data_types) {
                    $data_type = explode("|", $data_types);
                    $yes       = true;

                    if (count($data_type) > 1) {
                        if (!in_array($page, $data_type)) {
                            $yes = false;
                        }
                    }

                    if ($yes) {
                        if ($type == 'adwords') {
                            $config[$page][$key] = (($key == 'adwords_conversion_id') ? $tag_configs[$page]['adwords_conversion']['id'] : $tag_configs[$page]['adwords_conversion']['label']);
                        } else {
                            $config[$page][$key] = $tag_configs[$page][$key];
                        }
                    }
                }
            }

            $id = $ids[$type];

            if ($type == 'bing' && empty($id)) {
                $id = $bing_id_new;
            }

            if (!empty($id) || $type == 'adwords' || $type == 'additional') {
                $update_config = serialize($config);

                $query = "INSERT INTO tag_config (dealership, tag_type, account_id, config) VALUES ('{$cron_name}', '{$type}', '{$id}', '{$update_config}');";
                $db_connect->query($query);
                echo 'Type :: ' . ' :: ' . $type . ' :: ' . $id . '<br>';
                echo 'Config :: ' . $update_config . '<br>';
            }
        }

        echo '========================<br><br> ';
    }
}

/**
 * Gets the analytics accounts.
 *
 * @return     array  The analytics accounts.
 */
function get_analytics_accounts()
{
    global $db_connect;

    $resp   = [];
    $gquery = "SELECT DISTINCT(analytics_account) FROM dealerships WHERE analytics_account != '' AND analytics_account IS NOT NULL;";
    $gfetch = $db_connect->query($gquery);

    while ($grow = mysqli_fetch_assoc($gfetch)) {
        $resp[] = $grow['analytics_account'];
    }

    return $resp;
}

/**
 * Gets the analytics account.
 *
 * @param      <type>  $dealership  The dealership
 *
 * @return     <type>  The analytics account.
 */
function get_analytics_account_info($dealership)
{
    global $db_connect;

    $gquery = "SELECT analytics_account, ana_acc_id, ana_view_id, ana_profile_id FROM dealerships WHERE dealership = '{$dealership}';";
    $gfetch = $db_connect->query($gquery);
    $grow   = mysqli_fetch_assoc($gfetch);

    return [
        'analytics_account' => $grow['analytics_account'],
        'ana_acc_id'        => $grow['ana_acc_id'],
        'ana_view_id'       => $grow['ana_view_id'],
        'profile_id'        => $grow['ana_profile_id'],
    ];
}

/**
 * { function_description }
 *
 * @param      <type>  $dealership  The dealership
 * @param      <type>  $params      The parameters
 */
function update_dealer_info($dealership, $params)
{
    global $db_connect;

    $qparams = $db_connect->prepare_query_params($params, DbConnect::PREPARE_EQUAL);
    $aquery  = "UPDATE dealerships SET {$qparams} WHERE dealership = '{$dealership}';";
    $db_connect->query($aquery);
}

/**
 * Gets the facebook account information.
 *
 * @param      <type>  $dealership  The dealership
 *
 * @return     array   The facebook account information.
 */
function get_facebook_account_info($dealership)
{
    global $db_connect;

    $gquery = "SELECT fb_account_id, pixel_content_id_field FROM dealerships WHERE dealership = '{$dealership}';";
    $gfetch = $db_connect->query($gquery);
    $grow   = mysqli_fetch_assoc($gfetch);

    return [
        'fb_account_id'          => $grow['fb_account_id'],
        'pixel_content_id_field' => $grow['pixel_content_id_field'],
    ];
}