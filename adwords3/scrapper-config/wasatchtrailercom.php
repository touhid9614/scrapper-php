<?php

global $scrapper_configs;

$scrapper_configs["wasatchtrailercom"] = array(
    "entry_points"           => array(
        'new' => array(
              'https://www.wasatchtrailer.com/layton-inventory',
              'https://www.wasatchtrailer.com/springville-inventory',
          
        ),
    ),

    'vdp_url_regex'          => '/\/(?:-|)[0-9a-zA-Z]+-[^-]+-/',
    'srp_page_regex'         => '/com\/all-inventory/',
    // 'ty_url_regex'           => '/com\/all-inventory/',
    'use-proxy'              => true,

    'refine'                 => false,
    'picture_selectors'      => ['.inv-gallery-img'],
    'picture_nexts'          => ['.fancybox-next'],
    'picture_prevs'          => ['.fancybox-prev'],

    'details_start_tag'      => '<div class="item-listing-view item-listing-view-lite">   ',
    'details_end_tag'        => '<div class="tc-footer-w">',
    'details_spliter'        => '<article class="inventory-item tc-list-item inventory',

    'data_capture_regx'      => array(
        'url'          => '/<span itemprop="name">\s*<a href="(?<url>[^"]+)"/',
        'price'        => '/(?:Sale Price:|Price:)\s*(?<price>\$[0-9,]+)/',  
        'year'         => '/<span itemprop="name">\s*<a href="(?<url>[^"]+)".*>(?<year>[0-9]{4})? ?(?<make>[^\s*]+)\s*(?<model>[^<]+)/',
        'make'         => '/<span itemprop="name">\s*<a href="(?<url>[^"]+)".*>(?<year>[0-9]{4})? ?(?<make>[^\s*]+)\s*(?<model>[^<+)/',
        'model'        => '/<span itemprop="name">\s*<a href="(?<url>[^"]+)".*>(?<year>[0-9]{4})? ?(?<make>[^\s*]+)\s*(?<model>[^<]+)/',
      
    ),

    'data_capture_regx_full' => array(
            'msrp'  => '/MSRP:\s*(?<msrp>\$[0-9,]+)/',
        'description'    => '/"description":\s*"(?<description>[\s\S]*?(?=Specs))/',
        'year'  => '/itemprop="releaseDate">(?<year>[^<]+)/',
        'make'  => '/itemprop="manufacturer">(?<make>[^<]+)/',
        'model' => '/itemprop="model">(?<model>[^<]+)/',
        'stock_number' => '/Stock No:[^>]+>\s*(?<stock_number>[^<]+)/',
        'city'  => '/<p class="name" itemprop="name">Wasatch Trailer Sales (?<city>[^<]+)/',
    ),

    'next_page_regx'         => '/page\s*next">\s*<a\s*href="(?<next>[^"]+)/',
    'images_regx'            => '/<a class="zoom" rel="gallery" title="[^"]+" href="(?<img_url>[^"]+)"/',
);

add_filter('filter_wasatchtrailercom_field_url', 'filter_wasatchtrailercom_field_url');
add_filter('filter_wasatchtrailercom_car_data', 'filter_wasatchtrailercom_car_data');
add_filter("filter_wasatchtrailercom_field_price", "filter_wasatchtrailercom_field_price", 10, 3);

function filter_wasatchtrailercom_field_url($url)
{
    $url = str_replace('|', '%7c', $url);

    return $url;
}

function filter_wasatchtrailercom_car_data($car_data)
{
    $car_data['model'] = str_replace('&#039;', '', $car_data['model']);
    $car_data['model'] = str_replace('&quot;', '"', $car_data['model']);
    $car_data['city']  = strtolower(str_replace(' ', '_', $car_data['city']));


    $car_data['description'] = str_replace('&amp;quot;', '', $car_data['description']);
    $car_data['description'] = str_replace('&#039;', '', $car_data['description']);
   

    return $car_data;
}

function filter_wasatchtrailercom_field_price($price, $car_data, $spltd_data)
{
    $prices = [];

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
    }

    $msrp_regex       = '/<span class="sales-price" itemprop="price">\s*(?<price>[^\s*]+)/';
    $wholesale_regex  = '/wholesalePrice">.*class=\'value[^>]+>(?<price>[^<]+)/';
    $internet_regex   = '/internetPrice">.*class=\'value[^>]+>(?<price>[^<]+)/';
    $cond_final_regex = '/stackedConditionalFinal"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/';
    $retail_regex     = '/retailValue"[^>]+>\s*<strong[^>]+>(?<price>[^<]+)/';
    $asking_regex     = '/askingPrice"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/';

    $matches = [];

    if (preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
    }

    if (preg_match($wholesale_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
    }

    if (preg_match($internet_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
    }

    if (preg_match($cond_final_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
    }

    if (preg_match($retail_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
    }

    if (preg_match($asking_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
    }

    if (count($prices) > 0) {
        $price = butifyPrice(min($prices));
    }

    return $price;
}

add_filter("filter_wasatchtrailercom_field_description", "filter_wasatchtrailercom_field_description");
   function filter_wasatchtrailercom_field_description($description)
    {
       return strip_tags($description);
    }
