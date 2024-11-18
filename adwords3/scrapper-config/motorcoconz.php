
<?php
global $scrapper_configs;
$scrapper_configs["motorcoconz"] = array(
    'entry_points'           => array(
        'used' => 'https://motorco.co.nz/inventory/',
    ),
    'vdp_url_regex'          => '/\/inventory\//i',
    'use-proxy'              => true,
    'refine'                 => false,
    'picture_selectors'      => ['.img-responsive'],
    'picture_nexts'          => ['.fa-angle-right'],
    'picture_prevs'          => ['.fa-angle-left'],

    'details_start_tag'      => '<div class="grid-wrapper inventory-items',
    'details_end_tag'        => '<div class="footer',
    'details_spliter'        => '<li class="car-date',
    'data_capture_regx'      => array(
        'url'            => '/<h2>\s*<a href="(?<url>[^"]+)">(?<make>[^\s*]+)\s*(?<model>[^&]+)&nbsp;(?<year>[^<]+)/',
        'year'           => '/<h2>\s*<a href="(?<url>[^"]+)">(?<make>[^\s*]+)\s*(?<model>[^&]+)&nbsp;(?<year>[^<]+)/',
        'make'           => '/<h2>\s*<a href="(?<url>[^"]+)">(?<make>[^\s*]+)\s*(?<model>[^&]+)&nbsp;(?<year>[^<]+)/',
        'model'          => '/<h2>\s*<a href="(?<url>[^"]+)">(?<make>[^\s*]+)\s*(?<model>[^&]+)&nbsp;(?<year>[^<]+)/',
        'price'          => '/<span class="fullprice">(?<price>\$[0-9,]+)/',
        'stock_number'   => '/STOCK NO[^>]+>[^>]+>(?<stock_number>[^<]+)/',
        'transmission'   => '/TRANSMISSION[^>]+>[^>]+>(?<transmission>[^<]+)/',
        'kilometres'     => '/ODOMETER[^>]+>[^>]+>(?<kilometres>[^\s]+)/',
        'body_style'     => '/BODY[^>]+>[^>]+>(?<body_style>[^<]+)/',
        'engine'         => '/ENGINE[^>]+>[^>]+>(?<engine>[^\,]+)/',
        'exterior_color' => '/EXT COLOUR[^>]+>[^>]+>(?<exterior_color>[^<]+)/',
        'interior_color' => '/INTERIOR[^>]+>[^>]+>(?<interior_color>[^<]+)/',
        'finance_term'   => '/weekprice">From\s*<strong>(?<finance_term>[^<]+)/',
    ),
    'data_capture_regx_full' => array(

    ),
    'next_page_regx'         => '/<a href="(?<next>[^"]+)" class="next">/',
    'images_regx'            => '/<img src=\'(?<img_url>[^"]+)\' class=\'img-responsive\' alt=[^>]+><\/div>/',
);

add_filter("filter_motorcoconz_field_images", "filter_motorcoconz_field_images");
function filter_motorcoconz_field_images($im_urls)
{
    $new_im_urls = [];
    $url_base    = "https://motorco.co.nz/";
    foreach ($im_urls as $im_url) {
        $new_im_url = preg_replace("/http:\/\/motorco.co.nz\/inventory\/[^\/]+/", $url_base, $im_url);
        array_push($new_im_urls, $new_im_url);
    }
    return $new_im_urls;
}