<?php
global $scrapper_configs;
$scrapper_configs["scougallmotorscom"] = array( 
	'entry_points' => array(
            'new'  => 'https://www.scougallmotors.com/new/',
            'used'  => 'https://www.scougallmotors.com/used/'
        ),
        'vdp_url_regex'     => '/\/(?:new|used)\/vehicle\/[0-9]{4}-/i',
        'use-proxy' => true,
        'refine'=>false,
        'picture_selectors' => ['.thumb li'],
        'picture_nexts'     => ['.next'],
        'picture_prevs'     => ['.prev'],
        'details_start_tag' => '<div class="instock-inventory-content',
        'details_end_tag'   => '<div class="ajax-loading',
        'details_spliter'   => '<div class="col-xs-12 col-sm-12 col-md-12"',
        'data_capture_regx' => array(
            'url'                 => '/href="(?<url>[^"]+)"><span/',
            'year'                => '/itemprop=\'releaseDate[^>]+>(?<year>[0-9]{4})/',
            'make'                => '/itemprop=\'manufacturer[^>]+>(?<make>[^\<]+)/',
            'model'               => '/itemprop=\'model[^>]+>(?<model>[^\s*]+)/',
            'trim'                => '/"trim":"(?<trim>[^"]+)"/',
            'price'               => '/<span itemprop="price"[^>]+>(?<price>[^\<]+)/',
            'kilometres'          => '/itemprop="mileageFromOdometer"[^>]*>(?<kilometres>[^<]+)/',
            'stock_number'        => '/itemprop="sku">(?<stock_number>[^\<]+)/',
            'engine'              => '/itemprop="vehicleEngine">(?<engine>[^\<]+)/',
            'body_style'          => '/itemprop="bodyType">(?<body_style>[^\<]+)/',
            'transmission'        => '/itemprop="vehicleTransmission">(?<transmission>[^\<]+)/',
             'exterior_color'     => '/itemprop="color"\s>(?<exterior_color>[^\<]+)/',
           
        ),
        'data_capture_regx_full' => array(                  
            'make'                => '/itemprop=\'manufacturer\'[^>]+>(?<make>[^\s]+)/',
            'model'               => '/itemprop=\'model\'[^>]+>(?<model>[^\s]+)/',
            'interior_color'      => '/itemprop="vehicleInteriorColor"\s*>\s*(?<interior_color>[^\<]+)/'
        ) ,
        'next_page_regx'    => '/class="active"><a\s*href="">[0-9]+<\/a><\/li>\s*<li><a\s*href="(?<next>[^"]+)/',
        'images_regx'       => '/<img onerror=".*" data-src="(?<img_url>[^"]+)"\s*alt="/'
    );
    
    add_filter("filter_scougallmotorscom_field_images", "filter_scougallmotorscom_field_images");
   
    function filter_scougallmotorscom_field_images($im_urls)
    {
        return array_filter($im_urls, function($im_url){
            return !endsWith($im_url, 'no_image-640x480.jpg');
        });
    }
   add_filter("filter_scougallmotorscom_field_price", "filter_scougallmotorscom_field_price", 10, 3);

    function filter_scougallmotorscom_field_price($price,$car_data, $spltd_data)
    {
        $prices = [];

        slecho('');

        if($price && numarifyPrice($price) > 0) {
            $prices[] = numarifyPrice($price);
            slecho("scougallmotorscom Price: $price");
        }

        $msrp_regex      = '/MSRP:<\/span>\s*<span[^>]+><meta[^>]+><span[^>]+>(?<price>\$[0-9,]+)/';
        $suggested_regex = '/Suggested Price[^>]+>[^>]+>[^>]+>(?<price>\$[0-9,]+)/';
        $final_regex     = '/Final Price:<\/span>\s*<span[^>]+><meta[^>]+><span[^>]+>(?<price>\$[0-9,]+)/';
        $price_regex     = '/>Price:<\/span>\s*<span[^>]+>[\S\s]+?itemprop="price"[^>]+>(?<price>\$[0-9,]+)/';

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