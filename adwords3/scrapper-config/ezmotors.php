<?php

global $scrapper_configs;

$scrapper_configs['ezmotors'] = array(
    'entry_points' => array(
        'used' => 'https://www.ezmotors.ca/used-cars.aspx',
    ),
    'vdp_url_regex' => '/\/details-[0-9]{4}-/i',
    'use-proxy' => true,
    'picture_selectors' => ['.lightgallery-item img'],
    'picture_nexts' => ['.lg-next'],
    'picture_prevs' => ['.lg-prev'],
    'details_start_tag' => '<div class="col-md-9 nopadding clearfix">',
    'details_end_tag' => '<div id="disclaimer" class="clearfix">',
    'details_spliter' => '<div class="srp-vehicle-block',
    'data_capture_regx' => array(
        'stock_number' => '/<li><strong>Stock #:<\/strong>(?<stock_number>[^<]+)/',
        'year' => '/ebiz-vdp-title"><a href="[^"]+">(?<year>[0-9]{4})\s*/',
        'make' => '/ebiz-vdp-title"><a href="[^"]+">[0-9]{4}\s*(?<make>[^\s]+)\s*/',
        'model' => '/ebiz-vdp-title"><a href="[^"]+">[0-9]{4}\s*[^\s]+\s*(?<model>[^<]*)/',
        'price' => '/Price<\/div>\s*<a[^>]+><h4[^>]+>(?<price>\$[0-9,]+)/',
        'engine' => '/Engine:<\/strong>\s*(?<engine>[^<]+)/',
        'transmission' => '/Transmission:<\/strong>\s*(?<transmission>[^<]+)/',
        'exterior_color' => '/Exterior:<\/strong>\s*(?<exterior_color>[^<]+)/',
        'interior_color' => '/Interior:<\/strong>\s*(?<interior_color>[^<]+)/',
        'url' => '/ebiz-vdp-title"><a href="(?<url>[^"]+)/'
    ),
    'data_capture_regx_full' => array(
        'body_style' => '/Body Style :(?<body_style>[^<]+)/',
       // 'trim' => '/InventoryTrimParam:\s*\'(?<trim>[^\']+)/',
        'make' => '/InventoryMakeParam:\s*\'(?<make>[^\']+)/',
        'model' => '/InventoryModelParam:\s*\'(?<model>[^\']+)/',
        'kilometres' => '/Kilometers<\/strong><\/td>\s*<td class="[^>]+>(?<kilometres>[^<]+)/',
    ),
    'next_page_regx' => '/<li class="active">[^<]+<\/li><li><a href="(?<next>[^"]+)"/',
    'images_regx' => '/<div class="lightgallery-item" .*\s*<img src="[^"]+" data-src="(?<img_url>[^"]+)"/',
);

add_filter("filter_ezmotors_next_page", "filter_ezmotors_next_page", 10, 2);

function filter_ezmotors_next_page($next_page) {
    slecho("Filtering Next url");
    return str_replace('&amp;', '&', $next_page);
}
