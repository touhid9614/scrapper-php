<?php
    global $scrapper_configs;

    $scrapper_configs['mymotorlink'] = array(
        'entry_points' => array(
           'used'  => 'https://mymotorlink.com/jacksonville-florida-commercial-vehicle-sales/jacksonville-florida-commercial-vehicles-for-sale/stock'
        ),
        'vdp_url_regex'     => '/\/detail\//i',
        //'ty_url_regex'      => '/\/form\/confirm.htm/i',
        'use-proxy' => true,
        'picture_selectors' => ['.img-polaroid.visible-phone'],
        'picture_nexts'     => ['#cboxNext','#cboxLoadedContent'],
        'picture_prevs'     => ['#cboxPrevious'],
        'details_start_tag' => '<div class="maincontent">',
        'details_end_tag'   => '<div id="container_base"',
        'details_spliter'   => '<div class="rdautos_vehicle_container">',
        'data_capture_regx' => array(
           'year'          => '/<a href="[^"]+">.*(?<year>[0-9]{4})<\/strong> - (?<make>[^\s]+)\s*(?<model>[^<]+)/',
           'make'          => '/<a href="[^"]+">.*(?<year>[0-9]{4})<\/strong> - (?<make>[^\s]+)\s*(?<model>[^<]+)/',
           'model'         => '/<a href="[^"]+">.*(?<year>[0-9]{4})<\/strong> - (?<make>[^\s]+)\s*(?<model>[^<]+)/',
           'price'         => '/Price[^\n]+\s*<td[^>]+>(?<price>\$ [0-9,.]+)/',
           'kilometres'    => '/Mileage[^\n]+\s*<td[^>]+>(?<kilometres>[^<]+)/',
           'url'           => '/<a href="(?<url>[^"]+)">\s*<img/'
        ),
        'data_capture_regx_full' => array(
            'transmission'  => '/Transmission<\/div>\s*<div[^>]+>(?<transmission>[^<]+)/',
            'exterior_color'=> '/>Color<\/div>\s*<div[^>]+>(?<exterior_color>[^<]+)/',
            'interior_color'=> '/Interior Color<\/div>\s*<div[^>]+>(?<interior_color>[^<]+)/',
            'stock_number'  => '/VIN Number<\/div>\s*<div[^>]+>(?<stock_number>[^<]+)/',
        ),
        //'next_page_regx'    => '/rel="next" *(?:data-href|href)="(?<next>[^"]+)"/',
        'images_regx'       => '/<img src="(?<img_url>[^"]+).* class="img-polaroid visible-phone/',
       
    );
