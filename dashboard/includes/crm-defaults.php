<?php

global $CronConfigs, $scrapper_configs;

$cron_names = array_intersect(array_keys($CronConfigs), array_keys($scrapper_configs));
natcasesort($cron_names);

$default_dealership = [
    'dealership'        => $cron_names[0],
    'saler_type'        => 'Dealership',
    'company_name'      => $cron_names[0],
    'group_name'        => '',
    'phone'             => '',
    'websites'          => '',
    'address'           => '',
    'city'              => '',
    'state'             => '',
    'post_code'         => '',
    'billing_address'   => '',
    'billing_city'      => '',
    'billing_state'     => '',
    'billing_post_code' => '',

    'website_rep'       => [
        'name'  => '',
        'email' => '',
        'phone' => '',
    ],

    'company_rep'       => [
        'name'  => '',
        'email' => '',
        'phone' => '',
    ],

    'inventories'       => [],
    'campaign_types'    => [],
    'start_date'        => 0,
    'end_date'          => 0,
    'last_contacted'    => 0,
    'happiness'         => 100,
    'status'            => 'active',
];

$all_oems = [
    'Chevrolet',
    'GMC',
    'Cadillac',
    'Buick',
    'Ford',
];