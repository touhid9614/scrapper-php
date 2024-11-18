<?php
    global $scrapper_configs;

    $scrapper_configs['quillplains'] = array(
        'entry_points' => array(
            'new'       => 'https://www.quillplains.com/new/',
            'used'      => 'https://www.quillplains.com/used/',
         
          ),
         'vdp_url_regex' => '/\/(?:new|used)\/vehicle\/[0-9]{4}/i',
       'refine' => false,
       'picture_selectors' => ['.thumb li'],
       'picture_nexts' => ['.next-small'],
       'picture_prevs' => ['.left-small'],
        
      'details_start_tag' => '<div class="instock-inventory-content',
      'details_end_tag' => '<footer',
      'details_spliter' => '<input type="hidden" style="display:none;" id="vehicle_owner_dealer_id',
        'data_capture_regx' => array(
            'vin'               => '/VIN[^>]+>[^>]+>(?<vin>[^<]+)/',
            'url'              => '/<a class="stat-text-link" data-loc="[^"]+".*href="(?<url>[^"]+)">\s*<span[^>]+>/',    
            'year'             => '/<a class="stat-text-link" data-loc="[^"]+".*href="(?<url>[^"]+)">\s*<span[^>]+>(?<year>[0-9]{4})/',
            'make'             => '/temprop=\'manufacturer\'[^>]+>[^>]+>(?<make>[^\<]+)/',
            'model'            => '/temprop=\'model\'[^>]+>[^>]+>(?<model>[^\<]+)/',
            'body_style'       => '/Body Style:[^>]+>[^>]+>(?<body_style>[^<\/]+)/',
            'transmission'     => '/Transmission:[^>]+>[^>]+>(?<transmission>[^<\/]+)/',
            'engine'           => '/Engine:[^>]+>[^>]+>(?<engine>[^<\/]+)/',
            'exterior_color'   => '/Exterior Colour:[^>]+>[^>]+>(?<exterior_color>[^<\/]+)/',  
            'stock_number'     => '/Stock #:[^>]+>[^>]+>(?<stock_number>[^<\/]+)/',
            'kilometres'       => '/Mileage:[^>]+>[^>]+>(?<kilometres>[^<\s]+)/',
            'price'            => '/itemprop="price" content="(?<price>[^"<]+)/',
        ),
        'data_capture_regx_full' => array(
          'interior_color'   => '/Interior:[^>]+>\s*[^>]+>\s*(?<interior_color>[^<\s]+)/',
        ),
        
        'next_page_regx' => '/class="active"><a\s*href="">[0-9]+<\/a><\/li>\s*<li><a\s*href="(?<next>[^"]+)/',
        'images_regx'   => '/onerror="[^"]+"\s*(?:data-src|src)="(?<img_url>[^"]+)"/'
    );
    add_filter("filter_quillplains_field_price", "filter_quillplains_field_price", 10, 3);
   
    function filter_quillplains_field_price($price,$car_data, $spltd_data)
    {
        $prices = [];
        
        slecho('');
        
        if($price && numarifyPrice($price) > 0) {
            $prices[] = numarifyPrice($price);
            slecho("Internet Price: $price");
        }
        
        $msrp_regex =  '/MSRP: <\/span>[^\$]+(?<price>\$[0-9,]+)/';
        $internetPrice    ='/class="pull-right primaryPrice">(?<price>[^<]+)/';
        
        $matches = [];
        
        if(preg_match($internetPrice, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex MSRP: {$matches['price']}");
        }
        
         if(preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex MSRP: {$matches['price']}");
        }
        
        if(count($prices) > 0) {
            $price = butifyPrice(min($prices));
        }
        
        slecho("Sale Price: {$price}".'<br>');
        return $price;
    }
   
 add_filter("filter_quillplains_field_images", "filter_quillplains_field_images");
    
    function filter_quillplains_field_images($im_urls)
    {
       if(count($im_urls)<2)
            {
            return [];
            
            }
       
        return $im_urls;
    }