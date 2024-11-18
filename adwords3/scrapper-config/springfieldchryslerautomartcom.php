<?php
global $scrapper_configs;
$scrapper_configs["springfieldchryslerautomartcom"] = array( 
	   'entry_points' => array(
            'new'   => 'https://www.springfieldchryslerautomart.com/searchnew.aspx?Dealership=Springfield%20Chrysler%20Auto%20Mart%20Inc',
            'used'  => 'https://www.springfieldchryslerautomart.com/searchused.aspx?Dealership=Springfield%20Chrysler%20Auto%20Mart%20Inc',
        ),
        'use-proxy' => true,
        'vdp_url_regex'     => '/\/(?:new|used)-[^-]+-[0-9]{4}/i',
        'ty_url_regex'      => '/\/thankyou.aspx/i',

        'picture_selectors' => ['.carousel__item'],
        'picture_nexts'     => ['.carousel__control--next'],
        'picture_prevs'     => ['.carousel__control--prev'],

        'details_start_tag' => '<div class="col-md-9 sidebar-oncanvas',
        'details_end_tag'   => '<footer class',
        'details_spliter'   => '<div id="srpRow',
        'data_capture_regx' => array(
            'stock_number'  => '/Stock\s*#:\s*<\/strong>\s*(?<stock_number>[^<]+)/',
            'title'         => '/"stat-text-link".*href="(?<url>[^"]+)">\s*[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*(?<model>[^ <]+)[^\n<]*)/',
            'year'          => '/"stat-text-link".*href="(?<url>[^"]+)">\s*[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*(?<model>[^ <]+)[^\n<]*)/',
            'make'          => '/"stat-text-link".*href="(?<url>[^"]+)">\s*[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*(?<model>[^ <]+)[^\n<]*)/',
            'model'         => '/"stat-text-link".*href="(?<url>[^"]+)">\s*[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*(?<model>[^ <]+)[^\n<]*)/',
            'price'         => '/FINAL PRICE:\s*[^>]+>[^>]+>(?<price>[$0-9,]+)/',
            'engine'        => '/Engine: <\/strong>\s*(?<engine>[^<]+)/',
            'transmission'  => '/Transmission:\s*<\/strong>\s*(?<transmission>[^<]+)/',
            'exterior_color'=> '/Ext. Color:\s*<\/strong>\s*(?<exterior_color>[^<]+)/',
            'interior_color'=> '/Int. Color:\s*<\/strong>\s*(?<interior_color>[^<]+)/',
            'kilometres'    => '/Mileage:\s*<\/strong>\s*(?<kilometres>[^<]+)/',
            'url'           => '/"stat-text-link".*href="(?<url>[^"]+)">\s*[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*(?<model>[^ <]+)[^\n<]*)/',
            'body_style'    => '/Body Style:\s*<\/strong>\s*(?<body_style>[^<]+)/'
        ),
        'data_capture_regx_full' => array(
            'make'          => '/vehicleMake="(?<make>[^"]+)/',
            'model'         => '/vehicleModel="(?<model>[^"]+)/',
            'trim'          => '/vehicleTrim="(?<trim>[^"]+)/'
        ) ,
        'next_page_regx'    => '/<li\s*class="active[^>]+>[\s\S]+?<\/li>\s*<li\s*>\s*<a[\s\S]+?href="(?<next>[^"]+)"/',
        'images_regx'       => '/data-image-full="(?<img_url>[^\?]+)/',
    );
    
     add_filter("filter_springfieldchryslerautomartcom_field_price", "filter_springfieldchryslerautomartcom_field_price", 10, 3);
    
    function filter_springfieldchryslerautomartcom_field_price($price,$car_data, $spltd_data)
    {
        $prices = [];
        
        slecho('');
        
        if($price && numarifyPrice($price) > 0) {
            $prices[] = numarifyPrice($price);
            slecho("Regex Selling Price: $price");
        }
        
        $internet_regex  =  '/Internet Price\s*[^>]+>[^>]+>(?<price>[$0-9,]+)/';
        $retail_regex    =  '/Retail Price:\s*[^>]+>[^>]+>(?<price>[$0-9,]+)/';
        $msrp_regex      =  '/MSRP:\s*<\/span>\s*<span class="pull-right[^>]+>(?<price>[$0-9,]+)/';

        $matches = [];
        
        if(preg_match($internet_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex Internet Price: {$matches['price']}");
        }
        
        if(preg_match($retail_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex Price: {$matches['price']}");
        }
        
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
