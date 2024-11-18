<?php
global $scrapper_configs;
$scrapper_configs["energydodge"] = array(
    'entry_points'         => array(
        'new' => 'https://energydodge.com/inventory?newUsed=New',
        'used' => 'https://energydodge.com/inventory?newUsed=Used',
    ),
    'vdp_url_regex'        => '/\/details\//i',
    'srp_page_regex'       => '/newUsed=(?:Used|New)/i',
    'use-proxy'            => true,
    'picture_selectors'    => ['.swiper-slide img'],
    'picture_nexts'        => ['.swiper-button-next'],
    'picture_prevs'        => ['.swiper-button-prev'],

    'details_start_tag' => '<div id="cardealer_inventory"',
    'details_end_tag' => '<section class="inventory container ">',
    'details_spliter' => '<script type="application',


    'data_capture_regx' => array(
        'url' => '/"url": "(?<url>[^"]+)",/',
        'currency' => '/priceCurrency": "(?<currency>[^"]+)",/',
        'price' => '/price": "(?<price>[^"]+)",/',
    ),
    'data_capture_regx_full' => array(

        'title' => '/<h1 itemprop="name">(?<title>(?<year>[^ ]+) *(?<make>[^ <]+) *(?<model>[^ <]+)?[^<]*)/',
        'year' => '/<h1 itemprop="name">(?<title>(?<year>[^ ]+) *(?<make>[^ <]+) *(?<model>[^ <]+)?[^<]*)/',
        'make' => '/<h1 itemprop="name">(?<title>(?<year>[^ ]+) *(?<make>[^ <]+) *(?<model>[^ <]+)?[^<]*)/',
        'model' => '/<h1 itemprop="name">(?<title>(?<year>[^ ]+) *(?<make>[^ <]+) *(?<model>[^ <]+)?[^<]*)/',

        'stock_number' => '/stockNumber":"(?<stock_number>[^"]+)/',
        'vin' => '/VIN:\s*(?<vin>[^<]+)/',


        'transmission'   => '/<li>\s*Transmission:\s*(?<transmission>[^\s*]+)/',
        'exterior_color' => '/<li>\s*Exterior Color:\s*(?<exterior_color>[^<]+)/',
        'interior_color' => '/<li>\s*Interior Color:\s*(?<interior_color>[^<]+)/',

        'engine' => '/<\/li>\s*<li>\s*Engine:\s*(?<engine>[^<]+)/',
        'kilometres' => '/<\/li>\s*<li>\s*Odometer:\s*(?<kilometres>[^<]+)/',
        'description'    => '/<meta property="og:description" content="(?<description>[^"]+)/',
        'stock_type'        => '/status:\s*\'(?<stock_type>[^\']+)/',


    ),
    'images_regx'          => '/data-src=\'(?<img_url>[^\']+)/',
    'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)/'
);

add_filter("filter_energydodge_field_images", "filter_energydodge_field_images");

function filter_energydodge_field_images($im_urls) {
    if (count($im_urls) < 3) {
        slecho("Less than three images");
        return [];
    }

    return $im_urls;
}