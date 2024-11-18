<?php
global $scrapper_configs;
$scrapper_configs["badlandshdcom"] = array( 
	'entry_points' => array(
        'used' => 'https://www.badlandshd.com/default.asp?page=inventory&condition=pre-owned&pg=1',
        'new' => 'https://www.badlandshd.com/default.asp?page=inventory&condition=new&pg=1',
        
    ),
    'vdp_url_regex' => '/\/(?:New|Pre-owned)-Inventory-[0-9]{4}-/i',
    'use-proxy' => true,
    'refine'   => false,
    'picture_selectors' => ['.lS-image-wrapper'],
    'picture_nexts' => ['.lSNext'],
    'picture_prevs' => ['.lSPrev'],
    'details_start_tag' => '<div class="v7list-results listview',
    'details_end_tag' => '<footer',
    'details_spliter' => '<li class="v7list-results__item"',
    'data_capture_regx' => array(
      
        'year' => '/vehicle-heading__year">(?<year>[0-9]{4})/',
        'make' => '/vehicle-heading__name">(?<make>[^<]+)/',
        'model' => '/vehicle-heading__model">(?<model>[^<]+)/',
        'url' => '/<a class="vehicle-heading__link" href="(?<url>[^"]+)"/',
       
        'kilometres'     => '/Miles:[^>]+>(?<kilometres>[^<]+)/',
        'exterior_color' => '/Color:[^>]+>(?<exterior_color>[^<]+)/',
        'fuel_type'      => '/Fuel Type:[^>]+>(?<fuel_type>[^<]+)/',
        'drivetrain'     => '/Vehicle Type:[^>]+>(?<drivetrain>[^<]+)/',
        'engine'         => '/Category:[^>]+>(?<engine>[^<]+)/',
        'body_style'     => '/Category:[^>]+>(?<body_style>[^<]+)/'
     
    ),
    'data_capture_regx_full' => array(
         'price' => '/<div class="price-value\s*">\s*<span class="currency"><\/span>(?<price>\$[0-9,]+)/',
         'stock_number' => '/Stock Number<\/label>\s*[^>]+>(?<stock_number>[^\<]+)/',
         'vin' => '/Stock Number<\/label>\s*[^>]+>(?<vin>[^<]+)/',
        'fuel_type' => '/Fuel Type<\/label>\s*[^>]+>(?<fuel_type>[^<]+)/',
        'exterior_color' => '/Color<\/label>\s*[^>]+>(?<exterior_color>[^\<]+)/',
        'description' => '/<meta name="description" content="(?<description>[^"]+)/',
         'engine' => '/Engine<\/label>\s*[^>]+>(?<engine>[^\<]+)/',
         'kilometres' => '/Odometer<\/label>\s*[^>]+>(?<kilometres>[^\s*]+)/',
        'body_style' => '/Body Style<\/label>\s*[^>]+>(?<body_style>[^\<]+)/',
    ),
    'next_page_regx' => '/v7list-pagination__page">Page\s*(?<next>[^\s]+)\sof[^>]+>\s*[^>]+>[^>]+>[^"]+"[^"]+" aria-label="Next Page of Results">/',
    'images_regx' => '/<div class="lS-image-wrapper">\s*<img src="(?<img_url>[^"]+)/',
);
 add_filter("filter_badlandshdcom_next_page", "filter_badlandshdcom_next_page", 10, 2);
add_filter("filter_badlandshdcom_field_images", "filter_badlandshdcom_field_images");

add_filter('filter_badlandshdcom_car_data', 'filter_badlandshdcom_car_data');

function filter_badlandshdcom_car_data($car_data) {

    $car_data['make'] =preg_replace('/[^A-Za-z0-9 -]/', '', $car_data['make']);
    $car_data['model']=preg_replace('/[^A-Za-z0-9 -]/', '', $car_data['model']);
    if(strlen($car_data['model'])>20){
        return null;
    }
     
    return $car_data;
}

function filter_badlandshdcom_next_page($next, $current_page) {

    slecho($current_page);
    $next = explode('/', $next);
    $index = count($next) - 1;
    $next = ($next[$index]);
    $next++;
    $peg = "pg=" . $next;
    $prev = "pg=" . ($next - 1);
    $url = str_replace($prev, $peg, $current_page);

    return $url;
}

add_filter("filter_badlandshdcom_field_images", "filter_badlandshdcom_field_images");
function filter_badlandshdcom_field_images($im_urls)
{
    $retval = [];

    foreach($im_urls as $img)
    {
        $retval[] = str_replace(["&#x2F;","https://www.badlandshd.com/"], ["/",""], $img);
    }

    return $retval;
}

add_filter("filter_badlandshdcom_field_price", "filter_badlandshdcom_field_price", 10, 3);

function filter_badlandshdcom_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho(" Price: $price");
    }

    $msrp_regex = '/<div class="price-value\s*">\s*<span class="currency">[^>]+>(?<price>[0-9,]+)/';
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
