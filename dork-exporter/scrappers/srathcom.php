<?php

global $site_scrappers;

$site_scrappers['srathcom'] = array(
    'use-proxy' => true,
    'details_start_tag' => '<ul class="list-unstyled list-search-result">',
    'details_end_tag'   => '</ul>',
    'details_spliter'   => '<li ',
    'data_capture_regx' => array(
        'url'           => '/data-vdp_url="(?<url>[^"]+)/',
        'title'         => '/width="[0-9]+"\s*alt="(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ "]+)[^"]+)"/',
        'year'          => '/width="[0-9]+"\s*alt="(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ "]+)[^"]+)"/',
        'make'          => '/width="[0-9]+"\s*alt="(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ "]+)[^"]+)"/',
        'model'         => '/width="[0-9]+"\s*alt="(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ "]+)[^"]+)"/',
        'price'         => '/<span class="list-price">(?<price>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
        'stock_number'  => '/<li>Stock # <span>(?<stock_number>[^<]+)/',
        'engine'        => '/<li>Engine <span>[^\w]+(?<engine>[^<\n]+)/',
        'transmission'  => '/<li>Transmission <span>(?<transmission>[^<]+)/',
        'kilometres'    => '/<li>Odometer <span>(?<kilometres>[^<]+)/',
    ),
    'options_start_tag' => '<span>Equipment</span>',
    'options_end_tag'   => '<div class="footnote">',        
    'options_regx'      => '/<li>(?<option>[^<]+)/',        
    'next_page_regx'    => '/<li class="active">\s*<a[^>]+>[^>]+>[^>]+>\s*<li><a href="(?<next>[^"]+)/',
    'images_regx'       => '/href="(?<img_url>[^"]+)" class="openphoto"/'
);

?>
