<?php

global $scrapper_configs;

$scrapper_configs['rockymountainmotors'] = array(
    'entry_points'           => array(
        'used' => 'https://www.rockymountainmotors.co/inventory',
    ),
    'vdp_url_regex'          => '/\/vehicle-details\/[0-9]{4}-/i',
    'use-proxy'              => true,
    'init_method'            => 'post',
    'picture_selectors'      => ['.flexslider.featured-photo-slider div ul li a img'],
    'picture_nexts'          => ['.fancybox-button.fancybox-button--arrow_right'],
    'picture_prevs'          => ['.fancybox-button.fancybox-button--arrow_left'],
    'details_start_tag'      => '<div class="inventory-list-container',
    'details_end_tag'        => '<div class="footer-container">',
    'details_spliter'        => '<div class="col- dynamic-col">',
    'data_capture_regx'      => array(
        'stock_number'   => '/<meta itemprop="sku" content="(?<stock_number>[^"]+)/',
        'url'            => '/<a class="accent-color1" href="(?<url>[^"]+)" title="(?<title>(?<year>[0-9]{4})[^"]+)/',
        'title'          => '/<a class="accent-color1" href="(?<url>[^"]+)" title="(?<title>(?<year>[0-9]{4})[^"]+)/',
        'year'           => '/<a class="accent-color1" href="(?<url>[^"]+)" title="(?<title>(?<year>[0-9]{4})[^"]+)/',
        'make'           => '/data-displaymake="(?<make>[^"]+)/',
        'model'          => '/data-displaymodel="(?<model>[^"]+)/',
        'trim'           => '/data-displaytrim="(?<trim>[^"]+)/',
        'price'          => '/class="currency-symbol">\$+<\/span>(?<price>[^<]+)/',
        'exterior_color' => '/<span class="Extcolor">(?<exterior_color>[^<]+)/',
        'interior_color' => '/<span class="Intcolor">(?<interior_color>[^<]+)/',
        'engine'         => '/<div class="engine">(?<engine>[^<]+)/',
        'transmission'   => '/<div class="transmission">(?<transmission>[^<]+)/',
        'kilometres'     => '/<span class="mileage">(?<kilometres>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
    ),
    'images_regx'            => '/<a href="(?<img_url>[^"]+)"\s* title="" alt="[0-9]{4} [^"]+"/',
    'images_fallback_regx'   => '/<meta property="og:image" content="(?<img_url>[^"]+)"/',
);
add_filter('filter_rockymountainmotors_field_url', 'filter_rockymountainmotors_field_url');
add_filter('filter_rockymountainmotors_post_data', 'filter_rockymountainmotors_post_data', 10, 2);

function filter_rockymountainmotors_post_data($post_data, $stock_type)
{

    return "xControlId=582e0d86e41e40b48f18736614550d8f&xAction=SetPageSize&xPageSize=100";
}
