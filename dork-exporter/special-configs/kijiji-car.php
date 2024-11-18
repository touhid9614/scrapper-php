<?php

global $special_configs;

$special_configs[] = array(
    'type'          => 'kijiji-car',
    'url_identity'  => '/www.kijiji.ca\/v-cars-trucks\//',
    'fields'    => array(
        'stock_number'  => '/ Ad ID:? (?<stock_number>[^\s<]+)/',
        'year'          => '/Year<\/th>\s*<td>\s*(?<year>[^<]+)/',
        'make'          => '/<span itemprop="brand">(?<make>[^<]+)/',
        'model'         => '/<span itemprop="model">(?<model>[^<]+)/',
        'trim'          => '/Trim<\/th>\s*<td>\s*(?<trim>[^<]+)/',
        'price'         => '/<span itemprop="price"><strong>(?<price>[^\.<]+)/',
        'kilometres'    => '/Kilometers<\/th>\s*<td>\s*(?<kilometres>[^<]+)/',
        'body_style'    => '/Body Type<\/th>\s*<td>\s*(?<body_style>[^<]+)/',
        'transmission'  => '/Transmission<\/th>\s*<td>\s*(?<transmission>[^<]+)/',
        'exterior_color'=> '/<span itemprop="color">(?<exterior_color>[^<]+)/',
        'arrival_date'  => '/Date Listed<\/th>\s*<td>\s*(?<arrival_date>[^<]+)/',
        'description'   => '/<span itemprop="description">\s*(?<description>[\s\S]+?(?=(?:<\/span>)))/',
        'lat'           => '/<meta property="og:latitude" content="(?<lat>[^"]+)/',
        'long'          => '/<meta property="og:longitude" content="(?<long>[^"]+)/'
    ),
    'fields_all'   => array(
        'all_images'    => '/itemprop="image" src="(?<all_images>[^"]+)/'
    ),
    'fields_cal'    => array(
        'arrival_date' => array(
            'func'  => 'strtotime',
            'args'  => array(
                'arrival_date'
            )
        ),
        'all_images' => array(
            'func'  => 'urlCombine',
            'args'  => array(
                '_url',
                'all_images'
            )
        )
    )
);