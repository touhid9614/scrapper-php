<?php

    global $scrapper_configs;

    $scrapper_configs['saskatoonsouthhyundai'] = array(
        'entry_points' => array(
            'new'   => 'https://www.saskatoonsouthhyundai.com/new/',
            'used'  => 'https://www.saskatoonsouthhyundai.com/used/'
        ),
        'vdp_url_regex'     => '/\/(?:new|used)\/vehicle\/[0-9]{4}-/i',
        'refine'=>false,
        'use-proxy' => true,
        'picture_selectors' => ['.thumb li img'],
        'picture_nexts'     => ['.next.next-small'],
        'picture_prevs'     => ['.left.left-small'],
        
        'details_start_tag' => '<div class="instock-inventory-content',
        'details_end_tag'   => 'class="copyright disclaimer">',
        'details_spliter'   => '<div class="col-xs-12 col-sm-12 col-md-12"',
        'data_capture_regx' => array(
            'url'                 => '/href="(?<url>[^"]+)"><span/',
            'year'                => '/itemprop=\'releaseDate\' notranslate>(?<year>[0-9]{4})/',
            'make'                => '/itemprop=\'manufacturer\' notranslate><var>(?<make>[^\<]+)/',
            'model'               => '/itemprop=\'model\' notranslate><var>(?<model>[^<]+)/',
            'price'               => '/itemprop="price"[^>]+>(?<price>\$[0-9,]+)/',
            'kilometres'          => '/itemprop="mileageFromOdometer"[^>]*>(?<kilometres>[^<]+)/',
            'stock_number'        => '/itemprop="sku">(?<stock_number>[^\<]+)/',
            'engine'              => '/itemprop="vehicleEngine">(?<engine>[^\<]+)/',
            'body_style'          => '/itemprop="bodyType">(?<body_style>[^\<]+)/',
            'transmission'        => '/itemprop="vehicleTransmission">(?<transmission>[^\<]+)/',
            'exterior_color'      => '/itemprop="color"\s>(?<exterior_color>[^\<]+)/',
            'drivetrain'          => '/itemprop="driveWheelConfiguration">(?<drivetrain>[^<]+)/',
            'trim'                => '/itemprop=\'model\' notranslate>(?<model>[^\s]+)\s*(?<trim>[^<]+)/',  
            //'interior_color'      => '/itemprop="vehicleInteriorColor"\s>(?<interior_color>[^\<]+)/'
        ),
        'data_capture_regx_full' => array(        
            'interior_color'      => '/itemprop="vehicleInteriorColor"\s*>\s*(?<interior_color>[^\<]+)/',
            'vin'                 => '/\&vin=(?<vin>[^\&]+)/',
            'fuel_type'           => '/Fuel type:<\/td>[^>]+>\s*(?<fuel_type>[^<]+)/',
            'description'             => '/itemprop="description"[^>]+>(?<description>[^<]+)/',
        ) ,
        'next_page_regx'    => '/class="active"><a\s*href="">[0-9]+<\/a><\/li>\s*<li><a\s*href="(?<next>[^"]+)/',
        'images_regx'       => '/imgError\(this\)\;"\s*(?:data-src|src)="(?<img_url>[^"]+)/'
    );
    
    add_filter("filter_saskatoonsouthhyundai_field_price", "filter_saskatoonsouthhyundai_field_price", 10, 3);
    add_filter("filter_saskatoonsouthhyundai_field_images", "filter_saskatoonsouthhyundai_field_images");
    function filter_saskatoonsouthhyundai_field_price($price,$car_data, $spltd_data)
    {
        $prices = [];

        slecho('');

        if($price && numarifyPrice($price) > 0) {
            $prices[] = numarifyPrice($price);
            slecho("saskatoonsouthhyundai Price: $price");
        }

        $msrp_regex      = '/MSRP[^>]+>\s*[^>]+>[^>]+>[^>]+>[^>]+>(?<price>\$[0-9,]+)/';
        $suggested_regex = '/Suggested Price:<\/span>\s*<span[^>]+><meta[^>]+><span[^>]+>(?<price>\$[0-9,]+)/';
        $final_regex     = '/Final Price:<\/span>\s*<span[^>]+><meta[^>]+><span[^>]+>(?<price>\$[0-9,]+)/';
        $price_regex     = '/Our Price:[^>]+>\s*[^>]+>[^>]+>[^>]+>[^>]+>(?<price>\$[0-9,]+)/';

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
    function filter_saskatoonsouthhyundai_field_images($im_urls)
    {
        return array_filter($im_urls, function($im_url){
            return !endsWith($im_url, 'no_image-640x480.jpg');
        });
    }