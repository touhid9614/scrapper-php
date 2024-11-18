<?php

global $scrapper_configs;

$scrapper_configs["brucewaltersford"] = array(
    'entry_points'           => array(
        'used' => 'https://www.brucewaltersford.com/searchused.aspx',
        'new'  => 'https://www.brucewaltersford.com/searchnew.aspx',
    ),

    'vdp_url_regex'          => '/\/(?:new|used)-[^-]+-[0-9]{4}-/i',
    'use-proxy'              => true,
    'refine'                 => false,

    'picture_selectors'      => ['.carousel__item.js-carousel__item img'],
    'picture_nexts'          => ['.js-carousel__control--next'],
    'picture_prevs'          => ['.js-carousel__control--prev'],

    'details_start_tag'      => '<div class="col-md-9 sidebar-oncanvas">',
    'details_end_tag'        => '<div class="row srpDisclaimer">',
    'details_spliter'        => '<div id="srpRow-',

    'data_capture_regx'      => array(
        'url'            => '/class="vehicleTitle\s*margin-[^>]+>\s*<a.*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+))/',
        'title'          => '/class="vehicleTitle\s*margin-[^>]+>\s*<a.*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+))/',
        'year'           => '/class="vehicleTitle\s*margin-[^>]+>\s*<a.*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+))/',
        'make'           => '/class="vehicleTitle\s*margin-[^>]+>\s*<a.*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+))/',
        'model'          => '/class="vehicleTitle\s*margin-[^>]+>\s*<a.*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+))/',
        'body_style'     => '/<strong>Body\s*Style:\s*[^>]+>(?<body_style>[^<\/]+)/',
        // 'transmission'     => '/<strong>Transmission:\s*[^>]+>(?<transmission>[^<\/]+)/',
        'engine'         => '/<strong>Engine:\s*[^>]+>(?<engine>[^<\/]+)/',
        'exterior_color' => '/<strong>Ext.\s*Color:\s*[^>]+>(?<exterior_color>[^<\/]+)/',
        //  'interior_color'   => '/<strong>Int.\s*Color:\s*[^>]+>(?<interior_color>[^<\/]+)/',
        'stock_number'   => '/<strong>Stock\s*#:\s*[^>]+>(?<stock_number>[^<\/]+)/',
        'kilometres'     => '/<strong>Mileage\s*[^>]+>(?<kilometres>[^<\/]+)/',
        'price'          => '/(?:Internet Price|Final Price:)\s*<\/span><span[^>]+>\$(?<price>[^<]+)/',
        //  'msrp'             => '/MSRP: <\/span><span class="pull-right">(?<msrp>[^<]+)/',
        'vin'            => '/VIN #: <\/strong><span>(?<vin>[^<]+)/',
        // 'drivetrain'       => '/Drive Type: <\/strong>(?<drivetrain>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
        'body_style' => '/Body Style:\s*<\/strong><span>(?<body_style>[^<]+)/',
        'make'       => '/var vehicleMake="(?<make>[^"]+)/',
        'model'      => '/var vehicleModel="(?<model>[^"]+)/',
    ),

    'next_page_regx'         => '/<a href="(?<next>[^"]+)"\s*class="stat-arrow-next"[^>]+>\s*Next/',
    'images_regx'            => '/zoom feature element -->\s*<img src="(?<img_url>[^\?]+)/',
);
// add_filter('filter_brucewaltersford_field_url', 'filter_brucewaltersford_field_url');
// function filter_brucewaltersford_field_url($url) {
//     slecho("URL:" . $url);
//     $url = str_replace("%2B", "+", $url);
//     return $url;
// }


add_filter("filter_brucewaltersford_field_images", "filter_brucewaltersford_field_images");

function filter_brucewaltersford_field_images($im_urls)
{   if(count($im_urls)<2)
            {
            return [];
            
            }
    return array_filter($im_urls, function($im_url){
            return !endsWith($im_url, 'photo_unavailable_640.png');
        });
    
}

