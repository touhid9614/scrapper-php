<?php
global $scrapper_configs;
 $scrapper_configs["green_hyundai"] = array( 
	'entry_points' => array(
            'new'  => 'http://www.green-hyundai.com/new-inventory/index.htm',
            'used' => 'http://www.green-hyundai.com/used-inventory/index.htm',
          //  'certified' => 'http://www.green_hyundai.com/certified-inventory/index.htm'
        ),
        'vdp_url_regex'     => '/\/(?:new|used|certified)\/[^\/]+\/[0-9]{4}-/i',
        'ty_url_regex'      => '/\/form\/confirm.htm/i',
        'use-proxy' => true,
        'picture_selectors' => ['#carousel .slide','.jcarousel li'],
        'picture_nexts'     => ['#hotspot_image .next','.imageScrollNext.next'],
        'picture_prevs'     => ['#hotspot_image .prev','.imageScrollPrev.previous'],
        
        'details_start_tag' => '<ul class="inventoryList data full list-unstyled">',
        'details_end_tag'   => '<div class="ft">',
        'details_spliter'   => '<div class="item-compare">',
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
            'engine'        => '/Engine:<\/dt>\s*<dd>(?<engine>[^\<]+)/',
            'body_style'    => '/data-bodyStyle="(?<body_style>[^"]+)/',
            'transmission'  => '/Transmission:<\/dt>\s*<dd>(?<transmission>[^\<]+)/',
            'exterior_color'=> '/Exterior Color:<\/dt>\s*<dd>(?<exterior_color>[^\<]+)/',
            'interior_color'=> '/Interior Color:<\/dt>\s*<dd>(?<interior_color>[^\<]+)/',
            'certified'     => '/<li class="(?<certified>certified)"><div class=\'badge \'\s*>/'
        ),
        'data_capture_regx_full' => array(        
            'make'          => '@make\: \'(?<make>[^\']+)\'@',
            'model'         => '@model\: \'(?<model>[^\']+)\'@',
            'body_style'    => '@bodyStyle: \'(?<body_style>[^\']+)@',
            'trim'          => '@"trim": "(?<trim>[^"]+)@',
            'biweekly'      => '/paymentLease"[^\n]+\s*<strong[^>]+>(?<biweekly>\$[0-9.,]+)/',
        ) ,
        'next_page_regx'    => '/href="(?<next>[^"]+)"\s*rel="next"/',
        'images_regx'       => '/<a href="(?<img_url>[^"]+)"\s*class="js-link">/',
        'images_fallback_regx'  => '/<meta name="og:image" content="(?<img_url>[^"]+)"/'
    );
    add_filter("filter_green_hyundai_field_price", "filter_green_hyundai_field_price", 10, 3);
    add_filter("filter_green_hyundai_field_images", "filter_green_hyundai_field_images");
    
    
    function filter_green_hyundai_field_price($price,$car_data, $spltd_data)
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
        $asking_regex     =  '/askingPrice"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/';

                
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
        if(preg_match($asking_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex Asking Price: {$matches['price']}");
        }
        
        if(count($prices) > 0) {
            $price = butifyPrice(min($prices));
        }
        
        slecho("Sale Price: {$price}".'<br>');
        return $price;
    }
    
    function filter_green_hyundai_field_images($im_urls)
    {
        return array_filter($im_urls, function($im_url){
            return !endsWith($im_url, 'unavailable_stockphoto.png');
        });
    }


