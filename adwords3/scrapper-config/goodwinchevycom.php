<?php
global $scrapper_configs;
$scrapper_configs["goodwinchevycom"] = array( 
	'entry_points' => array(
            'used' => 'https://www.goodwinchevyoxford.com/used-inventory/index.htm',
            'new'  => 'https://www.goodwinchevyoxford.com/new-inventory/index.htm',
            
         ),
         'vdp_url_regex'     => '/\/(?:new|used|commercial-used)\/[^\/]+\/[0-9]{4}-/i',
        'ty_url_regex'      => '/\/form\/confirm.htm/i',
        'use-proxy' => true,
       'refine'=>false,
        'picture_selectors' => ['.slider-slide img'],
        'picture_nexts'     => ['.ddc-icon-carousel-arrow-right'],
        'picture_prevs'     => ['.ddc-icon-carousel-arrow-left'],
           
            'details_start_tag' => '<div class="type-2 ddc-content"',
        'details_end_tag'   => '<div  class="ddc-footer"',
        'details_spliter'   => '<div class="item-compare">',
        'data_capture_regx' => array(
            'url'           => '/class="url"\s*href="(?<url>[^"]+)">(?<title>[^<]+)/',
            'title'         => '/class="url"\s*href="(?<url>[^"]+)">(?<title>[^<]+)/',
            'year'          => '/data-year="(?<year>[^"]+)/',
            'make'          => '/data-make="(?<make>[^"]+)/',
            'model'         => '/data-model="(?<model>[^"]+)/',
            'trim'          => '/data-trim="(?<trim>[^"]+)/',    
            'price'         => '/(?:Final Price|Sale Price|Bottom Line Deal)<[^>]+>:.*(?<price>\$[0-9,]+)/',
            'kilometres'    => '/Mileage:[^>]+>[^>]+>(?<kilometres>[^<]+)/',
            'stock_number'  => '/VIN:[^>]+>[^>]+>(?<stock_number>[^<]+)/',
            'engine'        => '/Engine:<\/dt>\s*<dd>(?<engine>[^<]+)/',
            'body_style'    => '/data-bodyStyle="(?<body_style>[^"]+)/',
            'transmission'  => '/Transmission:<\/dt>\s*<dd>(?<transmission>[^<]+)/',
            'exterior_color'=> '/Exterior Color:<\/dt>\s*<dd>(?<exterior_color>[^<]+)/',
            'interior_color'=> '/Interior Color:<\/dt>\s*<dd>(?<interior_color>[^<]+)/',
             'msrp'         => '/MSRP<span class=[^>]+>[^>]+>[^>]+>[^>]+>(?<msrp>\$[0-9,]+)/',
        ),
        'data_capture_regx_full' => array(        
            'make'          => '/make\: \'(?<make>[^\']+)\'/',
            'model'         => '/model\: \'(?<model>[^\']+)\'/',
            'body_style'    => '/bodyStyle: \'(?<body_style>[^\']+)/',
            'trim'          => '/"trim": "(?<trim>[^"]+)/', 
        ) ,
        'next_page_regx'    => '/href="(?<next>[^"]+)"\s*rel="next"/',
        'images_regx'       => '/id"[^"]+"uri"[^"]+"(?<img_url>[^"]+)"/',
        'images_fallback_regx'  => '/<meta name="og:image" content="(?<img_url>[^"]+)"/'
      
    );
    add_filter("filter_goodwinchevycom_field_images", "filter_goodwinchevycom_field_images");
    add_filter("filter_goodwinchevycom_field_price", "filter_goodwinchevycom_field_price", 10, 3);

  function filter_goodwinchevycom_field_images($im_urls)
    {
      
         if(count($im_urls)<2)
            {
            return [];
            
            }     
            
         $retval = [];   
        foreach($im_urls as $img)
        {
            
             $retval[] = str_replace(["|","%20","?impolicy=resize&w=650","?impolicy=resize&w=414","?impolicy=resize&w=768","?impolicy=resize&w=1024"], ["%7C"," ", " "," "," "," "], $img);
        }
        
        return $retval;

          
    }
    function filter_goodwinchevycom_field_price($price,$car_data, $spltd_data)
    {
        $prices = [];     
        slecho('');
        if($price && numarifyPrice($price) > 0) {
            $prices[] = numarifyPrice($price);
            slecho(" Price: $price");
        }
        
          $msrp_regex  =  '/MSRP<span class=[^>]+>[^>]+>[^>]+>[^>]+>(?<price>\$[0-9,]+)/';              
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


   