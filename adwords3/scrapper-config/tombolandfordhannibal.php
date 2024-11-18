<?php
    global $scrapper_configs;

    $scrapper_configs['tombolandfordhannibal'] = array(
        'entry_points' => array(
            'new'   => 'http://www.tombolandfordhannibal.com/new-inventory/index.htm',
            'used'  => 'http://www.tombolandfordhannibal.com/used-inventory/index.htm'
        ),
        'vdp_url_regex'     => '/\/.*(?:new|used|certified)\/[^\/]+\/[0-9]{4}-/i',
        'ty_url_regex'      => '/\/form\/confirm.htm/i',
        //'required_params'   => ['searchDepth'],
        'use-proxy' => true,
        'picture_selectors' => ['.jcarousel-item'],
        'picture_nexts'     => ['.next'],
        'picture_prevs'     => ['.prev'],
        'details_start_tag' => '<ul class="inventoryList data full list-unstyled">',
        'details_end_tag'   => '<div class="ft">',
        'details_spliter'   => 'class="item notshared ',
        'data_capture_regx' => array(
            'stock_number'  => '/Stock #:[^>]+>[^>]+>(?<stock_number>[^<]+)/',
            'url'           => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
            'title'         => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
            'make'          => '/data-make="(?<make>[^"]+)/',
            'model'         => '/data-model="(?<model>[^"]+)/',
            'trim'          => '/data-trim="(?<trim>[^"]+)/',
            'price'         => '/(?:internetPrice final-price|stackedFinal final-price|final final-price|msrp final-price)"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/',
            'transmission'  => '/Transmission:[^>]+>[^>]+>(?<transmission>[^<]+)/',
            'exterior_color'=> '/Exterior Colou?r:[^>]+>[^>]+>(?<exterior_color>[^<\[]+)/',
            'interior_color'=> '/Interior Colou?r:[^>]+>[^>]+>(?<interior_color>[^<]+)/',
            'engine'        => '/Engine:[^>]+>[^>]+>(?<engine>[^<]+)/',
            'kilometres'    => '/<dt>Mileage:<\/dt>\s*<dd>(?<kilometres>[^\<]+)/'
        ),
        'data_capture_regx_full' => array(          
            'make'          => '/make":\s*"(?<make>[^"]+)/',
            'model'         => '/model":\s*"(?<model>[^"]+)/',
            'certified'     => '/"inventoryType":\s*"(?<certified>certified)"/',
        ),
        'next_page_regx'    => '/rel="next" *(?:data-href|href)="(?<next>[^"]+)"/',
        'images_regx'       => '/<a href="(?<img_url>[^"]+)" class="js-link">/',
        'images_fallback_regx'  => '/<meta name="og:image" content="(?<img_url>[^"]+)"/'
    );
     add_filter("filter_tombolandfordhannibal_field_model", "filter_tombolandfordhannibal_field_model");
     add_filter("filter_tombolandfordhannibal_field_price", "filter_tombolandfordhannibal_field_price", 10, 3);
     add_filter("filter_tombolandfordhannibal_field_images", "filter_tombolandfordhannibal_field_images");
    
    function filter_tombolandfordhannibal_field_images($im_urls)
    {
       $retval = array();

        foreach($im_urls as $url) {
            $retval[] = str_replace('|', '%7C', $url);     
        }

        return $retval;
    }
    function filter_tombolandfordhannibal_field_model($model)
    {
       return  str_replace('\x20', ' ', $model);
    }
   
    function filter_tombolandfordhannibal_field_price($price,$car_data, $spltd_data)
    {
        $prices = [];
        
        slecho('');
        
        if($price && numarifyPrice($price) > 0) {
            $prices[] = numarifyPrice($price);
            slecho(" Price: $price");
        }
        
        $msrp_regex       =  '/msrp">.*class=\'value[^>]+>(?<price>[^<]+)/';
        $internet_regex   =  '/internetPrice">.*class=\'value[^>]+>(?<price>[^<]+)/';
        $cond_final_regex =  '/stackedConditionalFinal"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/';
        $retail_regex     =  '/retailValue"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/';

                
        $matches = [];
        
        if(preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex MSRP: {$matches['price']}");
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
        
        if(count($prices) > 0) {
            $price = butifyPrice(min($prices));
        }
        
        slecho("Sale Price: {$price}".'<br>');
        return $price;
    }
