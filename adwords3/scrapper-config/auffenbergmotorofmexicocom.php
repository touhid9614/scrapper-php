<?php
global $scrapper_configs;
$scrapper_configs["auffenbergmotorofmexicocom"] = array( 
	"entry_points" => array(
    	'new' => 'https://www.auffenbergmotorofmexico.com/new-inventory/index.htm',
        'used' => 'https://www.auffenbergmotorofmexico.com/used-inventory/index.htm',
    ),
    'vdp_url_regex' => '/\/(?:new|used|certified)\/[^\/]+\/[0-9]{4}-/i',
    'picture_selectors' => ['.slider-slide img'],
    'picture_nexts' => ['.pswp__button.pswp__button--arrow--right'],
    'picture_prevs' => ['.pswp__button.pswp__button--arrow--left'],
    'details_start_tag' => '<ul class="gv-inventory-list simple-grid list-unstyled">',
    'details_end_tag' => '<div class="clearfix ft">',
    'details_spliter' => '<li class="item hproduct clearfix',
    'data_capture_regx' => array(
        'url' => '/<h3 class="[^>]+>\s*<a href="(?<url>[^"]+)"\sclass=[^>]+>(?<title>[^<]+)/',
        'title' => '/<h3 class="[^>]+>\s*<a href="(?<url>[^"]+)"\sclass=[^>]+>(?<title>[^<]+)/',
        'year' => '/data-year="(?<year>[^"]+)/',
        'make' => '/data-make="(?<make>[^"]+)/',
        'model' => '/data-model="(?<model>[^"]+)/',
        'trim' => '/data-trim="(?<trim>[^"]+)/',
        'price' => '/(?:Price|MSRP).*\s*<span[^>]+>:<\/span>\s*<\/span>\s*<span[^>]+>\s*(?<price>\$[0-9,]+)/',
        'kilometres' => '/Mileage<\/label>\s*<span>(?<kilometres>[^\<]+)/',
        'stock_number' => '/Stock Number<\/label>\s*<span>(?<stock_number>[^\<]+)/',
         'vin' => '/data-vin="(?<vin>[^"]+)"\s*data-year/',
        'engine' => '/data-engine="(?<engine>[^\"]+)/',
        'transmission' => '/data-transmission="(?<transmission>[^\"]+)/',
        'exterior_color' => '/Exterior Color<\/label>\s*<span>(?<exterior_color>[^\<]+)/',
        'interior_color' => '/Interior Color<\/label>\s*<span>(?<interior_color>[^\<]+)/',
        'body_style'     => '/Bodystyle<\/label>\s*<span>\s*(?<body_style>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
        
    ),
    'next_page_regx' => '/class="btn btn-xsmall btn-xs next-btn[^"]+"\s*data-href="(?<next>[^"]+)">/',
    'images_regx' => '/"id":[^"]+"uri":"(?<img_url>[^"]+)","thumbnail"/',
    'images_fallback_regx' => '/<meta name="og:image" content="(?<img_url>[^"]+)"/'
);

add_filter("filter_auffenbergmotorofmexicocom_field_price", "filter_auffenbergmotorofmexicocom_field_price", 10, 3);

function filter_auffenbergmotorofmexicocom_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho(" Price: $price");
    }

    $msrp_regex = '/Final Price\s*[^>]+>\s*[^>]+>\s*[^>]+>\s*[^>]+>\s*(?<price>\$[0-9,]+)/';
    $wholesale_regex = '/wholesalePrice">.*class=\'value[^>]+>(?<price>[^<]+)/';
    $internet_regex = '/internetPrice">.*class=\'value[^>]+>(?<price>[^<]+)/';
    $cond_final_regex = '/stackedConditionalFinal"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/';
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
