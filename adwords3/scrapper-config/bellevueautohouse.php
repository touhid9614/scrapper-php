<?php
global $scrapper_configs;
 $scrapper_configs["bellevueautohouse"] = array( 
	 'entry_points' => array(
            'used'  => 'http://www.bellevueautohouse.com/bellevue-used-cars',
        ),
        'vdp_url_regex'     => '/\/detail/i',
       // 'ty_url_regex'      => '/\/eprice-[^\?]+\?.*form-action=success/i',
        'use-proxy' => true,
        
        'picture_selectors' => ['.item'],
        'picture_nexts'     => ['.right'],
        'picture_prevs'     => ['.left'],
        
        'details_start_tag' => '<div class="browse-page clearfix">',
        'details_end_tag'   => '<footer id="footer"',
        'details_spliter'   => '<div class="clearfix">',
        
        'data_capture_regx' => array(
            'stock_number'  => '/Stock(?:#| Number):<\/span><span[^>]+>(?<stock_number>[^<]+)/',
            'url'           => '/id="link_[0-9]*" value="(?<url>[^"]+)/',
            'title'         => '/<h4 class="hidden-xs">(?<title>(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
            'year'          => '/<h4 class="hidden-xs">(?<title>(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
            'make'          => '/<h4 class="hidden-xs">(?<title>(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
            'model'         => '/<h4 class="hidden-xs">(?<title>(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
            'price'         => '/Our Price:<\/span><span[^>]+>(?<price>\$[0-9,]+)/',
            'exterior_color'=> '/Exterior:<\/span><span[^>]+>(?<exterior_color>[^<]+)/',
            'interior_color'=> '/Interior:<\/span><span[^>]+>(?<interior_color>[^<]+)/',
            'kilometres'    => '/Mileage:<\/span><span[^>]+>(?<kilometres>[^<]+)/',
            'certified'     => '/"images/detail/btn_toyota-(?<certified>certified).png/'
            
            
        ),
        'data_capture_regx_full' => array(
            'make'          => '/Make_(?<make>[^;]+)/',
            'model'         => '/Model_(?<model>[^;]+)/',
            'transmission'  => '/Transmission:<\/span><span[^>]+>(?<transmission>[^<]+)/',
            'engine'        => '/Engine:<\/span><span[^>]+>(?<engine>[^<]+)/',
            'body_style'    => '/Body Type:<\/span>[^>]+>(?<body_style>[^<]+)/',
            
            
        ),
        //'next_page_regx'    => '/<li id="il-pagination-element-[0-9]*" class="active">\s*<a.*\s*<\/li>\s*<li[^>]+>\s*<a href="(?<next>[^"]+)"/',
        'images_regx'       => '/class="item" data-pos="[0-9]+"><img src="(?<img_url>[^"]+)/',
        'images_fallback_regx'   => '/<meta\s*name="og:image"\s*content="(?<img_url>[^"]+)/'
    );
    add_filter("filter_bellevueautohouse_field_price", "filter_bellevueautohouse_field_price", 10, 3);
    function filter_bellevueautohouse_field_price($price,$car_data, $spltd_data)
    {
        $prices = [];
        
        slecho('');
        
        if($price && numarifyPrice($price) > 0) {
            $prices[] = numarifyPrice($price);
            slecho("Regex Sale Price: $price");
        }
        
       
        $msrp_regex =  '/MSRP:<\/span><span class="high-price-value">(?<price>\$[0-9,]+)/';
        
        $matches = [];
        
        if(preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex MSRP: {$matches['price']}");
        }
        
        if(count($prices) > 0) {
            $price = butifyPrice(min($prices));
        }
        
        slecho("Sale Price: {$price}".'<br>');
        return $price;
    }