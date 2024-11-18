<?php
global $scrapper_configs;
 $scrapper_configs["toyotaofglendora"] = array( 
	 'entry_points' => array(
            'new'   => 'https://www.toyotaofglendora.com/search/new/tp/',
            'used'  => 'https://www.toyotaofglendora.com/search/used/tp/',
           // 'certified' => 'https://www.toyotaofglendora.com/search/certified/tp/'
        ),
        'use-proxy' => true,
        'vdp_url_regex'     => '/\/[^\/]+\/(?:new|used)-[0-9]{4}-/i',
        'ty_url_regex'      => '/\/thank-you-/i',
        'picture_selectors' => ['.dep_image_slider_ul_style li'],
        'picture_nexts'     => ['.dep_image_slider_next_btn'],
        'picture_prevs'     => ['.dep_image_slider_prev_btn'],
        'details_start_tag' => '<div class="srp_results_count_container">',
        'details_end_tag'   => '<div id="details-disclaimer"',
        'details_spliter'   => '<div class="srp_vehicle_wrapper srp_vehicle_item_container"',
        
        'data_capture_regx' => array(
            'stock_number'  => '/<meta\s*itemprop="sku"\s*content="(?<stock_number>[^"]+)/',
            'year'          => '/<meta\s*itemprop="releaseDate"\s*content="(?<year>[^"]+)/',
            'make'          => '/<meta\s*itemprop="brand"\s*content="(?<make>[^"]+)/',
            'model'         => '/<meta\s*itemprop="model"\s*content="(?<model>[^"]+)/',
            'transmission'  => '/<meta\s*itemprop="vehicleTransmission"\s*content="(?<transmission>[^"]+)/',
            'price'         => '/Final Price\s*[^\n]+\s*<dd class="vehicle_price\s*"[^\n]+\s*(?<price>\$[0-9,]+)/',
            'exterior_color'=> '/<meta\s*itemprop="color"\s*content="(?<exterior_color>[^"]+)/',
            'interior_color'=> '/<meta\s*itemprop="vehicleInteriorColor"\s*content="(?<interior_color>[^"]+)/',
            'kilometres'    => '/Mileage:<\/span>\s*<span[^>]+>(?<kilometres>[^<]+)/',
            'url'           => '/srp_vehicle_titlebar.*\s.*<h2\s*><a href="(?<url>[^"]+)".*title="(?<title>[^"]+)/',
            'title'         => '/srp_vehicle_titlebar.*\s.*<h2\s*><a href="(?<url>[^"]+)".*title="(?<title>[^"]+)/'
        ),
        'data_capture_regx_full' => array(
            'engine'        => '/Engine<\/td>\s*<td[^>]+>(?<engine>[^<]+)/',
            'trim'          => '/Trim<\/td>\s*<td[^>]+>(?<trim>[^<]+)/',
            'model'         => '/<meta itemprop="model"\s*content="(?<model>[^"]+)/',
            'certified'     => '/<img\s*class="(?<certified>certified)"/'
            
            
        ),
        'next_page_regx'        => '/<li class="active[^>]+.*<\/li>\s*<li[^>]+>\s*<a\s*class="[^"]+"\s*href="(?<next>[^"]+)/',
        'images_regx'           => '/<meta property="og:image" content="(?<img_url>[^"]+)"/',
        'images_fallback_regx'  => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'
    );
    add_filter('filter_toyotaofglendora_field_price', 'filter_toyotaofglendora_field_price',10,3);
    add_filter('filter_toyotaofglendora_field_images', 'filter_toyotaofglendora_field_images');
    
    function filter_toyotaofglendora_field_price($price,$car_data, $spltd_data)
    {
        $prices = [];
        
        slecho('');
        
        if($price && numarifyPrice($price) > 0) {
            $prices[] = numarifyPrice($price);
            slecho(" Price: $price");
        }
        
        $msrp_regex       =  '/MSRP\s*[^\n]+\s*<dd class="vehicle_price[^\n]+\s*(?<price>\$[0-9,]+)/';
        $list_regex       =  '/List Price\s*[^\n]+\s*<dd class="vehicle_price\s*"[^\n]+\s*(?<price>\$[0-9,]+)/';
        $sale_regex       =  '/Sale Price\s*[^\n]+\s*<dd class="vehicle_price\s*"[^\n]+\s*(?<price>\$[0-9,]+)/';
        $price_regex      =  '/>\s*Price\s*[^\n]+\s*<dd class="vehicle_price\s*"[^\n]+\s*(?<price>\$[0-9,]+)/';
                
                
        $matches = [];
        
        if(preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex MSRP: {$matches['price']}");
        }
         if(preg_match($list_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex list: {$matches['price']}");
        }
         if(preg_match($sale_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex sale: {$matches['price']}");
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
    function filter_toyotaofglendora_field_images($im_urls)
    {
        return array_filter($im_urls, function ($im_url){
            return !endsWith($im_url,'null_o.jpg');
        });
    }