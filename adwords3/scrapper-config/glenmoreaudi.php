<?php

global $scrapper_configs;

$scrapper_configs['glenmoreaudi'] = array(
    'entry_points' => array(
        'new' => 'https://www.glenmoreaudi.com/en/new-catalog',
        'used' => 'https://www.glenmoreaudi.com/en/pre-owned-inventory'
    ),
    'use-proxy' => true,
    'details_start_tag' => '<section class="page__content-right">',
    'details_end_tag' => '<footer class="footer',
    'details_spliter' => 'class="catalog-vehicle-list styling-border',
    'data_capture_regx' => array(
        'url' => '/<p class="name"><a href="(?<url>[^"]+)"> *(?<title>[^<]+)/',
        'title' => '/<p class="name"><a href="(?<url>[^"]+)"> *(?<title>[^<]+)/',
        'year' => '/&desired_year=(?<year>[^\&]+)/',
        'make' => '/&desired_make=(?<make>[^\&]+)/',
        'model' => '/&desired_model=(?<model>[^\&]+)/',
        'trim' => '/&desired_trim=(?<trim>[^\"]+)/',
        'price' => '/class="showroom-price__price--regular">\s*(?<price>\$[0-9,]+)/',
    ),
    'data_capture_regx_full' => array(
        'transmission' => '/><li >Transmission:(?<transmission>[^<]+)/', //new vdp
        'exterior_color' => '/data-color-name="(?<exterior_color>[^"]+)/', //new vdp
        'interior_color' => '/>interior:<\/div>\s*<div class="[^>]+>(?<interior_color>[^<]+)/', //new vdp
    ),
    'images_regx' => '/<a id="[^"]+" ><img src="(?<img_url>[^"]+)/',
    'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)"/',
);

