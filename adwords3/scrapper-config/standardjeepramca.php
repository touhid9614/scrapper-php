<?php

    global $scrapper_configs;

        $scrapper_configs['standardjeepramca'] = array(
        'entry_points' => array(
             'used'  => 'https://www.standardjeepram.ca/used/',
            'new'  => 'https://www.standardjeepram.ca/new/',
           
        ),
        'vdp_url_regex'     => '/\/vehicle\/[0-9]{4}-/i',
        'srp_page_regex'     => '/\/(?:new|used)\//i',
        'use-proxy' => true,
        'refine'=>false,
        'picture_selectors' => ['.thumb li'],
        'picture_nexts'     => ['.next.next-small'],
        'picture_prevs'     => ['.left.left-small'],
        'details_start_tag' => 'class="wp header-baset',
        'details_end_tag'   => '</footer>',
        'details_spliter'   => 'itemprop="ItemOffered',
        'data_capture_regx' => array(
            'url'                 => '/href="(?<url>[^"]+)"><span styl/',
            'year'                => '/itemprop=\'releaseDate\'[^>]+>(?<year>[0-9]{4})/',
            'make'                => '/itemprop=\'manufacturer\'[^>]+>[^>]+>(?<make>[^\s*<]+)/',
            'model'               => '/itemprop=\'model\'[^>]+>[^>]+>(?<model>[^\<]+)/',
            'price'               => '/(?:Our Price):[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>(?<price>[^<]+)/',
        ),
        'data_capture_regx_full' => array(  
            'kilometres'          => '/itemprop="mileageFromOdometer" class="mileage-used-value">[^>]+>[^>]+>(?<kilometres>[^<]+)/',  
            'body_style'          => '/itemprop="bodyType">(?<body_style>[^<]+)/',
            'trim'                => '/trim=(?<trim>[^\&]+)/',
            'vin'                 => '/itemprop="productID">(?<vin>[^<]+)/',  
            'stock_number'        => '/itemprop="sku">(?<stock_number>[^<]+)/',  
        ) ,
        'next_page_regx'    => '/class="active"><a\s*href="">.*<\/a><\/li>\s*<li><a\s*href="(?<next>[^"]+)/',
        'images_regx'       => '/imgError\(this\)\;"\s*(?:data-src|src)="(?<img_url>[^"]+)/'
    );
    
    add_filter("filter_standardjeepramca_field_images", "filter_standardjeepramca_field_images");
   
    function filter_standardjeepramca_field_images($im_urls)
    {
        return array_filter($im_urls, function($im_url){
            return !endsWith($im_url, 'no_image-640x480.jpg');
        });
    }


add_filter("filter_standardjeepramca_field_price", "filter_standardjeepramca_field_price", 10, 3);

function filter_standardjeepramca_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho(" Price: $price");
    }

    $msrp_regex = '/Now:[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>(?<price>[^<]+)/';
    $wholesale_regex = '/wholesalePrice">.*class=\'value[^>]+>(?<price>[^<]+)/';
    $internet_regex = '/internetPrice">.*class=\'value[^>]+>(?<price>[^<]+)/';
    $cond_final_regex = '/stackedConditionalFinal"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/';
    $retail_regex = '/retailValue"[^>]+>\s*<strong[^>]+>(?<price>[^<]+)/';
    $asking_regex = '/askingPrice"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/';


    $matches = [];

    if (preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex MSRP: {$matches['price']}");
    }
    if (preg_match($wholesale_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex wholesale: {$matches['price']}");
    }
    if (preg_match($internet_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex internet: {$matches['price']}");
    }

    if (preg_match($cond_final_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex Conditional Price: {$matches['price']}");
    }

    if (preg_match($retail_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex Retail Price: {$matches['price']}");
    }
    if (preg_match($asking_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex Asking Price: {$matches['price']}");
    }

    if (count($prices) > 0) {
        $price = butifyPrice(min($prices));
    }

    slecho("Sale Price: {$price}" . '<br>');
    return $price;
}
