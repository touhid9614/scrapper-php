<?php
global $scrapper_configs;
 $scrapper_configs["uhonda"] = array( 
	'entry_points' => array(
            'new'   => 'http://www.uhonda.com/new-inventory/pageSizeChange/1/50/~/VehicleType_~Model_~Trim_~Year_~Price1_~EPAHighway_~TransmissionGeneric_~ExteriorColorGeneric_/~/1000',
            'used'  => 'http://www.uhonda.com/used-inventory/pageSizeChange/1/50/~/VehicleType_~Make_~Model_~Year_~Price1_~Mileage_~EPAHighway_~TransmissionGeneric_~ExteriorColorGeneric_/~/1000'
        ),
        'vdp_url_regex'     => '/\/detail/i',
        //'ty_url_regex'      => '/\/form\/confirm.htm/i',
        
         'use-proxy' => true,
        
        'picture_selectors' => ['div#detail-media-thumbs div'],
        'picture_nexts'     => ['.glyphicon.glyphicon-chevron-right'],
        'picture_prevs'     => ['.glyphicon.glyphicon-chevron-left'],
        
        'details_start_tag' => '<div class="browse-page clearfix">',
        'details_end_tag'   => '<footer id="footer"',
        'details_spliter'   => 'class="browse-row ">',
     
        'data_capture_regx' => array(
            'url'           => '/<input type="hidden" id="link_[0-9]+" value="(?<url>[^"]+)/',
            'title'         => '/<h4 class="hidden-xs">(?<title>(?:New|Used) (?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
            'year'          => '/<h4 class="hidden-xs">(?<title>(?:New|Used) (?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
            'make'          =>' /<h4 class="hidden-xs">(?<title>(?:New|Used) (?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
            'model'         => '/<h4 class="hidden-xs">(?<title>(?:New|Used) (?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
            'stock_number'  => '/Stock Number:<\/span><span[^>]+>(?<stock_number>[^<]+)/',
            'price'         => '/Price:<\/span><span[^>]+>(?<price>\$[0-9,]+)/',
            'exterior_color'=> '/Exterior Color:<\/span><span[^>]+>(?<exterior_color>[^<]+)/',
            //'transmission'  => '/Transmission:<\/span><span[^>]+>(?<transmission>[^<]+)/',
            'kilometres'    => '/Mileage:<\/span><span[^>]+>(?<kilometres>[^<]+)/',
            
          
        ),
        'data_capture_regx_full' => array(  
            'year'          => '/Year_(?<year>[0-9]{4});Make_(?<make>[^\;]+);Model_(?<model>[^\;]+)/',
            'make'          => '/Year_(?<year>[0-9]{4});Make_(?<make>[^\;]+);Model_(?<model>[^\;]+)/',
            'model'         => '/Year_(?<year>[0-9]{4});Make_(?<make>[^\;]+);Model_(?<model>[^\;]+)/',
            'engine'        => '/Engine:<\/span><span[^>]+>(?<engine>[^<]+)/',
            'body_style'    => '/Body Type:<\/span><span[^>]+>(?<body_style>[^<]+)/',
            'interior_color'=> '/Interior Color:<\/span><span[^>]+>(?<interior_color>[^<]+)/',
            'transmission'  => '/Transmission:<\/span><span[^>]+>(?<transmission>[^<]+)/',
               
        ),
        //'next_page_regx'    => '/href="(?<next>[^"]+)" rel="next"/',
        'images_regx'       => '/<div class="item"[^>]+><img src="(?<img_url>[^"]+)" alt="/',
        'images_fallback_regx'   => '/<meta\s*name="og:image"\s*content="(?<img_url>[^"]+)/'

    );
   
    add_filter("filter_uhonda_field_images", "filter_uhonda_field_images");
    add_filter("filter_uhonda_field_price", "filter_uhonda_field_price", 10, 3);

    
    function filter_uhonda_field_images($im_urls)
    {
       return array_filter($im_urls, function($img_url){
            return !endsWith($img_url, "notfound-t.jpg");
        });
    }
    function filter_uhonda_field_price($price,$car_data, $spltd_data)
    {
        $prices = [];
        
        slecho('');
        
        if($price && numarifyPrice($price) > 0) {
            $prices[] = numarifyPrice($price);
            slecho("Final Price: $price");
        }
        
        $retail_regex =  '/>MSRP:<\/span><span[^>]+>(?<price>\$[0-9,]+)/';
        $price_regex  =  '/>Price:<\/span><span[^>]+>(?<price>\$[0-9,]+)/';        
        $matches = [];
        
        if(preg_match($retail_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex  Msrp price: {$matches['price']}");
        }
        if(preg_match($price_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex  Retail price: {$matches['price']}");
        }
        
        if(count($prices) > 0) {
            $price = butifyPrice(min($prices));
        }
        
        slecho("Sale Price: {$price}".'<br>');
        return $price;
    }
