<?php
global $scrapper_configs;
$scrapper_configs["raypricelincolncom"] = array( 
	"entry_points" => array(
	    'new' => 'https://www.raypricelincoln.com/new-inventory/index.htm',
        'used' => 'https://www.raypricelincoln.com/used-inventory/index.htm',
      
    ),
    'vdp_url_regex' => '/\/(?:new|used|certified|wholesale-new|exotic-new)\/[^\/]+\/[0-9]{4}-/i',
    'use-proxy' => false,
    //'refine'=>false,
     'picture_selectors' => ['.pswp-thumbnail'],
    'picture_nexts' => ['.ddc-icon-carousel-arrow-right'],
    'picture_prevs' => ['.ddc-icon-carousel-arrow-left'],
     'details_start_tag' => '<div class="type-2 ddc-content"',
        'details_end_tag'   => '<div  class="ddc-footer"',
        'details_spliter'   => '<div class="item-compare">',
    'data_capture_regx' => array(
          'url' => '/class="url"\s*href="(?<url>[^"]+)">(?<title>[^<]+)/',
        'year' => '/data-year="(?<year>[^"]+)/',
        'make' => '/data-make="(?<make>[^"]+)/',
        'model' => '/data-model="(?<model>[^"]+)/',
        'price' => '/"(?:invoicePrice|internetPrice|stackedFinal|final|msrp|salePrice|retailValue|askingPrice|stackedConditionalFinal) final-price"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/', ///dealer price///
        'kilometres' => '/Mileage:<\/dt>\s<dd>(?<kilometres>[^<]+)/',
        'stock_number' => '/Stock #:[^>]+>[^>]+>(?<stock_number>[^<]+)/',
        'engine' => '/Engine:[^>]+>[^>]+>(?<engine>[^\<]+)/',
        'body_style' => '/data-bodyStyle="(?<body_style>[^"]+)/',
        'transmission' => '/Transmission:<\/dt>\s*<dd>(?<transmission>[^\<]+)/',
        'exterior_color' => '/Exterior Color:<\/dt>\s*<dd>(?<exterior_color>[^\<]+)/',
        'interior_color' => '/Interior Color:<\/dt>\s*<dd>(?<interior_color>[^\<]+)/'
    ),
    'data_capture_regx_full' => array(
          'price' => '/conditional-final-price .price-value">(?<price>[^<]+)/',
      
    ),
    'next_page_regx' => '/href="(?<next>[^"]+)"\s*rel="next"/',
   'images_regx' => '/"id":[^"]+"src":"(?<img_url>[^"]+)","thumbnail"/',
    'images_fallback_regx' => '/<meta name="og:image" content="(?<img_url>[^"]+)"/'
);


add_filter("filter_raypricelincolncom_field_price", "filter_raypricelincolncom_field_price", 10, 3);
add_filter("filter_raypricelincolncom_field_images", "filter_raypricelincolncom_field_images");
  

function filter_raypricelincolncom_field_images($im_urls) {
   $retval = [];
         foreach($im_urls as $img)
        {
            
             $retval[] = str_replace(["|","%20","?impolicy=resize&w=650","?impolicy=resize&w=414","?impolicy=resize&w=768","?impolicy=resize&w=1024"], ["%7C"," ", " "," "," "," "], $img);
        }
        
        return $retval;
}


function filter_raypricelincolncom_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho(" Price: $price");
    }

    $msrp_regex = '/final-price.*class=\'value[^>]+>(?<price>[^<]+)/';
    $wholesale_regex = '/wholesalePrice">.*class=\'value[^>]+>(?<price>[^<]+)/';
    $internet_regex = '/Internet Price[^>]+>:[^>]+>[^>]+>[^>]+>(?<price>[^<]+)/';
    $cond_final_regex = '/Conditional Final Price[^>]+>:[^>]+>[^>]+>[^>]+>(?<price>[^<]+)/';
    $retail_regex = '/retailValue"[^>]+>\s*<strong[^>]+>(?<price>[^<]+)/';
    $asking_regex = '/askingPrice"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/';


    $matches = [];

    if (preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex MSRP: {$matches['price']}");
    }
    if (preg_match($wholesale_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex wholesale: {$matches['price']}");
    }
    if (preg_match($internet_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex internet: {$matches['price']}");
    }

    if (preg_match($cond_final_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex Conditional Price: {$matches['price']}");
    }

    if (preg_match($retail_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex Retail Price: {$matches['price']}");
    }
    if (preg_match($asking_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex Asking Price: {$matches['price']}");
    }

    if (count($prices) > 0) {
        $price = butifyPrice(min($prices));
    }

    slecho("Sale Price: {$price}" . '<br>');
    return $price;
}
