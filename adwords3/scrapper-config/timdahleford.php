<?php
global $scrapper_configs;
 $scrapper_configs["timdahleford"] = array( 
	'entry_points' => array(
        'new' => 'https://www.timdahleford.net/new-inventory/index.htm',
        'used' => 'https://www.timdahleford.net/used-inventory/index.htm'
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
        'price' => '/"(?:invoicePrice|internetPrice|stackedFinal|final|salePrice|retailValue|askingPrice|stackedConditionalFinal) final-price"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/',
        'kilometres' => '/Mileage:<\/dt>\s<dd>(?<kilometres>[^\s]+)/',
        'stock_number' => '/Stock #:<\/dt>\s*<dd>(?<stock_number>[^\<]+)/',
        'engine' => '/Engine:<\/dt>\s*<dd>(?<engine>[^\<]+)/',
        'body_style' => '/data-bodyStyle="(?<body_style>[^"]+)/',
        'transmission' => '/Transmission:<\/dt>\s*<dd>(?<transmission>[^\<]+)/',
        'exterior_color' => '/Exterior Color:<\/dt>\s*<dd>(?<exterior_color>[^\<]+)/',
        'interior_color' => '/Interior Color:<\/dt>\s*<dd>(?<interior_color>[^\<]+)/',
          'vin' => '/data-vin\=\"(?<vin>[^\"]+)"\s*data-make="[^"]+"/',
    ),
    'data_capture_regx_full' => array(
        'make' => '@make\: \'(?<make>[^\']+)\'@',
        'model' => '@model\: \'(?<model>[^\']+)\'@',
        'body_style' => '@bodyStyle: \'(?<body_style>[^\']+)@',
        'trim' => '@"trim": "(?<trim>[^"]+)@'
    ),
    'next_page_regx' => '/href="(?<next>[^"]+)"\s*rel="next"/',
    'images_regx' => '/id":[^"]+"uri"[^"]+"(?<img_url>[^"]+)"/',
    'images_fallback_regx' => '/<meta name="og:image" content="(?<img_url>[^"]+)"/'
);
add_filter("filter_timdahleford_field_price", "filter_timdahleford_field_price", 10, 3);
add_filter("filter_timdahleford_field_images", "filter_timdahleford_field_images");

function filter_timdahleford_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho(" Price: $price");
    }

    $msrp_regex = '/MSRP<\/span>\s*[^>]+>MSRP<sup>[^>]+>[^>]+>:[^>]+>[^>]+>[^>]+>(?<price>[^<]+)/';
   

    $matches = [];

    if (preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex MSRP: {$matches['price']}");
    }


    if (count($prices) > 0) {
        $price = butifyPrice(min($prices));
    }

    slecho("Sale Price: {$price}" . '<br>');
    return $price;
}

function filter_timdahleford_field_images($im_urls) {
   if (count($im_urls) < 2)  { return array(); }
        $retval = [];
        
        foreach($im_urls as $img)
        {
            
             $retval[] = str_replace(["|","%20","?impolicy=resize&w=650","?impolicy=resize&w=414","?impolicy=resize&w=768","?impolicy=resize&w=1024"], ["%7C"," ", " "," "," "," "], $img);
        }
        
        return $retval;
}
