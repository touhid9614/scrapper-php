<?php

global $scrapper_configs;
$scrapper_configs["murraygmpenticton"] = array(
    'entry_points' => array(
       'new' => 'https://www.murraygmpenticton.ca/inventory/New/',
       'used' => 'https://www.murraygmpenticton.ca/inventory/Used/',
    ),
    'use-proxy' => true,
    'refine'    => false,
    'vdp_url_regex' => '/\/inventory\/(?:New|certified|Used)-[0-9]{4}-/i',
    'picture_selectors' => ['.owl-item.cloned'],
    'picture_nexts' => ['#newnext'],
    'picture_prevs' => ['#newprev'],
    'details_start_tag' => 'class="srpVehicles__wrap">',
    'details_end_tag' => 'class="disclaimer__wrap">',
    'details_spliter' => 'class="carbox-wrap',
    'data_capture_regx' => array(
        'url' => '/data-permalink="(?<url>[^"]+)/',
        'year' => '/class="vehicle-title--year">\s*(?<year>[0-9]{4})/',
        'make' => '/class="notranslate vehicle-title--make ">\s*(?<make>[^<]+)/',
        'model' => '/class="notranslate vehicle-title--model ">\s*(?<model>[^<]+)/',
        'trim' => '/title-trim[^>]+>\s*(?<trim>[^<]+)/',
        'stock_number' => '/Stock#:<\/span>[^>]+>\s*(?<stock_number>[^<]+)/',
        'price' => '/class="currency">\$[^>]+>(?<price>[0-9,]+)/',
    ),
    'data_capture_regx_full' => array(
    ),
    'next_page_regx' => '/next page-numbers" href="(?<next>[^"]+)/',
    'images_regx' => '/data-lightbox="(?<img_url>[^"]+)"/',
    'images_fallback_regx' => '/property="og:image" content="(?<img_url>[^"]+)"/'
);