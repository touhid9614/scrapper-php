<?php
    global $scrapper_configs;

    $scrapper_configs['johnsonfordofnewrichmond'] = array(
        'entry_points' => array(
            'new'   => 'http://www.johnsonfordofnewrichmond.net/new-inventory/index.htm',
            'used'  => 'http://www.johnsonfordofnewrichmond.net/used-inventory/index.htm'
        ),
        'vdp_url_regex'     => '/\/(?:new|used|certified)\/+[^\/]+\/[0-9]{4}-/i',
        'ty_url_regex'      => '/\/form\/confirm.htm/i',
        //'required_params'   => ['searchDepth'],
        'use-proxy' => true,
        'picture_selectors' => ['.jcarousel-item'],
        'picture_nexts'     => ['.imageScrollNext.next'],
        'picture_prevs'     => ['.imageScrollPrev.prev'],
        'details_start_tag' => '<ul class="inventoryList data full list-unstyled">',
        'details_end_tag'   => '<div class="ft">',
        'details_spliter'   => '<div class="item-compare">',
        
        'data_capture_regx' => array(
            'stock_number'  => '/Stock #:[^>]+>[^>]+>(?<stock_number>[^<]+)/',
            'title'         => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
            'year'          => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
            'make'          => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
            'model'         => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
            'price'         => '/final-price.*class=\'value[^>]+>(?<price>[^<]+)/',
            //'body_style'    => '/Bodystyle:[^>]+>[^>]+>(?<body_style>[^<]+)/',
            'engine'        => '/Engine:[^>]+>[^>]+>(?<engine>[^<]+)/',
            'transmission'  => '/Transmission:[^>]+>[^>]+>(?<transmission>[^<]+)/',
            'exterior_color'=> '/Exterior Colou?r:[^>]+>[^>]+>(?<exterior_color>[^<\[]+)/',
            'interior_color'=> '/Interior Colou?r:[^>]+>[^>]+>(?<interior_color>[^<]+)/',
            'kilometres'    => '/Mileage:[^>]+>[^>]+>(?<kilometres>[^<]+)/',
            'url'           => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/'
        ),
        'next_page_regx'    => '/rel="next" *(?:data-href|href)="(?<next>[^"]+)"/',
        'images_regx'       => '/<a\s*href="(?<img_url>[^"]+)"\s*class="js-link"/',
        'images_fallback_regx'  => '/<meta name="og:image" content="(?<img_url>[^"]+)"/'
    );
    add_filter("filter_johnsonfordofnewrichmond_field_images", "filter_johnsonfordofnewrichmond_field_images");
    add_filter("filter_johnsonfordofnewrichmond_field_price", "filter_johnsonfordofnewrichmond_field_price",10,3);
    
    function filter_johnsonfordofnewrichmond_field_images($im_urls)
    {
       $retval = array();

        foreach($im_urls as $url) {
            $retval[] = str_replace('|', '%7C', $url);
        }

        return $retval;
    }
function filter_johnsonfordofnewrichmond_field_price($price,$car_data, $spltd_data)
    {
        $prices = [];
        
        slecho('');
        
        if($price && numarifyPrice($price) > 0) {
            $prices[] = numarifyPrice($price);
            slecho("Regex Sale Price: $price");
        }
        
        $john_price_regex =  '/Johnson Price<[^\$]+(?<price>[^<]+)/';
        $retail_regex     =  '/Retail Price<[^\$]+(?<price>[^<]+)/';
        $msrp_regex       =  '/MSRP<[^\$]+(?<price>[^<]+)/';
        
        $matches = [];
        
        if(preg_match($john_price_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex Johnson Price: {$matches['price']}");
        }
        
        if(preg_match($retail_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex Retail Price: {$matches['price']}");
        }
        
        if(preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex MSRP: {$matches['price']}");
        }
        
        if(count($prices) > 0) {
            $price = butifyPrice(min($prices));
        }
        
        slecho("Final Sale Price: {$price}".'<br>');
        return $price;
    }