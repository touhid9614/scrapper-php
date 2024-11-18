<?php

require_once 'config.php';
require_once 'includes/loader.php';
require_once ADSYNCPATH . 'config.php';
require_once ADSYNCPATH . 'Google/Util.php';
require_once ADSYNCPATH . 'db_connect.php';
require_once ADSYNCPATH . 'utils.php';
require_once ADSYNCPATH . 'ajax-misc.php';

global $connection, $user, $cron_names;

$cron_name   = $user['cron_name'];
$cron_config = $user['cron_config'];

$db_connect = new DbConnect($cron_name);
$db_connect->create_meta_table('tag_configs');
$all_dealerships = DbConnect::get_instance()->get_all_dealers(1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    switch (filter_input(INPUT_POST, 'action')) {
        case 'update_vdp_tag_config':
            update_tag_config($db_connect, $cron_name, $cron_names, 'vdp');
            break;
        case 'update_ty_tag_config':
            update_tag_config($db_connect, $cron_name, $cron_names, 'ty');
            break;
        case 'update_other_tag_config':
            update_tag_config($db_connect, $cron_name, $cron_names, 'other');
            break;
    }

    echo ("<script type='text/javascript'> location.href = location.href; </script>");
}

$tag_configs = $db_connect->get_meta('tag_configs', "{$cron_name}_tag_configs");

if (!$tag_configs) {
    $tag_configs = default_tag_configs();
}

if (!isset($tag_configs['vdp']['install_analytics'])) {
    $tag_configs['vdp']['install_analytics'] = false;
}

if (!isset($tag_configs['ty']['install_analytics'])) {
    $tag_configs['ty']['install_analytics'] = false;
}

if (!isset($tag_configs['other']['install_analytics'])) {
    $tag_configs['other']['install_analytics'] = false;
}

if (!isset($tag_configs['vdp']['install_fbq'])) {
    $tag_configs['vdp']['install_fbq'] = false;
}

if (!isset($tag_configs['ty']['install_fbq'])) {
    $tag_configs['ty']['install_fbq'] = false;
}

if (!isset($tag_configs['other']['install_fbq'])) {
    $tag_configs['other']['install_fbq'] = false;
}

$db_connect->close_connection();

function update_tag_config(DbConnect $db_connect, $cron_name, $cron_names, $page, $update_all = false)
{
    $tag_configs = $db_connect->get_meta('tag_configs', "{$cron_name}_tag_configs");

    if (!$tag_configs) {
        $tag_configs = default_tag_configs();
    }

    $tag_configs[$page] = array(
        'install_analytics'     => filter_input(INPUT_POST, 'install_analytics') === 'true',
        'ga'                    => isset($_POST['ga']) && is_array($_POST['ga']) ? $_POST['ga'] : [],
        'profitable_engagement' => filter_input(INPUT_POST, 'profitable_engagement') === 'true',
        'scroll_depth'          => filter_input(INPUT_POST, 'scroll_depth') === 'true',
        'install_fbq'           => filter_input(INPUT_POST, 'install_fbq') === 'true',
        'install_bing'          => filter_input(INPUT_POST, 'install_bing') === 'true',
        'fbq'                   => isset($_POST['fbq']) && is_array($_POST['fbq']) ? $_POST['fbq'] : [],
        'bing_events'           => isset($_POST['bing_events']) && is_array($_POST['bing_events']) ? $_POST['bing_events'] : [],
        'viewcontent'           => isset($_POST['viewcontent']) && is_array($_POST['viewcontent']) ? $_POST['viewcontent'] : [],
        'adwords_conversion'    => array(
            'id'    => filter_input(INPUT_POST, 'adwords_conversion_id'),
            'label' => filter_input(INPUT_POST, 'adwords_conversion_label'),
        ),
        'additional_scripts'    => explode("\n", trim(filter_input(INPUT_POST, 'additional_scripts'))),
    );

    $db_connect->update_meta('tag_configs', "{$cron_name}_tag_configs", $tag_configs);

    if (!$update_all) {
        return;
    }

    foreach ($cron_names as $c_name) {
        if ($c_name === $cron_name) {
            continue;
        }

        $tag_configs = $db_connect->get_meta('tag_configs', "{$c_name}_tag_configs");

        if (!$tag_configs) {
            $tag_configs = default_tag_configs();
        }

        $tag_configs[$page] = array(
            'install_analytics'     => filter_input(INPUT_POST, 'install_analytics') === 'true',
            'ga'                    => isset($_POST['ga']) && is_array($_POST['ga']) ? $_POST['ga'] : [],
            'profitable_engagement' => filter_input(INPUT_POST, 'profitable_engagement') === 'true',
            'scroll_depth'          => filter_input(INPUT_POST, 'scroll_depth') === 'true',
            'install_fbq'           => filter_input(INPUT_POST, 'install_fbq') === 'true',
            'install_bing'          => filter_input(INPUT_POST, 'install_bing') === 'true',
            'fbq'                   => isset($_POST['fbq']) && is_array($_POST['fbq']) ? $_POST['fbq'] : [],
            'bing_events'           => isset($_POST['bing_events']) && is_array($_POST['bing_events']) ? $_POST['bing_events'] : [],
            'viewcontent'           => isset($_POST['viewcontent']) && is_array($_POST['viewcontent']) ? $_POST['viewcontent'] : [],
            'adwords_conversion'    => isset($tag_configs[$page]['adwords_conversion']) ? $tag_configs[$page]['adwords_conversion'] : array('id' => '', 'label' => ''),
            'additional_scripts'    => isset($tag_configs[$page]['additional_scripts']) ? $tag_configs[$page]['additional_scripts'] : [],
        );

        $db_connect->update_meta('tag_configs', "{$c_name}_tag_configs", $tag_configs);
    }
}

function default_tag_configs()
{
    return array(
        'vdp'   => array(
            'install_analytics'     => false,
            'ga'                    => [],
            'profitable_engagement' => false,
            'scroll_depth'          => false,
            'install_fbq'           => false,
            'fbq'                   => [],
            'viewcontent'           => [],
            'adwords_conversion'    => array(
                'id'    => '',
                'label' => '',
            ),
            'install_bing'          => false,
            'bing_events'           => [],
            'additional_scripts'    => [],
        ),
        'ty'    => array(
            'install_analytics'     => false,
            'ga'                    => [],
            'profitable_engagement' => false,
            'scroll_depth'          => false,
            'install_fbq'           => false,
            'fbq'                   => [],
            'adwords_conversion'    => array(
                'id'    => '',
                'label' => '',
            ),
            'additional_scripts'    => [],
        ),
        'other' => array(
            'install_analytics'     => false,
            'ga'                    => [],
            'profitable_engagement' => false,
            'scroll_depth'          => false,
            'install_fbq'           => false,
            'fbq'                   => [],
            'adwords_conversion'    => array(
                'id'    => '',
                'label' => '',
            ),
            'additional_scripts'    => [],
        ),
    );
}

function object_dump($obj)
{
    echo "<pre>";
    print_r($obj);
    echo "</pre>";
}