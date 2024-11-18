<?php
    global $scrapper_configs;

    $scrapper_configs['bertogdenmissionkia'] = array(
        'entry_points' => array(
            'new'   => 'http://www.bertogdenmissionkia.com/new-kia-mission-tx',
            'used'  => 'http://www.bertogdenmissionkia.com/used-cars-mission-tx',
            'certified'=> 'http://www.bertogdenmissionkia.com/certified-used-kia-mission-tx'
        ),
        'vdp_url_regex'     => '/\/vehicle-details\/(?:new|used)-[0-9]{4}-/i',
       // 'ty_url_regex'      => '/\/eprice-[^\?]+\?.*form-action=success/i',
        'use-proxy' => true,
        'picture_selectors' => ['.slick-slide'],
        'picture_nexts'     => ['.right'],
        'picture_prevs'     => ['.left'],
        'details_start_tag' => '<div class="c-vehicles list">',
        'details_end_tag'   => '<div class="com-inventory-listing-pagination row',
        'details_spliter'   => '<div class="vehicle"',
        
        'data_capture_regx' => array(
            'stock_number'  => '/<meta itemprop="sku" content="(?<stock_number>[^"]+)/',
            'url'           => '/<meta itemprop="url" content="(?<url>[^"]+)/',
            'title'         => '/<meta itemprop="name" content="(?<title>[^"]+)/',
            'year'          => '/<meta itemprop="releaseDate" content="(?<year>[^"]+)/',
            'make'          => '/<meta itemprop="brand" content="(?<make>[^"]+)/',
            'model'         => '/<meta itemprop="model" content="(?<model>[^"]+)/',
            'price'         => '/Final Price:[^\n]+\s*.*\s*<[^>]+>(?<price>\$[0-9,]+)/',
            'exterior_color'=> '/<meta itemprop="color" content="(?<exterior_color>[^"]+)/',
            'interior_color'=> '/Interior:.*\s*<span class="value">(?<interior_color>[^<]+)/',
            'engine'        => '/<span class="spec-value spec-value-enginedescription">(?<engine>[^<]+)/',
            'transmission'  => '/<span class="spec-value spec-value-transmission">(?<transmission>[^<]+)/',
            'kilometres'    => '/<span class="spec-value spec-value-miles">(?<kilometres>[^<]+)/',
            'certified'     =>'/<img\s*src="[^"]+"\s*alt="Certified"\s*class="[^"]+"\s*title="(?<certified>[^"]+)"/'
        ),
        'data_capture_regx_full' => array(
            'trim'          => '/Trim:.*\s*<span class="value">(?<trim>[^ <]+)/',
            'body_style'    => '/Body\s*style\:.*\s*<span class="value">(?<body_style>[^<]+)/',
            
        ),
        'next_page_regx'    => '/<li id="il-pagination-element-[0-9]*" class="active">\s*<a.*\s*<\/li>\s*<li[^>]+>\s*<a href="(?<next>[^"]+)"/',
        'images_regx'       => '/<li><img src="(?<img_url>[^"]+)" alt="[^"]+" class="img-responsive" itemprop="image"/'
    );
    
    add_filter("filter_bertogdenmissionkia_field_images", "filter_bertogdenmissionkia_field_images");
    add_filter("filter_bertogdenmissionkia_field_price", "filter_bertogdenmissionkia_field_price", 10, 3);

    function filter_bertogdenmissionkia_field_images($im_urls)
    {
        return array_filter($im_urls, function($im_url){
            return !endsWith($im_url, 'noimage_bertog.jpg');
        });
    }
    
    function filter_bertogdenmissionkia_field_price($price,$car_data, $spltd_data)
    {
        $prices = [];
        
        slecho('');
        
        if($price && numarifyPrice($price) > 0) {
            $prices[] = numarifyPrice($price);
            slecho("Final Price: $price");
        }
        
        $msrp_regex =  '/MSRP:[^\n]+\s*.*\s*<[^>]+>(?<price>\$[0-9,]+)/';
        $price_regex =  '/Price:[^\n]+\s*.*\s*(?<price>\$[0-9,]+)/';
        
        $matches = [];
        
        if(preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex MSRP: {$matches['price']}");
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
