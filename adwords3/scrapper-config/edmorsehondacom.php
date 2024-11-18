<?php
global $scrapper_configs;
$scrapper_configs["edmorsehondacom"] = array( 
	'entry_points' => array(
        'new' => 'https://www.edmorsehonda.com/searchnew.aspx',
        'used' => 'https://www.edmorsehonda.com/searchused.aspx'
    ),
    'vdp_url_regex' => '/\/(?:new|used)-[^-]+-[0-9]{4}-/i',
    'ty_url_regex' => '/\/form\/confirm.htm/i',
    'use-proxy' => true,
     'refine' => false,
    'picture_selectors' => ['.carousel__item'],
    'picture_nexts' => ['.carousel__control--next'],
    'picture_prevs' => ['.carousel__control--prev'],
    'details_start_tag'   => '<!-- Vehicle Start -->',
        'details_end_tag'     => '<div class="row srpDisclaimer">',
        'details_spliter'     => '<div id="srpRow-',
    'data_capture_regx' => array(
        'url' => '/class="vehicleTitle\s*margin-[^>]+>\s*<a.*\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*(?<trim>[^<]*))/',
        'title' => '/class="vehicleTitle\s*margin-[^>]+>\s*<a.*\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*(?<trim>[^<]*))/',
        'year' => '/class="vehicleTitle\s*margin-[^>]+>\s*<a.*\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*(?<trim>[^<]*))/',
        'make' => '/class="vehicleTitle\s*margin-[^>]+>\s*<a.*\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*(?<trim>[^<]*))/',
        'model' => '/data-model=\'(?<model>[^\']+)/',
        'body_style' => '/<strong>Body\s*Style:\s*[^>]+>(?<body_style>[^<]+)/',
        'transmission' => '/<strong>Transmission:\s*[^>]+>(?<transmission>[^<]+)/',
        'engine' => '/<strong>Engine:\s*[^>]+>(?<engine>[^<\/]+)/',
        'vin' => '/<strong>VIN\s*#:\s*[^>]+><span>(?<vin>[^<]+)/',
        'drivetrain' => '/<strong>Drive\sType*:\s*[^>]+>(?<drivetrain>[^<]+)/',
        'exterior_color' => '/<strong>Ext.\s*Color:\s*[^>]+>(?<exterior_color>[^<]+)/',
        'interior_color' => '/<strong>Int.\s*Color:\s*[^>]+>(?<interior_color>[^<]+)/',
        'stock_number' => '/<strong>Stock\s*#:\s*[^>]+>(?<stock_number>[^<]+)/',
        'price' => '/(?:MSRP:|Internet Price)\s*<\/span>[^>]+>(?<price>[^<]+)/',
      
    ),
    'data_capture_regx_full' => array(
    ),
    'next_page_regx' => '/<a href="(?<next>[^"]+)" class="stat-arrow-next"[^>]+>\s*Next/',
    'images_regx' => '/zoom feature element -->\s*<img src="(?<img_url>[^\?]+)/'
    //'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'
);


add_filter("filter_edmorsehondacom_field_price", "filter_edmorsehondacom_field_price", 10, 3);

add_filter("filter_edmorsehondacom_field_images", "filter_edmorsehondacom_field_images");


    function filter_edmorsehondacom_field_price($price,$car_data, $spltd_data)
    {
        $prices = [];
        
        slecho('');
        
        if($price && numarifyPrice($price) > 0) {
            $prices[] = numarifyPrice($price);
            slecho("Adjusted Price: $price");
        }
        
        $msrp_regex =  '/FINAL PRICE: <\/span>[^>]+>(?<price>[^<]+)/';
        
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


function filter_edmorsehondacom_field_images($im_urls)
{
    $images=  array_filter($im_urls,function($img_url){
        return !endsWith($img_url,"carfax.png");
    });

 

    return $images;
}

