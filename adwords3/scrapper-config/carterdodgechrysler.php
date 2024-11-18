<?php

global $scrapper_configs;

$scrapper_configs['carterdodgechrysler'] = array(
    'entry_points' => array(
         'new'   => 'https://www.carterdodgechrysler.com/new/',
            'used'  => 'https://www.carterdodgechrysler.com/used/'
        ),
        'vdp_url_regex'     => '/\/(?:new|used)\/vehicle\/[0-9]{4}-/i',
        'use-proxy' => true,
        'picture_selectors' => ['.thumb li'],
        'picture_nexts'     => ['.next.next-small'],
        'picture_prevs'     => ['.left.left-small'],
        
        'details_start_tag' => '<div class="instock-inventory-content',
        'details_end_tag'   => '<footer class="footer wp"',
        'details_spliter'   => '<div class="col-xs-12 col-sm-12 col-md-12"',
        'data_capture_regx' => array(
            'url'                 => '/href="(?<url>[^"]+)"><span style/',
            'year'                => '/itemprop=\'releaseDate\'>(?<year>[0-9]{4})/',
            'make'                => '/itemprop=\'manufacturer\'>(?<make>[^\<]+)/',
            'model'               => '/itemprop=\'model\'>(?<model>[^\<]+)/',
            'price'               => '/priceCurrency[\S\s]*?itemprop="price" content="(?<price>[0-9,]+)/',
            'kilometres'          => '/itemprop="mileageFromOdometer"[^>]*>(?<kilometres>[^<]+)/',
            'stock_number'        => '/itemprop="sku">(?<stock_number>[^\<]+)/',
            'engine'              => '/itemprop="vehicleEngine">(?<engine>[^\<]+)/',
            'body_style'          => '/itemprop="bodyType">(?<body_style>[^\<]+)/',
            'transmission'        => '/itemprop="vehicleTransmission">(?<transmission>[^\<]+)/',
             'exterior_color'     => '/itemprop="color"\s>(?<exterior_color>[^\<]+)/',
            //'interior_color'      => '/itemprop="vehicleInteriorColor"\s>(?<interior_color>[^\<]+)/'
        ),
        'data_capture_regx_full' => array(        
            'interior_color'      => '/itemprop="vehicleInteriorColor"\s*>\s*(?<interior_color>[^\<]+)/'
        ) ,
        'next_page_regx'    => '/class="active"><a\s*href="">[0-9]<\/a><\/li>\s*<li><a\s*href="(?<next>[^"]+)/',
        'images_regx'       => '/imgError\(this\)\;"\s*src="(?<img_url>[^"]+)/'
    );
    
    add_filter("filter_carterdodgechrysler_field_images", "filter_carterdodgechrysler_field_images");
    
    add_filter("filter_carterdodgechrysler_field_price", "filter_carterdodgechrysler_field_price", 10, 3);
    
    function filter_carterdodgechrysler_field_images($im_urls)
    {
        return array_filter($im_urls, function($im_url){
            return !endsWith($im_url, 'no_image-640x480.jpg');
        });
    }
     
    function filter_carterdodgechrysler_field_price($price,$car_data, $spltd_data)
    {
        $prices = [];

        slecho('');

        if($price && numarifyPrice($price) > 0) {
            $prices[] = numarifyPrice($price);
            slecho("carterdodgechrysler Price: $price");
        }

        $original_regex =  '/>Original Price:[\S\s]*?itemprop="price" content="(?<price>[0-9,]+)/';
        $price_regex  =  '/>Price:[\S\s]*?itemprop="price" content="(?<price>[0-9,]+)/';
        $msrp_regex  =  '/>MSRP[\S\s]*?itemprop="price" content="(?<price>[0-9,]+)/';


        $matches = [];

        if(preg_match($original_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex original price: {$matches['price']}");
        }

        if(preg_match($price_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex price: {$matches['price']}");
        }
        if(preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex price: {$matches['price']}");
        }

        if(count($prices) > 0) {
            $price = butifyPrice(min($prices));
        }

        slecho("Sale Price: {$price}".'<br>');
        return $price;
    }