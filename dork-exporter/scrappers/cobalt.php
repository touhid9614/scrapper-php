<?php

global $site_scrappers;

$site_scrappers['cobalt'] = array(
    'use-proxy' => true,
    'details_start_tag' => '<section class="vehicleListWrapper">',
    'details_end_tag'   => '<footer >',
    'details_spliter'   => '<article class="itemscope',
    'data_capture_regx' => array(
        'stock_number'  => '/<a data-window-pixel="vsr_title"\s[^h]href="VehicleDetails\/[^\/]+\/(?<stock_number>[^"]+)"/',
        'year'          => '/<span class="year" itemprop="releaseDate" value="(?<year>[^"]+)"/',
        'make'          => '/<span class="make" itemprop="manufacturer" value="(?<make>[^"]+)"/',
        'model'          => '/<span class="model" itemprop="model" value="(?<model>[^"]+)"/',
        'price'          => '/<span class="price" itemprop="price"\s[^t]+title="(?<price>[^"]+)"/',
        'engine'         => '/Engine<\/span>\s[^<]+<span title="(?<engine>[^"]+)">/',
        'transmission'  => '/Transmission<\/span>\s[^<]+<span title="(?<transmission>[^"]+)">/',
        'kilometres'  => '/Kilometers<\/span>\s[^<]+<span title="(?<kilometres>[^"]+)">/',
        'exterior_color'  => '/Exterior<\/span>\s[^<]+<span title="(?<exterior_color>[^"]+)">/',
        'interior_color'  => '/Interior<\/span>\s[^<]+<span title="(?<interior_color>[^"]+)">/',
        'url'  => '/<a data-window-pixel="vsr_title"\s[^h]href="(?<url>[^"]+)"/',
    ),
    'data_capture_regx_full' => array(
    ) ,
    'next_page_regx'    => '/<a href="(?<next>[^"]+)" alt="Next Page">Next Page<\/a>/',
    'images_regx'       => '/media.push\({ src: \'(?<img_url>[^\']+)\'/'
);

?>
