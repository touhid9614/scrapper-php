<?php
    global $scrapper_configs;

    $scrapper_configs['acuraofseattle'] = array(
        'entry_points' => array(
            //'new'   => 'http://espanol.toyotaofglendora.com/buscar/nuevo/tp/',
            'used'  => 'https://www.acuraofseattle.com/search/used-seattle-wa/?s:yr=1&cy=98188&tp=used',
           // 'certified' => 'https://www.espanol_toyotaofglendora.com/search/certified/tp/'
        ),
        'use-proxy' => true,
        'vdp_url_regex'     => '/\/auto\/(?:nuevo|usado|new|used)-[0-9]{4}-/i',
        //'ty_url_regex'      => '/\/thank-you-/i',
        'picture_selectors' => ['.dep_image_slider_ul_style li'],
        'picture_nexts'     => ['.dep_image_slider_next_btn'],
        'picture_prevs'     => ['.dep_image_slider_prev_btn'],
        'details_start_tag' => 'class="srp_results carbon">',
        'details_end_tag'   => '<div id="details-disclaimer"',
        'details_spliter'   => 'class="vehicle_item"',
        
        'data_capture_regx' => array(
            'stock_number'  => '/Stock #[^>]+>[^>]+>(?<stock_number>[^<]+)/',
            'year'          => '/alt="[^\s*]+\s*(?<year>[^\s*]+\s*(?<make>[^\s*]+)\s*)(?<model>[^"]+)/',
            'make'          => '/alt="[^\s*]+\s*(?<year>[^\s*]+\s*(?<make>[^\s*]+)\s*)(?<model>[^"]+)/',
            'model'         => '/alt="[^\s*]+\s*(?<year>[^\s*]+\s*(?<make>[^\s*]+)\s*)(?<model>[^"]+)/',
            'transmission'  => '/<meta\s*itemprop="vehicleTransmission"\s*content="(?<transmission>[^"]+)/',
            'price'         => '/class="vehicle_price[^>]+>\s*(?<price>[^<*]+)/',
            'exterior_color'=> '/Exterior Color[^>]+>[^>]+>(?<exterior_color>[^<]+)/',
            'interior_color'=> '/Interior Color[^>]+>[^>]+>(?<interior_color>[^<]+)/',
            'kilometres'    => '/Mileage[^>]+>[^>]+>(?<kilometres>[^<]+)/',
            'url'           => '/<a href="(?<url>[^"]+)"\s*alt/',
            // 'title'         => '/srp_vehicle_titlebar.*\s.*<h2\s*><a href="(?<url>[^"]+)".*title="(?<title>[^"]+)/',
            'engine'        => '/vehicleEngine"[^>]+>\s*[^"]+"[^"]+"[^"]+"(?<engine>[^"]+)/',
            'trim'          => '/Trim[^>]+>[^>]+>(?<trim>[^<]+)/',
            'vin'           => '/VIN[^>]+>[^>]+>(?<vin>[^<]+)/',
        ),
        'data_capture_regx_full' => array(
            
          //  'trim'          => '/Trim<\/td>\s*<td[^>]+>(?<trim>[^<]+)/',
          //  'model'         => '/<meta itemprop="model"\s*content="(?<model>[^"]+)/',
          //  'certified'     => '/<img\s*class="(?<certified>certified)"/'
        ),
        'next_page_regx'        => '/<li class="active[^>]+.*<\/li>\s*<li[^>]+>\s*<a\s*class="[^"]+"\s*href="(?<next>[^"]+)/',
        'images_regx'           => '/<meta property="og:image" content="(?<img_url>[^"]+)"/',
        //'images_fallback_regx'  => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'
    );
       add_filter("filter_acuraofseattle_field_price", "filter_acuraofseattle_field_price", 10, 3);
        function filter_acuraofseattle_field_price($price,$car_data, $spltd_data)
        {
            $prices = [];

            slecho('');

            if($price && numarifyPrice($price) > 0) {
                $prices[] = numarifyPrice($price);
                slecho("acuraofseattle Price: $price");
            }

            $msrp_regex =  '/MSRP.*(?<price>\$[0-9,]+)/';
            $now_regex  =  '/Now:\s*(?<price>\$[0-9,]+)/';
            $list_regex =  '/List Price:\s*(?<price>\$[0-9,]+)/';

            $matches = [];

            if(preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
                $prices[] = numarifyPrice($matches['price']);
                slecho("Regex MSRP: {$matches['price']}");
            }
            
            if(preg_match($now_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
                $prices[] = numarifyPrice($matches['price']);
                slecho("Regex Now: {$matches['price']}");
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



