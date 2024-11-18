<?php

global $scrapper_configs;
$scrapper_configs["stephenwademazda"] = array(
    "entry_points" => array(
        'new' => 'https://www.stephenwademazda.com/new-mazda-st-george-ut',
        'used' => 'https://www.stephenwademazda.com/used-cars-st-george-ut'
    ),
    'vdp_url_regex' => '/\/vehicle-details\/(?:new|certified|used)-[0-9]{4}-/i',
    
   'picture_selectors' => ['.thumb img'],
    'picture_nexts' => ['.right'],
    'picture_prevs' => ['.left'],
    
    'details_start_tag' => '<div class="search-wrapper box-wrapper">',
    'details_end_tag' => '<footer class="layout-footer"',
    'details_spliter' => '<div class="vehicle"',
    'data_capture_regx' => array(
        'url' => '/<div class="v-title">\s*<a href="(?<url>[^"]+)">\s*(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
        'title' => '/<div class="v-title">\s*<a href="(?<url>[^"]+)">\s*(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
        'year' => '/<div class="v-title">\s*<a href="(?<url>[^"]+)">\s*(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
        'make' => '/<div class="v-title">\s*<a href="(?<url>[^"]+)">\s*(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
        'model' => '/<div class="v-title">\s*<a href="(?<url>[^"]+)">\s*(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
       
        'stock_number' => '/stocknumber">#(?<stock_number>[^<]+)/',
        'price' => '/<span class="price-value text-bold">(?<price>\$[0-9,]+)/',
        'engine' => '/enginedescription">(?<engine>[^<]+)/',
        'transmission' => '/spec-value-transmission">(?<transmission>[^<]+)/',
        'exterior_color' => '/exteriorcolor">(?<exterior_color>[^<\[]+)/',
        'interior_color' => '/interiorcolor">(?<interior_color>[^<]+)/',
        'kilometres' => '/miles">(?<kilometres>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
       
    ),
    'next_page_regx'    => '/<li id="il-pagination-element-[0-9]*" class="active">\s*<a.*\s*<\/li>\s*<li[^>]+>\s*<a href="(?<next>[^"]+)"/',
    'images_regx' => '/<img src="(?<img_url>[^"]+)" alt="[0-9]{4} [^"]+" class="img-responsive" itemprop="image"/',
    
);

add_filter("filter_stephenwademazda_field_images", "filter_stephenwademazda_field_images");
function filter_stephenwademazda_field_images($im_urls)
{
    if (count($im_urls) < 2) {
        return array();
    }
    return $im_urls;
}
