<?php

global $scrapper_configs;

$scrapper_configs['goschfordtemecula'] = array(
     'entry_points' => array(
            'new'   => 'https://www.goschfordtemecula.biz/new-inventory/index.htm',
            'used'  => 'https://www.goschfordtemecula.biz/used-inventory/index.htm'
        ),
        'vdp_url_regex'     => '/\/(?:new|used|certified)\/+[^\/]+\/[0-9]{4}-/i',
        'ty_url_regex'      => '/\/form\/confirm.htm/i',
        'use-proxy' => true,
        
        'picture_selectors' => ['.jcarousel li'],
        'picture_nexts'     => ['.next'],
        'picture_prevs'     => ['.previous'],
        
        'details_start_tag' => '<ul class="inventoryList data full list-unstyled">',
        'details_end_tag'   => '<div class="ft">',
        'details_spliter'   => '<div class="item-compare">',
     
        'data_capture_regx' => array(
            'url'           => '/<a\s*class="url"\s*href="(?<url>[^"]+)">\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^ ]+)\s*(?<model>[^ ]+)\s*[^<]+)/',
            'title'         => '/<a\s*class="url"\s*href="(?<url>[^"]+)">\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^ ]+)\s*(?<model>[^ ]+)\s*[^<]+)/',
            'year'          => '/<a\s*class="url"\s*href="(?<url>[^"]+)">\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^ ]+)\s*(?<model>[^ ]+)\s*[^<]+)/',
            'make'          => '/data-make="(?<make>[^"]+)/',
            'model'         => '/data-model="(?<model>[^"]+)/',
            'trim'          => '/data-trim="(?<trim>[^"]+)/',
            'stock_number'  => '/Stock\s*#:<\/dt>\s*<dd>(?<stock_number>[^<]+)/',
            'price'         => '/"(?:invoicePrice|internetPrice|stackedFinal|final|msrp|salePrice|retailValue|askingPrice|stackedConditionalFinal) final-price"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/',
            'exterior_color'=> '/data-exteriorColor="(?<exterior_color>[^"]+)/',
            'body_style'    => '/data-bodyStyle="(?<body_style>[^"]+)/',
            'trim'          => '/data-trim="(?<trim>[^"]+)/',
            'interior_color'=> '/Interior\s*Color:<\/dt>\s*<dd>(?<interior_color>[^<]+)/',
            'engine'        => '/Engine:<\/dt>\s*<dd>(?<engine>[^<]+)/',
            'transmission'  => '/Transmission:<\/dt>\s*<dd>(?<transmission>[^<]+)/',
            'kilometres'    => '/Mileage:<\/dt>\s*<dd>(?<kilometres>[^<]+)/'
           
        ),
        'data_capture_regx_full' => array(          
            'make'          => '/make":\s*"(?<make>[^"]+)/',
            'model'         => '/model":\s*"(?<model>[^"]+)/',
             'price'         => '/"(?:invoicePrice|internetPrice|stackedFinal|final|msrp|salePrice|retailValue|askingPrice|stackedConditionalFinal) final-price" data-attribute-value="(?<price>[^"]+)/',
           // 'certified'     => '/"inventoryType":\s*"(?<certified>certified)"/',
           // 'biweekly'      => '/(?:paymentLoan|paymentLease)"[^\n]+\s*<strong[^>]+>(?<biweekly>\$[0-9.,]+)/',
        ),
        'next_page_regx'    => '/rel="next"\s*data-href="(?<next>[^"]+)/',
        'images_regx'       => '/<a href="(?<img_url>[^"]+)"\s*class="js-link">/',
        'images_fallback_regx'  => '/<meta name="og:image" content="(?<img_url>[^"]+)"/'
    );
    
     add_filter("filter_goschfordtemecula_field_model", "filter_goschfordtemecula_field_model");
     add_filter("filter_goschfordtemecula_field_price", "filter_goschfordtemecula_field_price", 10, 3);
    function filter_goschfordtemecula_field_model($model)
    {
       return  str_replace('\x20', ' ', $model);
    }
   
    function filter_goschfordtemecula_field_price($price,$car_data, $spltd_data)
    {
        $prices = [];
        
        slecho('');
        
        if($price && numarifyPrice($price) > 0) {
            $prices[] = numarifyPrice($price);
            slecho(" Price: $price");
        }
        
        $msrp_regex       =  '/msrp">.*class=\'value[^>]+>(?<price>[^<]+)/';
        $wholesale_regex  =  '/wholesalePrice">.*class=\'value[^>]+>(?<price>[^<]+)/';
        $internet_regex   =  '/internetPrice">.*class=\'value[^>]+>(?<price>[^<]+)/';
        $cond_final_regex =  '/stackedConditionalFinal"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/';
        $retail_regex     =  '/retailValue"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/';
        $asking_regex     =  '/askingPrice"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/';

                
        $matches = [];
        
        if(preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex MSRP: {$matches['price']}");
        }
        if(preg_match($wholesale_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex wholesale: {$matches['price']}");
        }
        if(preg_match($internet_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex internet: {$matches['price']}");
        }
       
        if(preg_match($cond_final_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex Conditional Price: {$matches['price']}");
        }
        
        if(preg_match($retail_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex Retail Price: {$matches['price']}");
        }
        if(preg_match($asking_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex Asking Price: {$matches['price']}");
        }
        
        slecho("Sale Price: {$price}".'<br>');
        return $price;
    }
    
    add_filter("filter_goschfordtemecula_field_images", "filter_goschfordtemecula_field_images");

    function filter_goschfordtemecula_field_images($im_urls)
    {
        if(count($im_urls) > 0) { unset($im_urls[0]); }
        return $im_urls;
    }
    
