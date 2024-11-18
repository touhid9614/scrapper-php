<?php
global $scrapper_configs;

    $scrapper_configs['hondaofmarysville'] = array(
        'entry_points' => array(
           // 'new'   => 'http://www.hondaofmarysville.com/new-car-dealers/pageSizeChange/1/10/~/VehicleType_~Make_~Model_~Trim_~BodyType_~LowestPriceSort_~Year_~DriveTrain_~Mileage_~TransmissionGeneric_~ExteriorColorGeneric_/~/1000',
            'used'  => 'http://www.hondaofmarysville.com/used-car-dealers/pageSizeChange/1/10/~/VehicleType_~Make_~Model_~Trim_~BodyType_~LowestPriceSort_~Year_~DriveTrain_~Mileage_~TransmissionGeneric_~ExteriorColorGeneric_/~/1000'
        ),
        'vdp_url_regex'     => '/\/detail/i',
        //'ty_url_regex'      => '/\/form\/confirm.htm/i',
        
         'use-proxy' => true,
        
        'picture_selectors' => ['.item','#detail-media-thumbs div img'],
        'picture_nexts'     => ['.right'],
        'picture_prevs'     => ['.left'],
        
        'details_start_tag' => '<div class="browse-page clearfix">',
        'details_end_tag'   => '<footer id="footer"',
        'details_spliter'   => '<div class="clearfix">',
     
        'data_capture_regx' => array(
            'url'           => '/<input type="hidden" id="link_[0-9]+" value="(?<url>[^"]+)/',
            'title'         => '/<h4 class="hidden-xs">(?<title>(?:New|Used) (?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
            'year'          => '/<h4 class="hidden-xs">(?<title>(?:New|Used) (?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
            'make'          =>' /<h4 class="hidden-xs">(?<title>(?:New|Used) (?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
            'model'         => '/<h4 class="hidden-xs">(?<title>(?:New|Used) (?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
            'stock_number'  => '/Stock Number:<\/span><span[^>]+>(?<stock_number>[^<]+)/',
            'price'         => '/Internet Price:.*<\/span><span[^>]+>(?<price>\$[0-9,]+)/',
            'exterior_color'=> '/Exterior Color:<\/span><span[^>]+>(?<exterior_color>[^<]+)/',
            'kilometres'    => '/Mileage:<\/span><span[^>]+>(?<kilometres>[^<]+)/',
            'certified'     => '/<a href=".*-(?<certified>certified)/'
          
        ),
        'data_capture_regx_full' => array(  
            'make'          => '/Make_(?<make>[^;]+)/',
            'model'         => '/Model_(?<model>[^;]+)/',
            'transmission'  => '/Transmission:<\/span><span[^>]+>(?<transmission>[^<]+)/',
            'engine'        => '/Engine:<\/span><span[^>]+>(?<engine>[^<]+)/',
            'body_style'    => '/Body Type:<\/span><span[^>]+>(?<body_style>[^<]+)/',
            'interior_color'=> '/Interior Color:<\/span><span[^>]+>(?<interior_color>[^<]+)/',
               
        ),
        //'next_page_regx'    => '/href="(?<next>[^"]+)" rel="next"/',
        'images_regx'       => '/<div [^>]+><img src="(?<img_url>[^"]+)"/',
        'images_fallback_regx'   => '/<meta\s*name="og:image"\s*content="(?<img_url>[^"]+)/'

    );
   
    add_filter("filter_hondaofmarysville_field_images", "filter_hondaofmarysville_field_images");
    add_filter("filter_hondaofmarysville_field_price", "filter_hondaofmarysville_field_price", 10, 3);

    
    function filter_hondaofmarysville_field_images($im_urls)
    {
       return array_filter($im_urls, function($img_url){
            return !endsWith($img_url, "notfound-t.jpg");
        });
    }
    function filter_hondaofmarysville_field_price($price,$car_data, $spltd_data)
    {
        $prices = [];
        
        slecho('');
        
        if($price && numarifyPrice($price) > 0) {
            $prices[] = numarifyPrice($price);
            slecho("Final Price: $price");
        }
        
        $msrp_regex =  '/MSRP:.*<\/span><span[^>]+>(?<price>\$[0-9,]+)/';
        $list_regex =  '/List Price:.*<\/span><span[^>]+>(?<price>\$[0-9,]+)/';
        $special_regex =  '/Special Price:.*<\/span><span[^>]+>(?<price>\$[0-9,]+)/';
        
        $matches = [];
        
        if(preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex  msrp price: {$matches['price']}");
        }
        if(preg_match($list_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex  list price: {$matches['price']}");
        }
        if(preg_match($special_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex  special price: {$matches['price']}");
        }
        
        if(count($prices) > 0) {
            $price = butifyPrice(min($prices));
        }
        
        slecho("Sale Price: {$price}".'<br>');
        return $price;
    }
