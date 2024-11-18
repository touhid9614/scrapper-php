<?php
global $scrapper_configs;
 $scrapper_configs["mjmcguirenet"] = array( 
'entry_points' => array(
            'new'  => 'https://www.mjmcguire.net/new-inventory/index.htm',
            'used' => 'https://www.mjmcguire.net/used-inventory/index.htm',
        
        ),
        'vdp_url_regex'     => '/\/(?:new|used|certified)\/[^\/]+\/[0-9]{4}-/i',
        'ty_url_regex'      => '/\/form\/confirm.htm/i',
        'use-proxy' => true,
        'picture_selectors' => ['.slider-slide img'],
        'picture_nexts'     => ['.ddc-icon-carousel-arrow-right'],
        'picture_prevs'     => ['.ddc-icon-carousel-arrow-left'],
         'details_start_tag' => '<ul class="inventoryList data full list-unstyled">',
         //'details_end_tag' => '<div class="ft">',
         'details_spliter' => '<div class="item-compare">',
        'data_capture_regx' => array(
            'url'           => '/class="url"\s*href="(?<url>[^"]+)">(?<title>[^<]+)/',
            'title'         => '/class="url"\s*href="(?<url>[^"]+)">(?<title>[^<]+)/',
            'year'          => '/data-year="(?<year>[^"]+)/',
            'make'          => '/data-make="(?<make>[^"]+)/',
            'model'         => '/data-model="(?<model>[^"]+)/',
            'trim'          => '/data-trim="(?<trim>[^"]+)/',
            'price'         => '/"(?:invoicePrice|internetPrice|stackedFinal|final|msrp|salePrice|retailValue|askingPrice|stackedConditionalFinal) final-price"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/',
            'kilometres'    => '/Mileage:<\/dt>\s*<dd>(?<kilometres>[^\<]+)/',
            'stock_number'  => '/Stock #:<\/dt>\s*<dd>(?<stock_number>[^\<]+)/',
            'engine'        => '/Engine:<\/dt>\s*<dd>\s*(?<engine>[^\<]+)/',
            'body_style'    => '/data-bodyStyle="(?<body_style>[^"]+)/',
            'transmission'  => '/Transmission:<\/dt>\s*<dd>(?<transmission>[^\<]+)/',
            'exterior_color'=> '/Exterior Color:<\/dt>\s*<dd>(?<exterior_color>[^\<]+)/',
            'interior_color'=> '/Interior Color:<\/dt>\s*<dd>(?<interior_color>[^\<]+)/',
       
        ),
        'data_capture_regx_full' => array(        
            'make'          => '@make\: \'(?<make>[^\']+)\'@',
            'model'         => '@model\: \'(?<model>[^\']+)\'@',
            'body_style'    => '@bodyStyle: \'(?<body_style>[^\']+)@',
            'trim'          => '@"trim": "(?<trim>[^"]+)@',
         //   'biweekly'      => '/paymentLease"[^\n]+\s*<strong[^>]+>(?<biweekly>\$[0-9.,]+)/',
        ) ,
        'next_page_regx'    => '/<a rel="next" href="(?<next>[^"]+)"/',
         'images_regx' => '/id"[^"]+"src"[^"]+"(?<img_url>[^"]+)"/',
        'images_fallback_regx'  => '/<meta name="og:image" content="(?<img_url>[^"]+)"/'
    );
    
       add_filter("filter_mjmcguirenet_field_images", "filter_mjmcguirenet_field_images");
    function filter_mjmcguirenet_field_images($im_urls)
    {
      $retval = [];

    foreach ($im_urls as $img) {

        $retval[] = str_replace(["|", "%20", "?impolicy=resize&w=650", "?impolicy=resize&w=414", "?impolicy=resize&w=768", "?impolicy=resize&w=1024"], ["%7C", " ", " ", " ", " ", " "], $img);
    }

    return $retval;
    }
 add_filter("filter_mjmcguirenet_field_price", "filter_mjmcguirenet_field_price", 10, 3);
        function filter_mjmcguirenet_field_price($price,$car_data, $spltd_data)
        {
            $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho("mjmcguirenet Price: $price");
    }

    $msrp_regex = '/MSRP.*(?<price>\$[0-9,]+)/';
    $final_regex = '/Final Price[^>]+>:[^>]+>[^>]+>[^>]+>(?<price>[^<]+)/';
    $cond_final_regex = '/Conditional Final Price[^>]+>[^>]+>[^>]+>[^>]+>(?<price>\$[0-9,]+)/';
    $matches = [];

    if (preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex MSRP: {$matches['price']}");
    }

    if (preg_match($final_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex Final price: {$matches['price']}");
    }
    if (preg_match($cond_final_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex Conditional Price: {$matches['price']}");
    }
    if (count($prices) > 0) {
        $price = butifyPrice(min($prices));
    }

    slecho("Sale Price: {$price}" . '<br>');
    return $price;
    
}
