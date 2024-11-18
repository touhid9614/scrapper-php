<?php

global $scrapper_configs;

$scrapper_configs['midwestautoia'] = array(
    'entry_points' => array(
        "used"          => "https://www.midwestautoia.com/inventory?PageNumber=1&PageSize=1000",
    ),
    'vdp_url_regex'     => '/\/details\//i',
    'use-proxy'         => true,
    
    'picture_selectors' => ['.vehicle-img .item'],
    'picture_nexts'     => ['.right'],
    'picture_prevs'     => ['.left'],
    'details_start_tag' => '<ul class="list-unstyled list-inline vehicle-section">',
    'details_end_tag'   => '<div class="disclaimer">',
    'details_spliter'   => '<li class="vehicle-snapshot vehicle-list',
    'data_capture_regx' => array(
        'url'           => '/<a href="(?<url>[^"]+)">\s*<h3 class="vehicle-title[^"]+">/',
        'title'         => '/"name":\s*"(?<title>[^"]+)/',
        'year'          => '/"vehicleModelDate":\s*(?<year>[0-9]{4})/',
        'make'          => '/"manufacturer":\s*"(?<make>[^"]+)/',
        'model'         => '/"model":\s*"(?<model>[^"]+)/',
        'transmission'  => '/Trans:\s*.*\s*<div[^\n]+\s*(?<transmission>[^<]+)/',
        'engine'        => '/Engine:\s*.*\s*<div[^\n]+\s*(?<engine>[^<]+)/',
        'price'         => '/vehicle-price[^\n]+\s*<a[^\n]+\s*(?<price>\$[0-9,]+)/',
        'kilometres'    => '/Mileage:\s*.*\s*<div[^\n]+\s*(?<kilometres>[^\s]+ miles)/',
    ),
    'data_capture_regx_full' => array(
        'exterior_color'=> '/Exterior Color:\s*.*\s*<div[^\n]+\s*(?<exterior_color>[^\n]+)/',
        'interior_color'=> '/Interior Color:\s*.*\s*<div[^\n]+\s*(?<interior_color>[^\n]+)/',
        'stock_number'  => '/Stock:\s*.*\s*<div[^\n]+\s*(?<stock_number>[^\n]+)/',
        'body_style'    => '/Style:\s*.*\s*<div[^\n]+\s*(?<body_style>[^\n]+)/',
    ),
    'next_page_regx'        => '/<a href="(?<next>[^"]+)" class="btn btn-secondary data-button-next-page/',
    'images_regx'           => '/<div class="item [^>]+>\s*<img .* src="(?<img_url>[^"]+)/',
        //'images_fallback_regx'  => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'
    );
    add_filter("filter_midwestautoia_field_images", "filter_midwestautoia_field_images");
    
    
    function filter_midwestautoia_field_images($im_urls)
    {
        return array_filter($im_urls, function($im_url){
            return !endsWith($im_url, 'nophoto.png');
        });
    }
   