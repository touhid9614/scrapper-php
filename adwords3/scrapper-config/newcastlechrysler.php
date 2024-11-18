<?php
global $scrapper_configs;
$scrapper_configs['newcastlechrysler'] = array(

    'entry_points' => array(
        'new' => 'https://www.newcastlechrysler.com/searchnew.aspx',
        'used'=> 'https://www.newcastlechrysler.com/searchused.aspx'
    ),
    'vdp_url_regex'       => '/\/(?:new|used)-Newcastle-[0-9]{4}-/i',
    'use-proxy'           => true,
    'picture_selectors' => ['.thumbs'],
    'picture_nexts'     => ['.mfp-arrow-right'],
    'picture_prevs'     => ['.mfp-arrow-left'],
    'details_start_tag'   => '<div class="row srpVehicle">',
    'details_end_tag'     => '<div class="row srpDisclaimer">',
    'details_spliter'     => '<div id="srpRow-',

    'data_capture_regx' => array(
        'url'              => '/class="vehicleTitle\s*margin-[^>]+>\s*<a\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+))/',
        'title'            => '/class="vehicleTitle\s*margin-[^>]+>\s*<a\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+))/',
        'year'             => '/class="vehicleTitle\s*margin-[^>]+>\s*<a\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+))/',
        'make'             => '/class="vehicleTitle\s*margin-[^>]+>\s*<a\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+))/',
        'model'            => '/class="vehicleTitle\s*margin-[^>]+>\s*<a\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+))/',
        'body_style'       => '/<strong>Body\s*Style:\s*[^>]+>(?<body_style>[^<\/]+)/',
        'transmission'     => '/<strong>Transmission:\s*[^>]+>(?<transmission>[^<\/]+)/',
        'engine'           => '/<strong>Engine:\s*[^>]+>(?<engine>[^<\/]+)/',
        'exterior_color'   => '/<strong>Ext.\s*Color:\s*[^>]+>(?<exterior_color>[^<\/]+)/',
        'interior_color'   => '/<strong>Int.\s*Color:\s*[^>]+>(?<interior_color>[^<\/]+)/',
        'stock_number'     => '/<strong>Stock\s*#:\s*[^>]+>(?<stock_number>[^<\/]+)/',
        'kilometres'       => '/<strong>Mileage\s*[^>]+>(?<kilometres>[^<\/]+)/',
        'price'            => '/Special Newcastle Price:\s*<\/span><span[^>]+>(?<price>\$[0-9,]+)/',

        ),
   'data_capture_regx_full' => array(
        'make'             => '/brand":\s*"(?<make>[^"]+)/',
        'model'            => '/model":\s*"(?<model>[^"]+)/',
        'trim'             => '/var vehicleTrim="(?<trim>[^"]+)/'
    ),
    'next_page_regx'    => '/<li\s*class="active\s*.*\s*.*\s*.*\s*.*\s*<\/li>\s*.*\s*<a\s*href="(?<next>[^"]+)"/',
    'images_regx'       => '/<img\s*class=\'img-responsive\'\s*src="(?<img_url>[^"]+)"/',
);
 add_filter("filter_newcastlechrysler_field_price", "filter_newcastlechrysler_field_price", 10, 3);

    function filter_newcastlechrysler_field_price($price,$car_data, $spltd_data)
    {
        $prices = [];
        
        slecho('');
        
        if($price && numarifyPrice($price) > 0) {
            $prices[] = numarifyPrice($price);
            slecho("Final sale Price: $price");
        }
        
        $msrp_regex =  '/MSRP:\s*<\/span><span[^>]+>(?<price>\$[0-9,]+)/';
        $normal_regex  =  '/>Price:\s*<\/span><span[^>]+>(?<price>\$[0-9,]+)/';
        
        $matches = [];
        
        if(preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex MSRP: {$matches['price']}");
        }
        if(preg_match($normal_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex price: {$matches['price']}");
        }
        
        if(count($prices) > 0) {
            $price = butifyPrice(min($prices));
        }
        
        slecho("Sale Price: {$price}".'<br>');
        return $price;
    }




