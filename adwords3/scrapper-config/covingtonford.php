<?php

    global $scrapper_configs;

    $scrapper_configs['covingtonford'] = array(
        'entry_points' => array(
            'new'  => 'http://www.covingtonfordinc.com/new-cars/?condition=new-cars',
            'used' => 'http://www.covingtonfordinc.com/pre-owned/?condition=used-cars'
        ),
        'vdp_url_regex'     => '/\/listings\/[0-9]{4}-/i',
        
        //'use-proxy' => true,
        'proxy-area'        => 'FL',
        'picture_selectors' => ['.owl-item'],
        'picture_nexts'     => ['.owl-next','.fancybox-next'],
        'picture_prevs'     => ['.owl-prev','.fancybox-prev'],
        
        'details_start_tag' => '<div id="listings-result">',
        'details_end_tag'   => '<footer',
        'details_spliter'   => '<div class="listing-list-loop',
        'data_capture_regx' => array(
            'url'           => '/<a href="(?<url>[^"]+)" class[^>]+>\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*[^<]*)/',
            'title'         => '/<a href="(?<url>[^"]+)" class[^>]+>\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*[^<]*)/',
            'year'          => '/<a href="(?<url>[^"]+)" class[^>]+>\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*[^<]*)/',
            'make'          => '/<a href="(?<url>[^"]+)" class[^>]+>\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*[^<]*)/',
            'model'         => '/<a href="(?<url>[^"]+)" class[^>]+>\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*[^<]*)/',
            'price'         => '/sale-price">\s*<span[^\n]+\s*<span[^>]+>(?<price>\$[0-9,\s]+)/',
            'kilometres'    => '/Mileage[^\n]+\s*.*\s*<div[^\n]+\s*(?<kilometres>[^<]+)/',
            'stock_number'  => '/stock#[^>]+>(?<stock_number>[^<]+)/',
            'engine'        => '/Engine.*\s*[^\s]*\s+[^>]*>\s*(?<engine>[^<]+)/',
            'transmission'  => '/Transmission[^\n]+\s*.*\s*<div[^\n]+\s*(?<transmission>[^<]+)/',
        ),
        'data_capture_regx_full' => array(     
            'exterior_color'=> '/Exterior Color<\/td>\s*<td[^>]+>(?<exterior_color>[^<]+)/',
            'interior_color'=> '/Interior Color<\/td>\s*<td[^>]+>(?<interior_color>[^<]+)/',
            'make'          => '@"tax_make":\["(?<make>[^"]+)@',
            'model'         => '@"tax_serie":\["(?<model>[^"]+)@',
            'stock_number'  => '/Vin<\/td>\s*<td[^>]+>(?<stock_number>[^<]+)/'
        ) ,
        'next_page_regx'    => '/current\'>[^\n]+\s*<li><a.*href=\'(?<next>[^\']+)/',
        'images_regx'       => '/<a href="(?<img_url>[^"]+)" class="stm_fancybox"/',
        'images_fallback_regx'  => '/<meta property="og:image" content="(?<img_url>[^"]+)/'
    );
    add_filter("filter_covingtonford_field_price", "filter_covingtonford_field_price", 10, 3);

    function filter_covingtonford_field_price($price,$car_data, $spltd_data)
    {
        $prices = [];
        
        slecho('');
        
        if($price && numarifyPrice($price) > 0) {
            $prices[] = numarifyPrice($price);
            slecho("Final Price: $price");
        }
        
        
        $msrp_regex =  '/regular-price">\s*<span[^\n]+\s*(?<price>\$[0-9,\s]+)/';
        $normal_regex  =  '/sale-price">\s*<span[^>]+>(?<price>\$[0-9,\s]+)/';
        $regular_regex =  '/normal-price">\s*<span[^\n]+\s*(?<price>\$[0-9,\s]+)/';
        
        
        
        $matches = [];
        
        if(preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex MSRP: {$matches['price']}");
        }
        if(preg_match($normal_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex price: {$matches['price']}");
        }
        
        if(preg_match($regular_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex price: {$matches['price']}");
        }
        if(count($prices) > 0) {
            $price = butifyPrice(min($prices));
        }
        
        slecho("Sale Price: {$price}".'<br>');
        return $price;
    }


