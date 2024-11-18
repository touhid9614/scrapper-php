<?php
    global $scrapper_configs;

    $scrapper_configs['hanoverchryslerdodge'] = array(
        'entry_points' => array(
            'new'  => 'https://www.hanoverchryslerdodge.com/new/',
            'used'  => 'https://www.hanoverchryslerdodge.com/used/'
        ),
        'vdp_url_regex' => '/\/(?:new|used|certified)\/vehicle\/[0-9]{4}-/i',
    'use-proxy'              => true,
    'refine'                 => false,
    'picture_selectors'      => ['.thumb li'],
    'picture_nexts'          => ['.next'],
    'picture_prevs'          => ['.prev'],
    'details_start_tag'      => '<div class="instock-inventory-content',
    'details_end_tag'        => '<footer class="',
    'details_spliter'        => '<!-- vehicle-list-cell -->',
    'data_capture_regx'      => array(
        'url'            => '/href="(?<url>[^"]+)"><span\s*style=\'/',
        'price'          => '/<span itemprop="price"[^>]+>(?<price>[^\<]+)/',
        'kilometres'     => '/mileage-list"  >Mileage:[^>]+>[^>]+>(?<kilometres>[^<]+)<\/span><\/p>/',
        'engine'         => '/itemprop="vehicleEngine">(?<engine>[^\<]+)/',
        'transmission'   => '/itemprop="vehicleTransmission">(?<transmission>[^\<]+)/',
        'exterior_color' => '/itemprop="color"\s>(?<exterior_color>[^\<]+)/',
        'drivetrain'     => '/"driveTrain":"(?<drivetrain>[^"]+)/'
    ),
    'data_capture_regx_full' => array(
        'make'           => '/make\':\s*\'(?<make>[^\']+)/',
        'model'          => '/model\':\s*\'(?<model>[^\']+)/',
        'year'           => '/year\':\s*\'(?<year>[^\']+)/',
        //'kilometres'     => '/mileage-list"  >Mileage:[^>]+>[^>]+>(?<kilometres>[^<]+)<\/span><\/p>/',
        'stock_number'   => '/itemprop="sku">(?<stock_number>[^\<]+)/',
        'body_style'     => '/itemprop="bodyType">(?<body_style>[^\<]+)/',
        'interior_color' => '/itemprop="vehicleInteriorColor"\s*>\s*(?<interior_color>[^\<]+)/',
        'vin'            => '/\&vin=(?<vin>[^\&]+)/',
        'fuel_type'      => '/itemprop="fuelType">(?<fuel_type>[^<]+)/',
        'description'    => '/name="description" content="(?<description>[^"]+)/',
        'custom'         => '/Location Alert:\s*<\/strong>(?<custom>[^o]+)/',
    ),
    'next_page_regx'         => '/rel="next"\shref="(?<next>[^"]+)"/',
    'images_regx'            => '/imgError\(this\)\;"\s*(?:src|data-src)="(?<img_url>[^"]+)/'
);
    
    add_filter("filter_hanoverchryslerdodge_field_images", "filter_hanoverchryslerdodge_field_images");
   
    function filter_hanoverchryslerdodge_field_images($im_urls)
    { 
        if (count($im_urls) < 2) {
        return [];
    }
    return array_filter($im_urls, function($im_url){
            return !endsWith($im_url, 'no_image-640x480.jpg');
        });
    }