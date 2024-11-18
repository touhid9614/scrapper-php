<?php
    global $scrapper_configs;

    $scrapper_configs['starautosuperstore'] = array(
        'entry_points' => array(
            'new'   => 'https://www.starautosuperstore.com/searchnew.aspx',
            'used'  => 'https://www.starautosuperstore.com/searchused.aspx'
        ),
        'vdp_url_regex'     => '/\/(?:new|used)-Wiggins-[0-9]{4}-/i',
        'ty_url_regex'      => '/\/thankyou.aspx/i',
      //  'ajax_url_match'    => 'callback=secureLeadSubmission',
        'use-proxy'         => true,
        
        //'picture_selectors' => ['#vehicleImgThumbnail .thumbs'],
        'picture_selectors' => ['.thumbs'],
        'picture_nexts'     => ['.mfp-arrow-right'],
        'picture_prevs'     => ['.mfp-arrow-left'],
        
        'details_start_tag'   => '<div class="row srpVehicle">',
        'details_end_tag'     => '<div class="row srpDisclaimer">',
        'details_spliter'     => '<div id="srpRow-',
        'data_capture_regx' => array(
            'url'              => '/class="vehicleTitle\s*margin-[^>]+>\s*<a\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^\s]+))/',
            'title'            => '/class="vehicleTitle\s*margin-[^>]+>\s*<a\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^\s]+))/',
            'year'             => '/class="vehicleTitle\s*margin-[^>]+>\s*<a\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^\s]+))/',
            'make'             => '/class="vehicleTitle\s*margin-[^>]+>\s*<a\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^\s]+))/',
            'model'            => '/class="vehicleTitle\s*margin-[^>]+>\s*<a\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^\s]+))/',
            'body_style'       => '/<strong>Body\s*Style:\s*[^>]+>(?<body_style>[^<\/]+)/',
            'transmission'     => '/<strong>Transmission:\s*[^>]+>(?<transmission>[^<\/]+)/',
            'engine'           => '/<strong>Engine:\s*[^>]+>(?<engine>[^<\/]+)/',
            'exterior_color'   => '/<strong>Ext.\s*Color:\s*[^>]+>(?<exterior_color>[^<\/]+)/',
            'interior_color'   => '/<strong>Int.\s*Color:\s*[^>]+>(?<interior_color>[^<\/]+)/',
            'stock_number'     => '/<strong>Stock\s*#:\s*[^>]+>(?<stock_number>[^<\/]+)/',
            'kilometres'       => '/<strong>Mileage\s*[^>]+>(?<kilometres>[^<\/]+)/',
            'price'            => '/Internet Price:\s*[^"]+"[^>]+>\$(?<price>[^<\/]+)/',
        ),
        'data_capture_regx_full' => array(
            'make'          => '/(?:New|Used)\s*[0-9]{4}[^"]*" \s*href="[^\&]+\&make=(?<make>[^\&]+)\&model=(?<model>[^\&]+)\&trim=(?<trim>[^"]+)/',
            'model'         => '/(?:New|Used)\s*[0-9]{4}[^"]*" \s*href="[^\&]+\&make=(?<make>[^\&]+)\&model=(?<model>[^\&]+)\&trim=(?<trim>[^"]+)/',
            'trim'          => '/(?:New|Used)\s*[0-9]{4}[^"]*" \s*href="[^\&]+\&make=(?<make>[^\&]+)\&model=(?<model>[^\&]+)\&trim=(?<trim>[^"]+)/',
        ),
        //'next_page_regx' => '/<li class="active[^"]*" >\s*<a >\s*.*\s*[^<]+<\/a>\s*<\/li>\s*<li >\s*<a href="(?<next>[^"]+)"/',
        'next_page_regx' => '/<a href="(?<next>[^"]+)"\s*>\s*Next/',
        'images_regx'   => '/<div class=\'item[^>]+>\s*<div class=\'row\' onclick="DealerOnTrack.event\(\'Gallery Views\'[^"]+" href="(?<img_url>[^"]+)/'
    );
    add_filter("filter_starautosuperstore_field_price", "filter_starautosuperstore_field_price", 10, 3);
    add_filter("filter_starautosuperstore_field_model", "filter_starautosuperstore_field_model");
    add_filter("filter_starautosuperstore_field_trim", "filter_starautosuperstore_field_trim");
    function filter_starautosuperstore_field_price($price,$car_data, $spltd_data)
    {
        $prices = [];
        
        slecho('');
        
        if($price && numarifyPrice($price) > 0) {
            $prices[] = numarifyPrice($price);
            slecho("Internet Price: $price");
        }
        
        $msrp_regex =  '/MSRP:\s*[^"]+"[^>]+>\$(?<price>[^<\/]+)/';
        $sale_regex =  '/Sale Price: \s*[^"]+"[^"]+"[^>]+>(?<price>\$[0-9,]+)/';
        $asking_regex =  '/Asking Price: \s*[^"]+"[^"]+"[^>]+>(?<price>\$[0-9,]+)/';
        
        $matches = [];
        
        if(preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex MSRP: {$matches['price']}");
        }
        if(preg_match($sale_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex sale: {$matches['price']}");
        }
        if(preg_match($asking_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex asking: {$matches['price']}");
        }
        
        if(count($prices) > 0) {
            $price = butifyPrice(min($prices));
        }
        
        slecho("Sale Price: {$price}".'<br>');
        return $price;
    }
    function filter_starautosuperstore_field_model($model)
    {
        return str_replace('+', ' ', $model);
    }
    function filter_starautosuperstore_field_trim($trim)
    {
        return str_replace('+', ' ', $trim);
    }
 