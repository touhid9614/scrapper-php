<?php

global $scrapper_configs;
$scrapper_configs["smediaflywheelsitescom"] = array(
    "entry_points"           => array(
        'used' => 'http://smedia.flywheelsites.com/listing/',
    ),
    'use-proxy'              => true,
    'vdp_url_regex'          => '/\/listing\/[0-9]{4}/i',
    'picture_selectors'      => ['.bx-pager-wrap img'],
    'picture_nexts'          => ['.bx-next'],
    'picture_prevs'          => ['.bx-prev'],
    'details_start_tag'      => '<div class="facetwp-template elementor-element',
    'details_end_tag'        => '<div data-elementor-type="footer"',
    'details_spliter'        => '<div data-elementor-type="loop"',
    'data_capture_regx'      => array(
        'url'   => '/class="[^"]+"><a href="(?<url>[^"]+)">(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+))/',
        'make'  => '/class="[^"]+"><a href="(?<url>[^"]+)">(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+))/',
        'model' => '/class="[^"]+"><a href="(?<url>[^"]+)">(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+))/',
        'title' => '/class="[^"]+"><a href="(?<url>[^"]+)">(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+))/',
        'year'  => '/class="[^"]+"><a href="(?<url>[^"]+)">(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+))/',
        'price' => '/class="[^>]+>(?<price>\$[0-9,]+)/',
    ),
    'data_capture_regx_full' => array(
        'engine'         => '/<p>Engine<\/p><\/div>\s*<\/div>\s*<\/div>\s*<\/div>\s*<\/div>\s*<\/div>\s*<div[^>]+>\s*<div[^>]+>\s*<div[^>]+>\s*<div[^>]+>\s*<div[^>]+>\s*<div[^>]+><[^>]+>(?<engine>[^<]+)/',
        'transmission'   => '/<p>Transmission<\/p><\/div>\s*<\/div>\s*<\/div>\s*<\/div>\s*<\/div>\s*<\/div>\s*<div[^>]+>\s*<div[^>]+>\s*<div[^>]+>\s*<div[^>]+>\s*<div[^>]+>\s*<div[^>]+><[^>]+>(?<transmission>[^<]+)/',
        'exterior_color' => '/<p>Exterior<\/p><\/div>\s*<\/div>\s*<\/div>\s*<\/div>\s*<\/div>\s*<\/div>\s*<div[^>]+>\s*<div[^>]+>\s*<div[^>]+>\s*<div[^>]+>\s*<div[^>]+>\s*<div[^>]+><[^>]+>(?<exterior_color>[^<]+)/',
        'kilometres'     => '/<p>Odometer<\/p><\/div>\s*<\/div>\s*<\/div>\s*<\/div>\s*<\/div>\s*<\/div>\s*<div[^>]+>\s*<div[^>]+>\s*<div[^>]+>\s*<div[^>]+>\s*<div[^>]+>\s*<div[^>]+>(?<kilometres>[^<]+)/',
        'interior_color' => '/<p>Interior<\/p><\/div>\s*<\/div>\s*<\/div>\s*<\/div>\s*<\/div>\s*<\/div>\s*<div[^>]+>\s*<div[^>]+>\s*<div[^>]+>\s*<div[^>]+>\s*<div[^>]+>\s*<div[^>]+><[^>]+>(?<interior_color>[^<]+)/',
    ),
    'next_page_regx'         => '/rel="next" href="(?<next>[^"]+)/',
    'images_regx'            => '/<img class="swiper-slide-image"\s*src="(?<img_url>[^"]+)/',
);
