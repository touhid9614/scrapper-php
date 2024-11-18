<?php
    global $scrapper_configs;

    $scrapper_configs['goschtoyota'] = array(
        'entry_points' => array(
            'new'   => 'https://www.goschtoyota.com/inventory.php?type=new',
            'used'  => 'https://www.goschtoyota.com/inventory.php?type=used'
        ),
        'vdp_url_regex'     => '/\/vehicle-details\//i',
        'ty_url_regex'      => '/\/thank-you\?formName/i',
        'use-proxy'         => true,
        'picture_selectors' => ['.magic-thumbs ul li','.slick-slide',],
        'picture_nexts'     => ['.mz-button.mz-button-next'],
        'picture_prevs'     => ['.mz-button.mz-button-prev'],
        
        'details_start_tag' => '<div class="srp-vehicle-container" >',
        'details_end_tag'   => '<div class="footer">',
        'details_spliter'   => '<div class="row srp-vehicle"',
        
        'data_capture_regx' => array(
            'stock_number'      => '/Stock:<\/span>\s*(?<stock_number>[^<]+)/',
            'title'             => '/<span itemprop=\'name\'>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*[^<]*)/',
            'year'              => '/<span itemprop=\'name\'>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*[^<]*)/',
            'make'              => '/<span itemprop=\'name\'>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*[^<]*)/',
            'model'             => '/<span itemprop=\'name\'>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*[^<]*)/',
            'price'             => '/(?:Sale|Net) Price:[^\$]+\$.*itemprop=\'price\' content=\'(?<price>[^\']+)/',
            'engine'            => '/Engine:<\/span>\s*(?<engine>[^<]+)/',
            'transmission'      => '/Transmission:<\/span>\s*(?<transmission>[^<]+)/',
            'kilometres'        => '/Mileage:<\/span>\s*(?<kilometres>[^<]+)/',
            'exterior_color'    => '/Ext. Color:<\/span>\s*(?<exterior_color>[^<]+)/',
            'url'               => '/srp-vehicle-title">\s*<a href="(?<url>[^"]+)/'
        ),
        'data_capture_regx_full' => array(
            'make'          => '/make":\s*"(?<make>[^"]+)/',
            'model'         => '/model":\s*"(?<model>[^"]+)/',
            'trim'          => '/trim":\s*"(?<trim>[^"]+)/',
            'interior_color'=> '/Int. Color:<\/span>\s*(?<interior_color>[^<]+)/',
            'body_style'    => '/Body Style:<\/span>\s*(?<body_style>[^<]+)/',
            
        ) ,
        'next_page_regx'    => '/current\'><a[^>]+>[0-9]<\/a><\/li><li><a href=\'(?<next>[^\']+)/',
        'images_regx'       => '/vehicleGallery" href="(?<img_url>[^"]+)/',
    );
    
    
    /*
    
    add_filter("filter_goschtoyota_field_price", "filter_goschtoyota_field_price", 10, 3);
    
    function filter_goschtoyota_field_price($price,$car_data, $spltd_data)
    {
        $prices = [];
        
        slecho('');
        
        if($price && numarifyPrice($price) > 0) {
            $prices[] = numarifyPrice($price);
            slecho("Final Price: $price");
        }
        
        $msrp_regex   =  '/MSRP:[^\$]+\$.*itemprop=\'price\' content=\'(?<price>[^\']+)/';
        $retail_regex =  '/Retail Price:[^\$]+\$.*itemprop=\'price\' content=\'(?<price>[^\']+)/';
        
        $matches = [];
        
        if(preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex MSRP: {$matches['price']}");
        }
        if(preg_match($retail_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex retail price: {$matches['price']}");
        }
        
        if(count($prices) > 0) {
            $price = butifyPrice(min($prices));
        }
        
        slecho("Sale Price: {$price}".'<br>');
        return $price;
    }
     * 
     */