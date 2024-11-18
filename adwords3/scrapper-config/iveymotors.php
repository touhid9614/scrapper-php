<?php

    global $scrapper_configs;

    $scrapper_configs['iveymotors'] = array(
        'entry_points' => array(
            'new'  => 'http://www.iveymotors.net/new-inventory/index.htm',
            'used' => 'http://www.iveymotors.net/used-inventory/index.htm',
          //'certified' => 'http://www.iveymotors.com/certified-inventory/index.htm'
        ),
        'vdp_url_regex'     => '/\/(?:new|used|certified)\/[^\/]+\/[0-9]{4}-/i',
        'ty_url_regex'      => '/\/form\/confirm.htm/i',
        'use-proxy' => true,
        'picture_selectors' => ['li.jcarousel-item'],
        'picture_nexts'     => ['div#photos div.imageViewer div.imageViewerScrollWrap a.imageScrollNext.next'],
        'picture_prevs'     => ['div#photos div.imageViewer div.imageViewerScrollWrap a.imageScrollPrev.previous'],
        
        'details_start_tag' => '<ul class="gv-inventory-list simple-grid list-unstyled">',
        'details_end_tag'   => '<div class="ft clearfix">',
        'details_spliter'   => '<div class="item-compare">',
        'data_capture_regx' => array(
            'url'           => '/class="inventory-title[^>]+>\s*<a href="(?<url>[^"]+)/',
            'title'         => '/class="url">\s*(?<title>[^<]+)/',
            'year'          => '/data-year="(?<year>[^"]+)/',
            'make'          => '/data-make="(?<make>[^"]+)/',
            'model'         => '/data-model="(?<model>[^"]+)/',
            'trim'          => '/data-trim="(?<trim>[^"]+)/',
            'price'         => '/Our Price[^>]+>[^>]+>[^>]+>\s*[^>]+>\s*(?<price>\$[0-9,]+)/',
            'stock_number'  => '/VIN<\/label>[^>]+>(?<stock_number>[^<]+)/',
            'engine'        => '/Engine<\/label>[^>]+>(?<engine>[^<]+)/',
            'body_style'    => '/data-bodyStyle="(?<body_style>[^"]+)/',
            'transmission'  => '/Transmission<\/label>[^>]+>(?<transmission>[^<]+)/',
            'exterior_color'=> '/Exterior Color<\/label>[^>]+>(?<exterior_color>[^<]+)/',
            'interior_color'=> '/Interior Color<\/label>[^>]+>(?<interior_color>[^<]+)/',
            
        ),
        'data_capture_regx_full' => array(        
//           'make'          => '@make\: \'(?<make>[^\']+)\'@',
//            'model'         => '@model\: \'(?<model>[^\']+)\'@',
//            'body_style'    => '@bodyStyle: \'(?<body_style>[^\']+)@',
//            'trim'          => '@"trim": "(?<trim>[^"]+)@',
//            'biweekly'      => '/paymentLease"[^\n]+\s*<strong[^>]+>(?<biweekly>\$[0-9.,]+)/',
        ) ,
        'next_page_regx'    => '/class="btn btn-xsmall btn-xs next-btn" data-href="(?<next>[^"]+)/',
        'images_regx'       => '/<a href="(?<img_url>[^"]+)"\s*class="js-link">/',
        'images_fallback_regx'  => '/<meta name="og:image" content="(?<img_url>[^"]+)"/'
    );
    add_filter("filter_iveymotors_field_price", "filter_iveymotors_field_price", 10, 3);
    add_filter("filter_iveymotors_field_images", "filter_iveymotors_field_images");
    
    
    function filter_iveymotors_field_price($price,$car_data, $spltd_data)
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
    
    function filter_iveymotors_field_images($im_urls)
    {
        $retval = [];
        foreach($im_urls as $url)
        {
            $retval[] = str_replace('|',"%7C", $url);
        }
        return array_filter($retval, function($im_url){
            return !endsWith($im_url, 'unavailable_stockphoto.png');
        });
    }


