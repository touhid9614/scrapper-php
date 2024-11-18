<?php

global $scrapper_configs;
$scrapper_configs["newfoundland_infinitiretailer"] = array(
        'entry_points' => array(
            'new'   => 'http://newfoundland.infinitiretailer.ca/inventory/new/',
            'used'  => 'http://newfoundland.infinitiretailer.ca/inventory/used/'
        ),
        'vdp_url_regex'     => '/\/inventory\/(?:new|certified|used)\//i',
        'ty_url_regex' => '/\/form\/confirm.htm/i',
        'use-proxy' => true,
        'details_start_tag' => '<div id="inventory-list-container">',
        'details_end_tag'   => '<div id="footer">',
        'details_spliter'   => '<a class="vehicle-listing-lead-teaser popup-link"',
        'data_capture_regx' => array(
             'url'           => '/<a href="(?<url>[^"]+)"\s*class="vehicle-listing-link"/',
             'price'         => '/class="vehicle-listing-display-price">\s*\$\s*(?<price>[^\s*]+)/',
        ),
        'data_capture_regx_full' => array(
       
             'body_style'    => '/Body Style:[^>]+>\s*[^>]+>(?<body_style>[^<]+)/', 
            'year'          => '/<span itemprop="name">(?:New|Used|).*(?<year>[0-9]{4})/',
            'make'          => '/itemprop="name">(?<make>[^<]+)<\/span>/',
            'model'         => '/itemprop="model">(?<model>[^<]+)/',
            'engine'        => '/Engine:<\/dt>\s*<dd>(?<engine>[^\<]+)/',
            'transmission'  => '/<dt>Transmission:<\/dt>\s*<dd>(?<transmission>[^<]+)/',
            'exterior_color'=> '/Exterior Colour:[^>]+>\s*[^>]+>(?<exterior_color>[^\/<]+)/',
            'kilometres'    => '/<dt>Mileage:<\/dt>\s*<dd>(?<kilometres>[^&<]+)/'
        ) ,
        'next_page_regx'    => '/<li id="inventory-pager-next"><a\shref="(?<next>[^"]+)/',
        'images_regx'       => '/<img alt=".*"\s*class=".*" src="(?<img_url>[^"]+)"/'
    );
