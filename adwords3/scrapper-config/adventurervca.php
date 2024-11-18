<?php
global $scrapper_configs;
/*
$scrapper_configs["adventurervca"] = array(
"entry_points"           => array(
'new' => 'https://adventurerv.ca/rv-inventory/',
),

'vdp_url_regex'          => '/\/inventory\//',
//'srp_page_regex'          => '/\/rv-inventory/i',
'use-proxy'              => true,
'refine'                 => false,
'picture_selectors'      => ['.slick-slide img'],
'picture_nexts'          => ['.slick-next'],
'picture_prevs'          => ['.slick-prev'],

// 'details_start_tag'  => '<div class="search-filter-results" id="search-filter-results-',
// 'details_end_tag'    => '<!-- #main -->',
// 'details_spliter'    => '<div class="rv-listing">',

'data_capture_regx'      => array(
'year'   => '/<div class="rv-info">\s*<h3>\s*<span class="year">\s*(?<year>[^\s*]+)\s*[^>]+>\s*(?<make>[^\s*]+)/',
'make'   => '/<div class="rv-info">\s*<h3>\s*<span class="year">\s*(?<year>[^\s*]+)\s*[^>]+>\s*(?<make>[^\s*]+)/',
'mdoel'  => '/<div class="rv-info">\s*<h3>\s*<span class="year">\s*(?<year>[^\s*]+)\s*[^>]+>\s*(?<make>[^\s*]+)\s+(?<model>[^\<]+)/',
'price'  => '/Our Price:[^>]+>\s*[^>]+>\s*[^>]+>\s*(?<price>[^\s*]+)/',
'url'    => '/<a href="(?<url>[^"]+)"\s*class="rv-listing-wrapper">/',
'length' => '/Length:[^>]+>\s*<\/td>\s*<td>(?<length>[^<]+)/',
'weight' => '/Weight:[^>]+>\s*<\/td>\s*<td>(?<length>[^<]+)/',
//'capacity'  => '/Sleeping Capacity:<\/td>\s*<td style="padding-right: 0;">(?<capacity>[^<]+)/',
),
'data_capture_regx_full' => array(
'stock_type' => '/class="condition">(?<stock_type>[^<]+)/',
'type'       => '/<td class="condition">(?<type>[^<]+)/',
'hight'      => '/Height:[^>]+>\s*<\/td>\s*<td>(?<hight>[^<]+)/',
'model'      => '/<title>(?<model>[^\s*]+)/',
//'description' => '/<meta property="og:description" content="(?<description>[^"]+)/',
),
//'next_page_regx' => '//',
'images_regx'            => '/img src="(?<img_url>[^"]+)" alt=""/',
);

add_filter('filter_adventurervca_car_data', 'filter_adventurervca_car_data');

function filter_adventurervca_car_data($car_data)
{
$car_data['model'] = str_replace('&#8211;', "", $car_data['model']);
if (!isset($car_data['exterior_color'])) {
$car_data['exterior_color'] = "other";
}
$car_data['vin'] = md5($car_data['url']);
return $car_data;
}

// add_filter("filter_adventurervca_field_description", "filter_adventurervca_field_description");
// function filter_adventurervca_field_description($description)
// {
//     return strip_tags($description);
// }

add_filter("filter_adventurervca_field_price", "filter_adventurervca_field_price", 10, 3);
function filter_adventurervca_field_price($price, $car_data, $spltd_data)
{
$prices = [];

slecho('');

if ($price && numarifyPrice($price) > 0) {
$prices[] = numarifyPrice($price);
slecho(" Price: $price");
}

$msrp_regex       = '/Reduced:\s*<\/span><span>(?<price>[^<]+)/';
$wholesale_regex  = '/wholesalePrice">.*class=\'value[^>]+>(?<price>[^<]+)/';
$internet_regex   = '/internetPrice">.*class=\'value[^>]+>(?<price>[^<]+)/';
$cond_final_regex = '/stackedConditionalFinal"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/';
$retail_regex     = '/retailValue"[^>]+>\s*<strong[^>]+>(?<price>[^<]+)/';
$asking_regex     = '/askingPrice"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/';

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
 */

$scrapper_configs["adventurervca"] = array(
    "entry_points"         => array(
        'new' => 'https://adventurerv.ca/rv-inventory/',
    ),
    'vdp_url_regex'        => '/\/inventory\//',
    // 'srp_page_regex'       => '/\/rv-inventory/i',

    'use-proxy'            => true,
    'refine'               => false,

    'picture_selectors'    => ['.slick-slide img'],
    'picture_nexts'        => ['.slick-next'],
    'picture_prevs'        => ['.slick-prev'],

    "custom_data_capture"  => function ($url, $data) {
        $site                 = "https://adventurerv.ca/sitemap_index.xml";
        $vdp_url_regex        = '/\/inventory\//';
        $images_regx          = '/data-fancybox="gallery" src="[^"]+" data-src="(?<img_url>[^"]+)"\s*alt/';
        $images_fallback_regx = null;
        $required_params      = []; // Mandatory url parameters
        $use_proxy            = false; // Uses proxy to reach site
        $keymap               = null; // Return the output data mapped against any car key
        $invalid_images       = []; // List of image urls to be filtered out
        $use_custom_site      = true; // Force crawler to use the given url as sitemap url

        $annoy_func = function ($car) {
            $car['custom'] = trim(str_replace(["–", "â€“"], ["", ""], $car['custom']));
            $car['custom'] = trim(preg_replace('!\s+!', ' ', $car['custom']));
            $car_parts     = explode(" ", $car['custom']);
            $car['make']   = trim($car_parts[0]);
            $car['model']  = trim(str_replace([$car['make']], [""], $car['custom']));
            //$car['trim']   = trim(str_replace([$car['make'], $car['model']], ["", ""], $car['custom']));
            unset($car['custom']);

            $drop_stocks = ['ARV22017b'];

            if (in_array($car['stock_number'], $drop_stocks)) {
               return [];
            }

            return $car;
        };

        $data_capture_regx_full = [
            'stock_type'   => '/<td class="condition">(?<stock_type>[^<]+)<\/td>/',
            'year'         => '/<h1><span class="year">(?<year>[^<]+)<\/span>/i',
            'price'        => '/Our Price:<\/strong><\/td>\s*<td class="price"><strong>(?<price>[^<]+)/i',
            'stock_number' => '/class="single-rv-stock">Stock #:\s*(?<stock_number>[^<]+)/i',
            'custom'       => '/<span class="year">(?<year>[^<]+)<\/span>(?<custom>[^<]+)<\/h1>/',
        ];

        $cars = sitemap_crawler($site, $vdp_url_regex, $data_capture_regx_full, $images_regx, $images_fallback_regx, $required_params, $use_proxy, $keymap, $invalid_images, $use_custom_site, $annoy_func);

        return $cars;
    }
);