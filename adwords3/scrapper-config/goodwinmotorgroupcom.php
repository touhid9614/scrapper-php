<?php
global $scrapper_configs;
$scrapper_configs["goodwinmotorgroupcom"] = array( 
	 'entry_points' => array(
            'new'  => 'https://www.goodwinmotorgroup.com/new-inventory/index.htm',
            'used' => 'https://www.goodwinmotorgroup.com/used-inventory/index.htm'
        ),
       'vdp_url_regex'     => '/\/(?:new|used|certified|wholesale-used)\/[^\/]+\/[0-9]{4}-/i',
        'ty_url_regex'      => '/\/form\/confirm.htm/i',
        'use-proxy' => true,
       'refine'=>false,
        'picture_selectors' => ['.pswp-thumbnail'],
        'picture_nexts'     => ['.pswp__button--arrow--right'],
        'picture_prevs'     => ['.pswp__button--arrow--left'],
        
       'details_start_tag' => '<div class="type-2 ddc-content"',
        'details_end_tag' => '<div  class="ddc-footer',
        'details_spliter' => '<div class="item-compare">',
       'data_capture_regx' => array(
            'url' => '/<a class="url" href="(?<url>[^"]+)[^>]+>(?<title>[^<]+)/',
            'year' => '/data-year="(?<year>[^"]+)/',
            'make' => '/data-make="(?<make>[^"]+)/',
            'model' => '/data-model="(?<model>[^"]+)/',
            'price' => '/Price<span[^>]+>[^>]+>[^>]+>[^>]+>(?<price>[^<]+)/',
            'kilometres' => '/<dt>Mileage:[^>]+>\s*[^>]+>(?<kilometres>[^\s]+)/',
            'stock_number' => '/Stock #:[^>]+>\s*[^>]+>(?<stock_number>[^<]+)/',
            'exterior_color' => '/<dt>Exterior Color[^>]+>\s*[^>]+>(?<exterior_color>[^<]+)/',
            'interior_color' => '/<dt>Interior Color[^>]+>\s*[^>]+>(?<interior_color>[^<]+)/',
           'transmission' => '/>Transmission[^>]+>\s*[^>]+>(?<transmission>[^\<]+)/',
             'engine' => '/>Engine[^>]+>\s*[^>]+>(?<engine>[^\<]+)/',
           
    ),
    'data_capture_regx_full' => array(
        'make' => '@make\: \'(?<make>[^\']+)\'@',
        'model' => '@model\: \'(?<model>[^\']+)\'@',
        'body_style' => '@bodyStyle: \'(?<body_style>[^\']+)@',
        
      
    ),
    'next_page_regx' => '/<a rel="next" href="(?<next>[^"]+)"/',
    'images_regx' => '/"id":[^"]+"src":"(?<img_url>[^"]+)","thumbnail"/',
    'images_fallback_regx' => '/<meta name="og:image" content="(?<img_url>[^"]+)"/'
   
    );
    add_filter("filter_goodwinmotorgroupcom_field_price", "filter_goodwinmotorgroupcom_field_price", 10, 3);
    add_filter("filter_goodwinmotorgroupcom_field_images", "filter_goodwinmotorgroupcom_field_images");
    
    
    function filter_goodwinmotorgroupcom_field_price($price,$car_data, $spltd_data)
    {
        $prices = [];
        
        slecho('');
        
        if($price && numarifyPrice($price) > 0) {
            $prices[] = numarifyPrice($price);
            slecho(" Price: $price");
        }
        
        $msrp_regex       =  '/(?:Market Price|MSRP)[^>]+>[^>]+>[^>]+>[^>]+>(?<price>[^<]+)/';
        $final_regex   =  '/Bottom Line Deal[^>]+>[^>]+>[^>]+>[^>]+>(?<price>[^<]+)/';
        $cond_final_regex =  '/Your Price[^>]+>[^>]+>[^>]+>[^>]+>(?<price>[^<]+)/';
        $retail_regex     =  '/>Price<span[^>]+>[^>]+>[^>]+>[^>]+>(?<price>\$[0-9,]+)/';
      
                
        $matches = [];
        
        if(preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex MSRP: {$matches['price']}");
        }
        if(preg_match($final_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex Final: {$matches['price']}");
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
    
    function filter_goodwinmotorgroupcom_field_images($im_urls)
    {
        return array_filter($im_urls, function($im_url){
            return !endsWith($im_url, 'unavailable_stockphoto.png');
        });
    }



