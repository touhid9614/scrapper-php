<?php
    global $scrapper_configs;

    $scrapper_configs['jaguaroftacoma'] = array(
        'entry_points' => array(
           // 'new'   => 'http://www.jaguaroftacoma.com/new-jaguar-tacoma-wa',
            'used'  => 'http://www.jaguaroftacoma.com/used-cars-tacoma-wa',
          //  'certified' => 'http://www.jaguaroftacoma.com/certified-used-jaguar-tacoma-wa'
        ),
        'vdp_url_regex'     => '/\/vehicle-details\/(?:new|used)-[0-9]{4}-/i',
        
        'use-proxy' => true,
        'picture_selectors' => ['.thumb'],
        'picture_nexts'     => ['.right'],
        'picture_prevs'     => ['.left'],
        'details_start_tag' => '<div class="c-vehicles list">',
        'details_end_tag'   => '<div class="com-inventory-listing-pagination row',
        'details_spliter'   => '<div class="vehicle"',
        'must_contain_regx' => '/<link itemprop="availability" href="http:\/\/schema.org\/InStock"\/>/i',
        
        'data_capture_regx' => array(
            'stock_number'  => '/<meta itemprop="sku" content="(?<stock_number>[^"]+)/',
            'url'           => '/<meta itemprop="url" content="(?<url>[^"]+)/',
            'title'         => '/<meta itemprop="name" content="(?<title>[^"]+)/',
            'year'          => '/<meta itemprop="releaseDate" content="(?<year>[^"]+)/',
            'make'          => '/<meta itemprop="brand" content="(?<make>[^"]+)/',
            'model'         => '/<meta itemprop="model" content="(?<model>[^"]+)/',
            'price'         => '/Sale Price:\s*(?<price>\$[0-9,]+)/',
            'exterior_color'=> '/<meta itemprop="color" content="(?<exterior_color>[^"]+)/',
            'engine'        => '/<span class="spec-value spec-value-enginedescription">(?<engine>[^<]+)/',
            'transmission'  => '/<span class="spec-value spec-value-transmission">(?<transmission>[^<]+)/',
            'kilometres'    => '/<span class="spec-value spec-value-miles">(?<kilometres>[^<]+)/',
            'certified'     =>'/<img\s*src="[^"]+"\s*alt="Certified"\s*class="[^"]+"\s*title="(?<certified>[^"]+)"/'

        ),
        'data_capture_regx_full' => array(
            'trim'          => '/Trim:<\/strong><\/span>\s*<span[^>]+>(?<trim>[^<]+)/',
            'model'         => '/Model:<\/strong><\/span>\s*<span[^>]+>(?<model>[^<]+)/',
            'body_style'    => '/Body:<\/strong><\/span>\s*<span[^>]+>(?<body_style>[^<]+)/',
            'interior_color'=> '/Interior:<\/strong><\/span>\s*<span[^>]+>(?<interior_color>[^<]+)/',
            'kilometres'    => '/Mileage:<\/strong><\/span>\s*<span[^>]+>(?<kilometres>[^<]+)/',
        ),
        'next_page_regx'    => '/<li id="il-pagination-element-[0-9]*" class="active">\s*<a.*\s*<\/li>\s*<li[^>]+>\s*<a href="(?<next>[^"]+)"/',
        'images_regx'       => '/<li><img src="(?<img_url>[^"]+)" alt="[0-9]{4} [^"]+" class="img-responsive" itemprop="image"/'
        );
       add_filter("filter_jaguaroftacoma_field_price", "filter_jaguaroftacoma_field_price", 10, 3);
        function filter_jaguaroftacoma_field_price($price,$car_data, $spltd_data)
        {
            $prices = [];

            slecho('');

            if($price && numarifyPrice($price) > 0) {
                $prices[] = numarifyPrice($price);
                slecho("jaguaroftacoma Price: $price");
            }

            $msrp_regex =  '/MSRP.*(?<price>\$[0-9,]+)/';
            $price_regex =  '/>Price:\s*(?<price>\$[0-9,]+)/';

            $matches = [];

            if(preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
                $prices[] = numarifyPrice($matches['price']);
                slecho("Regex MSRP: {$matches['price']}");
            }
            
            if(preg_match($price_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
                $prices[] = numarifyPrice($matches['price']);
                slecho("Regex List Price: {$matches['price']}");
            }

            if(count($prices) > 0) {
                $price = butifyPrice(min($prices));
            }

            slecho("Sale Price: {$price}".'<br>');
            return $price;
        }



