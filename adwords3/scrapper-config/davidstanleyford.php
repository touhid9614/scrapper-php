<?php
    global $scrapper_configs;

    $scrapper_configs['davidstanleyford'] = array(
        'entry_points' => array(
            'new'   => 'http://www.davidstanleyford.com/search/new/tp/',
            'used'  => 'http://www.davidstanleyford.com/search/used/tp/'
        ),
        'vdp_url_regex'     => '/\/[^\/]+\/(?:new|used)-[0-9]{4}-/i',
//        'ty_url_regex'      => '/\/form\/confirm.htm/i',
        'use-proxy' => true,
        'picture_selectors' => ['.dep_image_slider_ul_style li'],
        'picture_nexts'     => ['.dep_image_slider_next_btn'],
        'picture_prevs'     => ['.dep_image_slider_prev_btn'],
        
        'details_start_tag' => '<div class="srp_results"',
        'details_end_tag'   => '<div id="details-disclaimer" class=\'thm-general_border\'>',
        'details_spliter'   => '<div class="srp_vehicle_item_container srp_vehicle_table"',
        'data_capture_regx' => array(
            'stock_number'  => '/<meta itemprop="sku" content="(?<stock_number>[^"]+)" \/>/',
            'title'         => '/<h2>\s*<a\s*href="(?<url>[^"]+)".*title="(?<title>[^"]+)"/',
            'year'          => '/<meta itemprop="releaseDate" content="(?<year>[^"]+)" \/>/',
            'make'          => '/<meta itemprop="manufacturer" content="(?<make>[^"]+)" \/>/',
            'model'         => '/<meta itemprop="model" content="(?<model>[^"]+)" \/>/',
            'price'         => '/Internet Sale Price\s*[^\n]+\s*<dd class="vehicle_price\s*"[^\n]+\s*(?<price>\$[0-9,]+)/',
            'transmission'  => '/<meta itemprop="vehicleTransmission" content="(?<transmission>[^"]+)" \/>/',
            'exterior_color'=> '/<meta itemprop="color" content="(?<exterior_color>[^"]+)" \/>/',
            'interior_color'=> '/<meta itemprop="vehicleInteriorColor" content="(?<interior_color>[^"]+)" \/>/',
            'kilometres'    => '/Mileage:<\/span>\s*<span[^>]+>(?<kilometres>[^<]+)/',
            'url'           => '/<h2>\s*<a\s*href="(?<url>[^"]+)".*title="(?<title>[^"]+)"/'
        ),
        'data_capture_regx_full' => array(
            'engine'        => '/Engine<\/td>\s*<td[^>]+>(?<engine>[^<]+)/',
            'make'          => '/<meta itemprop="brand" content="(?<make>[^"]+)" \/>/',
            'model'         => '/<meta itemprop="model" content="(?<model>[^"]+)" \/>/',
            'trim'          => '/Trim<\/td>\s*<td[^>]+>(?<trim>[^<]+)/',
            
            
        ),
        'next_page_regx'       => '/<li\s*class="active[^>]+>.*<\/li>\s*<li[^>]+>\s*<a class="[^"]+"\s*href="(?<next>[^"]+)/',
//        'images_regx'          => '/<\/div>\s*<meta itemprop="image"\s*content="(?<img_url>[^"]+)"\s*\/>\n+/',
        'images_regx'          => '/data-org-source="(?<img_url>[^"]+)/',
        //'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'
    );
    add_filter('filter_davidstanleyford_field_price', 'filter_davidstanleyford_field_price',10,3);
    add_filter('filter_davidstanleyford_field_images', 'filter_davidstanleyford_field_images');
    
    function filter_davidstanleyford_field_price($price,$car_data, $spltd_data)
    {
        $prices = [];
        
        slecho('');
        
        if($price && numarifyPrice($price) > 0) {
            $prices[] = numarifyPrice($price);
            slecho(" Price: $price");
        }
        
        $msrp_regex       =  '/MSRP\s*[^\n]+\s*<dd class="vehicle_price[^\n]+\s*(?<price>\$[0-9,]+)/';
         $retail_regex     =  '/Roush MRSP\s*[^>]+>\s*<dd class="vehicle_price[^\n]+\s*(?<price>\$[0-9,]+)/';
        

                
        $matches = [];
        
        if(preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex MSRP: {$matches['price']}");
        }
        
        
        if(preg_match($retail_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("roush MSRP: {$matches['price']}");
        }
        
        if(count($prices) > 0) {
            $price = butifyPrice(min($prices));
        }
        
        slecho("Sale Price: {$price}".'<br>');
        return $price;
    }
    function filter_davidstanleyford_field_images($im_urls)
    {
        return array_filter($im_urls, function ($im_url){
            return !endsWith($im_url,'null_o.jpg');
        });
    }
