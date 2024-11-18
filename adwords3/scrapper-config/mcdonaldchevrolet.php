<?php

global $scrapper_configs;

$scrapper_configs['mcdonaldchevrolet'] = array(
    'entry_points' => array(
        'used' => 'https://www.mcdonaldchevrolet.ca/en/used-inventory?limit=500',
        'new' => 'https://www.mcdonaldchevrolet.ca/en/new-inventory?limit=500',
        
    ),
    'picture_selectors' => ['.inventory-photo-gallery-from-catalog__picture-img'],
    'picture_nexts' => [''],
    'picture_prevs' => [''],
    'vdp_url_regex' => '/\/en\/(?:new|used)-inventory\//i',
    'use-proxy' => true,
    'refine'    => false,
    'details_start_tag' => '<div class="inventory-listing-charlie__vehicles',
    'details_end_tag' => '<span id="price-legal">',
    'details_spliter' => '<article class="inventory-preview-bravo"',
    'data_capture_regx' => array(
        'stock_number' => '/\#\s*stock(?<stock_number>[^<]+)/',
        // 'title'         => '/<a\s*href="(?<url>[^"]+)" class="inventory-preview-bravo__vehicle-name"[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*(?<model>[^\s*]*)\s*[^<]*)/',
        'year' => '/<a\s*href="(?<url>[^"]+)" class="inventory-preview-bravo__vehicle-name"[^>]+>[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*(?<model>[^<]+))/',
        'make' => '/<a\s*href="(?<url>[^"]+)" class="inventory-preview-bravo__vehicle-name"[^>]+>[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*(?<model>[^<]+))/',
        'model' => '/<a\s*href="\/en\/(?:used|new)-inventory\/[^\/]+\/(?<model>[^\/]+)\/[^"]+" class="inventory-preview-bravo__vehicle-name"/',
        'price' => '/vehicleCashPurchase_sellingPrice_fontColor">\s*(?<price>\$[0-9,]+)/',
        'url' => '/<a\s*href="(?<url>[^"]+)" class="inventory-preview-bravo__vehicle-name"[^>]+>[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*(?<model>[^<]+))/'
    ),
    'data_capture_regx_full' => array(
        'body_style' => '/Bodystyle:<\/div>\s*[^>]+>\s*(?<body_style>[^<]+)/',
        'engine' => '/Engine Type\s*<\/span>[^>]+>\s*(?<engine>[^<]+)/',
        'interior_color' => '/Int\. color:<\/div>[^>]+>\s*(?<interior_color>[^<]+)<\/div>/',
        'exterior_color' => '/Ext\. Color:<\/div>[^>]+>\s*(?<exterior_color>[^<]+)<\/div>/',
        'transmission' => '/Transmission:<\/div>\s*[^>]+>\s*(?<transmission>[^<]+)/',
        'stock_number' => '/data-stock-number="(?<stock_number>[^"]+)/',
        'vin' => '/data-vin="(?<vin>[^"]+)/',
        'trim' => '/Trim\s*<\/span>[^>]+>\s*(?<trim>[^<]+)/',
        'fuel_type' => '/Fuel:<\/div>\s*[^>]+>\s*(?<fuel_type>[^<]+)/',
        'kilometres' => '/class="inventory-vehicle-infos__odometer-text"[^>]+>\s*(?<kilometres>[0-9,^<]+)/',
    ),
    //'next_page_regx'    => '/<li class="current\s*test"><a href="[^"]+">[^<]+<\/a><\/li>\s*<li ><a href="(?<next>[^"]+)"/',
    'images_regx' => '/(?:inventoryDetailsHeader_separator_borderColor">|inventory-vehicle-photo-gallery--single-picture">|gallery-delta-slider__slide[^>]+>)\s*<img src="(?<img_url>[^"]+)"/',
);

add_filter("filter_mcdonaldchevrolet_field_images", "filter_mcdonaldchevrolet_field_images");
function filter_mcdonaldchevrolet_field_images($im_urls)
{
   $retvals = [];
   foreach ($im_urls as $img) {
       $retvals[] = str_replace(["|", "%20", "?impolicy=resize&w=650", "?impolicy=resize&w=414", "?impolicy=resize&w=768", "?impolicy=resize&w=1024"], ["%7C", " ", " ", " ", " ", " "], $img);
   }
   return array_filter($retvals, function ($retval) {
       return !startsWith($retval, 'https://place-hold.it/');
   });
}