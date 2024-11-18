<?php
global $scrapper_configs;
$scrapper_configs["goschtoyotacom"] = array( 
	  'entry_points' => array(
        'new' => 'https://www.goschtoyota.com/inventory/New/',
        'used' => 'https://www.goschtoyota.com/inventory/Used/'
    ),
    'vdp_url_regex' => '/\/vehicle-details\//i',
    'use-proxy' => true,
    'refine'=>false,
    'picture_selectors' => ['.slick-slide',],
    'picture_nexts' => ['button.slick-next'],
    'picture_prevs' => ['button.slick-prev'],
    'details_start_tag' => 'data-loc="site-header">',
    'details_end_tag' => 'class="modal-footer">',
    'details_spliter' => 'id="carbox__',
    'data_capture_regx' => array(
        'url' => '/data-permalink="(?<url>[^"]+)/',
        // 'title' => '/<span itemprop=\'name\'>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*[^<]*)/',
        'year' => '/class="vehicle-title--year">\s*(?<year>[^<]+)/',
        'make' => '/class="notranslate vehicle-title--make ">\s*(?<make>[^<]+)/',
        'model' => '/class="notranslate vehicle-title--model ">\s*(?<model>[^<]+)/',
        'trim' => '/class="notranslate vehicle-title--trim ">\s*(?<trim>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
        'price' => '/pricefinal="(?<price>[^"]+)/',
        'exterior_color' => '/data-vehicle="extcolor" >(?<exterior_color>[^<]+)/',
        'body_style' => '/data-vehicle="standardbody" >(?<body_style>[^<]+)/',
        'kilometres' => '/data-vehicle="miles" data-format=[^>]+>(?<kilometres>[^<]+)/'
    ),
    'next_page_regx' => '/next page-numbers"\s*href="(?<next>[^"]+)/',
    'images_regx' => '/<img\s*width[^"]"+[^"]+"[^"]+"[^"]+"[^"]+"(?<img_url>[^"]+)/',
);

add_filter("filter_goschtoyotacom_next_page", "filter_goschtoyotacom_next_page", 10, 2);

function filter_goschtoyotacom_next_page($next_page_regex)
{
	slecho("Filtering Next url");
	 return str_replace('inventory', '',  $next_page_regex);
	 
}
