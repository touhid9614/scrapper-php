<?php
global $scrapper_configs;
$scrapper_configs["holidayautogroupcom"] = array( 
	'entry_points' => array(
            'new'   => 'https://www.holidayautogroup.com/new/',
            'used'  => 'https://www.holidayautogroup.com/used/',
        ),
        'vdp_url_regex'     => '/\/details\//i',
        'use-proxy' => true,
        'picture_selectors' => ['.smallimage'],
        'picture_nexts'     => [''],
        'picture_prevs'     => [''],
        
        'details_start_tag' => '<div class="inventory_results_area',
        'details_end_tag'   => '<div class="footer_',
        'details_spliter'   => '<div class="inv_separator_margin',
        'data_capture_regx' => array(
            'url'                 => '/<a href="(?<url>[^"]+)" onClick/',
            'year'                => '/inventory_search_title">(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*(?<model>[^\s*]+)\s*(?<trim>[^<]+)/',
            'make'                => '/inventory_search_title">(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*(?<model>[^\s*]+)\s*(?<trim>[^<]+)/',
            'model'               => '/inventory_search_title">(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*(?<model>[^\s*]+)\s*(?<trim>[^<]+)/',
            'price'               => '/search_secondary_price-low new_inv_cell">(?<price>\$[0-9,]+)/',
            'kilometres'          => '/Mileage\s*[^>]+>\s*[^>]+>\s*(?<kilometres>[^<]+)/',
            'stock_number'        => '/Stock #[^>]+>[^>]+>(?<stock_number>[^\<]+)/',
            'engine'              => '/>Engine[^>]+>[^>]+>(?<engine>[^\<]+)/',
            'body_style'          => '/>Body Style[^>]+>[^>]+>(?<body_style>[^\<]+)/',
            'transmission'        => '/>Trans[^>]+>[^>]+>(?<transmission>[^\<]+)/',
             'exterior_color'     => '/>Ext. Color[^>]+>[^>]+>(?<exterior_color>[^\<]+)/',
            'interior_color'      => '/>Int. Color[^>]+>[^>]+>(?<interior_color>[^\<]+)/' 
        ),
        'data_capture_regx_full' => array(        
            
        ) ,
        'next_page_regx'    => '/<a href="(?<next>[^"]+)" class="chameleon"/',
        'images_regx'       => '/onClick="setphotourl[^\']+\'(?<img_url>[^\']+)/'
    );
 add_filter("filter_holidayautogroupcom_field_price", "filter_holidayautogroupcom_field_price", 10, 3);
        function filter_holidayautogroupcom_field_price($price,$car_data, $spltd_data)
        {
            $prices = [];

            slecho('');

            if($price && numarifyPrice($price) > 0) {
                $prices[] = numarifyPrice($price);
                slecho("holidayautogroupcom Price: $price");
            }

            $msrp_regex =  '/MSRP:[^>]+>[^>]+>(?<price>\$[0-9,]+)/';
            $selling_regex  =  '/Selling Price:[^>]+>[^>]+>(?<price>\$[0-9,]+)/';
           

            $matches = [];

            if(preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
                $prices[] = numarifyPrice($matches['price']);
                slecho("Regex MSRP: {$matches['price']}");
            }
            
            if(preg_match($selling_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
                $prices[] = numarifyPrice($matches['price']);
                slecho("Regex selling price: {$matches['price']}");
            }

            if(count($prices) > 0) {
                $price = butifyPrice(min($prices));
            }

            slecho("Sale Price: {$price}".'<br>');
            return $price;
        }



