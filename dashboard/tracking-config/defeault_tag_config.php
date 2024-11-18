<?php

global $default_tag_config;

$default_tag_config = [
    'analytics' => [
        'vdp'   => [
            'install_analytics'     => false,
            'ga'                    => [],
            'profitable_engagement' => false,
            'scroll_depth'          => false,
        ],
        'srp'   => [
            'install_analytics' => false,
            'ga'                => [],
            'scroll_depth'      => false,
        ],
        'ty'    => [
            'install_analytics' => false,
            'ga'                => [],
            'scroll_depth'      => false,
        ],
        'other' => [
            'install_analytics' => false,
            'ga'                => [],
            'scroll_depth'      => false,
        ],
    ],
    'adwords'   => [
        'vdp'   => [
            'adwords_conversion_id'    => '',
            'adwords_conversion_label' => '',
        ],
        'srp'   => [
            'adwords_conversion_id'    => '',
            'adwords_conversion_label' => '',
        ],
        'ty'    => [
            'adwords_conversion_id'    => '',
            'adwords_conversion_label' => '',
        ],
        'other' => [
            'adwords_conversion_id'    => '',
            'adwords_conversion_label' => '',
        ],
    ],
    'bing'      => [
        'vdp'   => [
            'install_bing' => false,
            'bing_events'  => [],
        ],
        'srp'   => [
            'install_bing' => false,
            'bing_events'  => [],
        ],
        'ty'    => [
            'install_bing' => false,
            'bing_events'  => [],
        ],
        'other' => [
            'install_bing' => false,
            'bing_events'  => [],
        ],
    ],
    'facebook'  => [
        'vdp'   => [
            'install_fbq'       => false,
            'fbq'               => [],
            'viewcontent'       => [],
            'fbq_selectors'     => []
        ],
        'srp'   => [
            'install_fbq'     => false,
            'fbq'             => [],
            'fbq_selectors'   => []
        ],
        'ty'    => [
            'install_fbq'   => false,
            'fbq'           => [],
            'fbq_selectors' => []
        ],
        'other' => [
            'install_fbq'   => false,
            'fbq'           => [],
            'fbq_selectors' => []
        ],
    ],
    'snapchat'  => [
        'vdp'   => [
            'install_snapchat' => false,
            'snapchat_events'  => [],
        ],
        'srp'   => [
            'install_snapchat' => false,
            'snapchat_events'  => [],
        ],
        'ty'    => [
            'install_snapchat' => false,
            'snapchat_events'  => [],
        ],
        'other' => [
            'install_snapchat' => false,
            'snapchat_events'  => [],
        ],
    ],
];