<?php
global $scrapper_configs;
$scrapper_configs["tomahlchryslerdodgecom"] = array( 
'entry_points' => array(
        'new' => 'https://www.tomahlchryslerdodge.com/new-inventory/index.htm',
        'used' => 'https://www.tomahlchryslerdodge.com/used-inventory/index.htm'
    ),
    'vdp_url_regex' => '/\/(?:new|used)\/[^\/]+\/[0-9]{4}-/i',
    'picture_selectors' => ['.slider-slide img'],
    'picture_nexts' => ['.pswp__button--arrow--right'],
    'picture_prevs' => ['.pswp__button--arrow--left'],
    'details_start_tag' => '<ul class="inventoryList data full list-unstyled">',
    'details_end_tag' => '<div class="ft">',
    'details_spliter' => '<div class="item-compare">',
    'data_capture_regx' => array(
        'url' => '/class="url"\s*href="(?<url>[^"]+)">(?<title>[^<]+)/',
        'title' => '/class="url"\s*href="(?<url>[^"]+)">(?<title>[^<]+)/',
        'year' => '/data-year="(?<year>[^"]+)/',
        'make' => '/data-make="(?<make>[^"]+)/',
        'model' => '/data-model="(?<model>[^"]+)/',
        'trim' => '/data-trim="(?<trim>[^"]+)/',
        'price' => '/(?:invoicePrice|internetPrice|stackedFinal|final|salePrice|askingPrice|stackedConditionalFinal) final-price"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/',
        
        'stock_number' => '/Stock #:<\/dt>\s*<dd>(?<stock_number>[^\<]+)/',
        'engine' => '/Engine:<\/dt>\s*<dd>(?<engine>[^\<]+)/',
        'body_style' => '/data-bodyStyle="(?<body_style>[^"]+)/',
        'transmission' => '/Transmission:<\/dt>\s*<dd>(?<transmission>[^\<]+)/',
        'exterior_color' => '/Exterior Color:<\/dt>\s*<dd>(?<exterior_color>[^\<]+)/',
        'interior_color' => '/Interior Color:<\/dt>\s*<dd>(?<interior_color>[^\<]+)/'
    ),
    'data_capture_regx_full' => array(
       'vin' => '/>VIN:[^>]+>(?<vin>[^<]+)/',
    ),
    'next_page_regx' => '/href="(?<next>[^"]+)"\s*rel="next"/',
    'images_regx' => '/id"[^"]+"src"[^"]+"(?<img_url>[^"]+)"[^"]+"thumbnail/',
    'images_fallback_regx'  => '/<meta name="og:image" content="(?<img_url>[^"]+)"/'
);
add_filter("filter_tomahlchryslerdodgecom_field_images", "filter_tomahlchryslerdodgecom_field_images");
function filter_tomahlchryslerdodgecom_field_images($im_urls) {
    
     $retval = [];    
        foreach($im_urls as $img)
        {
           
           $retval[] = str_replace(['|','%20','?impolicy=resize&w=650','?impolicy=resize&w=414','?impolicy=resize&w=768'], ['%7C','', '','',''], $img);
        }
        return $retval;

}

add_filter("filter_tomahlchryslerdodgecom_field_price", "filter_tomahlchryslerdodgecom_field_price", 10, 3);

function filter_tomahlchryslerdodgecom_field_price($price,$car_data, $spltd_data)
    {
        $prices = [];
        
        slecho('');
        
        if($price && numarifyPrice($price) > 0) {
            $prices[] = numarifyPrice($price);
            slecho(" Price: $price");
        }
        
        $msrp_regex       =  '/MSRP[^>]+>:[^>]+>[^>]+>[^>]+>(?<price>[^<]+)/';
       $sale_regex       =  '/Sale Price[^>]+>:[^>]+>[^>]+>[^>]+>(?<price>[^<]+)/';
    

                
        $matches = [];
        
        if(preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex MSRP: {$matches['price']}");
        }
        
        if(preg_match($sale_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex sale: {$matches['price']}");
        }
        
        if(count($prices) > 0) {
            $price = butifyPrice(min($prices));
        }
        
        slecho("Sale Price: {$price}".'<br>');
        return $price;
    }
