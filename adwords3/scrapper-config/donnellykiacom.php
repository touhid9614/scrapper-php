<?php
global $scrapper_configs;
$scrapper_configs["donnellykiacom"] = array( 
    'entry_points' => array(
        'new'   => 'http://www.donnellykia.com/new/',
        'used'  => 'http://www.donnellykia.com/used/'
    ),
    'vdp_url_regex'     => '/\/(?:new|used)\/vehicle\/[0-9]{4}-/i',
    'use-proxy' => true,
    'picture_selectors' => ['.thumb li'],
    'picture_nexts'     => ['.next.next-small'],
    'picture_prevs'     => ['.left.left-small'],
    'details_start_tag' => '<div class="instock-inventory-content',
    'details_end_tag'   => '<footer class=',
    'details_spliter'   => '<div class="col-xs-12 col-sm-12 col-md-12',
    'data_capture_regx' => array(
        'url'                 => '/href="(?<url>[^"]+)"><span/',
        'year'                => '/itemprop=\'releaseDate\'\s*notranslate>(?<year>[0-9]+)/',
        'make'                => '/itemprop=\'manufacturer\'\s*notranslate><var>(?<make>[^\s*]+)/',
        'model'               => '/itemprop=\'model\'\s*notranslate><var>(?<model>[^<]+)/',
        //'interior_color'      => '/itemprop="vehicleInteriorColor"\s>(?<interior_color>[^\<]+)/'
    ),
    'data_capture_regx_full' => array(   
        'price'               => '/itemprop="price" content="(?<price>[^"]+)/',
        'kilometres'          => '/itemprop="mileageFromOdometer">(?<kilometres>[0-9]+)/',
        'stock_number'        => '/itemprop="sku">(?<stock_number>[^<]+)/',
        'engine'              => '/itemprop="vehicleEngine">(?<engine>[^\<]+)/',
        'body_style'          => '/itemprop="bodyType">(?<body_style>[^<]+)/',
        'transmission'        => '/itemprop="vehicleTransmission">(?<transmission>[^\<]+)/',
         'exterior_color'     => '/itemprop="color"\s>(?<exterior_color>[^\<]+)/',     
        'interior_color'      => '/itemprop="vehicleInteriorColor"\s*>\s*(?<interior_color>[^\<]+)/'
    ) ,
    'next_page_regx'    => '/class="active"><a\s*href="">[0-9]<\/a><\/li>\s*<li><a\s*href="(?<next>[^"]+)/',
    'images_regx'       => '/imgError\(this\)\;"\s*src="(?<img_url>[^"]+)/'
);
    
    add_filter("filter_donnellykiacom_field_price", "filter_donnellykiacom_field_price", 10, 3);
    add_filter("filter_donnellykiacom_field_images", "filter_donnellykiacom_field_images");
    
    function filter_donnellykiacom_field_price($price,$car_data, $spltd_data)
    {
        $prices = [];

            slecho('');

            if($price && numarifyPrice($price) > 0) {
                $prices[] = numarifyPrice($price);
                slecho("Donnellykia Price: $price");
            }

            $msrp_regex =  '/Market Price:[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>(?<price>[^\<]+)/';
            $suggested_regex =  '/All In:[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>(?<price>[^\<]+)/';
            $internet_regex =  '/Sale Price:[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>(?<price>[^\<]+)/';
            $matches = [];

            if(preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
                $prices[] = numarifyPrice($matches['price']);
                slecho("Regex MSRP: {$matches['price']}");
            }

            if(preg_match($suggested_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
                $prices[] = numarifyPrice($matches['price']);
                slecho("Regex suggested: {$matches['price']}");
            }
            if(preg_match($internet_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
                $prices[] = numarifyPrice($matches['price']);
                slecho("Regex sale: {$matches['price']}");
            }
            if(count($prices) > 0) {
                $price = butifyPrice(min($prices));
            }

            slecho("Sale Price: {$price}".'<br>');
            return $price;
    }
    function filter_donnellykiacom_field_images($im_urls)
    {
        return array_filter($im_urls, function($im_url){
            return !endsWith($im_url, 'no_image-640x480.jpg');
        });
    }