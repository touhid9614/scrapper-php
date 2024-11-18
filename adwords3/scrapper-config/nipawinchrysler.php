<?php

global $scrapper_configs;
$scrapper_configs["nipawinchrysler"] = array(
    'entry_points' => array(
       'used' => 'https://www.nipawinchrysler.com/used/city/Nipawin',
        'new' => 'https://www.nipawinchrysler.com/new/',

      //  For used : Only list Nipawin Inventory on Used Inventory
     // Task link https://app.asana.com/0/1116316622272921/1199927507138305/f//
   
        ),
    'vdp_url_regex'     => '/\/(?:new|used|certified)\/vehicle\/[0-9]{4}-/i',
        'use-proxy' => true,
        'refine'=>false,
        'picture_selectors' => ['.thumb li'],
        'picture_nexts'     => ['.next'],
        'picture_prevs'     => ['.prev'],
         'details_start_tag' => '<div class="instock-inventory-content',
         'details_end_tag' => '<footer class="footer',
         'details_spliter' => '<div itemprop="ItemOffered"',
        'data_capture_regx' => array(
        'url' => '/role="button" href="(?<url>[^"]+)"/',
        'year' => '/itemprop=\'releaseDate\'.*>(?<year>[0-9]{4})/',
        'make' => '/itemprop=\'manufacturer\' notranslate><var>(?<make>[^\<]+)/',
        'model' => '/itemprop=\'model\' notranslate><var>(?<model>[^\<]+)/',
        'price' => '/<span itemprop="price" content="[^>]+>(?<price>\$[0-9,]+)/',
        'stock_number' => '/STK#\s*(?<stock_number>[^\/]+)/',
           
        ),
        'data_capture_regx_full' => array(                  
        'stock_number' => '/itemprop="sku">\s*(?<stock_number>[^<]+)/',
        'kilometres' => '/itemprop="mileageFromOdometer"[^>]+>\s*(?<kilometres>[^<]+)/',
        'engine' => '/itemprop="vehicleEngine">\s*(?<engine>[^\<]+)/',
        'body_style' => '/itemprop="bodyType">\s*(?<body_style>[^\<]+)/',
        'transmission' => '/itemprop="vehicleTransmission">\s*(?<transmission>[^\<]+)/',
        'exterior_color' => '/itemprop="color"\s>\s*(?<exterior_color>[^\<]+)/',
        'interior_color' => '/itemprop="vehicleInteriorColor"\s*>\s*(?<interior_color>[^\<]+)/',
        'vin' => '/data-vin="(?<vin>[^"]+)/',
        ),
        'next_page_regx'    => '/class="active"><a\s*href="">[^<]+<\/a><\/li>\s*<li><a\s*href="(?<next>[^"]+)/',
        'images_regx'       => '/imgError\(this\)\;"\s*(?:data-src|src)="(?<img_url>[^"]+)/'
    );
    
    add_filter("filter_nipawinchrysler_field_images", "filter_nipawinchrysler_field_images");
   
    function filter_nipawinchrysler_field_images($im_urls)
    {
        return array_filter($im_urls, function($im_url){
            return !endsWith($im_url, 'no_image-640x480.jpg');
        });
    }
   add_filter("filter_nipawinchrysler_field_price", "filter_nipawinchrysler_field_price", 10, 3);

    function filter_nipawinchrysler_field_price($price,$car_data, $spltd_data)
    {
        $prices = [];

        slecho('');

        if($price && numarifyPrice($price) > 0) {
            $prices[] = numarifyPrice($price);
            slecho("nipawinchrysler Price: $price");
        }

        $msrp_regex      = '/MSRP:<\/span>\s*<span[^>]+><meta[^>]+><span[^>]+>(?<price>\$[0-9,]+)/';
        $suggested_regex = '/Price:[^>]+>\s*[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>(?<price>\$[0-9,]+)/';
        $final_regex     = '/Final Price:[^>]+>\s*[^>]+>[^>]+>[^>]+>[^>]+>(?<price>\$[0-9,]+)/';
        $price_regex     = '/Suggested Price:[^>]+>\s*[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>(?<price>\$[0-9,]+)/';

        $matches = [];

        if(preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex MSRP: {$matches['price']}");
        }

        if(preg_match($suggested_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex suggested: {$matches['price']}");
        }
        
        if(preg_match($final_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex final: {$matches['price']}");
        }
        
        if(preg_match($price_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex price: {$matches['price']}");
        }

        if(count($prices) > 0) {
            $price = butifyPrice(min($prices));
        }

        slecho("Sale Price: {$price}".'<br>');
        return $price;
    }