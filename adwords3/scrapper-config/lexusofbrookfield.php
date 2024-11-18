<?php
global $scrapper_configs;
 $scrapper_configs["lexusofbrookfield"] = array( 
    "entry_points" => array(
        'new' => 'https://www.lexusofbrookfield.com/new-inventory/index.htm',
        'used' => 'https://www.lexusofbrookfield.com/used-inventory/index.htm'
    ),
    'vdp_url_regex' => '/\/(?:new|used|certified)\/[^\/]+\/[0-9]{4}-/i',
    'ty_url_regex' => '/\/form\/confirm.htm/i',
    'use-proxy' => true,
    'picture_selectors' => ['.slider-slide img'],
    'picture_nexts' => ['.pswp__button--arrow--right'],
    'picture_prevs' => ['.pswp__button--arrow--left'],
    'details_start_tag' => '<form id="compareForm" class="BLANK" action=',
    'details_end_tag' => '<div class=" ddc-content content-default"',
    'details_spliter' => '<div class="item-compare">',
    'data_capture_regx' => array(
        'url' => '/class="url"\s*href="(?<url>[^"]+)">(?<title>[^<]+)/',
        'title' => '/class="url"\s*href="(?<url>[^"]+)">(?<title>[^<]+)/',
        'year' => '/data-year="(?<year>[^"]+)/',
        'make' => '/data-make="(?<make>[^"]+)/',
        'model' => '/data-model="(?<model>[^"]+)/',
        'trim' => '/data-trim="(?<trim>[^"]+)/',
        'price' => '/(?:invoicePrice|internetPrice|stackedFinal|final|salePrice|askingPrice|stackedConditionalFinal).*"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/',
        'vin' => '/Stock\s*#:[^>]+>\s*[^>]+>(?<vin>[^<]+)/',
        'kilometres' => '/Mileage:<\/dt> <dd>(?<kilometres>[^<]+)/',
        'stock_number' => '/Stock\s*#:[^>]+>\s*[^>]+>(?<stock_number>[^<]+)/',
        'engine' => '/Engine:<\/dt> <dd>(?<engine>[^<]+)/',
        'body_style' => '/data-bodyStyle="(?<body_style>[^"]+)/',
        'transmission' => '/Transmission:<\/dt> <dd>(?<transmission>[^<]+)/',
        'exterior_color' => '/Exterior Color:<\/dt> <dd>(?<exterior_color>[^<]+)/',
        'interior_color' => '/Interior Color:[^>]+>\s*[^>]+>(?<interior_color>[^<]+)/',
        'msrp' => '/msrp">[^>]+>[^>]+>:[^>]+>[^>]+>[^>]+>(?<msrp>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
      
    ),
    'next_page_regx' => '/rel="next" *(?:data-href|href)="(?<next>[^"]+)"/',
    'images_regx' => '/id[^"]+"[^"]+"src[^"]+"[^"]+"(?<img_url>[^"]+)[^"]+"[^"]+"thumbnail/',
    'images_fallback_regx' => '/<meta name="og:image" content="(?<img_url>[^"]+)"/'
);
add_filter("filter_lexusofbrookfield_field_price", "filter_lexusofbrookfield_field_price", 10, 3);

function filter_lexusofbrookfield_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho(" Price: $price");
    }

    $msrp_regex = '/msrp">[^>]+>[^>]+>:[^>]+>[^>]+>[^>]+>(?<price>[^<]+)/';
    $internet_regex = '/Internet Price [^>]+>:[^>]+>[^>]+>[^>]+>(?<price>[^<]+)/';
    $final_regex = '/Final Price[^>]+>:[^>]+>[^>]+>[^>]+>(?<price>[^<]+)/';
  
   
    $matches = [];

    if (preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex MSRP: {$matches['price']}");
    }

    if (preg_match($internet_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex internet: {$matches['price']}");
    }
   if (preg_match($final_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex final: {$matches['price']}");
    }
   
    if (count($prices) > 0) {
        $price = butifyPrice(min($prices));
    }

    slecho("Sale Price: {$price}" . '<br>');
    return $price;
}
add_filter("filter_lexusofbrookfield_field_images", "filter_lexusofbrookfield_field_images");

function filter_lexusofbrookfield_field_images($im_urls) {
    
   $retval = [];    
        foreach($im_urls as $img)
        {
           
           $retval[] = str_replace(['|','%20','?impolicy=resize&w=650','?impolicy=resize&w=414','?impolicy=resize&w=768','?impolicy=resize&w=1024'], ['%7C','', '','','',''], $img);
        }
     
        return array_filter($retval, function($im_url){
            return !endsWith($im_url, 'unavailable_stockphoto.png');
        });
}
