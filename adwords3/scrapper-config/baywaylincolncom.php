<?php
global $scrapper_configs;
 $scrapper_configs["baywaylincolncom"] = array( 
	  'entry_points' => array(
        'new' => 'https://www.baywaylincoln.com/new-inventory/index.htm',
        'used' => 'https://www.baywaylincoln.com/used-inventory/index.htm',
    ),
    'vdp_url_regex' => '/\/(?:new|used|certified)\/[^\/]+\/[0-9]{4}-/i',
    'ty_url_regex' => '/\/form\/confirm.htm/i',
    'use-proxy' => true,
    'picture_selectors' => ['.pswp-thumbnail'],
    'picture_nexts' => ['.ddc-icon-carousel-arrow-right'],
    'picture_prevs' => ['.ddc-icon-carousel-arrow-left'],
    'details_start_tag' => '<ul class="inventoryList data full list-unstyled">',
    'details_end_tag' => '<div  class="ddc-footer">',
    'details_spliter' => '<div class="item-compare">',
    'data_capture_regx' => array(
        'url' => '/class="url"\s*href="(?<url>[^"]+)">(?<title>[^<]+)/',
        'title' => '/class="url"\s*href="(?<url>[^"]+)">(?<title>[^<]+)/',
        'year' => '/data-year="(?<year>[^"]+)/',
        'make' => '/data-make="(?<make>[^"]+)/',
        'model' => '/data-model="(?<model>[^"]+)/',
        'trim' => '/data-trim="(?<trim>[^"]+)/',
        'price' => '/"(?:invoicePrice|internetPrice|stackedFinal|final|salePrice|retailValue|askingPrice|stackedConditionalFinal) final-price"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/',
        'kilometres' => '/Kilometres:<\/dt>\s*<dd>(?<kilometres>[^\<]+)/',
        'stock_number' => '/Stock #:<\/dt>\s*<dd>(?<stock_number>[^\<]+)/',
        'engine'        => '/Engine:<\/dt>\s*<dd>(?<engine>[^\<]+)/',
        'body_style' => '/data-bodyStyle="(?<body_style>[^"]+)/',
        'exterior_color' => '/Exterior Colou?r:<\/dt>\s*<dd>(?<exterior_color>[^\<]+)/',
        'interior_color' => '/Interior Colou?r:<\/dt>\s*<dd>(?<interior_color>[^\<]+)/',
    ),
    'data_capture_regx_full' => array(
        'transmission' => '/transmission": "(?<transmission>[^\"]+)"/',
        'make' => '@make\: \'(?<make>[^\']+)\'@',
        'model' => '@model\: \'(?<model>[^\']+)\'@',
        'body_style' => '@bodyStyle: \'(?<body_style>[^\']+)@',
        'trim' => '@"trim": "(?<trim>[^"]+)@'
    ),
    'next_page_regx' => '/<a rel="next" href="(?<next>[^"]+)"/',
    'images_regx' => '/id"[^"]+"src"[^"]+"(?<img_url>[^"]+)"[^"]+"thumbnail/',
    'images_fallback_regx' => '/<meta name="og:image" content="(?<img_url>[^"]+)"/'
);
add_filter("filter_baywaylincolncom_field_price", "filter_baywaylincolncom_field_price", 10, 3);

function filter_baywaylincolncom_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho(" Price: $price");
    }

  
 
    $msrp_regex = '/MSRP\s*[^>]+>.*:<\/span>[^>]+>[^>]+>(?<price>[^<]+)/';
    $final_regex = '/Bayway Price[^>]+>[^>]+>[^>]+>[^>]+>(?<price>[^<]+)/';
    $conditional_regex = '/Bayway Conditional Price[^>]+>[^>]+>[^>]+>[^>]+>(?<price>[^<]+)/';


    $matches = [];


    if (preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex msrp: {$matches['price']}");
    }
    if (preg_match($final_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex final Price: {$matches['price']}");
    }
    if (preg_match($conditional_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex conditional Price: {$matches['price']}");
    }

 
 

    if (count($prices) > 0) {
        $price = butifyPrice(min($prices));
    }

    slecho("Sale Price: {$price}" . '<br>');
    return $price;
}
add_filter("filter_baywaylincolncom_field_images", "filter_baywaylincolncom_field_images");
  

function filter_baywaylincolncom_field_images($im_urls) {
   $retval = [];
         foreach($im_urls as $img)
        {
            
             $retval[] = str_replace(["|","%20","?impolicy=resize&w=650","?impolicy=resize&w=414","?impolicy=resize&w=768","?impolicy=resize&w=1024"], ["%7C"," ", " "," "," "," "], $img);
        }
        
        return $retval;
}