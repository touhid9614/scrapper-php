<?php

global $special_configs;

$special_configs[] = array(
    'type'          => 'kijiji-carlist',
    'url_identity'  => '/www.kijiji.ca\/b-cars-trucks\/[^\/]+(?:\/page-[0-9]+)?\/c174l[0-9]+\?for-sale-by=ownr/',
    'sections'      => array(
        'cars'  => array(
            'pre_process'   => array(
                'start_tag'     => '<table class="top-feature  js-hover',
                'end_tag'       => '</table><div class="adsense-top-bar">',
                'split_tag'     => '</table>'
            ),
            'fields'        => array(
                'car_url'  => '/<table class=" regular-ad js-hover " data-vip-url="(?<car_url>[^"]+)/',
            ),
            'fields_cal'    => array(
                'car_url' => array(
                    'func'  => 'urlCombine',
                    'args'  => array(
                        '_url',
                        'car_url'
                    )
                )
            )
        )
    ),
    'fields'    => array(
        'next_page_url' => '/title="Next" href="(?<next_page_url>[^"]+)/'
    ),
    'fields_cal'    => array(
        'next_page_url' => array(
            'func'  => 'urlCombine',
            'args'  => array(
                '_url',
                'next_page_url'
            )
        )
    )
);