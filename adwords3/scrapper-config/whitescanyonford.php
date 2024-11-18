<?php

    global $scrapper_configs;

    $scrapper_configs['whitescanyonford'] = array(
        'entry_points' => array(
            'new'  => 'https://www.whitescanyonford.com/searchnew.aspx',
            'used' => 'https://www.whitescanyonford.com/searchused.aspx'
        ),
        'vdp_url_regex' => '/\/(?:new|used)-[^-]+-[0-9]{4}-/i',
    //'ty_url_regex' => '/\/thankyou.aspx/i',
     'refine' => false,
    //   'proxy-area'        => 'FL',
    'picture_selectors' => ['.hero-carousel__image'],
    'picture_nexts' => ['div.carousel__control--next'],
    'picture_prevs' => ['div.carousel__control--prev'],
    'details_start_tag' => '<div class="col-md-9 sidebar-oncanvas">',
    'details_end_tag' => '<div class="row srpDisclaimer">',
    'details_spliter' => 'data-vehicle-information',
    'data_capture_regx' => array(
        'vin'           => '/data-vin="(?<vin>[^"]+)/',
        'url' => '/hero-carousel__item--viewvehicle"\s*href="(?<url>[^"]+)/',
        //'title' => '/class="vehicleTitle\s*margin-[^>]+>\s*<a\s*.*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*(?<trim>[^<]*))/',
        'year' => '/data-year="(?<year>[^"]+)/',
        'make' => '/data-make="(?<make>[^"]+)/',
        'model' => '/data-model="(?<model>[^"]+)/',
        'trim' => '/data-trim="(?<trim>[^"]+)/',
        'body_style' => '/data-bodystyle="(?<body_style>[^"]+)/',
        'transmission' => '/data-trans="(?<transmission>[^"]+)/',
        'engine' => '/data-engine="(?<engine>[^"]+)/',
        'exterior_color' => '/data-extcolor="(?<exterior_color>[^"]+)/',
        'interior_color' => '/data-intcolor="(?<interior_color>[^"]+)/',
        'price' => '/data-price="(?<price>[^"]+)/',
    ),
    'data_capture_regx_full' => array(
        // 'price'     => '/Internet Price\s*<\/span><[^>]+>(?<price>\$[0-9,]+)/',
        'kilometres' => '/Mileage[^>]+>[^>]+>(?<kilometres>[^<]+)/',
        'stock_number' => '/Stock #:\s*<\/span>\s*[^>]+>(?<stock_number>[^<]+)/',
    ),
    'next_page_regx' => '/<a\s*href=\'(?<next>[^\']+)\'\s*class="stat\-arrow\-next"\s*/',
    'images_regx' => '/<img\s*src="(?<img_url>[^"]+)"\s*class=/'
);
    add_filter("filter_whitescanyonford_field_price", "filter_whitescanyonford_field_price", 10, 3);
    add_filter("filter_whitescanyonford_field_images", "filter_whitescanyonford_field_images");
    function filter_whitescanyonford_field_images($im_urls)
    {
     
         if(count($im_urls)<2)
            {
            return [];
            
            }
       $retval = array();

        foreach($im_urls as $url) {
           
        $retval[] = str_replace(["|", "%20", "?impolicy=resize&w=650", "?impolicy=resize&w=414", "?impolicy=resize&w=768", "?impolicy=resize&w=1024"], ["%7C", " ", " ", " ", " ", " "], $url);
    }
        

        return $retval;
    }
    
    // function filter_whitescanyonford_field_price($price,$car_data, $spltd_data)
    //    {
    //        $prices = [];

    //        slecho('');

    //        if($price && numarifyPrice($price) > 0) {
    //            $prices[] = numarifyPrice($price);
    //            slecho("whitescanyonford Price: $price");
    //        }

    //     //$msrp_regex       =  '/MSRP:\s*[^>]+>[^>]+>(?<price>\$[0-9,]+)/';
    //     $internet_regex   =  '/Internet Price\s*<\/span><[^>]+>(?<price>\$[0-9,]+)/';
    //     $best_price='/vehiclePricingHighlightAmount" style[^>]+>(?<price>\$[0-9,]+)/';

                
    //     $matches = [];

    //     if(preg_match($internet_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
    //         $prices[] = numarifyPrice($matches['price']);
    //         slecho("Regex internet: {$matches['price']}");
    //     }
    //     if(preg_match($best_price, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
    //         $prices[] = numarifyPrice($matches['price']);
    //         slecho("Regex best: {$matches['price']}");
    //     }
       
      
        
    //     if(count($prices) > 0) {
    //         $price = butifyPrice(min($prices));
    //     }

    //        slecho("Sale Price: {$price}".'<br>');
    //        return $price;
    //    }
   
