<?php
global $scrapper_configs;
$scrapper_configs["inskeepfordcom"] = array( 
	 'entry_points' => array(
        'new' => 'https://www.inskeepford.com/new-inventory/index.htm',
        'used' => 'https://www.inskeepford.com/used-inventory/index.htm',
    ),
    'vdp_url_regex' => '/\/(?:new|used|certified)\/[^\/]+\/[0-9]{4}-/i',
    'picture_selectors' => ['.slider-slide img'],
    'picture_nexts' => ['.pswp__button.pswp__button--arrow--right'],
    'picture_prevs' => ['.pswp__button.pswp__button--arrow--left'],
    'details_start_tag' => '<ul class="gv-inventory-list simple-grid list-unstyled">',
    'details_end_tag' => '<div class="clearfix ft">',
    'details_spliter' => '<li class="item hproduct clearfix',
    'data_capture_regx' => array(
        'url' => '/<h3 class="[^>]+>\s*<a href="(?<url>[^"]+)"\sclass=[^>]+>(?<title>[^<]+)/',
        'title' => '/<h3 class="[^>]+>\s*<a href="(?<url>[^"]+)"\sclass=[^>]+>(?<title>[^<]+)/',
        'year' => '/data-year="(?<year>[^"]+)/',
        'make' => '/data-make="(?<make>[^"]+)/',
        'model' => '/data-model="(?<model>[^"]+)/',
        'trim' => '/data-trim="(?<trim>[^"]+)/',
        'price' => '/(?:Final Price|Inskeep Ford Price).*\s*<span[^>]+>:<\/span>\s*<\/span>\s*<span[^>]+>\s*(?<price>\$[0-9,]+)/',
        'kilometres' => '/Mileage<\/label>\s*<span>(?<kilometres>[^\s]+)/',
        'stock_number' => '/Stock Number<\/label>\s*<span>(?<stock_number>[^\<]+)/',
         'vin' => '/>VIN[^>]+>\s*[^>]+>(?<vin>[^<]+)',
        
    ),
    'data_capture_regx_full' => array(
       // 'engine' => '/Engine<\/label>\s*<span>(?<engine>[^\<]+)/',
       // 'transmission' => '/Transmission<\/label>\s*<span>(?<transmission>[^\<]+)/',
        'exterior_color' => '/>Exterior Color[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>(?<exterior_color>[^\<]+)/',
        'interior_color' => '/>Interior Color[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>(?<interior_color>[^\<]+)/',
    ),
    'next_page_regx' => '/next-btn" data-href="(?<next>[^"]+)">/',
    'images_regx' => '/"id":[^"]+"src":"(?<img_url>[^"]+)","thumbnail"/',
    'images_fallback_regx' => '/<meta name="og:image" content="(?<img_url>[^"]+)"/'
);

    add_filter("filter_inskeepfordcom_field_price", "filter_inskeepfordcom_field_price", 10, 3);
    add_filter("filter_inskeepfordcom_field_images", "filter_inskeepfordcom_field_images");
    function filter_inskeepfordcom_field_price($price,$car_data, $spltd_data)
    {
        $prices = [];
        
        slecho('');
        
        if($price && numarifyPrice($price) > 0) {
            $prices[] = numarifyPrice($price);
            slecho(" Price: $price");
        }
        
        $msrp_regex       =  '/MSRP[^>]+>\s*[^>]+>[^>]+>[^>]+>\s*[^>]+>\s*[^>]+>\s*(?<price>[^\s]+)/';
      

                
        $matches = [];
        
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
    function filter_inskeepfordcom_field_images($im_urls)
    {
        $retval = [];
        
        foreach($im_urls as $img)
        {
            $retval[] = str_replace('|', '%7c', $img);
        }
        
        return $retval;
    }

