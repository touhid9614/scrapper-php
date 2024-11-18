<?php
    global $scrapper_configs;

    $scrapper_configs['romenissan'] = array(
        'entry_points' => array(
            'new'   => 'http://www.romenissan.com/new-nissan-rome-ga',
            'used'  => 'http://www.romenissan.com/used-cars-rome-ga',
        ),
        'vdp_url_regex'     => '/\/vehicle-details\//i',
        
        'use-proxy' => true,
        'picture_selectors' => ['.thumb'],
        'picture_nexts'     => ['.right'],
        'picture_prevs'     => ['.left'],
        'details_start_tag' => '<div class="c-vehicles clearfix grid">',
        'details_end_tag'   => '<div class="com-inventory-listing-pagination row',
        'details_spliter'   => '<div class="vehicle clearfix"',
        'must_contain_regx' => '/<link itemprop="availability" href="http:\/\/schema.org\/InStock"\/>/i',
        
        'data_capture_regx' => array(
            'stock_number'  => '/<meta itemprop="sku" content="(?<stock_number>[^"]+)/',
            'url'           => '/<meta itemprop="url" content="(?<url>[^"]+)/',
            'title'         => '/<meta itemprop="name" content="(?<title>[^"]+)/',
            'year'          => '/<meta itemprop="releaseDate" content="(?<year>[^"]+)/',
            'make'          => '/<meta itemprop="brand" content="(?<make>[^"]+)/',
            'model'         => '/<meta itemprop="model" content="(?<model>[^"]+)/',
            'price'         => '/Your Price\s*(?<price>\$[0-9,]+)/',
            'exterior_color'=> '/Exterior Color<\/div>\s*<div class="[^"]+">(?<exterior_color>[^<]+)/',
            'body_style'    => '/Body<\/div>\s*<div class=".*body-value">(?<body_style>[^<]+)/',
            'interior_color'=> '/Interior Color<\/div>\s*<div class="[^"]+">(?<interior_color>[^<]+)/',
            'engine'        => '/Engine<\/div>\s*<div class="[^"]+">(?<engine>[^<]+)/',
            'transmission'  => '/Trans<\/div>\s*<div class="[^"]+">(?<transmission>[^<]+)/',
            'certified'     =>'/<img\s*src="[^"]+"\s*alt="Certified"\s*class="[^"]+"\s*title="(?<certified>[^"]+)"/'

        ),
        'data_capture_regx_full' => array(
            'trim'          => '/Trim:<\/strong><\/span>\s*<span[^>]+>(?<trim>[^<]+)/',
            'model'         => '/Model:<\/strong><\/span>\s*<span[^>]+>(?<model>[^<]+)/',
            'body_style'    => '/Body:<\/strong><\/span>\s*<span[^>]+>(?<body_style>[^<]+)/',
            'kilometres'    => '/Mileage:<\/strong><\/span>\s*<span[^>]+>(?<kilometres>[^<]+)/',
        ),
        'next_page_regx'    => '/<li id="il-pagination-element-[0-9]*" class="active">\s*<a.*\s*<\/li>\s*<li[^>]+>\s*<a href="(?<next>[^"]+)"/',
        'images_regx'       => '/<li><img src="(?<img_url>[^"]+)" alt="[0-9]{4} [^"]+" class="img-responsive" itemprop="image"/'
        );
       add_filter("filter_romenissan_field_price", "filter_romenissan_field_price", 10, 3);
       add_filter("filter_romenissan_field_images", "filter_romenissan_field_images");
        function filter_romenissan_field_price($price,$car_data, $spltd_data)
        {
            $prices = [];

            slecho('');

            if($price && numarifyPrice($price) > 0) {
                $prices[] = numarifyPrice($price);
                slecho("romenissan Price: $price");
            }

            $msrp_regex  =  '/MSRP<\/div>\s*<div class=".*msrp-value">(?<price>\$[0-9,]+)/';
            $sell_regex  =  '/Selling Price\s*(?<price>\$[0-9,]+)/';
            $list_regex  =  '/List Price:\s*(?<price>\$[0-9,]+)/';

            $matches = [];

            if(preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
                $prices[] = numarifyPrice($matches['price']);
                slecho("Regex MSRP: {$matches['price']}");
            }
            
            if(preg_match($sell_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
                $prices[] = numarifyPrice($matches['price']);
                slecho("Regex Selling: {$matches['price']}");
            }

            if(preg_match($list_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
                $prices[] = numarifyPrice($matches['price']);
                slecho("Regex List Price: {$matches['price']}");
            }

            if(count($prices) > 0) {
                $price = butifyPrice(min($prices));
            }

            slecho("Sale Price: {$price}".'<br>');
            return $price;
        }

    function filter_romenissan_field_images($im_urls)
    {
        return array_filter($im_urls, function($im_url){
            return !endsWith($im_url, 'noimage.jpg');
        });
    }

