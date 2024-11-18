<?php
global $scrapper_configs;
$scrapper_configs["kenganleytoyotacom"] = array( 
	"entry_points" => array(
	    'new' =>  'https://www.kenganleytoyota.com/new-toyota-for-sale',
        'used' => 'https://www.kenganleytoyota.com/used-cars-for-sale'
    ),
    'vdp_url_regex' => '/\/vehicle-details\/(?:new|used)-[0-9]{4}-/i',
    'use-proxy' => true,
    'picture_selectors' => ['.magic-thumbs ul li', '.slick-slide',],
    'picture_nexts' => ['.mz-button.mz-button-next'],
    'picture_prevs' => ['.mz-button.mz-button-prev'],
    'details_start_tag' => '<div class="large-9 columns srp-results">',
    'details_end_tag' => '<div class="footer">',
    'details_spliter' => '<div class="row srp-vehicle"',
    'data_capture_regx' => array(
        'stock_number' => '/<div class="column"><span>Stock:<\/span>\s*(?<stock_number>[^<]+)/',
        'title' => '/<span itemprop=\'name\'>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*[^<]*)/',
        'year' => '/<span itemprop=\'name\'>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*[^<]*)/',
        'make' => '/<span itemprop=\'name\'>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*[^<]*)/',
        'model' => '/<span itemprop=\'name\'>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*[^<]*)/',
        'price' => '/Selling Price:\s*<\/span><[^>]+><[^>]+>[^>]+><span itemprop=\'price\' content=\'[^>]+><\/span>(?<price>[^<]+)/',
        'engine' => '/Engine:<\/span>\s*(?<engine>[^<]+)/',
        'transmission' => '/Transmission:<\/span>\s*(?<transmission>[^<]+)/',
        'kilometres' => '/Mileage:<\/span>\s*(?<kilometres>[^<]+)/',
        'exterior_color' => '/Ext. Color:<\/span>\s*(?<exterior_color>[^<]+)/',
        'url' => '/srp-vehicle-title">\s*<a href="(?<url>[^"]+)/',
        'interior_color' => '/Int. Color:<\/span>\s*(?<interior_color>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
       
    ),
    'next_page_regx' => '/current\'><a[^>]+>[0-9]<\/a><\/li><li><a href=\'\/inventory(?<next>[^\']+)/',
    'images_regx' => '/vehicleGallery" href="(?<img_url>[^"]+)/',
);
